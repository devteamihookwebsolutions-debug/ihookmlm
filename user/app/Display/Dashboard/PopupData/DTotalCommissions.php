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

class DTotalCommissions
{
    /**
     * This public static function is used  to show the dashboard top selling products
     * @param array $records;
     * @return HTML data
     */

    public static function getTotalCommissions($records, $iTotal)
    {
        if (count((array)$records) != 0) {

            for ($i = 0; $i < count((array)$records); $i++) {

                if ($records[$i]['history_datetime'] != '0000-00-00') {
                    $formatuseddate = MFormatDate::formatingDate($records[$i]['history_datetime']);
                } else {
                    $formatuseddate = '-';
                }


                if ($records[$i]['history_type'] == 'withdraw_pending') {
                    $payment_status = '<span class="bg-pink-100 text-pink-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-pink-900 dark:text-pink-300>' .__('Pending') . '</span>';
                } else {
                    $payment_status = '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">' .__('Paid') . '</span>';
                }
                if (trim($records[$i]['history_type']) == 'pv') {
                    $site_currency  = '';
                    $history_amount = number_format($records[$i]['history_amount'], 0);
                    $history_type   = self::getHistoryType($records[$i]['history_type']);
                } else {
                    $site_currency  = $_SESSION['site_settings']['site_currency'];
                    $history_amount = MFormatNumber::formatingNumberCurrency($records[$i]['history_amount']);
                    $history_type   = self::getHistoryType($records[$i]['history_type']);
                }
                $view = '<a aria-label="link" href="' . $_ENV['FCPATH'] . '/dashboard/commissioninvoice/'. $records[$i]['history_id'] . '" target="_blank">' .__('View') . '</a>';


                $mem_data[] = array(
                    'date' => $formatuseddate,
                    'description' => $records[$i]['history_description'],
                    'type' => $records[$i]['history_type'],
                    'amount' => $_SESSION['site_settings']['site_currency'] . ' ' . MFormatNumber::formatingNumberCurrency($records[$i]['history_amount']),
                    'invoice' => $view,
                    'status' => $payment_status,
                );
            }

            if ($mem_data == null) {
                $mem_data = array();
            }
            $res_array   = array(
                'records' => $mem_data,
                'total_records' => $iTotal,
                "columns" => ["date","description","type","amount","invoice","status"]
            );
            $data_result = json_encode($res_array);
            echo $data_result;
            exit();

        } else {

            $res_array   = array(
                'records' => [],
                'total_records' => 0,
                "columns" => ["date","description","type","amount","invoice","status"]

            );
            $data_result = json_encode($res_array);
            echo $data_result;
            exit();
        }
    }

    public static function getHistoryType($historytype)
    {
        $historytypes = array('levelcommission' => 'CUS_LEVEL_COMMISSION','directcommission' => 'CUS_DIRECT_COMMISSION','xupcommission' => 'CUS_XUP_COMMISSION','withdraw_pending' => 'CUS_WITHDRAW_PENDING','withdrawal' => 'CUS_WITHDRAWAL','binarycommission' => 'CUS_BINARY_COMMISSION','cyclecommission' => 'CUS_CYCLE_COMMISSION','productlevelcommission' => 'CUS_PRODUCT_LEVEL_COMMISSION','ewalletdeducts' => 'CUS_EWALLET_DEDUCTS','ewalletcredits' => 'CUS_EWALLET_CREDITS','adminbonus' => 'CUS_ADMIN_BONUS','admindeduct' => 'CUS_ADMIN_DEDUCT','pv' => 'CUS_PV','epinpurchasededuct' => 'CUS_EPIN_PURCHASE_DEDUCT','fundtransferred' => 'CUS_FUND_TRANSFERRED','fundreceived' => 'CUS_FUND_RECEIVED','rankbonus' =>
        'CUS_RANK_BONUS','joiningcommission' => 'CUS_JOINING_COMMISSION','entrybonus' => 'CUS_ENTRY_BONUS','exitbonus' => 'CUS_EXIT_BONUS','custombonus' => 'CUS_CUSTOM_BONUS','stairwellcommission' => 'CUS_STAIRWELL_COMMISSION','qualificationbonus' => 'CUS_QUALIFICATION_BONUS','directbonus' => 'CUS_DIRECT_BONUS','networkbonus' => 'CUS_NETWORK_BONUS','matchingbonus' => 'CUS_MATCHING_BONUS','withdrawcompleted' => 'CUS_WITHDRAW_COMPLETED','dailybinarycommision' => 'CUS_DAILY_BINARY_COMMISSION','weeklybinarycommision' => 'CUS_WEEKLY_BINARY_COMMISSION','monthlybinarycommision' => 'CUS_MONTHLY_BINARY_COMMISSION','stairstep' => 'CUS_STAIRSTEP','generationbonus' => 'CUS_GENERATION_BONUS','customer_acquisition_bonus' => 'CUS_CUSTOMER_ACQUISITION_BONUS','customer_retail_commission' => 'CUS_CUSTOMER_RETAIL_COMMISSION','membershipcommission' => 'CUS_MEMBERSHIP_COMMISSION','split_commission' => 'CUS_SPLIT_COMMISSION','pool' => 'CUS_POOL','walletorder' => 'WALLETORDER');

        foreach ($historytypes as $key => $value) {
            if ($historytype == $key) {
                $sqltrans = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "terminology_settings_table WHERE language_key='".$value."' and language='".$_SESSION['sitelang']."'";
                $objtrans = new Bin_Query();
                $objtrans->executeQuery($sqltrans);
                $recordstrans = $objtrans->records[0]['language_value'];
            }
        }

        return $recordstrans;


    }
}
?>
