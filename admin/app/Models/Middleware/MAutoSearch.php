<?php

/**
 * This class contains public functions related to MAutoSearchMembers
 *
 * @package         MAutoSearchMembers
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
namespace Admin\App\Models\Middleware;
use Admin\App\Models\Member\Member;
use Admin\App\Display\Bonus\DSendBonus;
use Admin\App\Display\Middleware\DAutoSearchMembers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
class MAutoSearch
{

 public static function getAllMembersNew()
{
    $table = (new Member)->getTable(); // 'ihook_members_table'
    $joinTable = str_replace('members_table', 'matrix_members_link_table', $table); // 'ihook_matrix_members_link_table'

    $records = Member::query()
        ->from($table . ' as a') // give an alias to main table
        ->leftJoin($joinTable . ' as b', 'a.members_id', '=', 'b.members_id')
        ->select('a.members_username', 'a.members_id')
        ->where('b.members_status', '>', 0)
        ->orderBy('a.members_username', 'asc')
        ->get();
        // dd($records);

    return DAutoSearchMembers::getAllMembersNew($records);
}
public static function getMembersList($searchval, $matrix_id, $wherecondition = '')
{
    // Start query
    $query = DB::table(env('IHOOK_PREFIX') . 'members_table as a')
        ->leftJoin(env('IHOOK_PREFIX') . 'matrix_members_link_table as b', 'a.members_id', '=', 'b.members_id')
        ->select('a.members_username', 'a.members_id')
        ->where('b.members_status', '>', 0);

    // Apply search filter if provided
    if (!empty($searchval)) {
        $query->where('a.members_username', 'like', $searchval . '%');
    }

    // Apply matrix filter if provided
    if (!empty($matrix_id) && $matrix_id > 0) {
        $query->where('b.matrix_id', $matrix_id);
    }

    // If your $wherecondition adds extra conditions dynamically:
    // Convert string conditions into closures or handle safely:
    if (!empty($wherecondition)) {
        // Only allow safe conditions or pre-validated clauses here
        $query->whereRaw($wherecondition);
    }

    // Apply grouping and limit
    $records = $query->groupBy('a.members_id')
                     ->limit(50)
                     ->get();

    // Return JSON response directly
    // dd($records);
    return response()->json($records);
}
public static function getAllMembers()
{
    // dd('funcion reached');
    $table = (new Member)->getTable(); // 'ihook_members_table'
    $joinTable = str_replace('members_table', 'matrix_members_link_table', $table); // 'ihook_matrix_members_link_table'

    $records = Member::query()
        ->from($table . ' as a') // give an alias to main table
        ->leftJoin($joinTable . ' as b', 'a.members_id', '=', 'b.members_id')
        ->select('a.members_username', 'a.members_id')
        ->where('b.members_status', '>', 0)
        ->orderBy('a.members_username', 'asc')
        ->get();
        // dd($records);

    return DAutoSearchMembers::getAllMembers($records);
}
}
