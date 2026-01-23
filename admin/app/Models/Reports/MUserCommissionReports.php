<?php

/**
 * This class contains public functions related to MUserCommissionReports
 *
 * @package         MUserCommissionReports
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
namespace Admin\App\Models\Reports;
use Admin\App\Models\Member\MatrixMemberLinks;
use Admin\App\Models\Member\Reports;
use Illuminate\Support\Facades\DB;
use Admin\App\Models\Member\HistoryType;
use Illuminate\Http\Request;
use Admin\App\Display\Reports\DUserCommisisonReports;
class MUserCommissionReports{



public static function getUserCommissionReports(Request $request)
{
    // Pagination setup
    $perPage = (int) $request->input('per_page', 15);
    $page = (int) $request->input('page', 1);

    // Optional filters
    $columnIndex = (int) $request->input('columnIndex');
    $queryValue = $request->input('query');

    // Get all commission-related history types
    $historyTypes = HistoryType::from('ihook_history_type_table')
        ->where('history_credit_type', 1)
        ->where('history_commission_type', 1)
        ->pluck('history_type_name')
        ->toArray();
    //    dd($historyTypes);
    // Base query
    $query = Reports::from('ihook_matrix_members_link_table as a')
        ->join('ihook_members_table as b', 'a.members_id', '=', 'b.members_id')
        ->join('ihook_history_table as c', 'b.members_id', '=', 'c.history_member_id')
        ->whereIn('c.history_type', $historyTypes)
        ->where('c.history_amount', '!=', 0);

    // Apply search filter (by username)
    if (!empty($queryValue) && $columnIndex === 1) {
        $query->where('b.members_username', trim($queryValue));
    }

    // Select and group results
    $query->select(
        'a.members_id',
        'a.matrix_id',
        'b.members_username',
        Reports::raw('MAX(c.history_id) as history_id'),
        Reports::raw('SUM(c.history_amount) as total_commission')
    )
    ->groupBy('a.members_id', 'a.matrix_id', 'b.members_username');

    // Manual total count (unique members)
    $totalCount = Reports::from('ihook_matrix_members_link_table as a')
        ->join('ihook_members_table as b', 'a.members_id', '=', 'b.members_id')
        ->join('ihook_history_table as c', 'b.members_id', '=', 'c.history_member_id')
        ->whereIn('c.history_type', $historyTypes)
        ->where('c.history_amount', '!=', 0)
        ->when(!empty($queryValue) && $columnIndex === 1, function ($q) use ($queryValue) {
            $q->where('b.members_username', trim($queryValue));
        })
        ->distinct('a.members_id')
        ->count('a.members_id');

    $totalPages = ceil($totalCount / $perPage);

    // Paginate result data
    $data = $query->paginate($perPage, ['*'], 'page', $page);
    $records = $data->items();
    // Debug
    // dd($records);
//  return DUserCommisisonReports::getUserCommissionReports($data, $totalPages, $totalRecords);
     return DUserCommisisonReports::getUserCommissionReports($records, $totalPages, $totalCount);
    // return $data;
}

}
