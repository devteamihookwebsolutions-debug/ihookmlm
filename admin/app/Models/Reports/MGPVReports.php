<?php

/**
 * This class contains public functions related to MGPVReports
 *
 * @package         MGPVReports
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php


namespace Admin\App\Models\Reports;

use Admin\App\Display\Reports\DGPVReports;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\MemberLinks;
use Illuminate\Http\Request;

class MGPVReports
{
    public static function getGPVReports($request)
    {
        $limit = $request->input('perPage', 10);
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $limit;

        $queryValue = $request->input('query');
        $columnIndex = $request->input('columnIndex', 0);

        // Base query
        $recordsQuery = MemberLinks::query()
            ->leftJoin('ihook_members_table as b', 'ihook_matrix_members_link_table.members_id', '=', 'b.members_id')
            ->select(
                'ihook_matrix_members_link_table.members_id',
                'ihook_matrix_members_link_table.matrix_id',
                'b.members_username'
            )
            ->where('ihook_matrix_members_link_table.members_account_status', '1')
            ->where('ihook_matrix_members_link_table.members_status', '1');

        // Search filter
        if (!empty($queryValue) && $columnIndex == 1) {
            $recordsQuery->where('b.members_username', trim($queryValue));
        }

        // Total count
        $iTotal = $recordsQuery->count();

        // Pagination
        $records = $recordsQuery
            ->skip($offset)
            ->take($limit)
            ->get();

        $total_pages = ceil($iTotal / $limit);
    //    dd($records);
        // Call Display Class
        return DGPVReports::getGPVReports($records, $total_pages, $iTotal);
    }
}
