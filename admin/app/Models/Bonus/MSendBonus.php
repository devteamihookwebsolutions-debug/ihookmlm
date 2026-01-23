<?php

/**
 * This class contains public functions related to MSendBonus
 *
 * @package         MSendBonus
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

namespace Admin\App\Models\Bonus;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\Reports;
use Admin\App\Models\Middleware\MSiteDetails;
use Admin\App\Models\Middleware\MCryptoConverter;
use Admin\App\Models\Middleware\MUserNotifyStatus;
use Admin\App\Models\Middleware\MSendMail;
use Admin\App\Display\Bonus\DSendBonus;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
class MSendBonus
{
 public static function showUser()
    {
        // Fetch all active and verified members
        $records = Member::where('members_status', 1)
                        ->where('members_verified', 1)
                        ->get();

        // Pass to DSendBonus (if it processes the member list)
        // dd($records);
        return DSendBonus::showUser($records);
    }
   public static function updateSendBonus($request)
    {
        $prefix = config('services.ihook.prefix');
        // dd($prefix);
        $history_wallet_type = $request->wallet_type;
        $site_currency = Session::get('site_settings.site_currency');

        // Get notification settings
        $push_notification_admin            = MSiteDetails::getSiteSettingValue('push_notification_admin');
        // dd($push_notification_admin);
        $push_notification_user            = MSiteDetails::getSiteSettingValue('push_notification_user');
        // dd($push_notification_user);

        if (count((array)$request->user_list) > 0) {
            $email_notification_user = MSiteDetails::getSiteSettingValue('email_notification_user');
            //  dd($email_notification_user);

            foreach ($request->user_list as $value) {
                // Use the correct variable ($value)
                // dd($value);
                // $member = Member::where('members_username', $value)->first();
                // dd($member);
                $member = DB::table($prefix.'_members_table')
                        ->where('members_username', $value)
                        ->first();

                // dd($member);
                $transaction_id = "#" . substr(number_format(time() * rand(), 0, '', ''), 0, 9);
                $report = new Reports();
                $report->timestamps = false;
                $report->history_member_id      = $member->members_id;
                $report->history_type           = 'adminbonus';
                $report->history_description    = $request->memo;
                $report->history_datetime       = now();
                $report->history_amount         = $request->amount;
                $report->history_transaction_id = $transaction_id;
                $report->history_wallet_type    = $history_wallet_type;
                // $report->crypto_qty             = $request->crypto_qty ?? 0;
                // $report->currency_id            = $request->cryptocurrency ?? null;
                $report->save();

            //start for push
            $usermailstatus            = MUserNotifyStatus::userMailStatus($value);//check status
            // dd($usermailstatus);

            // Assuming you already have these variables
            $member = DB::table($prefix.'_members_table')
                        ->where('members_username', $value)
                        ->first();

            // dd($member);

            // dd($member);

            // 1 Fetch member details safely
            $member = DB::table($prefix.'_members_table')
                        ->where('members_id', $member->members_id)
                        ->first(['members_username', 'members_email', 'members_phone']);
            // dd($member);
            if (!$member) {
                return response()->json(['error' => 'Member not found'], 404);
            }

            $members_username = $member->members_username;
            $members_email = $member->members_email;
            $members_phone = $member->members_phone;

            // 2 Check user notification settings if mail is not yet sent
          if ($usermailstatus == 0) {
        //    dd('fimciaslfnd');
        $prefix = config('services.ihook.prefix');
        // dd($prefix);
        $records = DB::table($prefix . '_usernotify_meta')
            ->where('user_id', $member)
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

    if ($email_notification_user == 1 && $usermailstatus == 1) {

    // dd('function reached or not');
    // Wallet type
    $walletType = ($history_wallet_type == 1) ? 'C-Wallet' : 'E-Wallet';
    // dd($walletType);
    // Get user mail language
    $mailLang = MUserNotifyStatus::userMailLang($value);

    // Fetch mail template
    $records = DB::table($prefix . '_mailtemplates_table')
        ->where('mail_default_name', 'wallet_notification_mail')
        ->where('mail_status', 1)
        ->where('mail_lang', $mailLang)
        ->first();
    // dd($records);
    // Fallback to default language
    if (!$records) {
        $records = DB::table($prefix . '_mailtemplates_table')
            ->where('mail_default_name', 'wallet_notification_mail')
            ->where('mail_status', 1)
            ->where('mail_lang', 1)
            ->first();
    }

    if ($records) {

        // Replace template variables
        $message = str_replace(
            ['[name]', '[amount]', '[wallettype]'],
            [$members_username, request('amount'), $walletType],
            $records->mail_content
        );
        // dd($message);
        // Send Mail
        MSendMail::send($records, $members_email, $message, '', '', '');

    }
}
            }


        // Redirect with success message
        return redirect()->back()->with('success', 'Amount transferred successfully!');
    }
        return redirect()->back()->with('error_message', 'No users selected.');
    }

}
