<?php
/**
 * This class contains public static functions related to matrix management
 *
 * @package         DShopifyEshop
 * @category        Display
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version        Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php

namespace Admin\App\Display\Shopify;
class DShopifyEshop
{

    public static function showProductList($records)
    {
        $output = '<div class="">';
        $output .= ' <select aria-label="label" id="eshopproducts" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500" name="eshopproducts" required>
             <option selected disabled hidden style="display: none" value="">' . __('select') . '</option>';
        if (count((array)$records) > 0) {
            for ($i = 0;$i < count((array)$records);$i++) {
                $output .= '<option value="' . $records[$i]['id'] . '">' . $records[$i]['title'] . ' </option>';
            }
        }
        $output .= '</select>';
        return $output;
    }

    public static function editEshopProducts($records, $eshop_id)
    {
        $output = '<div class="">';
        $output .= ' <select aria-label="label" id="eshopproducts" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500" name="eshopproducts" required>
             <option selected disabled hidden style="display: none" value="">' . __('select') . '</option>';
        if (count((array)$records) > 0) {
            for ($i = 0;$i < count((array)$records);$i++) {
                $selected = ($records[$i]['id'] == $eshop_id) ? 'selected=selected' : '';
                $output .= '<option value="' . $records[$i]['id'] . '" '.$selected.'>' . $records[$i]['title']. ' </option>';
            }
        }
        $output .= '</select>';
        return $output;

    }

}
?>
