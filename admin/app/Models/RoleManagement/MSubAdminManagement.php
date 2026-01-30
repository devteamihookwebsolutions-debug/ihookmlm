<?php

/**
 * This class contains public functions related to MSubAdminManagement
 *
 * @package         MSubAdminManagement
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

namespace Admin\App\Models\RoleManagement;
use Admin\App\Models\Member\Admin;
use Admin\App\Display\RoleManagement\DSubAdminManagement;
use Admin\App\Models\Middleware\MSendMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Admin\App\Models\Member\SubAdminMenuLink;
use Admin\App\Models\Middleware\MSiteDetails;
use Admin\App\Models\Middleware\MCryptoGraphy;
use Carbon\Carbon;
class MSubAdminManagement
{
    public static function showSubAdminSettings()
    {
        try {

            $records = Admin::where('admin_id', '>', 1)
                            ->orderBy('admin_id', 'desc')
                            ->get();

            // dd($records);
            return DSubAdminManagement::showSubAdminSettings($records);

        } catch (\Exception $e) {

            return collect();
        }
    }

        public static function addSubAdminDetails($request)
    {
        // dd($request->all());
        $prefix = config('services.ihook.prefix', 'ihook');
        $members_username = trim($request->sadmin_name);
        $members_email    = $request->sadmin_email;
        $members_password = $request->sadmin_password;
       $role_id = $request->role_type;
        $accesscontrol = $request->has('allaccesscontrol') ? '1' : '0';
        $status        = $request->has('admin_status') ? 'enable' : 'disable';
        $admin_type    = $request->role_type;
        // dd($admin_type);
        $admin = Admin::create([
            'admin_username'     => $members_username,
            'admin_password'     => Hash::make($members_password),
            'admin_status'       => $status,
            'intro_status'       => 0,
            'admin_email'        => $members_email,
            'admin_phone'        => $request->sadmin_phone ?? '',
            'admin_profile_image' => '',
            'admin_login_verified' => '',
            'admin_otp_decrypt'   => '',
            'admin_otp'           => '',
            'push_token'          => '',
            'allaccess_control'   => $accesscontrol,
            'admin_type'          => $admin_type,
            'created_on'           => Carbon::now()
        ]);
        // dd($admin);
       $insertId = $admin->admin_id;
    //    dd($insertId);
       $submenus = [];
       $recsss = [];
       $count = 0;

        foreach (request()->all() as $key => $value) {
            // dd($value);
            if ($count >= 4 && !in_array($key, ['sadmin_id','admincheck','do','submit','action'])) {

                $parentMenuId = DB::table($prefix. '_subadmintablemenu_table')
                    ->where('subadmin_id', $value)
                    ->value('parent_menu_id');
                // dd($parentMenuId);
                $recsss[] = $parentMenuId;
                $submenus[] = $value;
            }
            $count++;
        }


           $submenus = implode(',', $submenus);
            $submenuids = '';
            if ($accesscontrol == '1') {
                $submenuids = '1,2,3,4,5,6,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,97,98,99,100,101,102,103,104,105,106,107,108,109,110,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142';
            } else {
                $submenuids .= $submenus;
            }

            $roleSubmenu = DB::table($prefix . '_role_management_subadminmenu_link_table')
                ->where('role_id', $role_id)
                ->first();

                // dd($roleSubmenu);
            if ($roleSubmenu) {
                $submenuIds = $roleSubmenu->accesscontrol_id;

                // 2 Insert into subadmin_link_table
                $exists = DB::table($prefix . '_subadmin_link_table')
                ->where('subadmin_id', $insertId)
                ->where('role_id', $role_id)
                ->exists();

            if (!$exists) {
                DB::table($prefix . '_subadmin_link_table')->insert([
                    'subadmin_id'       => $insertId,
                    'accesscontrol_id'  => $submenuIds,
                    'privilege_setting' => 1,

                ]);
            }

                // 3 Set session message
                Session::flash('success', __('Sub Admin has been added successfully'));
            }

          $email_notification_admin = MSiteDetails::getSiteSettingValue('email_notification_admin');
          if ($email_notification_admin == '1') {
            // dd('fucntion reached or not ');

        // 2 Get first enabled admin with admin_type=1
        $admin = DB::table($prefix . '_admin_table')
            ->where('admin_status', 'enable')
            ->where('admin_type', 1)
            ->first();

        if ($admin) {
            $admin_name  = $admin->admin_username;
            $admin_email = $admin->admin_email;

            // 3 Get email template based on session language
            $mailLang = trim(session('adminsitelang_id', '1'));

            $template = DB::table($prefix . '_mailtemplates_table')
                ->where('mail_default_name', 'subadmin_register_mail')
                ->where('mail_status', 1)
                ->where('mail_lang', $mailLang)
                ->first();
            //  dd($template);
            // Fallback to mail_lang = 1 if template not found
            if (!$template) {
                $template = DB::table($prefix. 'mailtemplates_table')
                    ->where('mail_default_name', 'subadmin_register_mail')
                    ->where('mail_status', 1)
                    ->where('mail_lang', 1)
                    ->first();
            }

            if ($template) {
                $body = $template->mail_content;
                $site = env('BCPATH', url('/'));

                // 4 Replace placeholders
                $replacements = [
                    '[name]'      => $members_username,
                    '[username]'  => $members_username,
                    '[site_name]' => session('site_settings.site_name', 'My Site'),
                    '[site_link]' => $site,
                    '[password]'  => trim(request('sadmin_password')),
                ];

                $messageBody = str_replace(array_keys($replacements), array_values($replacements), $body);

                // 5 Send mail using Laravel Mail
            MSendMail::send($template, $members_email, $messageBody, '', '', $members_username);

        }
    }
        $email_notification_admin = MSiteDetails::getSiteSettingValue('email_notification_admin');
        if ($email_notification_admin == '1') {

        // dd('function reached or not ');
        // 2 Get first enabled admin with admin_type = 1
        $admin = DB::table($prefix. '_admin_table')
            ->where('admin_status', 'enable')
            ->where('admin_type', 1)
            ->first();

        if ($admin) {
            $adminName  = $admin->admin_username;
            $adminEmail = $admin->admin_email;

            // 3 Get email template for subadmin notification
            $mailLang = trim(session('adminsitelang_id', '1'));

            $template = DB::table($prefix. '_mailtemplates_table')
                ->where('mail_default_name', 'subadmin_notification_mail')
                ->where('mail_status', 1)
                ->where('mail_lang', $mailLang)
                ->first();
            // dd($template);
            // Fallback to default language if not found
            if (!$template) {
                $template = DB::table($prefix . '_mailtemplates_table')
                    ->where('mail_default_name', 'subadmin_notification_mail')
                    ->where('mail_status', 1)
                    ->where('mail_lang', 1)
                    ->first();
            }

            if ($template) {
                $body = $template->mail_content;
                $replacements = [
                    '[name]'     => $adminName,
                    '[username]' => $members_username,
                ];
               $messageBody = str_replace(array_keys($replacements), array_values($replacements), $body);
            //    dd($messageBody);
               MSendMail::send($template, $admin_email, $messageBody, '', '', $members_username);
    }
    }

}
 } else {
      Session::flash('error_message', __('Unabele to insert the details'));

        }
        return true;
}

public static function showRoleManagementSettings()
{
    $prefix = config('services.ihook.prefix', 'ihook');

    $roles = DB::table($prefix.'_role_management_roles_table')->get();

    $output = '<option value="0">Select</option>';

    foreach ($roles as $role) {
        $output .= '<option value="'.$role->id.'">'.$role->role_name.'</option>';
    }
    // dd($output);
    return $output;
}

  public static function checkSubAdminUsername($request)
    {
        $prefix = config('services.ihook.prefix', 'ihook');
        $sub1 = $request->query('sub1');
        $adminUsername = trim($request->input('sadmin_name'));

        $query = DB::table($prefix. '_admin_table')
            ->where('admin_username', $adminUsername);

        if (!empty($sub1)) {
            $query->where('admin_id', '!=', $sub1);
        }

        $exists = $query->exists();
        return response()->json($exists ? false : true);
    }

public static function showEditSubAdmin(Request $request, $id)
{
    $prefix = config('services.ihook.prefix', 'ihook');

    if (!ctype_digit((string)$id)) {
        abort(404, 'Invalid Subadmin ID');
    }

    $record = DB::table($prefix . '_admin_table')
        ->where('admin_id', (int) $id)
        ->first();

    if (!$record) {
        abort(404, 'Subadmin not found');
    }

    // dd($record);
    return $record;
}

// public static function showEditRoleManagementSettings(Request $request,$id)
// {
//     // dd($id);
//     $prefix = config('services.ihook.prefix', 'ihook');

//     // Get the role assigned to this subadmin
//     $subadminLink = DB::table($prefix . '_subadmin_link_table')
//         ->where('subadmin_id', $id)
//         ->first();
//     // dd($subadminLink);
//     $selectedRoleId = $subadminLink->role_id ?? null;
//     // dd($selectedRoleId);
//     // Get all roles
//     $roles = DB::table($prefix . '_role_management_roles_table')->get();
//     // dd($roles);
//     $output = '<option value="0">Select</option>';

//     foreach ($roles as $role) {
//         $selected = ($role->id == $selectedRoleId) ? 'selected' : '';
//         $output .= '<option value="' . $role->id . '" ' . $selected . '>'
//                  . $role->role_name .
//                  '</option>';
//     }
//     // dd($output);
//     return $output;
// }

public static function showEditRoleManagementSettings(Request $request, $id)
{
    $prefix = config('services.ihook.prefix', 'ihook');

    $subadminLink = DB::table($prefix . '_subadmin_link_table')
        ->where('subadmin_id', $id)
        ->first();

    $selectedRoleId = $subadminLink->role_id ?? null;
    //  dd($selectedRoleId);
    $roles = DB::table($prefix . '_role_management_roles_table')->get();

    // "Select" default
    $output = '<option value="0"' . (is_null($selectedRoleId) ? ' selected' : '') . '>Select</option>';

    foreach ($roles as $role) {
        $selected = ((int)$role->id === (int)$selectedRoleId) ? 'selected' : '';
        $output .= '<option value="' . $role->id . '" ' . $selected . '>'
                 . $role->role_name .
                 '</option>';

    }
// dd($selected);
    return $output;
}

    public static function updateSubAdmin(Request $request)
{
      $prefix = config('services.ihook.prefix', 'ihook');
    // 1 Validate request
    $request->validate([
        'sadmin_id'       => 'required|integer|exists:' .$prefix . '_admin_table,admin_id',
        'sadmin_name'     => 'required|string|max:255',
        'sadmin_email'    => 'required|email|max:255',
        'role_type'       => 'required|integer',
        'sadmin_password' => 'nullable|string|min:6',
        'allaccesscontrol'=> 'nullable',
        'admin_status'    => 'nullable'
    ]);

    // 2 Fetch Admin
    $admin = Admin::findOrFail($request->sadmin_id);

    // 3 Update main admin fields
    $admin->admin_username    = trim($request->sadmin_name);
    $admin->admin_email       = $request->sadmin_email;
    $admin->admin_status      = $request->has('admin_status') ? 'enable' : 'disable';
    $admin->allaccess_control = $request->input('allaccesscontrol', '0');

    if ($request->filled('sadmin_password')) {
        $admin->admin_password = MCryptoGraphy::encryptionData(trim($request->sadmin_password));
    }

    $admin->created_on = now();
    $admin->save();

    // 4 Delete existing subadmin links
    DB::table($prefix . '_subadmin_link_table')
        ->where('subadmin_id', $admin->admin_id)
        ->delete();


    // 5 Prepare submenu IDs
    $submenus = [];
    foreach ($request->except([
        'sadmin_id', 'admincheck', 'submit', 'admin_status',
        'sadmin_name', 'sadmin_email', 'role_type', 'sadmin_password', 'allaccesscontrol'
    ]) as $key => $value) {
        $parentMenuId = DB::table($prefix . '_subadmintablemenu_table')
            ->where('subadmin_id', $value)
            ->where('default_menu_name', trim($key))
            ->value('parent_menu_id');

        if ($parentMenuId) {
            $submenus[] = $value;
        }
    }

    $submenuids = $admin->allaccess_control == '1'
        ? '1,2,3,4,5,6,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,97,98,99,100,101,102,103,104,105,106,107,108,109,110'
        : implode(',', $submenus);

    // 6 Get role default submenu access
    $roleSubmenu = DB::table($prefix . '_role_management_subadminmenu_link_table')
        ->where('role_id', $request->role_type)
        ->first();

    if ($roleSubmenu) {
        $submenuids = $roleSubmenu->accesscontrol_id;
    }

    // 7 Insert new subadmin link
        DB::table($prefix . '_subadmin_link_table')->insert([
            'subadmin_id'      => $admin->admin_id,
            'accesscontrol_id' => $submenuids,
            'privilege_setting'=> '1',


        ]);

    // 8 Flash success message & redirect
    Session::flash('success', __('Sub-Admin details has been updated successfully'));

    return redirect()->route('subadmin'); // change route if necessary
}
public static function deleteSubAdmin(Request $request)
{
    try {

        // validation
        $request->validate([
            'subadminid' => 'required|array',
            'subadminid.*' => 'integer'
        ]);
   $prefix = config('services.ihook.prefix', 'ihook');
        // delete in one query
        DB::table($prefix .'_admin_table')
            ->whereIn('admin_id', $request->subadminid)
            ->delete();

        session()->flash(
            'success_message',
            __('Sub admin had been deleted successfully')
        );

        return redirect()->route('subadmin');

    } catch (\Exception $e) {

        session()->flash(
            'error_message',
            __('Please select the item to be deleted')
        );

        return redirect()->route('subadmin.index');
    }
}

}
