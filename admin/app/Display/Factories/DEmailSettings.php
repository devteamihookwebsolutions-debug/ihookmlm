<?php

/**
 * This class contains public functions related to DEmailSettings
 *
 * @package         DEmailSettings
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

namespace Admin\App\Display\Factories;


class DEmailSettings
{

public static function getENotificationSettings($records, $iTotal, $recordsLang)
{
    $output = '';

    if (count((array)$records) > 0) {

        $output .= '<table id="default-table" class="datatable-table">
            <thead>
                <tr>
                    <th></th>
                    <th>
                        <span class="flex items-center">Template Name</span>
                    </th>
                    <th>
                        <span class="flex items-center">Action</span>
                    </th>
                </tr>
            </thead>
            <tbody id="emailsettings">';

        foreach ($records as $record) {

            $output .= '<tr>
                <td></td>
                <td>' . htmlspecialchars($record->mail_name) . '</td>
                <td>';

            /* ---------- LANGUAGE LINKS ---------- */
            if (count((array)$recordsLang) > 0) {

                $langLinks = [];

                foreach ($recordsLang as $lang) {
                    $langLinks[] =
                        '<a aria-label="link"
                            href="javascript:void(0)"
                            onclick="updateMailTemplates(' . $lang->lang_id . ',' . $record->mail_id . ')"
                            class="text-blue-500 hover:underline px-1">
                            <span class="font-semibold">' . htmlspecialchars($lang->iso_lang_code) . '</span>
                        </a>';
                }

                // Join languages with " / "
                $output .= implode(' / ', $langLinks);

                // Default template link
                $output .= ' - <a aria-label="link"
                    href="javascript:void(0)"
                    onclick="updateMailTemplates(0,' . $record->mail_id . ')"
                    class="text-blue-500 hover:underline px-1">
                    <span class="font-semibold">Default Template For All Language</span>
                </a>';
            }

            $output .= '</td></tr>';
        }

        $output .= '</tbody></table>';
    }

    return $output;
}

}
