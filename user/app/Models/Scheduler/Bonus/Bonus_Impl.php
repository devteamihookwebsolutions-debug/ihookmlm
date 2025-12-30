<?php
/**
 * This class contains public static functions related to Bonus .
 *
 * @package         Bonus_Impl
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://promlmsoftware.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?>
<?php

namespace Model\Scheduler\Bonus;

use Query\Bin_Query;
use Model\Middleware\MMatrixDetails;
use Model\Middleware\MFormatNumber;
use Model\Scheduler\Bonus\MBonusCriteria;
use Model\Scheduler\Bonus\MHasPurchased;
use Model\Scheduler\Bonus\MIsHighestRank;
use Model\Scheduler\Bonus\MHasSponsored;
use Model\Scheduler\Bonus\MSpillover;
use Model\Scheduler\Bonus\MTotalSalesCount;
use Model\Scheduler\Bonus\MTotalProductSold;
use Model\Scheduler\Bonus\MHasLifePV;
use Model\Scheduler\Bonus\MHasDownlines;
use Model\Scheduler\Bonus\MHasPerioidicLineGPV;
use Model\Scheduler\Bonus\MSalesTarget;
use Model\Scheduler\Bonus\MGroupSalesTarget;

class Bonus_Impl
{
    /**
     * This public static function is used  to module bonus
     * @param int $User
     * @param int $package_id
     * @param int $matrix_id
     * @param int $rankid
     * @param string $bonustype
     * @return Boolean data
    */
    public static function moduleBonus($User, $matrix_id, $package_id, $rankid, $bonustype)
    {
        $bonuscriteriaarray = MBonusCriteria::bonusCriteria($matrix_id, $bonustype, "INSTANT");
        for ($i = 0; $i < count((array)$bonuscriteriaarray); $i++) {
            $periodstatus    = $bonuscriteriaarray[$i]['periodstatus'];
            $proceed         = true;
            $bonustype_check = $bonuscriteriaarray[$i]['bonustype'];
            if ($bonustype_check == 1) {
                $bonusid        = $bonuscriteriaarray[$i]['bonusid'];
                $bonus_check    = new Bin_Query();
                $sql_bonuscheck = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "bonusachieved where bonusid=" . $bonusid . " AND user_id=" . $User;
                $bonus_check->executeQuery($sql_bonuscheck);
                $record_bonuscheck = $bonus_check->records;
                if (count((array)$record_bonuscheck) > 0) {
                    $proceed = false;
                }
                $bonus_check2    = new Bin_Query();
                $sql_bonuscheck2 = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "history_table where bonusid=" . $bonusid . " AND history_member_id=" . $User;
                $bonus_check2->executeQuery($sql_bonuscheck2);
                $record_bonuscheck2 = $bonus_check2->records;
                if (count((array)$record_bonuscheck2) > 0) {
                    $proceed = false;
                }
            } else {
                $maximumlimit   = $bonuscriteriaarray[$i]['maximumlimit'];
                $bonusid        = $bonuscriteriaarray[$i]['bonusid'];
                $bonus_check    = new Bin_Query();
                $sql_bonuscheck = "SELECT SUM(bonusamt) AS achievedtotal FROM " . $_ENV['PROMLM_PREFIX'] . "bonusachieved where bonusid=" . $bonusid . " AND user_id=" . $User;
                $bonus_check->executeQuery($sql_bonuscheck);
                $record_bonuscheck = $bonus_check->records;
                if (count((array)$record_bonuscheck) > 0) {
                    $achievedtotal = $record_bonuscheck[0]['achievedtotal'];
                }
                $bonus_check2    = new Bin_Query();
                $sql_bonuscheck2 = "SELECT SUM(history_amount) AS historyamt_total FROM " . $_ENV['PROMLM_PREFIX'] . "history_table where bonusid=" . $bonusid . " AND history_member_id=" . $User;
                $bonus_check2->executeQuery($sql_bonuscheck2);
                $record_bonuscheck2 = $bonus_check2->records;
                if (count((array)$record_bonuscheck2) > 0) {
                    $historyamt_total = $record_bonuscheck2[0]['historyamt_total'];
                }
                $totalamtreceived = $achievedtotal + $historyamt_total;
                if ($totalamtreceived >= $maximumlimit) {
                    $proceed = false;
                }
            }
            if ($periodstatus == 0 && $proceed == true) {
                $bonus_active = true;
                if (array_key_exists("package id", $bonuscriteriaarray[$i])) {
                    $package_id   = $bonuscriteriaarray[$i]['package id'];
                    $bonus_active = MHasPurchased::hasPurchased($User, $package_id, $matrix_id);
                }
                if ($bonus_active) {
                    if (array_key_exists("rank id", $bonuscriteriaarray[$i])) {
                        $rank_id      = $bonuscriteriaarray[$i]['rank id'];
                        $bonus_active = MIsHighestRank::isHighestRank($User, $rank_id, $matrix_id);
                    }
                }
                if ($bonus_active) {
                    if (array_key_exists("No of Direct Referals", $bonuscriteriaarray[$i])) {
                        $sponsoredcnt   = $bonuscriteriaarray[$i]['No of Direct Referals'];
                        $account_status = 3;
                        $from_datetime  = "";
                        $to_datetime    = "";
                        $condition      = ">=";
                        $bonus_active   = MHasSponsored::hasSponsored($User, $matrix_id, $account_status, $from_datetime, $to_datetime, $sponsoredcnt, $condition);
                    }
                }
                if ($bonus_active) {
                    if (array_key_exists("No of Group Referals", $bonuscriteriaarray[$i])) {
                        $spillovercnt = $bonuscriteriaarray[$i]['No of Group Referals'];
                        $condition    = ">=";
                        $bonus_active = MSpillover::spillover($User, $matrix_id, $spillovercnt, $condition);
                    }
                }
                if ($bonus_active) {
                    if (array_key_exists("Number of Sales", $bonuscriteriaarray[$i])) {
                        $salescount   = $bonuscriteriaarray[$i]['Number of Sales'];
                        $condition    = ">=";
                        $bonus_active = MTotalSalesCount::totalSalesCount($User, $matrix_id, $salescount, $condition);
                    }
                }
                if ($bonus_active) {
                    if (array_key_exists("Number of Products sold", $bonuscriteriaarray[$i])) {
                        $productsoldcnt = $bonuscriteriaarray[$i]['Number of Products sold'];
                        $condition      = ">=";
                        $bonus_active   = MTotalProductSold::totalProductSold($User, $matrix_id, $productsoldcnt, $condition);
                    }
                }
                if ($bonus_active) {
                    if (array_key_exists("PV Points", $bonuscriteriaarray[$i])) {
                        $pv_value     = $bonuscriteriaarray[$i]['PV Points'];
                        $condition    = ">=";
                        $bonus_active = MHasLifePV::hasLifePV($User, $pv_value, $matrix_id, $condition);
                    }
                }
                if ($bonus_active) {
                    if (array_key_exists("GPV points", $bonuscriteriaarray[$i])) {
                        if (array_key_exists("levels", $bonuscriteriaarray[$i])) {
                            $levelcriteria = $bonuscriteriaarray[$i]['levels'];
                            $condition     = ">=";
                            $bonus_active  = MHasDownlines::hasDownlines($User, $levelcriteria, $matrix_id, $condition);
                        } else {
                            $gpv_value    = $bonuscriteriaarray[$i]['GPV points'];
                            $condition    = ">=";
                            $bonus_active = MHasPerioidicLineGPV::hasPerioidicLineGPV($User, $gpv_value, $matrix_id, $condition);
                        }
                    }
                }
                if ($bonus_active) {
                    if (array_key_exists("Sales Target", $bonuscriteriaarray[$i])) {
                        $targetamount = $bonuscriteriaarray[$i]['Sales Target'];
                        $condition    = ">=";
                        $bonus_active = MSalesTarget::salesTarget($User, $matrix_id, $targetamount, $condition);
                    }
                }
                if ($bonus_active) {
                    if (array_key_exists("Group Sales Target", $bonuscriteriaarray[$i])) {
                        $grouptargetamount = $bonuscriteriaarray[$i]['Group Sales Target'];
                        $condition         = ">=";
                        $bonus_active      = MGroupSalesTarget::groupSalesTarget($User, $matrix_id, $grouptargetamount, $condition);
                    }
                }
                if ($bonus_active) {
                    $amount   = $bonuscriteriaarray[$i]['amount'];
                    $giftname = $bonuscriteriaarray[$i]['giftname'];
                    if ($amount != 0 && $giftname == "") {
                        $bonusresult = 0;
                        $amount      = $bonuscriteriaarray[$i]['amount'];
                        $giftname    = "";
                    } else {
                        $bonusresult = 1;
                        $amount      = 0;
                        $giftname    = $bonuscriteriaarray[$i]['giftname'];
                    }
                    $bonus_user_id = $User;
                    $sponser_from  = 0;
                    if ($bonuscriteriaarray[$i]['bonus_to'] == 1) {
                        $sponsored_sql = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table 			
							WHERE members_id='" . $User . "'AND matrix_id='" . $matrix_id . "'";
                        $sponsor_query = new Bin_Query();
                        $sponsor_query->executeQuery($sponsored_sql);
                        $sponsor_records = $sponsor_query->records;
                        $bonus_user_id   = $sponsor_records[0]['direct_id'];
                        $sponser_from    = $User;
                    }
                    $bonusid         = $bonuscriteriaarray[$i]['bonusid'];
                    $admin_approve_bonus         = trim($bonuscriteriaarray[$i]['admin_approve_bonus']);
                    $crypto_qty = trim($bonuscriteriaarray[$i]['crypto_currency']);
                    $currency_id = trim($bonuscriteriaarray[$i]['crypto_currency_id']);

                    if ($admin_approve_bonus == '1') { //bonus will send after admin approve

                        $objs            = new Bin_Query();
                        $sqls            = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "bonusachieved(bonusid,user_id,bonustype,bonusresult,bonusamt,bonusgift,achieveddate,sponser_from,crypto_currency,crypto_currency_id) 
    						VALUES('" . $bonusid . "','" . $bonus_user_id . "','" . $bonustype . "','" . $bonusresult . "','" . $amount . "','" . $giftname . "',NOW(),'" . $sponser_from . "','".$crypto_qty."','".$currency_id."')";
                        $objs->updateQuery($sqls);
                    } else { //bonus will send automatically

                        $user_id = $bonus_user_id;
                        $bonustype = trim($bonuscriteriaarray[$i]['bonustype']);
                        $bonusid = trim($bonuscriteriaarray[$i]['bonusid']);
                        $bonusamt = trim($bonuscriteriaarray[$i]['amount']);
                        $achieveddate = trim($bonuscriteriaarray[$i]['achieveddate']);
                        $accountype = trim($bonuscriteriaarray[$i]['accountype']);
                        $sponser_from = trim($bonuscriteriaarray[$i]['bonus_to']);
                        $bonus_name = trim($bonuscriteriaarray[$i]['bonus_name']);
                        $crypto_qty = trim($bonuscriteriaarray[$i]['crypto_currency']);
                        $currency_id = trim($bonuscriteriaarray[$i]['crypto_currency_id']);

                        $matrixdetails = MMatrixDetails::getMatrixDetails($matrix_id);
                        $matrix_name = $matrixdetails['matrix_name'];
                        if ($sponser_from != 0) {
                            $sponsor_sql = "SELECT members_username,dailybonus_cron FROM " . $_ENV['PROMLM_PREFIX'] . "members_table WHERE members_id=" . $sponser_from;
                            $sponsor_obj = new Bin_Query();
                            $sponsor_obj->executeQuery($sponsor_sql);
                            $sponsor_records = $sponsor_obj->records;
                            $direct_user = $sponsor_records[0]['members_username'];
                            $dailybonus_cron = $sponsor_records[0]['dailybonus_cron'];
                            $member_upd_id = $sponser_from;
                            $history_description = $bonus_name.' - '.__('Bonus earned from').'&nbsp;'.$direct_user . " - " .strtolower($bonustype).'&nbsp;'.strtolower(__('through')).'&nbsp;'.$matrix_name.'&nbsp;'.strtolower(__('Plan'));
                        } elseif ($sponser_from == 0) {
                            $user_sql = "SELECT members_username,dailybonus_cron FROM " . $_ENV['PROMLM_PREFIX'] . "members_table WHERE members_id=" . $user_id;
                            $user_obj = new Bin_Query();
                            $user_obj->executeQuery($user_sql);
                            $user_records = $user_obj->records;
                            $dailybonus_cron = $user_records[0]['dailybonus_cron'];
                            $member_upd_id = $user_id;
                            $history_description = $bonus_name.' - '.__('Bonus earned from').'&nbsp;'.strtolower($bonustype).'&nbsp;'.strtolower(__('through')).'&nbsp;'.$matrix_name.'&nbsp;'.strtolower(__('Plan'));
                        }
                        $replace = $bonusid . ",";
                        $dailybonus_cron_upd = str_replace($replace, "", $dailybonus_cron);
                        $history_member_id = $user_id;
                        $history_type = 'custombonus';
                        $history_amount = $bonusamt;
                        $history_wallet_type = $accountype;
                        $format_history_amount = MFormatNumber::formatingNumberCurrency($history_amount);
                        $query_bonushistory = new Bin_Query();
                        $sql_bonushistory = "INSERT INTO `" . $_ENV['PROMLM_PREFIX'] . "history_table` (`history_member_id`, `history_type`,`history_description`,`history_datetime`, `history_amount`,`history_wallet_type`,`bonusid`,`history_transaction_id`,`crypto_qty`,`currency_id`)
                                VALUES ('" . $history_member_id . "','" . $history_type . "','" . $history_description . "',NOW(),'" . $format_history_amount . "','" . $history_wallet_type . "','" . $bonusid . "','#" . substr(number_format(time() * rand(), 0, '', ''), 0, 9) . "','".$crypto_qty."','".$currency_id."')";
                        $query_bonushistory->updateQuery($sql_bonushistory);

                    }

                }
            }
        }
    }
}
?>