<?php
/**
 * This class contains public static functions related to withdrawal payouts
 *
 * @package         DPayouts
 * @category        Display
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php

namespace Admin\App\Display\Withdrawal;

use Admin\App\Models\Middleware\MSiteDetails;
use Admin\App\Models\Middleware\MFormatDate;
use Admin\App\Models\Withdrawal\MPaymentSettings;
use Admin\App\Models\Middleware\MPaymentGatewayDetails;
use Admin\App\Models\Middleware\MWalletBalance;
use Admin\App\Models\Withdrawal\MWithdrawalSettings;
use Admin\App\Models\Middleware\MFormatNumber;
use Illuminate\Support\Facades\DB;
class DPayouts
{
    /**
     * This public static function is used for show the pending withdrawal settings
     * @param array $records
     * @param int $iTotal
     * @return HTML data
     */

public static function showWithdrawal($records, $iTotal)
{
    // dd($records);
    if (count((array)$records) === 0) {
        return '';
    }

    $output = '';

    foreach ($records as $record) {

        // Date fix
        $usr_date = explode("-", $record->history_datetime);
        if (count($usr_date) === 3) {
            $year = (int)$usr_date[0];
            $month = (int)$usr_date[1];
            $day = (int)$usr_date[2];
            $paid_date = date("M d, Y", mktime(0, 0, 0, $month, $day, $year));
        } else {
            $paid_date = "Invalid Date";
        }

        // Status
        $status = ($record->history_type == 'withdraw_pending') 
            ? '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-sm">Pending</span>'
            : '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-sm">Paid</span>';

        // Get member account details
        $member_account_details = self::getMembersAccountDetails('WHERE members_id="' . $record->history_member_id . '"');
        // dd($member_account_details);
        $wallet_type = "-";
        $paymentsettings_name = "-";
        $amount = "-";
        $viewaccount_details = "-";

        if ($record->history_description == 'withdrawal commission paid') {
            $accoutdetails = __('Admin Account');
            $viewaccount_details = '';
        } elseif (!empty($member_account_details[0])) {
            $member = $member_account_details[0];
            $accoutdetails = $member->account_number ?? "-";

            // Payment settings
            $payment_details = MPaymentGatewayDetails::getPaymentGatewayDetail($member->paymentsettings_id ?? 0);
            // dd($payment_details);
            $paymentsettings_name = $payment_details->paymentsettings_name ?? null;
            $paymentsettings_default_name = $payment_details->paymentsettings_default_name ?? null;
            //  dd($paymentsettings_name);
            // Get user account details
            $useraccountdetails = self::getMembersAccountDetails('WHERE account_number="' . $member->account_number . '"');
            $account_details = json_decode($useraccountdetails[0]->account_details ?? '[]', true);

    $viewaccount_details = '';
foreach ($account_details as $key => $value) {
    if ($key == 'paymentsettings_id') continue; // skip paymentsettings_id

    // Remove underscores for display
    $accountkey = str_replace('_', '', $key);

    if (!empty($paymentsettings_default_name)) {
        // CoinPayment special case
        if ($paymentsettings_default_name == 'coinpayment') {
            if ($key == 'account_number') {
                $viewaccount_details .= __('Address') . ' : ' . $value . '<br/>';
                $viewaccount_details .= __('Coin') . ' : ' . ($records[$i]['withdrawal_coin_type'] ?? '-') . '<br/>';
            } else {
                $viewaccount_details .= ucfirst(str_replace('_', ' ', $key)) . ' : ' . $value . '<br/>';
            }
        } else {
            // Default accounts (bank, PayPal, etc.)
            $viewaccount_details .= ucfirst(str_replace('_', ' ', $key)) . ' : ' . $value . '<br/>';
        }
    } else {
        // If no paymentsettings_default_name, just display normally
        $viewaccount_details .= ucfirst(str_replace('_', ' ', $key)) . ' : ' . $value . '<br/>';
    }
}


            // Wallet type
            $wallet_type = DB::table('ihook_wallettype')
                ->where('wallet_type_id', $record->history_wallet_type)
                ->value('wallet_name') ?? "-";

            // Withdraw commission
            $adminwithdrawcommission = DB::table('ihook_generalsettings_table')
                ->where('generalsettings_name', 'admin_withdraw_commission')
                ->value('generalsettings_value') ?? 0;

            // Calculate commission and payable
            $commission = $record->history_amount * ($adminwithdrawcommission / 100);
            $payable = (float)$record->history_amount - (float)$commission;

            // Currency
            $site_currency = DB::table('ihook_sitesettings_table')
                ->where('sitesettings_name', 'site_currency')
                ->value('sitesettings_value') ?? '$';

            if ($record->history_amount > 0) {
                $amount =
                    'Requested : ' . $site_currency . ' ' . MFormatNumber::formatingNumberCurrency($record->history_amount) . '<br/>' .
                    'Commission : ' . $site_currency . ' ' . MFormatNumber::formatingNumberCurrency($commission) . '<br/>' .
                    'Payable : ' . $site_currency . ' ' . MFormatNumber::formatingNumberCurrency($payable) . '<br/>';
            }
        }

        $formatdate = MFormatDate::formatingDate($record->history_datetime);

        $output .= '<tr>
            <td>' . ($record->members_username ?? '-') . '</td>
            <td>' . $amount . '</td>
            <td>' . $wallet_type . '</td>
            <td>' . $paymentsettings_name . '</td>
            <td>' . $viewaccount_details . '</td>
            <td>' . $formatdate . '</td>';

      if ($record->history_type == 'withdraw_pending') {
    $output .= '<td class="flex">
        <a aria-label="link" title="' . __('Click to pay') . '" onclick="changeWithdrawalSettings(' . $record->history_id . ',' . $record->history_member_id . ');" href="javascript:void(0);">✔</a>
        &nbsp;
        <a aria-label="link" title="' . __('Click to cancel') . '" onclick="cancelWithdrawalSettings(' . $record->history_id . ',' . $record->history_member_id . ');" href="javascript:void(0);">✖</a>
    </td>';
} else {
    $output .= '<td>-</td>';
}

        $output .= '</tr>';
    }
// dd($output);
    return $output;
}

