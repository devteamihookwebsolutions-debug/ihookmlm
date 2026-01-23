<?php

/**
 * This class contains public functions related to MDeductFunds
 *
 * @package         MDeductFunds
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

namespace Admin\App\Models\Funds;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\Reports;
use Admin\App\Models\Middleware\MSiteDetails;
use Admin\App\Models\Middleware\MWalletBalance;
use Illuminate\Http\Request;
use Admin\App\Models\Middleware\MSendMail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
class MDeductFunds
{

  public static function updateDetect($request)
    {
         $prefix = config('services.ihook.prefix');
        // dd($prefix);
        $history_wallet_type = $request->wallet_type;
        $site_currency = Session::get('site_settings.site_currency');

        // Get notification settings
        $push_notification_admin            = MSiteDetails::getSiteSettingValue('push_notification_admin');
        // dd($push_notification_admin);
        $push_notification_user            = MSiteDetails::getSiteSettingValue('push_notification_user');

        // Process cryptocurrency users

        if (count((array)$request->user_list) > 0) {
            $email_notification_user = MSiteDetails::getSiteSettingValue('email_notification_user');

            foreach ($request->user_list as $value) {
                // Use the correct variable ($value)
                $member = Member::where('members_username', $value)->first();
                // dd($member);
                // $balanceAmount = MWalletBalance::getWalletCurrentBalance($value, $history_wallet_type);
                // // dd($balanceAmount);
                // $requestedAmount = $request->input('amount');

                // if ($balanceAmount < $requestedAmount) {
                //     // Set flash session message
                //     Session::flash('error_message', __('User does not have enough balance'));

                //     // Redirect to route or URL
                //     return redirect()->to(env('BCPATH') . '/detect');
                // }

                $transaction_id = "#" . substr(number_format(time() * rand(), 0, '', ''), 0, 9);
                $report = new Reports();
                $report->timestamps = false;
                $report->history_member_id      = $member->members_id;
                $report->history_type           = 'admindeduct';
                $report->history_description    = $request->memo;
                $report->history_datetime       = now();
                $report->history_amount         = $request->amount;
                $report->history_transaction_id = $transaction_id;
                $report->history_wallet_type    = $history_wallet_type;
                // $report->crypto_qty             = $request->crypto_qty ?? 0;
                // $report->currency_id            = $request->cryptocurrency ?? null;

                // dd($report);
                $report->save();


                $member = DB::table($prefix.'_members_table')
                        ->where('members_username', $value)
                        ->first();

                // dd($member);

                // 1 Fetch member details safely
                $member = DB::table($prefix.'_members_table')
                            ->where('members_id', $member->members_id)
                            ->first(['members_username', 'members_email', 'members_phone']);
                }


                $members_username=$member->members_username;
                // dd($members_username);
                $members_email=$member->members_email;
                // dd($members_email);

                if (!$member) {
                        return response()->json(['error' => 'Member not found'], 404);
                    }

                if ($email_notification_user == 1 ) {

                    // dd('function reached or not');
                    // Wallet type
                    $walletType = ($history_wallet_type == 1) ? 'C-Wallet' : 'E-Wallet';
                    // dd($walletType);

                     $mailLang = Session::get('adminsitelang_id', 1);
                    // Fetch mail template
                    $records = DB::table($prefix . '_mailtemplates_table')
                        ->where('mail_default_name', 'wallet_detect_notification_mail')
                        ->where('mail_status', 1)
                        ->where('mail_lang', $mailLang)
                        ->first();
                    // dd($records);
                    // Fallback to default language
                    if (!$records) {
                        $records = DB::table($prefix . '_mailtemplates_table')
                            ->where('mail_default_name', 'wallet_detect_notification_mail')
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
        // Redirect with success message
        return redirect()->back()->with('success', 'Amount transferred successfully!');
    }
        return redirect()->back()->with('error_message', 'No users selected.');
        }
    }
}
