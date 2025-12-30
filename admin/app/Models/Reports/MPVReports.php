<?php
/**
 * This class contains public static functions related to commission reports .
 *
 * @package         MCommissionReports
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://promlmsoftware.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?>
<?php
namespace Admin\App\Models\Reports;
use Admin\App\Display\Reports\DPVReports;
use Admin\App\Models\Member\Reports;
use Illuminate\Http\Request;

class MPVReports
{
public static function getPVReports(Request $request)
{
    $perPage = (int) $request->input('perPage', 10);
    $page = (int) $request->input('page', 1);
    $queryValue = trim($request->input('query', ''));

    $query = Reports::from('ihook_history_table as a')
        ->join('ihook_members_table as b', 'a.history_member_id', '=', 'b.members_id')
        ->where('a.history_type', '=', 'pv')
        ->select(
            'a.history_id',
            'b.members_username',
            'a.history_amount',
            'a.history_datetime',
            'b.members_id'
        );

    // THIS IS THE MAIN FIX - Global Search across all columns
    if (!empty($queryValue)) {
        $query->where(function($q) use ($queryValue) {
            $q->where('b.members_username', 'LIKE', "%{$queryValue}%")
              ->orWhere('a.history_amount', 'LIKE', "%{$queryValue}%")
              ->orWhere('a.history_datetime', 'LIKE', "%{$queryValue}%")
              ->orWhereRaw("DATE_FORMAT(a.history_datetime, '%d-%m-%Y') LIKE ?", ["%{$queryValue}%"])
              ->orWhereRaw("CONCAT('', a.history_id) LIKE ?", ["%{$queryValue}%"]); // SNo is number
        });
    }

    $totalCount = (clone $query)->count();
    $totalPages = ceil($totalCount / $perPage);

    $records = $query
        ->orderBy('a.history_id', 'DESC')
        ->skip(($page - 1) * $perPage)
        ->take($perPage)
        ->get();

    return DPVReports::getPVReports($records, $totalPages, $totalCount);
}
}



