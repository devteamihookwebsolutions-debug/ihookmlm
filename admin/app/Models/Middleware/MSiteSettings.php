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
class MSiteSettings
{
public static function showSiteSettings($Err = null)
{
    $prefix = config('services.ihook.prefix');
    $fields = [];

    $records = DB::table($prefix . '_sitesettings_table')->get();

    foreach ($records as $row) {
        $key = strtolower(
            str_replace(' ', '_', $row->sitesettings_name)
        );

        $fields[$key] = $row->sitesettings_value;
    }
    if (
        $Err &&
        isset($Err->messages) &&
        count((array) $Err->messages) > 0 &&
        isset($Err->values)
    ) {
        $fields = $Err->values;
    }
    //  dd($fields);
    return $fields;
}
}
