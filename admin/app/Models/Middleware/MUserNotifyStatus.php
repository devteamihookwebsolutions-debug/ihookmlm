<?php

/**
 * This class contains public functions related to MSiteSettings
 *
 * @package         MSiteSettings
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

class MUserNotifyStatus
{

// public static function userMailStatus($user_id)
// {
//     $prefix = config('services.ihook.prefix');

//     $mail_notify = DB::table($prefix . '_usernotify_meta')
//         ->where('user_id', $user_id)
//         ->where('meta_key', 'mail_notify')
//         ->value('meta_value') ?? 0;

//     $notify_via = DB::table($prefix . '_usernotify_meta')
//         ->where('user_id', $user_id)
//         ->where('meta_key', 'notify_via')
//         ->value('meta_value') ?? 0;

//     return ($mail_notify == 1 && in_array($notify_via, [1, 4])) ? '1' : '0';
// }
public static function userMailStatus($user_id)
{
    $prefix = config('services.ihook.prefix');

    $mail_notify = DB::table($prefix . '_usernotify_meta')
        ->where('user_id', $user_id)
        ->where('meta_key', 'mail_notify')
        ->value('meta_value');

    $notify_via = DB::table($prefix . '_usernotify_meta')
        ->where('user_id', $user_id)
        ->where('meta_key', 'notify_via')
        ->value('meta_value');

    // If user meta not set, default to 1
    $mail_notify = is_null($mail_notify) ? 1 : $mail_notify;
    $notify_via  = is_null($notify_via) ? 4 : $notify_via; // 4 = email default

    return ($mail_notify == 1 && in_array($notify_via, [1, 4])) ? '1' : '0';
}

public static function userMailLang($user_id)
{
    $prefix = config('services.ihook.prefix'); // your table prefix

    // Get meta_value for notify_lang
    $notify_lang = DB::table($prefix . '_usernotify_meta')
        ->where('user_id', $user_id)
        ->where('meta_key', 'notify_lang')
        ->value('meta_value');
// dd($notify_lang);
    // Set default to '1' if not found or empty
    return !empty($notify_lang) ? $notify_lang : '1';
}

}
