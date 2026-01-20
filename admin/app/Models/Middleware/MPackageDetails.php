<?php

/**
 * This class contains public functions related to MPackageDetails
 *
 * @package         MPackageDetails
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
use Admin\App\Models\Member\Package;
use DateTime;

class MPackageDetails
{

    public static function getPackageDetails($package_id)
    {
        // Retrieve the first record matching the package_id
        return Package::where('package_id', $package_id)->first();
    }


    public static function getParamPackageDetails($param = '*', $where = [])
    {
        if (!is_array($where)) {
            $where = ['package_id' => $where];
        }

        $columns = $param === '*' ? ['*'] : array_map('trim', explode(',', $param));

        return Package::select($columns)->where($where)->first();
    }
}
