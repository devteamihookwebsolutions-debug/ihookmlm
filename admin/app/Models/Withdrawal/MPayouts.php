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
    // dd('asdfkahjd');
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
    $records = DB::table('ihook_members_table AS b')
        ->leftJoin('ihook_history_table AS a', 'a.history_member_id', '=', 'b.members_id')
        ->leftJoin('ihook_paymentsettings_table AS c', 'c.paymentsettings_id', '=', 'b.members_payment_id')
        ->select($columns)
        ->where('a.history_type', 'withdraw_pending')
        ->get();

    $iTotal = $records->count();

    // dd($records);
    return DPayouts::showWithdrawal($records, $iTotal);
}


    public static function showCompletedWithdrawal()
{
    // dd('ajksdf');
    $records = DB::table('ihook_members_table as b')
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
        ->leftJoin('ihook_history_table as a', 'a.history_member_id', '=', 'b.members_id')
        ->leftJoin('ihook_paymentsettings_table as c', 'c.paymentsettings_id', '=', 'b.members_payment_id')
        ->where('a.history_type', 'withdrawal')
        ->where('a.history_description', '!=', 'withdrawal commission paid')
        ->get();

    $iTotal = $records->count();
    // dd($records);
    return DPayouts::showCompletedWithdrawal($records, $iTotal);
}

public static function showCancelleddWithdrawal()
{
    // dd('function reached');
    $records = History::query()
        ->select(
            'ihook_history_table.history_id',
            'ihook_history_table.history_member_id',
            'ihook_history_table.history_type',
            'ihook_history_table.history_description',
            'ihook_history_table.account_id',
            'ihook_members_table.members_username',
            'ihook_history_table.history_amount',
            'ihook_members_table.members_account_number',
            'ihook_history_table.history_datetime',
            'ihook_members_table.members_lastname',
            'ihook_members_table.members_payment_id',
            'ihook_paymentsettings_table.paymentsettings_name',
            'ihook_history_table.updated_on',
            'ihook_history_table.history_wallet_type'
        )
        ->leftJoin('ihook_members_table', 'ihook_history_table.history_member_id', '=', 'ihook_members_table.members_id')
        ->leftJoin('ihook_paymentsettings_table', 'ihook_members_table.members_payment_id', '=', 'ihook_paymentsettings_table.paymentsettings_id')
        ->where('ihook_history_table.history_type', 'withdrawal')
        ->where('ihook_history_table.history_description', '!=', 'withdrawal commission paid')
        ->get();

    $iTotal = $records->count();
// dd($records);
    return DPayouts::showCompletedWithdrawal($records, $iTotal);
}


}


