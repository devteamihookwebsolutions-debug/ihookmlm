<?php

/**
 * This class contains public functions related to DMultiCurrency
 *
 * @package         DMultiCurrency
 * @category        Display
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

namespace Display\Middleware;

class DMultiCurrency
{
    /**
     * This public static function is used to show multicurrency list
     * @param array  $records
     * @return HTML data
     */
    public static function getMultiCurrency($records)
    {
        if (count((array)$records) > 0) {
            $output .= '<section id="showmulitcur"><select aria-label="label" id="multicurrency" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500" name="multicurrency" onchange="changemulticurrency(this.value);"> <option value="">' .__('Select'). '</option>';
            for ($i = 0; $i < count((array)$records); $i++) {
                if ($_SESSION['matrix']['temp_site_currency_code'] == $records[$i]['currency_value']) {
                    $selected = 'selected=selected';
                } else {
                    $selected = '';
                }
                $output .= '<option value="' . $records[$i]['currency_id'] . '" ' . $selected . '>' . $records[$i]['currency_symbol'] . '&nbsp(' . $records[$i]['currency_value'] . ')</option>';
            }
            $output .= '</select></section>';
        }
        return $output;
    }
}
?>
