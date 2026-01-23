<?php

/**
 * This class contains public functions related to DSendGridImport
 *
 * @package         DSendGridImport
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

namespace Admin\App\Display\Integrations;

class DSendGridImport
{
    /**
     * This public static function is used to show user list for sendgrid import
     * @param array  $records
     */
    public static function getSendGridImport($records)
    {
        $output = "";
        if (count((array)$records) > 0) {
            $output .= '<select aria-label="label" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" multiple data-actions-box="true" id="my_multi_select1" name="check[]" required>';

            $cnt = count((array)$records);
            for ($i = 0; $i < $cnt; $i++) {

                $selected_email = in_array($records[$i]['members_id'], $err_email) ? 'selected="selected"' : '';
                $output .= ' <option value="' . $records[$i]['members_id'] . '" ' . $records[$i]['members_email'] . '>' . $records[$i]['members_username'] . '</option>';
            }
            $output .= '</select>';
        }
        return $output;
    }
}
?>
