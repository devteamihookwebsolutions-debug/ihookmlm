<?php

/**
 * This class contains public functions related to MPaymentSuccess
 *
 * @package         MPaymentSuccess
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Models\PaymentConquest;

use Admin\App\Models\Member\PaymentHistory;
use Admin\App\Models\Member\Matrix;
use Admin\App\Models\Middleware\MPackageDetails;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\MemberLinks;
use Admin\App\Models\Member\MatrixConfiguration;
use Admin\App\Models\PaymentConquest\MMembersMatrixLevelComplete;
use Admin\App\Models\Middleware\MMatrixConfiguration;
use Admin\App\Models\PaymentConquest\MPackageRegisterSuccess;
use Admin\App\Models\PaymentConquest\MOneTimeRegisterSuccess;
use Admin\App\Models\PaymentConquest\MInstantBinary;
use Admin\App\Models\Middleware\MSiteDetails;
use Admin\App\Models\Middleware\MSendMail;
use Admin\App\Models\Middleware\MUserNotifyStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
// use DB;
use Illuminate\Support\Facades\Log;
use DateTime;

class MPaymentSuccess
{
    public static function afterPaymentSuccesssCommission(
        $members_id,
        $matrix_id,
        $members_subscription_plan,
        $paymenthistory_mode,
        $paymenthistory_type,
        $paymenthistory_amount,
        $package_price,
        $paymenthistory_id,
        $transaction_id,
        $matrix_type_id,
        $matrix_name,
        $payment_amt_exclusive
        ) {

        Log::info('[PaymentSuccess] START', [
            'members_id' => $members_id,
            'matrix_id' => $matrix_id,
            'paymenthistory_id' => $paymenthistory_id,
            'matrix_type_id' => $matrix_type_id,
            'payment_amt_exclusive' => $payment_amt_exclusive,
        ]);
        //send mail  start wanted this fields
        $filename         = mt_rand(100000000, 999999999);
        $site_currency = Session::get('site_settings.site_currency');
        $pdfpath          = "uploads/membersinvoice/" . "invoice" . $filename . ".pdf";
        $prefix = config('services.ihook.prefix');
        if ($paymenthistory_id <= 0) {
            Log::warning('[PaymentSuccess] Invalid paymenthistory_id', ['paymenthistory_id' => $paymenthistory_id]);
            return true;
        }

        // Update payment status
        $payment = PaymentHistory::find($paymenthistory_id);
        if (!$payment) {
            Log::error('[PaymentSuccess] PaymentHistory not found', ['paymenthistory_id' => $paymenthistory_id]);
            return true;
        }

        $payment->paymenthistory_status = 'paid';
        $payment->save();

        Log::info('[PaymentSuccess] Payment status updated to PAID', [
            'paymenthistory_id' => $paymenthistory_id,
            'transaction_id' => $transaction_id
        ]);

        // Update matrix member link
        $matrixLink = MemberLinks::where('members_id', $members_id)
            ->where('matrix_id', $matrix_id)
            ->first();

        if (!$matrixLink) {
            Log::error('[PaymentSuccess] MemberLinks not found', [
                'members_id' => $members_id,
                'matrix_id' => $matrix_id
            ]);
            return true;
        }

        Log::info('[PaymentSuccess] MemberLinks found', [
            'link_id' => $matrixLink->link_id,
            'direct_id' => $matrixLink->direct_id,
            'spillover_id' => $matrixLink->spillover_id
        ]);

        // Update member link status
        $matrixUpdate = MemberLinks::find($matrixLink->link_id);
        $matrixUpdate->members_account_status = 1;
        $matrixUpdate->members_status = 1;
        $matrixUpdate->members_subscription_status = 1;
        $matrixUpdate->save();

        Log::info('[PaymentSuccess] MemberLinks status activated', ['link_id' => $matrixLink->link_id]);

        // Fetch member info
        $member = Member::find($matrixLink->members_id);
        if (!$member) {
            Log::error('[PaymentSuccess] Member not found', ['members_id' => $members_id]);
            return true;
        }

        $memberName   = $member->members_username;
        $members_email   = $member->members_email;
        $direct_id    = $matrixLink->direct_id;
        $spillover_id = $matrixLink->spillover_id ?? 0;
        $moduletype   = $matrixLink->moduletype;

        if ($spillover_id == '') $spillover_id = 0;

        Log::info('[PaymentSuccess] Member details loaded', [
            'members_id' => $members_id,
            'username' => $memberName,
            'direct_id' => $direct_id,
            'spillover_id' => $spillover_id,
            'moduletype' => $moduletype
        ]);

        // Default leg of direct upline
        $directLink = MemberLinks::where('members_id', $direct_id)->first();
        $default_leg = $directLink?->default_leg ?? 0;

        Log::info('[PaymentSuccess] Direct upline default_leg', [
            'direct_id' => $direct_id,
            'default_leg' => $default_leg
        ]);

        // Get entry criteria
        $entry_criteria_data = MMatrixConfiguration::getMatrixConfigurationDetails($matrix_id, 'members_account_type');
        $entry_criteria = $entry_criteria_data[0]['matrix_value'] ?? null;

        Log::info('[PaymentSuccess] Entry criteria fetched', [
            'matrix_id' => $matrix_id,
            'entry_criteria' => $entry_criteria
        ]);

        // Check level completion
        $levelcompletecheck = MMembersMatrixLevelComplete::checkLevelComp($members_id, $matrix_id);

        Log::info('[PaymentSuccess] Level completion check', [
            'members_id' => $members_id,
            'matrix_id' => $matrix_id,
            'level_complete' => $levelcompletecheck
        ]);

        if ($levelcompletecheck != '1') {
            Log::info('[PaymentSuccess] Level NOT completed yet. Skipping commissions.', [
                'members_id' => $members_id,
                'matrix_id' => $matrix_id
            ]);
            return true;
        }

        Log::info('[PaymentSuccess] Level COMPLETED. Proceeding with commissions.', [
            'members_id' => $members_id,
            'matrix_id' => $matrix_id
        ]);

        // Set spillover logic
        if ($matrix_type_id != 6 && $spillover_id == 0 && $direct_id > 0) {
            Log::info('[PaymentSuccess] Spillover condition met. Applying spillover.', [
                'matrix_type_id' => $matrix_type_id,
                'default_leg' => $default_leg
            ]);

            if ($default_leg == 5 && ($matrix_type_id == 1 || $matrix_type_id == 2)) {
                Log::info('[PaymentSuccess] Calling setSpillover (default_leg 5)', compact('members_id', 'direct_id', 'matrix_id', 'matrix_type_id'));
                MSpillover::setSpillover($members_id, $direct_id, $matrix_id, $matrix_type_id);
            } elseif ($default_leg == 0 && $matrix_type_id == 3) {
                Log::info('[PaymentSuccess] Calling setSpillover (matrix_type 3)', compact('members_id', 'direct_id', 'matrix_id', 'matrix_type_id'));
                MSpillover::setSpillover($members_id, $direct_id, $matrix_id, $matrix_type_id);
            } else {
                Log::info('[PaymentSuccess] Calling setSpilloverbyLeg', [
                    'members_id', 'direct_id', 'matrix_id', 'matrix_type_id', 'default_leg'
                ]);
                MSpillover::setSpilloverByLeg($members_id, $direct_id, $matrix_id, $matrix_type_id, $default_leg, $spillover_id);
            }
        } else {
            Log::info('[PaymentSuccess] Spillover NOT applied', [
                'matrix_type_id' => $matrix_type_id,
                'spillover_id' => $spillover_id,
                'direct_id' => $direct_id
            ]);
        }
        $membersPaidAccountType = DB::table('ihook_matrix_configuration_table')
            ->where('matrix_key', 'members_paid_account_type')
            ->value('matrix_value');

        $membersPaidAccountType = $membersPaidAccountType == '1' ? 1 : 0;
        $selectedPackageId = $payment->paymenthistory_package_id ?? 0;

        Log::info('[PaymentSuccess] Registration Type Detection', [
            'members_paid_account_type' => $membersPaidAccountType,
            'selected_package_id' => $selectedPackageId,
            'payment_amount' => $payment_amt_exclusive
        ]);

        if ($membersPaidAccountType == 0 && $selectedPackageId == 0) {
            // FREE / ONE TIME REGISTRATION
            Log::info('[PaymentSuccess] Triggering ONE TIME Registration Commissions (Free)');
            MOneTimeRegisterSuccess::oneTimeRegisterSuccess(
                $members_id,
                $direct_id,
                $matrix_id,
                1,
                $payment_amt_exclusive,
                $memberName,
                $matrix_type_id
            );

            } else {
                // Package Based Registration (Paid packages mode)
                Log::info('[PaymentSuccess] Package Registration Commission Triggered', [
                    'members_id'                => $members_id,
                    'direct_id'                 => $direct_id,
                    'matrix_id'                 => $matrix_id,
                    'payment_amt_exclusive'     => $payment_amt_exclusive,
                    'members_subscription_plan' => $members_subscription_plan,
                    'memberName'                => $memberName,
                    'matrix_type_id'            => $matrix_type_id,
                    'members_paid_account_type' => $membersPaidAccountType
                ]);

                MPackageRegisterSuccess::packageRegisterSuccess(
                    $members_id,
                    $direct_id,
                    $matrix_id,
                    $entry_criteria ?? 2,
                    $payment_amt_exclusive,
                    $members_subscription_plan,
                    $memberName,
                    $matrix_type_id
                );
            }
        if ($matrix_type_id == 1) {
            Log::info('[PaymentSuccess] Binary Matrix - Instant Binary Commission', [
                'parents' => $matrixLink->members_parents,
                'members_id' => $members_id,
                'matrix_id' => $matrix_id,
                'amount' => $payment_amt_exclusive
            ]);
            MInstantBinary::binarySplitFun($matrixLink->members_parents, $members_id, $matrix_id, $payment_amt_exclusive, $memberName);
        }

        Log::info('[PaymentSuccess] Triggering Joining Commission', [
            'members_id' => $members_id,
            'matrix_id' => $matrix_id,
            'amount' => $payment_amt_exclusive
        ]);
        MJoiningCommission::sentJoiningCommission($members_id, $matrix_id, $payment_amt_exclusive);

        Log::info('[PaymentSuccess] ALL COMMISSIONS PROCESSED SUCCESSFULLY', [
            'members_id' => $members_id,
            'matrix_id' => $matrix_id,
            'paymenthistory_id' => $paymenthistory_id
        ]);
   //fetch package details
      $package_id                = $matrixLink->members_subscription_plan;
    //   dd($package_id);
        if ($package_id != '') {
            $package = MPackageDetails::getPackageDetails($package_id);
        }

        $registration_pv                  = $package['package_pv'];
        $packagename                      = $package['package_name'];
        $package_duration                 = $package['package_duration'];
        $package_direct_commission        = $package['package_direct_commission'];
        $package_direct_commission_method = $package['package_direct_commission_method'];
        $product_id                       = $package['eshop_products'];
        $autoship_duration                = $package['package_duration'];
        //send mail
        $email_notification_user = MSiteDetails::getSiteSettingValue('email_notification_user');
        // dd($email_notification_user);
        $push_notification_admin = MSiteDetails::getSiteSettingValue('push_notification_admin');

        $push_notification_user  = MSiteDetails::getSiteSettingValue('push_notification_user');

         $usermailstatus = MUserNotifyStatus::userMailStatus($members_id);
        if ($usermailstatus == 0) {
        //    dd('fimciaslfnd');
        $prefix = config('services.ihook.prefix');
        // dd($prefix);
        $records = DB::table($prefix . '_usernotify_meta')
            ->where('user_id', $members_id)
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

    if ($email_notification_user == '1' && $usermailstatus == '1') {
    //   dd('function reached or not');
    $mail_lang = MUserNotifyStatus::userMailLang($members_id);
    // dd($mail_lang);
    // Fetch template for user language
    $record = DB::table($prefix . '_mailtemplates_table')
        ->where('mail_default_name', 'package_purchase_notification')
        ->where('mail_status', 1)
        ->where('mail_lang', $mail_lang)
        ->first();
    // dd($record);
    // Fallback to default language (id=1)
    if (!$record) {
        $record = DB::table($prefix . '_mailtemplates_table')
            ->where('mail_default_name', 'package_purchase_notification')
            ->where('mail_status', 1)
            ->where('mail_lang', 1)
            ->first();
    }

    if ($record) {
        $body = $record->mail_content;

        // Replace placeholders
        $body = str_replace('[name]', $memberName, $body);
        $body = str_replace('[packagename]', $packagename, $body);
        $body = str_replace('[packageprice]', $site_currency . $paymenthistory_amount, $body);
        $body = str_replace('[packageduration]', $package_duration . ' Days', $body);
        $body = str_replace('[packagepv]', $registration_pv, $body);
        $body = str_replace('[packagecommision]', $package_direct_commission . $package_direct_commission_method, $body);

        MSendMail::send($record, $members_email, $body, $pdfpath, '', '');
    }
    }
        return true;
    }
}
