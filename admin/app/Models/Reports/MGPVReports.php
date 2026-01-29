<?php

/**
 * This class contains public functions related to MGPVReports
 *
 * @package         MGPVReports
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
        $prefix = config('services.ihook.prefix');

        // Base query
        $recordsQuery = MemberLinks::query()
            ->leftJoin($prefix.'_members_table as b', $prefix.'_matrix_members_link_table.members_id', '=', 'b.members_id')
            ->select(
                $prefix.'_matrix_members_link_table.members_id',
                $prefix.'_matrix_members_link_table.matrix_id',
                'b.members_username'
            )
            ->where($prefix.'_matrix_members_link_table.members_account_status', '1')
            ->where($prefix.'_matrix_members_link_table.members_status', '1');

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
