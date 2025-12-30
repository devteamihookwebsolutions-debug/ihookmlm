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

class DPackagePurchased
{
    /**
     * This public static function is used  to show the dashboard top selling products
     * @param array $records;
     * @return HTML data
     */

    public static function getPackagePurchased($records, $iTotal)
    {
        if (count((array)$records) != 0) {

            for ($i = 0; $i < count((array)$records); $i++) {


                if ($records[$i]['paymenthistory_date'] != '0000-00-00') {
                    $formatuseddate = MFormatDate::formatingDate($records[$i]['paymenthistory_date']);
                } else {
                    $formatuseddate = '-';
                }
                if ($records[$i]['members_subscription_expirydate'] != '0000-00-00') {
                    $expiry_date = MFormatDate::formatingDate($records[$i]['members_subscription_expirydate']);
                } else {
                    $expiry_date = '-';
                }


                if ($records[$i]['paymenthistory_status'] == 'notpaid') {
                    $status = '<span class="bg-pink-100 text-pink-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-pink-900 dark:text-pink-300">' .__('Pending') . '</span>';
                } else {
                    $status = '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">' .__('Paid'). '</span>';
                }

                $invoiceview = '<a aria-label="link" href="' . $_ENV['FCPATH'] . '/dashboard/packinvoice/'. $records[$i]['paymenthistory_id'] . '" target="_blank" >' .__('View') . '</a>';


                $purchased_package = $records[$i]['purchased_package_name']; // Purchased package
                $current_package_name = $records[$i]['current_package_name']; // Current package

                // ✅ Check if the current package matches the purchased package
                if ($current_package_name === $purchased_package) {
                    $current_package = '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">'
                                       . __('YES') .
                                       '</span>';
                    $current_package .= ' <span class="text-black text-xs">(' . __('Expires on: ') . $records[$i]['members_subscription_expirydate']. ')</span>';

                } else {
                    $current_package = '<span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300">'
                                       . __('NO') .
                                       '</span>';
                }


                // ✅ Store the data in the array
                $mem_data[] = array(
                    'date' => $formatuseddate,
                    'plan' => $records[$i]['plan_name'],
                    'package_name' => $records[$i]['purchased_package_name'],
                    'amount' =>  $_SESSION['site_settings']['site_currency'] . ' ' .MFormatNumber::formatingNumberCurrency($records[$i]['paymenthistory_amount']),
                    'package_status' => $status,
                    'invoice' => $invoiceview,
                    'current_package' => $current_package,
                );


            }

            if ($mem_data == null) {
                $mem_data = array();
            }
            $res_array   = array(
                'records' => $mem_data,
                'total_records' => $iTotal,
                "columns" => ["date","plan","package_name","amount","package_status","invoice", "current_package"]
            );
            $data_result = json_encode($res_array);
            echo $data_result;
            exit();

        } else {

            $res_array   = array(
                'records' => [],
                'total_records' => 0,
                "columns" => ["date","plan","package_name","amount","package_status","invoice", "current_package"]
            );
            $data_result = json_encode($res_array);
            echo $data_result;
            exit();
        }
    }
}
?>