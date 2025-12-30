<?php

namespace Admin\App\Models\Reports;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Admin\App\Display\Reports\DBonusAchieved;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\BonusAchieved;

class MBonusAchieved
{
//     public static function bonusAchieved(Request $request)
// {
//     // Pagination setup
//     $limit = $request->input('perPage', 10);
//     $page = $request->input('page', 1);
//     $offset = ($page - 1) * $limit;

//     $columnIndex = (int) $request->input('columnIndex');
//     $queryValue = $request->input('query');

//     // Base query
//     $query = DB::table('bonusachieved as ba')
//         ->leftJoin('bonus as b', 'b.bonusid', '=', 'ba.bonusid')
//         ->leftJoin('ihook_members_table as m', 'm.members_id', '=', 'ba.user_id')
//         ->select(
//             'ba.*',
//             'm.members_username',
//             'b.bonus_name'
//         )
//         ->where('ba.bonusid', '!=', 0);

//     // --- Filters (using if conditions, like your original) ---
//     if (!empty($queryValue)) {

//         if ($columnIndex == 1) {
//             $query->where('m.members_username', trim($queryValue));
//         }

//         if ($columnIndex == 2) {
//             $query->where('b.bonus_name', trim($queryValue));
//         }

//         if ($columnIndex == 3) {
//             $query->where('ba.bonustype', trim($queryValue));
//         }

//         if ($columnIndex == 5) {
//             $query->where('ba.bonus_status', trim($queryValue));
//         }

//         if ($columnIndex == 6) {
//             $dateArray = explode('|', $queryValue);
//             if (count($dateArray) == 2) {
//                 $startDate = date('Y-m-d', strtotime($dateArray[0]));
//                 $endDate   = date('Y-m-d', strtotime($dateArray[1]));
//                 $query->whereBetween(DB::raw('DATE(ba.achieveddate)'), [$startDate, $endDate]);
//             }
//         }
//     }

//     // --- Get total count before pagination ---
//     $totalRecords = $query->count();
//     $totalRecords = $totalRecords > 0 ? $totalRecords : 0;
//     $totalPages = ceil($totalRecords / $limit);

//     // --- Apply pagination ---
//     $records = $query
//         ->offset($offset)
//         ->limit($limit)
//         ->get();

//     // --- Optional: Pass to DBonusAchieved (if still used in your architecture) ---
//     return DBonusAchieved::bonusAchieved($records, $totalPages, $totalRecords);

//     // --- Or directly return JSON response ---
//     return response()->json([
//         'records' => $records,
//         'total_records' => $totalRecords,
//         'total_pages' => $totalPages,
//         'per_page' => $limit,
//         'current_page' => $page,
//     ]);
// }


// public static function bonusAchieved($request)
// {
//     $limit = $request->input('perPage', 10);
//     $page = $request->input('page', 1);
//     $offset = ($page - 1) * $limit;
//     $columnIndex = (int) $request->input('columnIndex', 0);
//     $queryValue = $request->input('query');
//     $sortDir = $request->input('sortDir', 'asc'); // optional ascending/descending sort

//     //Define sortable columns (no need for prefix)
//     $aColumnsorderby = [
//         'ba.bonusid',
//         'm.members_username',
//         'b.bonus_name',
//         'ba.bonustype',
//         'ba.bonusresult',
//         'ba.bonus_status',
//         'ba.achieveddate'
//     ];

//     // Base query
//     $query = DB::table('bonusachieved as ba')
//         ->leftJoin('bonus as b', 'b.bonusid', '=', 'ba.bonusid')
//         ->leftJoin('members_table as m', 'm.members_id', '=', 'ba.user_id')
//         ->select(
//             'ba.*',
//             'm.members_username',
//             'b.bonus_name'
//         )
//         ->where('ba.bonusid', '!=', 0);

//     // ✅ Apply filters (converted from your $wheres logic)
//     if (!empty($queryValue)) {
//         if ($columnIndex === 1) {
//             $query->where('m.members_username', trim($queryValue));
//         } elseif ($columnIndex === 2) {
//             $query->where('b.bonus_name', trim($queryValue));
//         } elseif ($columnIndex === 3) {
//             $query->where('ba.bonustype', trim($queryValue));
//         } elseif ($columnIndex === 5) {
//             $query->where('ba.bonus_status', trim($queryValue));
//         } elseif ($columnIndex === 6) {
//             $dateArray = explode('|', $queryValue);
//             if (count($dateArray) === 2) {
//                 $startDate = date('Y-m-d', strtotime($dateArray[0]));
//                 $endDate = date('Y-m-d', strtotime($dateArray[1]));
//                 $query->whereBetween(DB::raw('DATE(ba.achieveddate)'), [$startDate, $endDate]);
//             }
//         }
//     }

//     // Ordering (like old `$aColumnsorderby`)
//     if (isset($aColumnsorderby[$columnIndex])) {
//         $query->orderBy($aColumnsorderby[$columnIndex], $sortDir);
//     }

//     // Total count
//     $totalRecords = $query->count();

//     // Paginated data
//     $records = $query->offset($offset)->limit($limit)->get();

//     $totalPages = ceil($totalRecords / $limit);
//    dd($records);
//     return response()->json([
//         'records' => $records,
//         'total_records' => $totalRecords,
//         'total_pages' => $totalPages,
//     ]);
// }



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
