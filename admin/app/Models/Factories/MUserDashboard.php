<?php

/**
 * This class contains public functions related to Total Commission reports
 *
 * @package
 * @category        Controller
 * @author
 * @link
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Models\Factories;
// use Admin\App\Display\Factories\DRegisterSettings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Admin\App\Models\Member\UserDashboardMeta;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class MUserDashboard
{

    public static function showUserDashboardDetails()
{
    // dd('sdaj');
    $rows = UserDashboardMeta::all();
// dd($rows);
    $fields = [];

    foreach ($rows as $row) {
        // Convert meta_key: lower case + replace space with underscore
        $key = strtolower(str_replace(' ', '_', $row->meta_key));
        $fields[$key] = $row->meta_value;
    }
// dd($fields);
    return $fields;
}
public static function updateUserDashboard(Request $request)
{
    $dashboardId = 1;

    /* -----------------------------
       Upload Files
    --------------------------------*/
    $bannerImage  = self::uploadFile($request, 'banner_image', 'hidden_banner_image');
    $profileImage = self::uploadFile($request, 'dashboard_profile_image', 'hidden_dashboard_profile_image');
    $walletImage  = self::uploadFile($request, 'dashboard_wallet_image', 'hidden_dashboard_wallet_image');

    /* -------------------------------
       Ensure checkbox fields exist
    --------------------------------*/
    $loginNotification = $request->input('loginpopup_notification', 0);
    $rankNotification  = $request->input('newrank_notification', 0);

    /* -------------------------------
       Insert/Update all POST values
    --------------------------------*/
    foreach ($request->all() as $key => $value) {

        if (in_array($key, ['_token', '_method'])) {
            continue;
        }

        DB::table('ihook_userdashboard_meta')->updateOrInsert(
            ['meta_key' => $key, 'dashboard_id' => $dashboardId],
            [
                'meta_value' => $value,
                'updated_on' => now(),
                'updated_by' => auth()->id() ?? 'system'
            ]
        );
    }

    /* -------------------------------
       Store Image Paths
    --------------------------------*/
    self::saveMeta('banner_image', $bannerImage, $dashboardId);
    self::saveMeta('dashboard_profile_image', $profileImage, $dashboardId);
    self::saveMeta('dashboard_wallet_image', $walletImage, $dashboardId);

    return back()->with('success_message', __('User dashboard settings updated successfully.'));
}

private static function uploadFile(Request $request, $inputName, $hiddenInputName)
{
    if ($request->hasFile($inputName)) {
        $file = $request->file($inputName);

        $filename = hash('sha256', $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
        $path = 'uploads/dashboard/' . $filename;

        Storage::disk('s3')->put($path, file_get_contents($file));

        return $path;
    }

    return $request->input($hiddenInputName);
}

private static function saveMeta($key, $value, $dashboardId)
{
    DB::table('ihook_userdashboard_meta')->updateOrInsert(
        ['meta_key' => $key, 'dashboard_id' => $dashboardId],
        [
            'meta_value' => $value,
            'updated_on' => now(),
            'updated_by' => auth()->id() ?? 'system'
        ]
    );
}


}
