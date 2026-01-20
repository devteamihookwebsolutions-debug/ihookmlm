<?php

/**
 * This class contains public functions related to MSystemManagement
 *
 * @package         MSystemManagement
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

namespace Admin\App\Models\SystemModule;
use Admin\App\Models\Middleware\MSiteAppLink;

use Illuminate\Support\Facades\DB;

class MSystemManagement
{

        public static function checkSystemModuleActive($menu_name)
    {

        $applink = MSiteAppLink::getSiteAppLink();

    // Safe server IP fallback
    $ip = request()->server('SERVER_ADDR')
        ?? request()->server('LOCAL_ADDR')
        ?? request()->ip();

    $ch = curl_init();
    $fields = [
        'domainname' => $applink,
        'ipaddress'  => $ip,
        'menu_name'  => $menu_name
    ];
         //  print_r($fields); exit;
        // curl_setopt($ch, CURLOPT_URL, "https://licensing.sunsoftny.com/license/getactivesystemmodulelist");
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // curl_setopt($ch, CURLOPT_VERBOSE, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // $server_output = curl_exec($ch);
        // $errors        = curl_error($ch);
        // $response      = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // curl_close($ch);
        // return $server_output;
    }
}
