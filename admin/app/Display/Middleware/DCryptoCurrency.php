<?php

/**
 * This class contains public functions related to DCryptoCurrency
 *
 * @package         DCryptoCurrency
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

namespace Admin\App\Http\Display\Middleware;
class DCryptoCurrency
{

    public static function getCryptoCurrency($records, $editable = null)
{
    if ($records->isEmpty()) {
        return '<select id="cryptocurrency" name="cryptocurrency"
                class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                <option value="">-- No active currency found --</option>
            </select>';
    }

    $output = '<select id="cryptocurrency" name="cryptocurrency"
                class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">';
    $output .= '<option value="">-- Select currency --</option>';

    foreach ($records as $record) {
        $selected = ($editable == trim($record->crypto_currency_id)) ? 'selected' : '';
        $output .= '<option value="' . $record->crypto_currency_id . '" ' . $selected . '>'
                    . strtoupper(e($record->crypto_name)) . '</option>';
    }

    $output .= '</select>';

    return $output;
}

}
