<?php

/**
 * This class contains public functions related to MAdminActivityLog
 *
 * @package         MAdminActivityLog
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
