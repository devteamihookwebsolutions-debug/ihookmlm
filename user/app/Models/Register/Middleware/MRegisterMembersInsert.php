<?php

namespace User\App\Models\Register\Middleware;

use Admin\App\Models\UserManager\MInsertUserDetails;
use Admin\App\Models\UserManager\MInsertUserMatrixLinkDetails;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use User\App\Models\Member;
use User\App\Models\MemberLinks;
use User\App\Models\PaymentHistory;
use Admin\App\Models\Middleware\MMemberDetails;
use Admin\App\Models\Middleware\MMatrixDetails;
use User\App\Models\Logs\MUserLog;
use Admin\App\Models\UserManager\MBinaryPositionSpillover;
use Admin\App\Models\Member\MatrixConfiguration;

use DateTime;

class MRegisterMembersInsert
{
    /**
     * Insert new members into the system.
     */
    public static function insertMembers(Request $request,$matrix_id)
    {


        $data = $request->all();
        // dd($data);
        $date = $data['date'];
        $month = $data['month'];
        $year = $data['year'];
        $fullDate = DateTime::createFromFormat('d-m-Y', "$date-$month-$year");
        if (!$fullDate) {
            return null;
        }
        $formattedDate = $fullDate->format('Y-m-d');
        // Generate random transaction ID
        $transactionId =   implode('', array_map(fn () => rand(0, 9), range(1, 10)));
        // Extract user input
        $members_username       = $data['user_name'];
        $members_firstname      = $data['first_name'];
        $members_lastname       = $data['last_name'];
        $members_email          = $data['email'];
        $members_password       = Hash::make($data['password']);
        $members_dob            = $formattedDate;
        $members_address        = $data['address'];
        $members_country        = $data['country'];
        $members_state          = $data['state'];
        $members_city           = $data['city'];
        $members_zip            = $data['zipcode'];
        $members_phone          = $data['phone'];
        $members_payment_id     = $data['payment'];
        $members_package = $data['Package'];
        $group_id       = 1;
        $members_from   = 1;
        $status         = 1;
        // Insert user details
         $paymentMethod = $data['payment'] ?? '';
            $packageId = $data['Package'] ?? 0;

            $epinRequired = ($paymentMethod == 14);

            $epin_code = null;

            if ($epinRequired) {
                $epin_code = trim($request->input('epin_code') ?? $request->session()->get('register.epin_code', ''));

                if (empty($epin_code)) {
                    throw new Exception("E-PIN code is required for this payment method.");
                }

                $epin = DB::table('ihook_epin_table')
                    ->where('epin_code', $epin_code)
                    ->where('epin_status', 0)
                    ->first();

                if (!$epin) {
                    throw new Exception("Invalid or already used E-PIN!");
                }

                Log::info('E-PIN validated successfully', ['epin_code' => $epin_code]);
            } else {
                $epin_code = null;
                Log::info('E-PIN skipped - Payment method does not require E-PIN', [
                    'payment_method_id' => $paymentMethod
                ]);
            }


        $insertUserDetails = new MInsertUserDetails();
        $members_id = $insertUserDetails->insertUserDetails(
        $members_username,
        $members_password,
        $members_email,
        $members_firstname,
        $members_lastname,
        $members_state,
        $members_city,
        $members_address,
        $members_phone,
        $members_zip,
        $members_country,
        $members_from,
        $members_dob,
        $members_payment_id,
        $epin_code
        );
        // dd($members_id);
        // Store in session using Laravel's Session
        Session::put('register.members_id', $members_id);
        $members_subscription_plan = $members_package;
        $entry_criteria = $members_subscription_plan > 0 ? 2 : 1;
        // dd($entry_criteria);

        if ($data['sponsor_id']) {
            $sponsorId = $data['sponsor_id'];
        } else {
            $member = Member::first(); // fallback to first member
            $sponsorId = $member->members_id;
            // dd($sponsorId);
        }
        //get sponsor details
        $where = $sponsorId ;
        $sponsor_details = MMemberDetails::getWhereMemberDetails($where);
        $sponsor_id = $sponsor_details->members_id;
        // dd($sponsor_id);

        $sponsor_username = $sponsor_details->members_username;
        // dd($sponsor_username);

        $position_direct_id = $sponsor_details->members_id;
        // dd($position_direct_id);

        $direct_id = $sponsor_details->members_id;
        // dd($direct_id);
        $matrixdetails = MMatrixDetails::getMatrixDetails($matrix_id);
        // dd($matrixdetails);

        $matrixname = $matrixdetails->matrix_name;
        $matrix_type_id = $matrixdetails->matrix_type_id;
        // dd($matrix_type_id);

    try {
    $level_deep = MatrixConfiguration::where('matrix_id', $matrix_id)
        ->where('matrix_key', 'level_deep')
        ->value('matrix_value');

    $level_width = MatrixConfiguration::where('matrix_id', $matrix_id)
        ->where('matrix_key', 'level_width')
        ->value('matrix_value');

    // Determine width and depth
    $width = ($matrix_type_id == 1) ? 2 : ($level_width ?: 9999);
    // dd($width);
    $deep = ($matrix_type_id == 1) ? 9999 : ($level_deep ?: 9999);
    // dd($deep);
    $positions = range(1, $width);
    // dd($positions);
    // 1. Find sponsor
    $sponsorRoot = MemberLinks::where('members_id', $sponsorId)->first();
    if (!$sponsorRoot) {
        throw new Exception("Sponsor not found.");
    }
    $directId = $sponsorRoot->members_id;
    // dd($sponsorRoot);

    // 2. BFS under sponsor to find first available position
    $spilloverId = null;
    $position = null;

    // Queue stores ['id' => member_id, 'level' => current_level]
    $queue = [['id' => $directId, 'level' => 1]];

    while (!empty($queue)) {
        $current = array_shift($queue);
        $currentId = $current['id'];
        $currentLevel = $current['level'];

        // Skip if exceeds matrix depth
        if ($currentLevel > $deep) continue;

        // Get all children positions of current node
        $childPositions = MemberLinks::where('spillover_id', $currentId)
            ->pluck('position')
            ->map(fn($p) => (int)$p)
            ->toArray();

        // Fill first available position
        foreach ($positions as $pos) {
            if (!in_array($pos, $childPositions)) {
                $spilloverId = $currentId;
                $position = $pos;
                break 2; // Found position, exit BFS
            }
        }

        // Add children to queue for next level
        $childIds = MemberLinks::where('spillover_id', $currentId)
            ->pluck('members_id')
            ->toArray();

        foreach ($childIds as $childId) {
            $queue[] = ['id' => $childId, 'level' => $currentLevel + 1];
        }
    }

    if (!$position) {
        throw new Exception("No available position under sponsor.");
    }

    // // 3. Build members_parents chain from root → spillover parent
    // $membersParents = [];
    // $root = MemberLinks::where('position', 0)->first(); // root member
    // if (!$root) {
    //     throw new Exception("Root member not found.");
    // }

    // $membersParents[] = $root->members_id;
    // $currentParent = $spilloverId;
    // $path = [];
    // while ($currentParent && $currentParent != $root->members_id) {
    //     $record = MemberLinks::where('members_id', $currentParent)->first();
    //     if (!$record) break;
    //     $path[] = $record->members_id;
    //     $currentParent = $record->direct_id ?? null;
    // }

    // $membersParents = array_merge($membersParents, array_reverse($path));
    // $membersParentsStr = implode(',', $membersParents);
    // dd($membersParentsStr);


// 3. Build members_parents chain correctly
$parent = MemberLinks::where('members_id', $spilloverId)
    ->where('matrix_id', $matrix_id)
    ->first();

if (!$parent) {
    throw new Exception("Parent not found for spillover ID: $spilloverId");
}

// root = parent's root + 1
$rootValue = intval($parent->root) + 1;
// dd($rootValue);
// build parents chain
if (!empty($parent->members_parents)) {
    // append the parent itself
    $membersParentsStr = $parent->members_parents . ',' . $parent->members_id;
} else {
    // if parent is root
    $membersParentsStr = $parent->members_id;
}

$membersParentsStr = trim($membersParentsStr, ',');
// dd($membersParentsStr);

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
// dd($members_id);
        if ($members_id > 0) {
             $matrixLink = new MInsertUserMatrixLinkDetails();
                $matrixLink->insertUserMatrixLinkDetails(
                $members_id,
                $matrix_id,
                $members_package,
                $members_subscription_plan,
                $directId,
                $spilloverId,
                $entry_criteria,
                $position,
                $membersParentsStr,
                $rootValue
            );
        }

        //start: insert user log
        $register_message = $members_username . __(' has been joined');
        MUserLog::userLog($members_id, $register_message, 'register');
        //end: insert user log


        return $members_id;
    }
}
