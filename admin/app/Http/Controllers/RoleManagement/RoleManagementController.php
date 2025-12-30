<?php

namespace Admin\App\Http\Controllers\RoleManagement;


use Admin\App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Admin\App\Models\RoleManagement\MRoleManagement;
use Admin\App\Models\Middleware\MAdminActivityLog;

class RoleManagementController extends Controller
{
    // Show Role Management page
public function showRoleManagementSettings($id)
{
    $selectedRole = $id;

    // fetch roles
    $showroles = MRoleManagement::showRoleManagementSettings();
    // dd($showroles);
    // fetch menu
    $allmenu = MRoleManagement::getMenu();

    return view('rolemanagement.roleaccess', [
        'showroles' => $showroles,
        'allmenu' => $allmenu,
        'selectedRole' => $selectedRole
    ]);
}

    // Get Submenus
    public function getSubMenus()
    {
        try {
            return MRoleManagement::getSubMenus();
        } catch (\Exception $e) {
            return redirect()->route('rolemanagement.index')
                ->with('error_message', $e->getMessage());
        }
    }

    // Create Role
    public function createRole(Request $request)
    {
        // dd('function reached or not');
      
            $create_role['create_role'] = MRoleManagement::create_role($request);
            // dd($create_role);
         
        return redirect()->route('rolemanagement.view', ['id' => 1])
                     ->with('success', 'Role added successfully!');
    }

    // Validate Role
    public function validateRole(Request $request)
    {
        try {
            return MRoleManagement::validate_role($request);
        } catch (\Exception $e) {
            return redirect()->route('rolemanagement.index')
                ->with('error_message', $e->getMessage());
        }
    }

    // Update Role
    public function updateRole(Request $request)
    {
        // dd('function reached or not');
        // try {
            MAdminActivityLog::getAdminActivity('RoleManagement - Update Role');
            // MRoleManagement::updateRole($request);
            
          
    $result = MRoleManagement::updateRole($request);
    // dd($result);
    return response()->json($result);
        // } catch (\Exception $e) {
        //     return redirect()->back()->with('error_message', $e->getMessage());
        // }
    }

    // Delete Role
public function deleterole($id)
{
    // dd('function reached or not');
    MAdminActivityLog::getAdminActivity('RoleManagement - Delete Role');

    MRoleManagement::deleteRole($id);

    return response()->json([
        'status' => 'success',
        'message' => 'Role deleted successfully'
    ]);
}


    // Role Assign Detail
    public function roleAssignDetail($roleId)
    {
        try {
            $details = MRoleManagement::roleAssignDetail($roleId);
            return view('rolemanagement.role_assign_detail', compact('details'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', $e->getMessage());
        }
    }

    // Add Menu Page
    public function addMenu()
    {
        try {
            $main_menu = MRoleManagement::mainMenus();
            return view('rolemanagement.addmenu', compact('main_menu'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', $e->getMessage());
        }
    }

    // Remove Menu Page
    public function removeMenu()
    {
        try {
            $main_menu = MRoleManagement::allmainmenus();
            return view('rolemanagement.removemenu', compact('main_menu'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', $e->getMessage());
        }
    }

}
