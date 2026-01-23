<?php
/**
 * This class contains public functions related to country list
 *
 * @package         DCountryList
 * @category        Display
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php

namespace Display\Wordpress;

class DCountryList
{
    public function getCountryList($records, $Err)
    {
        $output .= '<select aria-label="label" id="single" class="text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500" name="country" id="country" onchange="getstateforwp(this.value)" required style="height: 50px;">
             <option value="0">Select country</option>';
        if (count((array)$records) > 0) {
            for ($i = 0; $i < count((array)$records); $i++) {
                if ($Err == $records[$i]['country_master_id']) {
                    $selected = 'selected=selected';
                } else {
                    $selected = '';
                }
                $output .= '<option value="' . $records[$i]['country_master_id'] . '" ' . $selected . '>' . $records[$i]['country_master_name'] . '</option>';
            }
        }
        $output .= '</select>';
        return $output;
    }
}
?>
