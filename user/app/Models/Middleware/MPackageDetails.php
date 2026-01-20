<?php

/**
 * This class contains public functions related to MPackageDetails
 *
 * @package         MPackageDetails
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

use Illuminate\Support\Facades\DB;
use User\App\Models\Package;


if (!function_exists('getAllPackage')) {
    function getAllPackage()
    {
        return Package::all();
    }
}
if (!function_exists('getPackageById')) {
    function getPackageById($id)
    {
        return Package::where('package_id', $id)->first();
    }
}
