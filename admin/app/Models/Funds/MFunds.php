<?php

namespace Admin\App\Models\Funds;
use Admin\App\Display\Funds\DFundTransfer;
use Illuminate\Support\Facades\DB;
use Admin\App\Models\Member\Reports;
use Illuminate\Http\Request;

class MFunds
{
public static function showFundTransfers(Request $request)
{
    $perPage = (int) $request->input('perPage', 10);
    $page = (int) $request->input('page', 1);
    $offset = ($page - 1) * $perPage;
    
    $query = Reports::query()
        ->select(
            'history_id',
            'history_member_id',
            'history_amount',
            'history_fund_transfer_from_to_id',
            'history_datetime',
            'history_wallet_type'
        )
        ->whereIn('history_type', ['fundtransferred'])
        ->where('history_member_id', '>', 0);

    $iTotal = $query->count();

    $records = $query
        ->offset($offset)
        ->limit($perPage)
        ->get();

    return DFundTransfer::showFundTransfers($records, $iTotal);
}


}