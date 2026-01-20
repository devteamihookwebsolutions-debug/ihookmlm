<?php

/**
 * This class contains public functions related to MBonusAchieved
 *
 * @package         MBonusAchieved
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


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Admin\App\Display\Reports\DBonusAchieved;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\BonusAchieved;

class MBonusAchieved
{

public static function bonusAchieved(Request $request)
{
    $prefix = 'ihook_'; // fallback prefix
    //  dd($prefix);
    $bonusAchievedTable = $prefix . 'bonusachieved';
    $bonusTable = $prefix . 'bonus';
    $membersTable = $prefix . 'members_table';

    $limit = $request->input('perPage', 10);
    $page = $request->input('page', 1);
    $offset = ($page - 1) * $limit;
    $columnIndex = (int) $request->input('columnIndex', 0);
    $queryValue = $request->input('query');
    $sortDir = $request->input('sortDir', 'asc');

    // Define sortable columns
    $aColumnsorderby = [
        'ba.bonusid',
        'm.members_username',
        'b.bonus_name',
        'ba.bonustype',
        'ba.bonusresult',
        'ba.bonus_status',
        'ba.achieveddate',
    ];

    // Base query with correct prefixed table names
    $query = DB::table("$bonusAchievedTable as ba")
        ->leftJoin("$bonusTable as b", 'b.bonusid', '=', 'ba.bonusid')
        ->leftJoin("$membersTable as m", 'm.members_id', '=', 'ba.user_id')
        ->select(
            'ba.*',
            'm.members_username',
            'b.bonus_name'
        )
        ->where('ba.bonusid', '!=', 0);
    //   dd($query);
    // Apply filters (converted from old $wheres logic)
    if (!empty($queryValue)) {
        if ($columnIndex === 1) {
            $query->where('m.members_username', trim($queryValue));
        } elseif ($columnIndex === 2) {
            $query->where('b.bonus_name', trim($queryValue));
        } elseif ($columnIndex === 3) {
            $query->where('ba.bonustype', trim($queryValue));
        } elseif ($columnIndex === 5) {
            $query->where('ba.bonus_status', trim($queryValue));
        } elseif ($columnIndex === 6) {
            $dateArray = explode('|', $queryValue);
            if (count($dateArray) === 2) {
                $startDate = date('Y-m-d', strtotime($dateArray[0]));
                $endDate = date('Y-m-d', strtotime($dateArray[1]));
                $query->whereBetween(DB::raw('DATE(ba.achieveddate)'), [$startDate, $endDate]);
            }
        }
    }

    // Apply ordering if column exists
    if (isset($aColumnsorderby[$columnIndex])) {
        $query->orderBy($aColumnsorderby[$columnIndex], $sortDir);
    }

    // Total record count
    $totalRecords = $query->count();

    // Paginated data
    $records = $query->offset($offset)->limit($limit)->get();

    $totalPages = ceil($totalRecords / $limit);
    // dd($records);
    return DBonusAchieved::bonusAchieved($records, $totalPages, $totalRecords);

}

}
