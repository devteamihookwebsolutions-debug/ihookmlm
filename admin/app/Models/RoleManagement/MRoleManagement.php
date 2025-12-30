<?php

namespace Admin\App\Models\RoleManagement;
use Admin\App\Display\RoleManagement\DRoleManagement;
use Admin\App\Models\Member\RoleManagementRole;
use Admin\App\Models\Member\SubAdminTableMenu;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class MRoleManagement
{
    
    public static function showRoleManagementSettings()
    {
        // dd('lkahsdf');
         $records = RoleManagementRole::all();

        //  dd($records);
    // Call the DRoleManagement method with the records
    return DRoleManagement::showRoleManagementSettings($records);
    }
    public static function getMenu()
{
    // Fetch menu items where parent_menu_id = 0 and status = 1
    $records = SubAdminTableMenu::where('parent_menu_id', 0)
                ->where('status', 1)
                ->get()
                ->toArray();

    // dd($records);
    return DRoleManagement::getMenu($records);
}
public static function updateRole($request)
{
    $request->validate([
        'role_type_id' => 'required|integer',
        'mainmenu_id'  => 'required|string',
        'submenu_id'   => 'required|string',
    ]);

    $roleId = $request->role_type_id;
    // dd($roleId);
    $mainMenu = explode(',', $request->mainmenu_id);
    $subMenu = explode(',', $request->submenu_id);

    $overallMenuArray = array_merge($mainMenu, $subMenu);
    sort($overallMenuArray);

    // If ALL menu selected
    if ($mainMenu[0] === 'all_menu') {

        $allMenus = DB::table('ihook_subadmintablemenu_table')
            ->where('status', '1')
            ->pluck('subadmin_id')
            ->toArray();

        $overallMenu = implode(',', $allMenus);
        $allMenuStatus = 1;

    } else {
        $overallMenu = implode(',', $overallMenuArray);
        $allMenuStatus = 0;
    }

    // Check role exists
    $recordExists = DB::table('ihook_role_management_subadminmenu_link_table')
        ->where('role_id', $roleId)
        ->exists();

    if ($recordExists) {

        // Update role
        DB::table('ihook_role_management_subadminmenu_link_table')
            ->where('role_id', $roleId)
            ->update([
                'accesscontrol_id' => $overallMenu,
                'all_menu_status'  => $allMenuStatus,
                'updated_on'       => now(),
            ]);

        // Update subadmin table
        DB::table('ihook_subadmin_link_table')
            ->updateOrInsert(
                ['role_id' => $roleId],
                ['accesscontrol_id' => $overallMenu]
            );

        return ['status' => true, 'message' => 'Role updated successfully'];
    }

    return ['status' => false, 'message' => 'Role not found'];
}

public static function create_role($request)
{
    // dd('ashd');
    // Validate the request
    $request->validate([
        'recipient_name' => 'required|string|max:255',
        'role_type'      => 'required|integer',
        'selectedmainmenu' => 'required|string',
        'selectedsubmenuadd' => 'required|string',
    ]);

    $roleName = $request->recipient_name;
    // dd($roleName);
    $roleType = $request->role_type;
    $mainMenu = explode(',', $request->selectedmainmenu);
    $subMenu = explode(',', $request->selectedsubmenuadd);

    $overallMenuArray = array_merge($mainMenu, $subMenu);
    sort($overallMenuArray);

    // Handle "all_menu" selection
    if ($mainMenu[0] === 'all_menu') {
        $allMenus = DB::table('ihook_subadmintablemenu_table')
            ->where('status', 1)
            ->pluck('subadmin_id')
            ->toArray();

        $overallMenu = implode(',', $allMenus);
        $allMenuStatus = 1;
    } else {
        $overallMenu = implode(',', $overallMenuArray);
        $allMenuStatus = 0;
    }

    // Determine copy role ID if user selects an existing role
    $copyRoleId = 0;
    if ($roleType != 0) {
        $copyRole = DB::table('ihook_role_management_roles_table')
            ->where('id', $roleType)
            ->first();

        if ($copyRole) {
            $copyRoleId = $copyRole->id;
        }
    }

    // Insert new role
    $roleId = DB::table('ihook_role_management_roles_table')->insertGetId([
        'role_name' => $roleName,
        'created_on' => now(),
         'updated_on' => now(),
        'copy_id' => $copyRoleId,
    ]);
// dd($roleId);
    // If copying an existing role, fetch its access controls
    if ($copyRoleId > 0) {
        $copyRoleAccess = DB::table('ihook_role_management_subadminmenu_link_table')
            ->where('role_id', $copyRoleId)
            ->first();

        if ($copyRoleAccess && $copyRoleAccess->accesscontrol_id != '') {
            $overallMenu = $copyRoleAccess->accesscontrol_id;
            $allMenuStatus = $copyRoleAccess->all_menu_status;
        }
    }

    // Insert role access
    DB::table('ihook_role_management_subadminmenu_link_table')->insert([
        'role_id' => $roleId,
        'accesscontrol_id' => $overallMenu,
        'copy_id' => $copyRoleId,
        'all_menu_status' => $allMenuStatus,
        'created_on' => now(),
        'updated_on' => now(),
    ]);
 
    Session::flash('success', 'Role added successfully!');
    
    return redirect()->route('rolemanagement.view', ['id' => 1]);
}
public static function deleteRole($id)
{
    // dd($id);
    DB::table('ihook_role_management_roles_table')
        ->where('id', $id)
        ->delete();

    DB::table('ihook_role_management_subadminmenu_link_table')
        ->where('role_id', $id)
        ->delete();

    return true;
}

}