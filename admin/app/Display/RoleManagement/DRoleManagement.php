<?php
namespace Admin\App\Display\RoleManagement;
use Admin\App\Models\Member\SubAdminMenuLink;
use Admin\App\Models\Member\SubAdminTableMenu;
use Illuminate\Http\JsonResponse;

class DRoleManagement
{
public static function showRoleManagementSettings($records)
{
    $output = '';

    // Get ID from route
    $selectedRole = request()->route('id');

    if (count($records) > 0) {
        foreach ($records as $record) {
            $selected = ($selectedRole == $record->id) ? 'selected' : '';

            $output .= '<option value="'. $record->id .'" '. $selected .'>'. $record->role_name .'</option>';
        }
    }
// dd($output);
    return $output;
}

public static function getMenu($records)
{
    // dd($records);
    // dd('jklahs');
    $roleId = request('id', 1); // default role 1
    // dd($roleId);
    // Fetch role access settings
    $roleAccess = SubAdminMenuLink::where('role_id', $roleId)->first();
    // dd($roleAccess);
    if (!$roleAccess) {
        return "<p>No access configuration found.</p>";
    }

    $allAccessStatus = $roleAccess->all_menu_status; // 1 or 0
    // dd($allAccessStatus);
    $accessControlIds = explode(',', $roleAccess->accesscontrol_id);
    // dd($accessControlIds);

    $allChecked = $allAccessStatus == 1 ? 'checked' : '';
    // dd($allChecked);

    // Start HTML output
    $output = '
        <div class="flex items-center space-x-3 mb-6">
            <input type="checkbox" id="all_menu" '.$allChecked.' name="selectedmenu[]" class="h-5 w-5 text-black border-neutral-300 rounded all_menu_checkbox" value="all_menu"/>
            <label for="all_menu" class="text-md font-medium text-black">Select All Menus</label>
        </div>
        <div class="space-y-2">
    ';
// dd($output);
    // Loop through main menus
    foreach ($records as $i => $menu) {
// dd($records);
        $checked = (
            ($allAccessStatus == 0 && in_array($menu['subadmin_id'], $accessControlIds))
            || $allAccessStatus == 1
        ) ? 'checked' : '';

        // dd($allAccessStatus);
        // Load submenus
        $submenus = SubAdminTableMenu::where('parent_menu_id', $menu['subadmin_id'])
            ->where('status', 1)
            ->get();
        // dd($submenus);
        // If submenu exists — accordion
        if ($submenus->count() > 0) {

            $output .= '
            <div class="accordion">
                <div class="flex items-center cursor-pointer p-3 rounded-lg hover:bg-neutral-100"
                     onclick="toggleSubmenu(\'menu-'.$i.'\')">

                    <span class="mr-3">
                        <svg id="menu-'.$i.'-icon" class="w-6 h-6 text-black transform transition-all" height="24"
                             fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m7 16 4-4-4-4m6 8 4-4-4-4" />
                        </svg>
                    </span>

                    <input type="checkbox" id="menu-'.$i.'" name="selectedmenu[]" '.$checked.'
                        class="h-5 w-5 text-black border-neutral-300 rounded main-menu-checkbox checkboxes"
                        value="'.$menu['subadmin_id'].'"/>

                    <label for="menu-'.$i.'" class="ml-3 text-md font-medium text-black">
                        '.$menu['subadmin_menu'].'
                    </label>
                </div>

                <div id="submenu-'.$i.'"
                    class="submenu lg:pl-20 pl-16 py-2 space-y-2 mt-2 h-50 bg-neutral-100 rounded-lg shadow max-h-60 overflow-y-auto hidden">
            ';

            foreach ($submenus as $j => $sub) {
                $subChecked = (
                    ($allAccessStatus == 0 && in_array($sub->subadmin_id, $accessControlIds))
                    || $allAccessStatus == 1
                ) ? 'checked' : '';

                $output .= '
                <div class="flex items-center">
                    <input type="checkbox" id="submenu-'.$i.'-'.$j.'" '.$subChecked.'
                        name="selectedsubmenu[]" class="h-5 w-5 text-black border-neutral-300 rounded sub-menu-checkbox"
                        value="'.$sub->subadmin_id.'" />

                    <label for="submenu-'.$i.'-'.$j.'" class="ml-3 text-black">
                        '.$sub->subadmin_menu.'
                    </label>
                </div>';
            }

            $output .= '</div></div>';

        } else {
            // Menu without submenu
            $output .= '
            <div class="accordion">
                <div class="flex items-center p-3 rounded-lg hover:bg-neutral-100">
                    <span class="mr-9"></span>

                    <input type="checkbox" id="menu-'.$i.'" '.$checked.'
                        name="selectedmenu[]" class="h-5 w-5 text-black border-neutral-300 rounded main-menu-checkbox checkboxes"
                        value="'.$menu['subadmin_id'].'" />

                    <label for="menu-'.$i.'" class="ml-3 text-md font-medium text-black">
                        '.$menu['subadmin_menu'].'
                    </label>
                </div>
            </div>';
        }
    }

    $output .= '</div>';

    // dd($output);
    return $output;
}
}
