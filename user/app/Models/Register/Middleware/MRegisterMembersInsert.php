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
use Admin\App\Models\Member\MatrixConfiguration;

use DateTime;

class MRegisterMembersInsert
{
    /**
     * Insert new members into the system.
     */
    public static function insertMembers(Request $request, $matrix_id)
    {
        $data = $request->all();
        $date = $data['date'];
        $month = $data['month'];
        $year = $data['year'];
        $fullDate = DateTime::createFromFormat('d-m-Y', "$date-$month-$year");
        if (!$fullDate) {
            return null;
        }
        $formattedDate = $fullDate->format('Y-m-d');

        // Generate random transaction ID
        $transactionId = implode('', array_map(fn () => rand(0, 9), range(1, 10)));

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
        $members_package        = $data['Package'];
        $group_id               = 1;
        $members_from           = 1;
        $status                 = 1;

        // E-PIN validation (if required)
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
            Log::info('E-PIN skipped - Payment method does not require E-PIN', [
                'payment_method_id' => $paymentMethod
            ]);
        }

        // Insert user details
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

        Session::put('register.members_id', $members_id);

        $members_subscription_plan = $members_package;
        $entry_criteria = $members_subscription_plan > 0 ? 2 : 1;

        // Get sponsor
        if ($data['sponsor_id']) {
            $sponsorId = $data['sponsor_id'];
        } else {
            $member = Member::first();
            $sponsorId = $member->members_id;
        }

        $sponsor_details = MMemberDetails::getWhereMemberDetails($sponsorId);
        $sponsor_id = $sponsor_details->members_id;
        $sponsor_username = $sponsor_details->members_username;
        $position_direct_id = $sponsor_details->members_id;
        $directId = $sponsor_details->members_id; // direct_id = sponsor

        // Get matrix details
        $matrixdetails = MMatrixDetails::getMatrixDetails($matrix_id);
        $matrixname = $matrixdetails->matrix_name;
        $matrix_type_id = $matrixdetails->matrix_type_id;

              try {
            if ($matrix_type_id != 1) {
                // Non-binary: place directly under sponsor
                $spilloverId = $sponsorId;
                $position = 1; // or auto-increment if needed

                $parent = MemberLinks::where('members_id', $sponsorId)
                    ->where('matrix_id', $matrix_id)
                    ->first();

                if (!$parent) {
                    throw new Exception("Sponsor not found in matrix links.");
                }

                $rootValue = $parent->root + 1;

                $membersParentsStr = $parent->members_parents
                    ? $parent->members_parents . ',' . $parent->members_id
                    : $parent->members_id;

            } else {
                // Binary: proper spillover with matrix_id filter
                $width = 2;
                $deep = 9999;
                $positions = [1, 2];

                $spilloverId = null;
                $position = null;

                $queue = [['id' => $sponsorId, 'level' => 1]];

                while (!empty($queue)) {
                    $current = array_shift($queue);
                    $currentId = $current['id'];
                    $currentLevel = $current['level'];

                    if ($currentLevel > $deep) continue;

                    $childPositions = MemberLinks::where('spillover_id', $currentId)
                        ->where('matrix_id', $matrix_id)
                        ->pluck('position')
                        ->map('intval')
                        ->toArray();

                    foreach ($positions as $pos) {
                        if (!in_array($pos, $childPositions)) {
                            $spilloverId = $currentId;
                            $position = $pos;
                            break 2;
                        }
                    }

                    $childIds = MemberLinks::where('spillover_id', $currentId)
                        ->where('matrix_id', $matrix_id)
                        ->pluck('members_id')
                        ->toArray();

                    foreach ($childIds as $childId) {
                        $queue[] = ['id' => $childId, 'level' => $currentLevel + 1];
                    }
                }

                if (!$position) {
                    throw new Exception("No position available in binary matrix.");
                }

                $parent = MemberLinks::where('members_id', $spilloverId)
                    ->where('matrix_id', $matrix_id)
                    ->first();

                if (!$parent) {
                    throw new Exception("Spillover parent not found.");
                }

                $rootValue = $parent->root + 1;

                $membersParentsStr = $parent->members_parents
                    ? $parent->members_parents . ',' . $parent->members_id
                    : $parent->members_id;
            }

            $membersParentsStr = trim($membersParentsStr, ',');

        } catch (Exception $e) {
            Log::error('Placement Error: ' . $e->getMessage());
            throw $e;
        }

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

        // Insert user log
        $register_message = $members_username . __(' has been joined');
        MUserLog::userLog($members_id, $register_message, 'register');

        return $members_id;
    }
}
