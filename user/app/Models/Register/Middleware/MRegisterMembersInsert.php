<?php

/**
 * This class contains public functions related to MRegisterMembersInsert
 *
 * @package         MRegisterMembersInsert
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace User\App\Models\Register\Middleware;

use Admin\App\Models\UserManager\MInsertUserDetails;
use Admin\App\Models\UserManager\MInsertUserMatrixLinkDetails;
use Admin\App\Models\Member\Admin;
use Illuminate\Support\Facades\DB;
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
use Admin\App\Models\Middleware\MSiteDetails;
use Admin\App\Models\Middleware\MSendMail;
use Admin\App\Models\Middleware\MUpdateCollection;
use Admin\App\Models\Middleware\MUserNotifyStatus;
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

        $prefix = config('services.ihook.prefix');
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
        $site_url = env('FCPATH');
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
    $membersParentsStr='';
    $spilloverId = null;
    $position = null;
    $rootValue=0;

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

    //send mail
     $email_notification_user = MSiteDetails::getSiteSettingValue('email_notification_user');
        // dd($email_notification_user);
     $push_notification_admin = MSiteDetails::getSiteSettingValue('push_notification_admin');

    $push_notification_user  = MSiteDetails::getSiteSettingValue('push_notification_user');

     $usermailstatus            = MUserNotifyStatus::usermailStatus($sponsor_id);
    //  dd($usermailstatus);
        if ($usermailstatus == 0) {
        //    dd('fimciaslfnd');
        $prefix = config('services.ihook.prefix');
        // dd($prefix);
        $records = DB::table($prefix . '_usernotify_meta')
            ->where('user_id', $sponsor_id)
            ->whereIn('meta_key', ['notify_via', 'all_notify', 'register_notify'])
            ->pluck('meta_value', 'meta_key'); // returns associative array: meta_key => meta_value
    // dd($records);
        $notify_via = $records['notify_via'] ?? 0;
        $all_notify = $records['all_notify'] ?? 0;
        $register_notify = $records['register_notify'] ?? 0;

        if (($all_notify == 1 || $register_notify == 1) && in_array($notify_via, [1, 4])) {
            $usermailstatus = 1;
        }
    }
   //start :Sponsor notification
            $sponsorname = $sponsor_details->members_username;
            $sponsormail = $sponsor_details->members_email;
            $sponsor_push = $sponsor_details->push_token;
            $sponsor_phone = $sponsor_details->members_phone;
            // dd($sponsorname);
        if ($email_notification_user == '1' && $usermailstatus == '1') {
        // dd('function reached or not');
            // Get user language preference
            $mail_lang = MUserNotifyStatus::usermailLang($sponsor_id);
            // dd($mail_lang);


        // Try to get mail template for user language
        $record = DB::table($prefix . '_mailtemplates_table')
            ->where('mail_default_name', 'downlinenotification_for_new_user')
            ->where('mail_status', 1)
            ->where('mail_lang', $mail_lang)
            ->first();
        // dd($record);
        // Fallback to default language = 1 if not found
        if (!$record) {
            $record = DB::table($prefix . '_mailtemplates_table')
                ->where('mail_default_name', 'downlinenotification_for_new_user')
                ->where('mail_status', 1)
                ->where('mail_lang', 1)
                ->first();
        }
            if ($record) {
            $placeholders = [
                '[name]'          => $sponsorname,
                '[username]'      => $members_username,
                '[members_email]' => $members_email,
            ];

            $body = strtr($record->mail_content, $placeholders);

            // Send email
            MSendMail::send($record, $sponsormail, $body, null, $members_username);
        }
        //End Sponor notification

        //start : register email,sms notification
        if ($email_notification_user == '1') {

        //    dd('function reached or not');
            $mailLang = Session::get('adminsitelang_id', 1);
            // dd($mailLang);
            // Get mail template for selected language
            $records = DB::table($prefix.'_mailtemplates_table')
                ->where('mail_default_name', 'registration_mail')
                ->where('mail_status', 1)
                ->where('mail_lang', $mailLang)
                ->first();

                // dd($records);
            // Fallback to default language (1)
            if (!$records) {
                $records = DB::table($prefix.'_mailtemplates_table')
                    ->where('mail_default_name', 'registration_mail')
                    ->where('mail_status', 1)
                    ->where('mail_lang', 1)
                    ->first();
            }

            if ($records) {

                // Template replacements
                $message = str_replace(
                    ['[name]', '[username]', '[pass]', '[url]'],
                    [$members_username, $members_username, $members_password, $site_url],
                    $records->mail_content
                );
        // dd($members_username);
                // Send mail
                MSendMail::send(
                    $records,
                    $members_email,
                    $message,
                    null,
                    null,
                    $members_username
                );
            }
        }
    }
    else {  //via link
            if ($email_notification_user == '1') {

                $membersId = (int) $members_id;

                // Using Eloquent
                Member::where('members_id', $membersId)
                    ->update(['members_status' => 0]);

                // OR using Query Builder
               $updateArray = ['members_status' => 0];

                // Update MySQL table
                DB::table($prefix . '_members_table')
                    ->where('members_id', $membersId)
                    ->update($updateArray);

                // Update MongoDB
                $where = ['members_id' => $membersId];
                MUpdateCollection::updateCollection($updateArray, $where, "members");

                // 1. Get Mail Template
                $mailLang = session('sitelang_id', 1);

                $records = DB::table($prefix . '_mailtemplates_table')
                    ->where('mail_default_name', 'registration_account_activation')
                    ->where('mail_status', 1)
                    ->where('mail_lang', $mailLang)
                    ->first();

                if (!$records) {
                    $records = DB::table($prefix . '_mailtemplates_table')
                        ->where('mail_default_name', 'registration_account_activation')
                        ->where('mail_status', 1)
                        ->where('mail_lang', 1)
                        ->first();
                }

                if (!$records) {
                    throw new \Exception('Mail template not found');
                }

                // 2. Update target_status
                $linkNumber = rand(100000, 999999);

                DB::table(env('PROMLM_PREFIX') . 'members_table')
                    ->where('members_id', $members_id)
                    ->update(['target_status' => $linkNumber]);

                // 3. Prepare URL and Message
                $activationUrl = env('APP_URL') . '/members/enable/' . $members_id . '/' . $linkNumber;

                $message = str_replace(
                    ['[name]', '[username]', '[pass]', '[mailactive]'],
                    [$members_username, $members_email, $members_password, $activationUrl],
                    $records->mail_content
                );
                MSendMail::send($records, $members_email, $message, '', '', $members_username);

            }
        }


        $email_notification_admin = MSiteDetails::getSiteSettingValue('email_notification_admin');
        if ($email_notification_admin == '1') {
                    // 2. Get admin user
        $admin = Admin::where('admin_status', 'enable')
                      ->where('admin_type', 1)
                      ->first();
        // dd($admin);
        $admin_email=$admin->admin_email;
        // dd($admin_email);
        if (!$admin) {
            return false;
        }

        // 3. Get mail template for the site language
        $mailLang = session('sitelang_id', 1); // fallback to '1'
        // dd($mail_lang);
        $records = DB::table($prefix .'_mailtemplates_table')
                                ->where('mail_default_name', 'adminnotification_for_new_user')
                                ->where('mail_status', 1)
                                ->where('mail_lang', $mailLang)
                                ->first();
        // dd($template);
        // fallback to default language if not found
        if (!$records) {
            $records = DB::table($prefix .'_mailtemplates_table')
                                    ->where('mail_default_name', 'adminnotification_for_new_user')
                                    ->where('mail_status', 1)
                                    ->where('mail_lang', 1)
                                    ->first();
        }

        if (!$records) {
            return false;
        }

        // 4. Replace placeholders
        $siteLink = url('/login'); // generates your site URL
        $message  = str_replace(
            ['[name]', '[username]', '[site_link]', '[members_email]'],
            [$admin->admin_username, $members_username, $siteLink, $members_email],
            $records->mail_content

        );
    //   dd($message);
            MSendMail::send($records, $admin_email, $message, '', '', $members_username);
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
