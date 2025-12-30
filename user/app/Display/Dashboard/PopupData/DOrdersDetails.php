<?php
/**
 * This class contains public static functions related to dashboard rank slider
 *
 * @package         DDashBoardRankProgress
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

namespace Display\Dashboard\PopupData;

use Query\Bin_Query;
use Model\Middleware\MAmazonCloudFront;
use Model\Middleware\MFormatDate;
use Model\Middleware\MFormatNumber;

class DOrdersDetails
{
    /**
     * This public static function is used  to show the dashboard top selling products
     * @param array $records;
     * @return HTML data
     */

    public static function getOrdersDetails($records, $iTotal)
    {

        if (count((array)$records) != 0) {

            for ($i = 0; $i < count((array)$records); $i++) {

                if ($records[$i]['members_doj'] != '0000-00-00') {
                    $formatuseddate = MFormatDate::formatingDate($records[$i]['members_doj']);
                } else {
                    $formatuseddate = '-';
                }
                if ($records[$i]['members_status'] == '0') {
                    $status = '<span class="bg-pink-100 text-pink-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-pink-900 dark:text-pink-300">' .__('Suspend') . '</span>';
                } else {
                    $status = '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">' .__('Active'). '</span>';
                }


                $mem_data[] = array(
                    'ID' => $records[$i]['order_id'],
                    'product_quantity' => $records[$i]['product_quantity'],
                    'order_status' => $records[$i]['order_status'],
                    'total_amount' => $_SESSION['site_settings']['site_currency'] . ' ' . MFormatNumber::formatingNumberCurrency($records[$i]['total_amount']),

                    'payment_method' =>  $records[$i]['payment_method'],
                    'order_date' => $records[$i]['order_date'],
                );
            }

            if ($mem_data == null) {
                $mem_data = array();
            }
            $res_array   = array(
                'records' => $mem_data,
                'total_records' => $iTotal,
                "columns" => ["ID","product_quantity","order_status","total_amount", "payment_method",'order_date']
            );
            $data_result = json_encode($res_array);
            echo $data_result;
            exit();

        } else {

            $res_array   = array(
                'records' => [],
                'total_records' => 0,
                "columns" => ["ID","product_quantity","order_status","total_amount", "payment_method",'order_date']

            );
            $data_result = json_encode($res_array);
            echo $data_result;
            exit();
        }
    }
}
?>