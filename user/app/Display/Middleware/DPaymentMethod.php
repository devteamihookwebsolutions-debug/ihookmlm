<?php

/**
 * This class contains public functions related to DPaymentMethod
 *
 * @package         DPaymentMethod
 * @category        Display
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

namespace Display\Middleware;

class DPaymentMethod
{
    /**
     * This public static function is used to show preferred payment method
     * @param array $records
     * @param int $err_perferred_payment_id
     * @return HTML data
     */
    public static function showPreferrredPaymentMethod($records, $err_perferred_payment_id)
    {
        if (count((array)$records) > 0) {
            $output .= '<select aria-label="label" name="perferred_payment_id" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
              <option value="">' . __('Select') . '</option>';
            for ($i = 0; $i < count((array)$records); $i++) {
                $id = $i + 1;
                if ($err_perferred_payment_id == $id) {
                    $selected = 'selected=selected';
                } else {
                    $selected = '';
                }
                $output .= '<option value="' . $id . '" ' . $selected . '>' . $records[$i] . '</option>';
            }
            $output .= '</select>';
        }
        return $output;
    }
}
?>
