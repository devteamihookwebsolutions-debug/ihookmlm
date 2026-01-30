<?php
/**
 * This class contains public functions related to SubAdminManagementController
 *
 * @package         SubAdminManagementController
 * @category        Controller
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

namespace Admin\App\Http\Controllers\RoleManagement;

use Admin\App\Models\RoleManagement\MSubAdminManagement;
use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Middleware\MAdminActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Exception;
class SubAdminManagementController extends Controller
{
 public function showSubAdminSettings()
    {
        // try {
// dd('function reachd or not');
            $subAdmins = MSubAdminManagement::showSubAdminSettings();
           
            return view('rolemanagement.subadmin', ['show_sub_admin' => $subAdmins]);

        // } catch (Exception $e) {
          
        //     return redirect()->route('subadmin.index') 
        //                      ->with('error_message', $e->getMessage());
        // }
    }
    public function addSubAdminDetails(Request $request)
    {
     
            // dd('function reached or not');

            MAdminActivityLog::getAdminActivity('Sub Admin - AddSub Admin');

            // Add sub-admin details
            MSubAdminManagement::addSubAdminDetails($request);

            // Redirect to subadmin listing with success message
            return redirect()->route('subadmin.store');
                            

    }
 public function showAddSubAdmin()
    {
        // try {
       
        // dd('function reached or not');
            $showRoles = MSubAdminManagement::showRoleManagementSettings();

          
            Session::forget(['success_message', 'error_message', 'message']);

         
            return view('rolemanagement.addsubadmin', [
                'showroles' => $showRoles
            ]);

        // } catch (Exception $e) {
          
        //     Session::flash('error_message', $e->getMessage());
        //     return redirect()->route('subadmin.addsubadmin'); 
        // }
    }
     public function checkSubAdminUsername(Request $request)
    {
        // try {
            // Call the model method (convert it to return a boolean or data in Laravel)
            MSubAdminManagement::checkSubAdminUsername($request);

        
            return redirect()->route('rolemanagement.subadmin'); 
        // } catch (Exception $e) {
        //     // Set error message in session and redirect
        //     Session::flash('error_message', $e->getMessage());
        //     return redirect()->route('rolemanagement.checksubadminusername');
        // }
    }
public function showEditSubAdmin(Request $request, $id)
{
       

// try {
// echo "hiashdf";
//             exit;
            // 1 Get subadmin info
            $showEditSubadmin = MSubAdminManagement::showEditSubAdmin($request,$id);
            // dd($showEditSubadmin);
            
            // 2 Get roles
            $showRoles = MSubAdminManagement::showEditRoleManagementSettings($request,$id);
// dd($showRoles);
            // 3 Clear old session messages
            Session::forget(['success', 'error_message']);
            
            return view('rolemanagement.editsubadmin', [
                'show_editsubadmin' => $showEditSubadmin,
                'showroles' => $showRoles,
                // 'show_previlage' => $showPrevilage, // optional if implemented
            ]);

        // } catch (Exception $e) {
        //     // 5 Flash error message and redirect
        //     Session::flash('error_message', $e->getMessage());
        //     return redirect()->route('subadmin.editsubadmin'); // assuming route name
        // }
    }
       public function updateSubAdmin(Request $request)
    {
        // dd('funcrion reached or not');
        // try {
            // 1 Log Admin Activity
            MAdminActivityLog::getAdminActivity('Sub Admin - Update Sub Admin');

            // dd('funrion f readche  or not');
            MSubAdminManagement::updateSubAdmin($request);

            return redirect()->route('subadmin');

        // } catch (Exception $e) {
        //     // Flash error message
        //     Session::flash('error_message', $e->getMessage());

        //     // Redirect back to edit page
        //     return redirect()->route('subadmin.edit', ['sub1' => $request->input('sadmin_id')]);
        // }
    }

public function deleteSubAdmin(Request $request, $id)
    {
        try {
            // Log admin activity
            MAdminActivityLog::getAdminActivity('Sub Admin - Delete Sub Admin');

            // Delete subadmin by ID
            MSubAdminManagement::deleteSubAdmin($id);

            // Redirect back with success message
            return redirect()->route('subadmin')
                             ->with('success', 'Sub Admin deleted successfully.');

        } catch (Exception $e) {
            // Redirect back with error message
            return redirect()->route('subadmin.index')
                             ->with('error', $e->getMessage());
        }
    }
}