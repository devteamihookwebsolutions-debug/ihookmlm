<?php
/**
 * This class contains public static functions related to downline level
 *
 * @package         DDownlineLevel
 * @category        Display
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2023, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
 *****************************************************************************/
?><?php

namespace Display\Network;

use Model\Middleware\MFormatDate;

class DDownlineLevel
{
    /**
     * This public static function is used to get level users
     * @param array  $records
     * @param int  $iTotal
     * @return HTML data
     */
    public static function getLevelUsers($records, $iTotal)
    {
        $count = count((array)$records);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $membername = $records[$i]['members_username'];
                $sponsor    = $records[$i]['sponsor'];
                $date       = MFormatDate::formatingDate($records[$i]['members_doj']);
                $mem_data[] = array(
                    'Date Of Join' => $date,
                    'Username' => $membername,
                    'Sponsor' => $sponsor
                );
            }
        }
        if ($mem_data == null || $records == '') {
            $mem_data = array();
        }
        $res_array   = array(
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iTotal,
            'sEcho' => 0,
            'sColumns' => '',
            'aaData' => $mem_data
        );
        $data_result = json_encode($res_array);
        echo $data_result;
        exit();
    }
    /**
     * This public static function is used to get level users
     * @param int  $root
     * @param int  $iTotal
     * @return HTML data
     */
    public static function getLevel($records, $root)
    {

        $output .= '<select aria-label="label" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"  onchange=getLevel(this.value); name="level" id="level">';
        $output .= '<option value="">' . __('Select Level') . '</option>';
        if (count((array)$records) > 0) {
            for ($i = 0; $i < count((array)$records); $i++) {
                if ($records[$i]['root'] != '') {
                    $level = $records[$i]['root'] - $root;
                    if ($level == $_GET['sub2']) {
                        $selected = 'selected=selected';
                    } else {
                        $selected = '';
                    }
                    $output .= '<option value="' . $level . '" ' . $selected . '>' . __('Level') . ' => ' . $level . '</option>';
                }
            }
        }
        $output .= '</select>';
        return $output;
    }
}
?>