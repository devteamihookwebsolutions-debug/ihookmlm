<?php
namespace Admin\App\Models\Middleware;
use Illuminate\Support\Facades\DB;
class MAdminActivityLog
{


public static function getAdminActivity($module)
{
    
    $adminId    = session('admin.id');
    $adminName  = session('admin.name');
    $adminType  = session('admin.admin_type');
    $adminIp    = request()->ip();

    
if (!$adminId) {
    // log and stop execution
    \Log::error('Admin session not found');
    return false; // or throw exception
}

session([
    'admin' => [
        'id'         => $admin->id,
        'name'       => $admin->name,
        'admin_type' => $admin->admin_type,
    ]
]);

    DB::table('ihook_admin_activity_log_table')->insert([
        'adminid'        => $adminId,
        'adminname'      => $adminName,
        'admin_type'     => $adminType,
        'admin_ipaddress'=> $adminIp,
        'module_name'    => $module,
        'in_time'        => now(),
        'out_time'       => null,
        'status'         => 1, 
    ]);

    return true;
}

}