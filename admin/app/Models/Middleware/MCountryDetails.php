<?php

/**
 * This class contains public functions related to MCountryDetails
 *
 * @package         MCountryDetails
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
?>
<?php

use Admin\App\Models\Member\Country;

if (!function_exists('getAllCountries')) {
    function getAllCountries()
    {
        return Country::select('country_master_name', 'sortname')->get();
    }
   if (!function_exists('getCountryByCode')) {
    function getCountryByCode($code)
    {
        return Country::where('sortname', $code)  // or 'country_code', depending on table
                      ->select('country_master_name', 'sortname')
                      ->first();
    }
}
}
