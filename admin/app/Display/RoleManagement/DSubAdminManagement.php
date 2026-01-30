<?php
namespace Admin\App\Display\RoleManagement;
/**
 * This class contains public functions related to DSubAdminManagement
 *
 * @package         DSubAdminManagement
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
class DSubAdminManagement
{

public static function showSubAdminSettings($records)
{
    $output = '';

    if (!empty($records)) {
        foreach ($records as $record) {

            $isEnabled = trim($record->admin_status) === 'enable';

            $status = '<span class="' . ($isEnabled
                ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
                : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
            ) . ' text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">'
                . ucfirst($record->admin_status) .
            '</span>';

            $output .= '
                <tr>
                    <td>' . e($record->admin_id) . '</td>
                    <td>' . e($record->admin_username) . '</td>
                    <td>' . e($record->admin_username) . '</td>
                    <td>' . e($record->admin_email) . '</td>
                    <td>' . $status . '</td>
                    <td>
                        <a class="hover:bg-success text-success p-2 rounded-full"
                          href="' . route('subadmin.editsubadmin', $record->admin_id) . '"

                           title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor"
                                 class="w-6 h-6 text-black dark:text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1
                                      2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897
                                      1.13L6 18l.8-2.685a4.5 4.5 0 0 1
                                      1.13-1.897l8.932-8.931ZM18 14v4.75A2.25
                                      2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1
                                      3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </a>
                    </td>
                </tr>';
        }
    }

    return $output;
}

}