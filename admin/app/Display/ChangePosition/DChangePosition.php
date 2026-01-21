<?php

/**
 * This class contains public static functions related to change position from genealogy tree.
 *
 * @package         DChangePosition
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

namespace Admin\App\Display\ChangePosition;


class DChangePosition
{
    /**
     * This public static function is used to show the users list.
     * @param array $records
     * @return HTML data
     */
    public static function viewUsers($records)
    {
        if (count((array)$records) > 0) {
            $output = '<select aria-label="label" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500" id="m_select2" name="change_member_id"  required>
        <option value="">' . __('select') . '</option>';
            for ($i = 0; $i < count((array)$records); $i++) {
                $recordsmembersdetails = MMembersDetails::getUserDetails($records[$i]['members_id']);
                $members_username      = $recordsmembersdetails['members_username'];
                $selected              = ($records[$i]['members_id'] == $_GET['sid']) ? " selected = \"selected\" " : "";
                $output .= '<option value="' . intval($records[$i]['members_id']) . '" ' . $selected . ' >' . $members_username . ' (' . $recordsmembersdetails['members_email'] . ') </option>';
            }
            $output .= '</select>';
            return $output;
        }
    }
}
?>
