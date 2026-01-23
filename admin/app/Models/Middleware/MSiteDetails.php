<?php

/**
 * This class contains public functions related to MSiteDetails
 *
 * @package         MSiteDetails
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?><?php
namespace Admin\App\Models\Middleware;

use Admin\App\Models\Member\currencyFormat;
use Admin\App\Models\Member\SiteDetails;
use Illuminate\Support\Facades\DB;
class MSiteDetails
{
        public static function getSiteSettingsDetails()
    {
         return SiteDetails::all();
    }
        public static function currencyformat(){
            return currencyformat::all();

        }
// public static function getSiteSettingsByName($name)
// {
//    $result=SiteDetails::where('sitesettings_name', $name)->first();
//    dd($result);

//    return $result;
// }



public static function getSiteSettingValue(string $settingName)
{
    $prefix = config('services.ihook.prefix');
    return DB::table($prefix.'_sitesettings_table')
        ->where('sitesettings_name', $settingName)
        ->value('sitesettings_value');
}
}
