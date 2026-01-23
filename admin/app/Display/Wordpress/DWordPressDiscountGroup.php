<?php
/**
 * This class contains public static functions related to show the discount group list .
 *
 * @package         DWordPressDiscountGroup
 * @category        Display
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?>
<?php

namespace Admin\App\Display\Wordpress;
use Illuminate\Support\Facades\DB;

use Admin\App\Models\Middleware\MFormatDate;

class DWordPressDiscountGroup
{

    public static function showGroup($records)
    {
        if (count((array)$records) > 0) {
            $j = 1;
            for ($i = 0;$i < count((array)$records);$i++) {
                if ($records[$i]['status'] == '1') {
                    $status = '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">' . __('On') . '</span>';
                } else {
                    $status = '<span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300">' . __('Off') . '</span>';
                }
                if ($records[$i]['cart_status'] == '1') {
                    $cart_status = '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">' . __('On') . '</span>';
                } else {
                    $cart_status = '<span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300">' . __('Off') . '</span>';
                }
                $output .= '
                          <tr>
                          <td>' . $j . '</td>
                          <td>' . $records[$i]['group_name'] . '</td>
                          <td>' . $status . '</td>
                           <td>' . $cart_status . '</td>
                          <td class="flex">
                          <a aria-label="link" href="' . $_ENV['BCPATH'] . '/wordpressdiscountgroup/edit/' . $records[$i]['id'] . '" class="m-1" title="' . __('Edit') . '">
                          <svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/></svg>
                        </a>
                        <a aria-label="link" href="' . $_ENV['BCPATH'] . '/wordpressdiscountgroup/view/' . $records[$i]['id'] . '" class="m-1" title="' . __('View') . '">
                          <svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/><path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                        </a>
                        <a aria-label="link" href="javascript:void(0);" onclick="delconfirm(' . $records[$i]['id'] . ');" title="' . __('Delete') . '" class="m-1" >
                          <svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"> <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/></svg>
                        </a>
                          </td>
                          </tr>';
                $j++;
            }
        }
        return $output;
    }


    public static function showGroupUsers($records)
    {
        $prefix = config('services.ihook.prefix'); // e.g., 'promlm_'
        $membersTable = $prefix . '_members_table';

        $output = '';

        if (!empty($records)) {
            $j = 1;

            foreach ($records as $record) {
                $memberId = $record['member_id'];

                // Fetch member details
                $member = DB::table($membersTable)
                    ->where('members_id', $memberId)
                    ->first();

                if ($member) {
                    $uname = $member->members_username;
                    $members_email = $member->members_email;
                    $date = MFormatDate::formatingDate($member->members_doj);
                    $members_status = $member->members_status;

                    // Status HTML
                    if ($members_status == '1') {
                        $status = '<span class="bg-neutral-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 dark:text-blue-400 border border-blue-400">Active</span>';
                    } elseif ($members_status == '2') {
                        $status = '<span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 dark:border-red-400 border border-red-400">Deleted</span>';
                    } elseif ($members_status == '0') {
                        $status = '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 dark:text-yellow-300 border border-yellow-300">Suspend</span>';
                    } else {
                        $status = '';
                    }

                    // Append row
                    $output .= '<tr>
                        <td>' . $j . '</td>
                        <td>' . $uname . '</td>
                        <td>' . $members_email . '</td>
                        <td>' . $date . '</td>
                        <td>' . $status . '</td>
                    </tr>';

                    $j++;
                }
            }
        }

        return $output;
    }


    public static function showUsers($records)
    {
        if (count((array)$records) > 0) {
            $j = 1;
            for ($i = 0;$i < count((array)$records);$i++) {
                if ($records[$i]['members_status'] == '1') {
                    $status = '<span class="bg-neutral-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 dark:text-blue-400 border border-blue-400">Active</span>';
                } elseif ($records[$i]['members_status'] == '2') {
                    $status = '<span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 dark:text-red-400 border border-red-400">Deleted</span>';
                } elseif ($records[$i]['members_status'] == '0') {
                    $status = '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 dark:text-yellow-300 border border-yellow-300">Suspend</span>';
                }
                $output .= '<tr>
                            <td>' . $records[$i]['members_id'] . '</td>
                            <td>' . $records[$i]['members_username'] . '</td>
                            <td>' . $records[$i]['members_email'] . '</td>
                            <td>' . MFormatDate::formatingDate($records[$i]['members_doj']). '</td>
                            <td>' . $status . '</td>
                            </tr>';
                $j++;
            }
        }
        return $output;
    }
}
