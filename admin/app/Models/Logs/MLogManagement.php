<?php

/**
 * This class contains public functions related to MLogManagement
 *
 * @package         MLogManagement
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
namespace Admin\App\Models\Logs;
use Admin\App\Display\Logs\DLogManagement;
use Illuminate\Support\Facades\DB;
use Admin\App\Models\Member\MemberLog;
use Illuminate\Http\Request;

class MLogManagement
{
public static function showUserLogs()
{
     $prefix = config('services.ihook.prefix');
    $perPage = 15;
    // Define the columns you want to select
    $aColumns = [
        $prefix.'_members_log_table.*', // all columns from log table
        $prefix.'_members_table.members_username' // joined username
    ];

    // Build the query using Eloquent
    $query = MemberLog::select($aColumns)
        ->leftJoin($prefix.'_members_table', $prefix.'_members_table.members_id', '=', $prefix.'_members_log_table.members_log_members_id')
        ->orderBy($prefix.'_members_log_table.members_log_id', 'desc');

    // Paginate results
    $records = $query->paginate($perPage);

    // Optionally get total distinct count (if needed)
    $iTotal = (clone $query)
        ->distinct('members_log_id')
        ->count('members_log_id');

    // Return formatted data using your existing handler
    // dd($records);
    return $records;
}

 public static function showAdminLogs($perPage = 15) // default 15 records per page
{
    $prefix = config('services.ihook.prefix');

    $records = DB::table($prefix.'_admin_log_table as a')
        ->leftJoin($prefix.'_admin_table as b', 'b.admin_id', '=', 'a.admin_log_admin_id')
        ->select('a.*', 'b.*')
        ->paginate($perPage); // <-- pagination here
// dd($records);
    return $records;
}

}
