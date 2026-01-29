<?php

/**
 * This class contains public functions related to MPayouts
 *
 * @package         MPayouts
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

namespace Admin\App\Models\Withdrawal;

use Illuminate\Support\Facades\DB;
use User\App\Models\PaymentHistory;
use Admin\App\Models\Member\History;
use Admin\App\Models\Member\GeneralSetting;
use Admin\App\Display\Withdrawal\DPayouts;

class MPayouts
{
public static function showWithdrawal()
{
        $prefix = config('services.ihook.prefix');
    // List of selected columns
    $columns = [
        'a.history_id',
        'a.history_member_id',
        'a.history_type',
        'a.history_description',
        'a.account_id',
        'b.members_username',
        'a.history_amount',
        'b.members_account_number',
        'a.history_datetime',
        'b.members_lastname',
        'b.members_username',
        'b.members_account_number',
        'c.paymentsettings_name',
        'a.history_wallet_type',
        'a.withdrawal_coin_type'
    ];

    // Query (no prefix)
    $records = DB::table($prefix.'_members_table AS b')
        ->leftJoin($prefix.'_history_table AS a', 'a.history_member_id', '=', 'b.members_id')
        ->leftJoin($prefix.'_paymentsettings_table AS c', 'c.paymentsettings_id', '=', 'b.members_payment_id')
        ->select($columns)
        ->where('a.history_type', 'withdraw_pending')
        ->get();

    $iTotal = $records->count();

    // dd($records);
    return DPayouts::showWithdrawal($records, $iTotal);
}


    public static function showCompletedWithdrawal()
{
     $prefix = config('services.ihook.prefix');
    // dd('ajksdf');
    $records = DB::table($prefix.'_members_table as b')
        ->select(
            'a.history_id',
            'a.history_member_id',
            'a.history_type',
            'a.history_description',
            'a.account_id',
            'b.members_username',
            'a.history_amount',
            'b.members_account_number',
            'a.history_type',
            'a.history_datetime',
            'b.members_lastname',
            'b.members_username',
            'b.members_account_number',
            'c.paymentsettings_name',
            'a.updated_on',
            'a.history_wallet_type',
            'a.withdrawal_coin_type'
        )
        ->leftJoin($prefix.'_history_table as a', 'a.history_member_id', '=', 'b.members_id')
        ->leftJoin($prefix.'_paymentsettings_table as c', 'c.paymentsettings_id', '=', 'b.members_payment_id')
        ->where('a.history_type', 'withdrawal')
        ->where('a.history_description', '!=', 'withdrawal commission paid')
        ->get();

    $iTotal = $records->count();
    // dd($records);
    return DPayouts::showCompletedWithdrawal($records, $iTotal);
}

public static function showCancelleddWithdrawal()
{
    $prefix = config('services.ihook.prefix');
    // dd('function reached');
    $records = History::query()
        ->select(
            $prefix.'_history_table.history_id',
            $prefix.'_history_table.history_member_id',
            $prefix.'_history_table.history_type',
            $prefix.'_history_table.history_description',
            $prefix.'_history_table.account_id',
            $prefix.'_members_table.members_username',
            $prefix.'_history_table.history_amount',
            $prefix.'_members_table.members_account_number',
            $prefix.'_history_table.history_datetime',
            $prefix.'_members_table.members_lastname',
            $prefix.'_members_table.members_payment_id',
            $prefix.'_paymentsettings_table.paymentsettings_name',
            $prefix.'_history_table.updated_on',
            $prefix.'_history_table.history_wallet_type'
        )
        ->leftJoin($prefix.'_members_table', $prefix.'_history_table.history_member_id', '=', $prefix.'_members_table.members_id')
        ->leftJoin($prefix.'_paymentsettings_table', $prefix.'_members_table.members_payment_id', '=', $prefix.'_paymentsettings_table.paymentsettings_id')
        ->where($prefix.'_history_table.history_type', 'withdrawal')
        ->where($prefix.'_history_table.history_description', '!=', 'withdrawal commission paid')
        ->get();

    $iTotal = $records->count();
// dd($records);
    return DPayouts::showCompletedWithdrawal($records, $iTotal);
}


}


