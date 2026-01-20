<?php

/**
 * This class contains public functions related to MDeductFunds
 *
 * @package         MDeductFunds
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
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
// use Admin\App\Http\Controllers\Display\Funds\;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
class MDeductFunds
{

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
                // dd($member);
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
