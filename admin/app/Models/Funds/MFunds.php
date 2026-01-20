<?php

/**
 * This class contains public functions related to MFunds
 *
 * @package         MFunds
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
