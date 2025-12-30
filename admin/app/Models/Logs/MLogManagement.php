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
    $perPage = 15;
    // Define the columns you want to select
    $aColumns = [
        'ihook_members_log_table.*', // all columns from log table
        'ihook_members_table.members_username' // joined username
    ];

    // Build the query using Eloquent
    $query = MemberLog::select($aColumns)
        ->leftJoin('ihook_members_table', 'ihook_members_table.members_id', '=', 'ihook_members_log_table.members_log_members_id')
        ->orderBy('ihook_members_log_table.members_log_id', 'desc');

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
    $records = DB::table('ihook_admin_log_table as a')
        ->leftJoin('ihook_admin_table as b', 'b.admin_id', '=', 'a.admin_log_admin_id')
        ->select('a.*', 'b.*')
        ->paginate($perPage); // <-- pagination here
// dd($records);
    return $records;
}

}