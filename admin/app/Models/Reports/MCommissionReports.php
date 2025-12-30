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


use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\Reports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Admin\App\Display\Reports\DCommissionReports;
class MCommissionReports{

// public static function getCommissionReports($perPage = 10)
// {
//     $query = Reports::from('ihook_history_table as a')
//         ->leftJoin('ihook_members_table as b', 'a.history_member_id', '=', 'b.members_id')
//         ->select(
//             'a.history_id',
//             'b.members_username',
//             'a.history_amount',
//             'a.history_type',
//             'a.history_datetime',
//             'a.history_member_id'
//         )
//         ->whereNotIn('a.history_type', ['withdraw_pending', 'pv'])
//         ->orderByDesc('a.history_datetime');

//     return $query->paginate($perPage);
// }
public static function getCommissionReports(Request $request)
{
    $limit = $request->input('perPage', 10);
    $page = $request->input('page', 1);
    $offset = ($page - 1) * $limit;
    $columnIndex = (int) $request->input('columnIndex');
    
    $queryValue = $request->input('query');
// dd($queryValue);
    // ✅ Build base query
    $query = DB::table('ihook_history_table as a')
        ->leftJoin('ihook_members_table as b', 'a.history_member_id', '=', 'b.members_id')
        ->select(
            'a.history_id',
            'b.members_username',
            'a.history_amount',
            'a.history_type',
            'a.history_datetime',
            'a.history_member_id'
        )
        ->whereNotIn('a.history_type', ['withdraw_pending', 'pv']);

    //Apply filters based on column index
    if (!empty($queryValue)) {
        switch ($columnIndex) {
            case 1: // Username filter
                $query->where('b.members_username', 'like', "%{$queryValue}%");
                break;

            case 3: // Type filter
                $query->where('a.history_type', 'like', "%{$queryValue}%");
                break;

            case 4: // Date range filter (format: start|end)
                $dateArray = explode('|', $queryValue);
                if (count($dateArray) === 2) {
                    $startDate = date('Y-m-d', strtotime($dateArray[0]));
                    $endDate = date('Y-m-d', strtotime($dateArray[1]));
                    $query->whereBetween(DB::raw('DATE(a.history_datetime)'), [$startDate, $endDate]);
                }
                break;
        }
    }

    // ✅ Clone query before counting
    $totalRecords = (clone $query)->count();
    //   dd($totalRecords);
    // ✅ Fetch paginated records
    $records = $query->orderByDesc('a.history_datetime')
        ->offset($offset)
        ->limit($limit)
        ->get();

    $totalPages = ceil($totalRecords / $limit);

    // ✅ Return formatted data
    return DCommissionReports::getCommissionReports($records, $totalPages, $totalRecords);
}


}