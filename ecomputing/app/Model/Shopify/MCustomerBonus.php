<?php
/**
 * This class contains public functions related to customer bonus
 *
 * @package         MCustomerBonus
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php

namespace Model\Shopify;

use Query\Bin_Query;

class MCustomerBonus
{
    public function sendCustomerBonus($customers_shop_id, $order_id, $amount)
    {

        $query           = new Bin_Query();
        $sql             = "SELECT * FROM `" . $_ENV['PROMLM_PREFIX'] . "customers` WHERE `customers_shop_id` ='" . $customers_shop_id . "'";
        if ($query->executeQuery($sql)) {
            $customers_id         = $query->records[0]['customers_id'];
            $customers_username   = $query->records[0]['customers_username'];
            $customers_sponsor_id = $query->records[0]['customers_sponsor_id'];
            //Customer Acquisition Bonus ( CAB )
            $query    = new Bin_Query();
            $sql_site = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "customerbonus_meta";
            $query->executeQuery($sql_site);
            $fields = $query->records;
            if (count((array)$fields) > 0) {
                for ($i = 0; $i < $query->totrows; $i++) {
                    if ($fields[$i]['meta_key'] == 'cab_bonus_name') {
                        $cab_bonus_name = $fields[$i]['meta_value'];
                    }
                    if ($fields[$i]['meta_key'] == 'cab_bonus_percentage') {
                        $cab_bonus_percentage = $fields[$i]['meta_value'];
                    }
                    if ($fields[$i]['meta_key'] == 'cab_bonus_percentage_type') {
                        $cab_bonus_percentage_type = $fields[$i]['meta_value'];
                    }
                    if ($fields[$i]['meta_key'] == 'cab_bonus_status') {
                        $cab_bonus_status = $fields[$i]['meta_value'];
                    }
                    if ($fields[$i]['meta_key'] == 'cab_bonus_wallet_type') {
                        $cab_bonus_wallet_type = $fields[$i]['meta_value'];
                    }
                    if ($fields[$i]['meta_key'] == 'retail_commission_name') {
                        $retail_commission_name = $fields[$i]['meta_value'];
                    }
                    if ($fields[$i]['meta_key'] == 'retail_commission_percenatge') {
                        $retail_commission_percenatge = $fields[$i]['meta_value'];
                    }
                    if ($fields[$i]['meta_key'] == 'retail_commission_percentage_type') {
                        $retail_commission_percentage_type = $fields[$i]['meta_value'];
                    }
                    if ($fields[$i]['meta_key'] == 'retail_commission_status') {
                        $retail_commission_status = $fields[$i]['meta_value'];
                    }
                    if ($fields[$i]['meta_key'] == 'retail_commission_wallet_type') {
                        $retail_commission_wallet_type = $fields[$i]['meta_value'];
                    }
                }
            }

            //check if already updated
            $queryorder           = new Bin_Query();
            $sqlorder             = "SELECT * FROM `" . $_ENV['STORE_PREFIX'] . "postmeta` WHERE `post_id` ='" . $order_id . "' AND meta_key='_paid_date' AND meta_value='".$completeddate."'";
            $queryorder->executeQuery($sqlorder);
            $recordsordercheck    = count($queryorder->records);

            if ($cab_bonus_status == '1') {
                //check First sales on cart related type - Customer Acquisition Bonus ( CAB )
                $sqlcheck = "SELECT * FROM ".$_ENV['STORE_PREFIX']."posts WHERE post_author='".$customers_shop_id."'";
                $objcheck = new Bin_Query();
                $objcheck->executeQuery($sqlcheck);
                $recorsshocnt = $objcheck->records;
                if (count($recorsshocnt) == 1) {
                    $cab_bonus_name = $cab_bonus_name;
                    if ($cab_bonus_percentage_type == '%') {
                        $commission_amt = $amount * ($cab_bonus_percentage / 100);
                    } else {
                        $commission_amt = $cab_bonus_percentage;
                    }
                    $history_description = $cab_bonus_name.' - bonus earned from'.$customers_username.' Order ID #'.$order_id;
                    $history_type = 'customer_acquisition_bonus';
                    $history_wallet_type = $cab_bonus_wallet_type;
                    $objlevel  = new Bin_Query();
                    $sql_level = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "history_table (history_member_id,history_customers_ref_id,history_amount,history_type,history_description,history_datetime,history_transaction_id,history_wallet_type,history_order_id)
                    VALUES (" . $customers_sponsor_id . ",'".$customers_id."'," . $commission_amt . ",'".$history_type."','" . $history_description . "',NOW(),'#" . substr(number_format(time() * rand(), 0, '', ''), 0, 9) . "','".$history_wallet_type."','".$order_id."')";
                    $objlevel->updateQuery($sql_level);
                }
            }
            if ($retail_commission_status == '1' && $recordsordercheck == '1') {
                $retail_commission_name = $retail_commission_name;
                if ($retail_commission_percentage_type == '%') {
                    $commission_amt = $amount * ($retail_commission_percenatge / 100);
                } else {
                    $commission_amt = $retail_commission_percenatge;
                }
                $history_description = $retail_commission_name.' - commission earned from'.$customers_username.' Order ID #'.$order_id;
                $history_type = 'customer_retail_commission';
                $history_wallet_type = $retail_commission_wallet_type;
                $objlevel  = new Bin_Query();
                $sql_level = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "history_table (history_member_id,history_customers_ref_id,history_amount,history_type,history_description,history_datetime,history_transaction_id,history_wallet_type,history_order_id)
                VALUES (" . $customers_sponsor_id . ",'".$customers_id."'," . $commission_amt . ",'".$history_type."','" . $history_description . "',NOW(),'#" . substr(number_format(time() * rand(), 0, '', ''), 0, 9) . "','".$history_wallet_type."','".$order_id."')";
                $objlevel->updateQuery($sql_level);
            }

        }


    }

}
?>
