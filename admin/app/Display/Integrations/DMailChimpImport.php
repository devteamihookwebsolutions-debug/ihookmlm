<?php

/**
 * This class contains public static functions related to integration
 *
 * @package         DMailChimpImport
 * @category        Display
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
 *****************************************************************************/
?>
<?php

namespace Display\Integrations;

class DMailChimpImport
{
    /**
     * This public static function is used to show user getMailChimp Import
     * @param array  $records
     * @return HTML data
     */
    public static function getMailChimpImport($records)
    {
        $output = "";
        if (count((array)$records) > 0) {
            $output .= '<select aria-label="label" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" multiple data-actions-box="true" id="my_multi_select1" name="check[]" required>';
            for ($i = 0; $i < count((array)$records); $i++) {
                $selected_email = in_array($records[$i]['members_id'], $err_email) ? 'selected="selected"' : '';
                $output .= ' <option value="' . $records[$i]['members_id'] . '" ' . $records[$i]['members_email'] . '>' . $records[$i]['members_username'] . '</option>';
            }
            $output .= '</select>';
        }
        return $output;
    }
}
?>