public static function showCompletedWithdrawal($records, $iTotal)
{
    // dd($records);
 if (count((array)$records) === 0) {
        return '';
    }

    $output = '';

    foreach ($records as $record) {

        // Date fix
        $usr_date = explode("-", $record->history_datetime);
        if (count($usr_date) === 3) {
            $year = (int)$usr_date[0];
            $month = (int)$usr_date[1];
            $day = (int)$usr_date[2];
            $paid_date = date("M d, Y", mktime(0, 0, 0, $month, $day, $year));
        } else {
            $paid_date = "Invalid Date";
        }

        // Status
        $status = ($record->history_type == 'withdraw_pending') 
            ? '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-sm">Pending</span>'
            : '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-sm">Paid</span>';

        // Get member account details
        $member_account_details = self::getMembersAccountDetails('WHERE members_id="' . $record->history_member_id . '"');
        // dd($member_account_details);
        $wallet_type = "-";
        $paymentsettings_name = "-";
        $amount = "-";
        $viewaccount_details = "-";

        if ($record->history_description == 'withdrawal commission paid') {
            $accoutdetails = __('Admin Account');
            $viewaccount_details = '';
        } elseif (!empty($member_account_details[0])) {
            $member = $member_account_details[0];
            $accoutdetails = $member->account_number ?? "-";

            // Payment settings
            $payment_details = MPaymentGatewayDetails::getPaymentGatewayDetail($member->paymentsettings_id ?? 0);
            // dd($payment_details);
            $paymentsettings_name = $payment_details->paymentsettings_name ?? null;
            $paymentsettings_default_name = $payment_details->paymentsettings_default_name ?? null;
            //  dd($paymentsettings_name);
            // Get user account details
            $useraccountdetails = self::getMembersAccountDetails('WHERE account_number="' . $member->account_number . '"');
// dd($useraccountdetails);
            $account_details = json_decode($useraccountdetails[0]->account_details ?? '[]', true);

  
$viewaccount_details = '';
foreach ($account_details as $key => $value) {
    if ($key == 'paymentsettings_id') continue; // skip paymentsettings_id

    // Remove underscores for display
    $accountkey = str_replace('_', '', $key);

    if (!empty($paymentsettings_default_name)) {
        // CoinPayment special case
        if ($paymentsettings_default_name == 'coinpayment') {
            if ($key == 'account_number') {
                $viewaccount_details .= __('Address') . ' : ' . $value . '<br/>';
                $viewaccount_details .= __('Coin') . ' : ' . ($records[$i]['withdrawal_coin_type'] ?? '-') . '<br/>';
            } else {
                $viewaccount_details .= ucfirst(str_replace('_', ' ', $key)) . ' : ' . $value . '<br/>';
            }
        } else {
            // Default accounts (bank, PayPal, etc.)
            $viewaccount_details .= ucfirst(str_replace('_', ' ', $key)) . ' : ' . $value . '<br/>';
        }
    } else {
        // If no paymentsettings_default_name, just display normally
        $viewaccount_details .= ucfirst(str_replace('_', ' ', $key)) . ' : ' . $value . '<br/>';
    }
}

            // Wallet type
            $wallet_type = DB::table('ihook_wallettype')
                ->where('wallet_type_id', $record->history_wallet_type)
                ->value('wallet_name') ?? "-";

            // Withdraw commission
            $adminwithdrawcommission = DB::table('ihook_generalsettings_table')
                ->where('generalsettings_name', 'admin_withdraw_commission')
                ->value('generalsettings_value') ?? 0;

            // Calculate commission and payable
            $commission = $record->history_amount * ($adminwithdrawcommission / 100);
            $payable = (float)$record->history_amount - (float)$commission;

            // Currency
            $site_currency = DB::table('ihook_sitesettings_table')
                ->where('sitesettings_name', 'site_currency')
                ->value('sitesettings_value') ?? '$';

            if ($record->history_amount > 0) {
                $amount =
                    'Requested : ' . $site_currency . ' ' . MFormatNumber::formatingNumberCurrency($record->history_amount) . '<br/>' .
                    'Commission : ' . $site_currency . ' ' . MFormatNumber::formatingNumberCurrency($commission) . '<br/>' .
                    'Payable : ' . $site_currency . ' ' . MFormatNumber::formatingNumberCurrency($payable) . '<br/>';
            }
        }

        $formatdate = MFormatDate::formatingDate($record->history_datetime);

        $output .= '<tr>
            <td>' . ($record->members_username ?? '-') . '</td>
            <td>' . $amount . '</td>
            <td>' . $wallet_type . '</td>
            <td>' . $paymentsettings_name . '</td>
            <td>' . $viewaccount_details . '</td>
            <td>' . $formatdate . '</td>';

        $output .= '</tr>';
    }
// dd($viewaccount_details);
    return $output;
}

public static function getMembersAccountDetails($where)
{
    // remove WHERE
    $where = trim(str_ireplace('WHERE', '', $where));

    // split key=value
    list($column, $value) = array_map('trim', explode('=', $where));

    // remove quotes
    $value = trim($value, '"\'');

    return DB::table('ihook_members_accounts_table')
        ->where($column, $value)
        ->get();
}


}