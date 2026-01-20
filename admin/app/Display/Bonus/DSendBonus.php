<?php

/**
 * This class contains public functions related to DSendBonus
 *
 * @package         DSendBonus
 * @category        Display
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
namespace Admin\App\Display\Bonus;


class DSendBonus
{
     public static function showUser($records)
    {
        if ($records->isEmpty()) {
            return '';
        }

        $output = '<select aria-label="label"
            class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
            dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800
            dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
            multiple data-actions-box="true" id="user_list" name="user_list[]" required>';

        foreach ($records as $member) {
            $output .= sprintf(
                '<option value="%s">%s</option>',
                e($member->members_id),
                e($member->members_username)
            );
        }

        $output .= '</select>';

// dd($output);
        // dd($output);
        return $output;
    }
}
