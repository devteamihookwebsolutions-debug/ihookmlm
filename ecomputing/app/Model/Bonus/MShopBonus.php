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
namespace Model\Bonus;
use Query\Bin_Query;

class MShopBonus
{

    public function sendSplitCommission($members_shop_id,$original_member_sponsor,$order_id,$amount){

        $query           = new Bin_Query();
        $sql             = "SELECT * FROM `" . $_ENV['PROMLM_PREFIX'] . "members_table` WHERE `members_shop_id` ='" . $members_shop_id . "'";
        if ($query->executeQuery($sql)) {
            $members_id         = $query->records[0]['members_id'];
            $members_username   = $query->records[0]['members_username'];
            //original sponsor
            $queryorg           = new Bin_Query();
            $sqlorg             = "SELECT * FROM `" . $_ENV['PROMLM_PREFIX'] . "members_table` WHERE `members_shop_id` ='" . $original_member_sponsor . "'";
            $queryorg->executeQuery($sqlorg);
            $members_original_id=$queryorg->records[0]['members_id'];
            if ($members_id>0 && $members_original_id >0 && ($members_id!=$members_original_id)) {
                //split comission
                $query    = new Bin_Query();
                $sql_site = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "shopbonus_meta";
                $query->executeQuery($sql_site);
                $fields=$query->records;
                if (count((array)$fields)>0) {
                    for ($i = 0; $i < $query->totrows; $i++) {
                        if ($fields[$i]['meta_key']=='split_commission') {
                            $split_commission=$fields[$i]['meta_value'];
                        }
                        if ($fields[$i]['meta_key']=='split_commission_original') {
                            $split_commission_original=$fields[$i]['meta_value'];
                        }
                        if ($fields[$i]['meta_key']=='split_commission_purchase') {
                            $split_commission_purchase=$fields[$i]['meta_value'];
                        }
                        if ($fields[$i]['meta_key']=='split_commission_percentage_type') {
                            $split_commission_percentage_type=$fields[$i]['meta_value'];
                        }
                        if ($fields[$i]['meta_key']=='split_commission_status') {
                            $split_commission_status=$fields[$i]['meta_value'];
                        }
                        if ($fields[$i]['meta_key']=='split_bonus_wallet_type') {
                            $split_bonus_wallet_type=$fields[$i]['meta_value'];
                        }
                    }
                }
                if ($split_commission_status=='1') {
                    $split_commission=$split_commission;
                    if ($split_commission_percentage_type=='%') {
                        $originalcommission_amt=$amount*($split_commission_original/100);
                        $purchasecommission_amt=$amount*($split_commission_purchase/100);
                    } else {
                        $originalcommission_amt=$split_commission_original;
                        $purchasecommission_amt=$split_commission_purchase;
                    }
                    $history_description = $split_commission.' - commission earned from'.$customers_username.' Order ID #'.$order_id;
                    $history_type = 'split_commission';
                    $history_wallet_type=$split_bonus_wallet_type;

                    //original sposnor
                    $objlevel  = new Bin_Query();
                    $sql_level = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "history_table (history_member_id,history_customers_ref_id,history_amount,history_type,history_description,history_datetime,history_transaction_id,history_wallet_type)
                        VALUES (" . $members_original_id . ",'".$customers_id."'," . $originalcommission_amt . ",'".$history_type."','" . $history_description . "',NOW(),'#" . substr(number_format(time() * rand(), 0, '', ''), 0, 9) . "','".$history_wallet_type."')";
                    $objlevel->updateQuery($sql_level);

                    //product purcahse
                    $objlevel  = new Bin_Query();
                    $sql_level = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "history_table (history_member_id,history_customers_ref_id,history_amount,history_type,history_description,history_datetime,history_transaction_id,history_wallet_type)
                        VALUES (" .$members_id. ",'".$customers_id."'," . $purchasecommission_amt . ",'".$history_type."','" . $history_description . "',NOW(),'#" . substr(number_format(time() * rand(), 0, '', ''), 0, 9) . "','".$history_wallet_type."')";
                    $objlevel->updateQuery($sql_level);
                }
            }

        }

    }

}
?>
