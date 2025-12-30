<?php

namespace Admin\App\Models\Funds;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\Reports;
use Admin\App\Models\Middleware\MSiteDetails;
// use Admin\App\Http\Controllers\Display\Funds\;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
class MDeductFunds
{

//     public static function updateDetect($request)
// {
//     // dd('function reached');
//     $transaction_id = "#" . substr(number_format(time() * rand(), 0, '', ''), 0, 9);
//     $history_wallet_type = $request->wallet_type;

//     // Check if users are selected
//     if (count((array)$request->user_list) > 0) {

//         // Fetch email notification setting (if needed)
//         $where = "WHERE sitesettings_name ='email_notification_user' ";
//         $sitesettings = MSiteDetails::getSiteSettingsDetails($where);
//         $email_notification_user = $sitesettings[0]['sitesettings_value'] ?? null;

//         // Fetch crypto default name
//         $cryptoCurrencyId = $request->cryptocurrency;
//         $crypto = DB::table(env('PROMLM_PREFIX') . 'crypto_currency_and_token')
//             ->where('crypto_currency_id', $cryptoCurrencyId)
//             ->first();

//         $cryptocurrency = $crypto->crypto_default_name ?? null;

//         // Get live crypto conversion
//         $btc_crypto_balance = MCryptoConverter::cryptoConverter($cryptocurrency);
//         $cryptovalue = (float) str_replace(',', '', $btc_crypto_balance);

//         // Calculate crypto qty
//         if ($cryptovalue != 0) {
//             $crypto_qty = $request->amount / $cryptovalue;
//         } else {
//             $crypto_qty = 0;
//         }

//         $crypto_qty = number_format($crypto_qty, 6, '.', '');

//         // Loop through users
//         foreach ($request->user_list as $username) {

//             // Find member
//             $member = Member::where('members_username', $username)->first();
//             if (!$member) continue;

//             $memberId = $member->members_id;

//             // Check wallet balance
//             $balance_amount = MWalletBalance::getWalletCurrentBalance($memberId, $history_wallet_type);

//             if ($balance_amount < $request->amount) {
//                 // Redirect with error
//                 return redirect()->back()->with('error_message', 'User ' . $username . ' does not have enough balance.');
//             }

//             // New transaction ID
//             $transaction_id = "#" . substr(number_format(time() * rand(), 0, '', ''), 0, 9);

//             // Create deduction record
//             $report = new Reports();
//             $report->timestamps = false;
//             $report->history_member_id      = $memberId;
//             $report->history_type           = 'admindeduct';
//             $report->history_description    = $request->memo;
//             $report->history_datetime       = now();
//             $report->history_amount         = $request->amount;
//             $report->history_transaction_id = $transaction_id;
//             $report->history_wallet_type    = $history_wallet_type;
//             $report->crypto_qty             = $crypto_qty;
//             $report->currency_id            = $request->cryptocurrency;
//             $report->save();
//         }

//         // Redirect success
//         return redirect()->back()->with('success_message', 'Amount deducted successfully!');
//     }

//     return redirect()->back()->with('error_message', 'No users selected.');
// }
  public static function updateDetect($request)
    {
        $history_wallet_type = $request->wallet_type;
        $site_currency = Session::get('site_settings.site_currency');

        // Get notification settings
        $where                   = "WHERE sitesettings_name ='push_notification_admin' ";
        $sitesettings            = MSiteDetails::getSiteSettingsDetails($where);
        $push_notification_admin = $sitesettings[0]['sitesettings_value'];
        $where                   = "WHERE sitesettings_name ='push_notification_user' ";
        $sitesettings            = MSiteDetails::getSiteSettingsDetails($where);
        $push_notification_user = $sitesettings[0]['sitesettings_value'];

        // Process cryptocurrency users

        if (count((array)$request->user_list) > 0) {
            $where = "WHERE sitesettings_name ='email_notification_user' ";
            $sitesettings = MSiteDetails::getSiteSettingsDetails($where);
            $email_notification_user = $sitesettings[0]['sitesettings_value'];

            foreach ($request->user_list as $value) {
                // Use the correct variable ($value)
                $member = Member::where('members_username', $value)->first();
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
                $report->save();
                }

          
        // Redirect with success message
        return redirect()->back()->with('success_message', 'Amount transferred successfully!');
    }
        return redirect()->back()->with('error_message', 'No users selected.');
    }
}