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
use Model\Scheduler\Bonus\MGetLevel;

class MBonus
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
     public static function bonusCron()
    {
        //bonus_cron field check - start
        $totalmember_sql   = "SELECT count(*) as total FROM " . $_ENV['PROMLM_PREFIX'] . "members_table WHERE bonus_cron=0 AND members_status=1";
        $totalmember_query = new Bin_Query();
        $totalmember_query->executeQuery($totalmember_sql);
        $totalmember_records = $totalmember_query->records[0]['total'];
        if ($totalmember_records == 0) {
            $totalupdmember_query = new Bin_Query();
            $totalupdmember_sql   = "UPDATE `" . $_ENV['PROMLM_PREFIX'] . "members_table` SET `bonus_cron`=0 WHERE members_status=1";
            $totalupdmember_query->updateQuery($totalupdmember_sql);
        }
        //bonus_cron field check - end
        $bonuscriteriaarray = MBonusCriteria::bonusCriteria(0, "Auto", "CRON");

        for ($i = 0; $i < count((array)$bonuscriteriaarray); $i++) {
            $matrix_id    = $bonuscriteriaarray[$i]['matrix_id'];
            $bonusid      = $bonuscriteriaarray[$i]['bonusid'];
            $bonustype    = $bonuscriteriaarray[$i]['workson'];
            $member_sql   = "SELECT mt.*,direct_id,members_subscription_plan,rankid,root             
                FROM " . $_ENV['PROMLM_PREFIX'] . "members_table AS mt
                LEFT JOIN " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table ON " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table.members_id = mt.members_id                       
                WHERE " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table.matrix_id ='" . $matrix_id . "' AND 
                mt.members_status=1 AND !FIND_IN_SET('" . $bonusid . "',`dailybonus_cron`) AND mt.bonus_cron=0 LIMIT 30";
            $member_query = new Bin_Query();
            $member_query->executeQuery($member_sql);
            $member_records = $member_query->records;

            for ($memcnt = 0; $memcnt < count((array)$member_records); $memcnt++) {
                $package_id      = $member_records[$memcnt]['members_subscription_plan'];
                $rank_id         = $member_records[$memcnt]['rankid'];
                $User            = $member_records[$memcnt]['members_id'];
                $dailybonus_cron = $member_records[$memcnt]['dailybonus_cron'];
                $memroot         = $member_records[$memcnt]['root'];
                $periodstatus    = $bonuscriteriaarray[$i]['periodstatus'];                
                  
                //Once Time or Repeat Checking - Start
                $proceed         = true;
                $bonustype_check = $bonuscriteriaarray[$i]['bonustype'];
                if ($bonustype_check == 1) {
                    $bonus_check    = new Bin_Query();
                    $sql_bonuscheck = "SELECT count(*) as total FROM " . $_ENV['PROMLM_PREFIX'] . "bonusachieved where bonusid=" . $bonusid . " AND user_id=" . $User;
                    $bonus_check->executeQuery($sql_bonuscheck);
                    $record_bonuscheck = $bonus_check->records[0]['total'];
                    if ($record_bonuscheck > 0) {
                        $proceed = false;
                    }
                    $bonus_check2    = new Bin_Query();
                    $sql_bonuscheck2 = "SELECT count(*) as total FROM " . $_ENV['PROMLM_PREFIX'] . "history_table where bonusid=" . $bonusid . " AND history_member_id=" . $User;
                    $bonus_check2->executeQuery($sql_bonuscheck2);
                    $record_bonuscheck2 = $bonus_check2->records[0]['total'];
                    if ($record_bonuscheck2 > 0) {
                        $proceed = false;
                    }
                } else {
                    $maximumlimit   = $bonuscriteriaarray[$i]['maximumlimit'];
                    $bonusid        = $bonuscriteriaarray[$i]['bonusid'];
                    $bonus_check    = new Bin_Query();
                    $sql_bonuscheck = "SELECT SUM(bonusamt) AS achievedtotal FROM " . $_ENV['PROMLM_PREFIX'] . "bonusachieved where bonusid=" . $bonusid . " AND user_id=" . $User;
                    $bonus_check->executeQuery($sql_bonuscheck);
                    $record_bonuscheck = $bonus_check->records;
                    if (count($record_bonuscheck) > 0) {
                        $achievedtotal = $record_bonuscheck[0]['achievedtotal'];
                    }
                    $bonus_check2    = new Bin_Query();
                    $sql_bonuscheck2 = "SELECT SUM(history_amount) AS historyamt_total FROM " . $_ENV['PROMLM_PREFIX'] . "history_table where bonusid=" . $bonusid . " AND history_member_id=" . $User;
                    $bonus_check2->executeQuery($sql_bonuscheck2);
                    $record_bonuscheck2 = $bonus_check2->records;
                    if (count($record_bonuscheck2) > 0) {
                        $historyamt_total = $record_bonuscheck2[0]['historyamt_total'];
                    }
                    $totalamtreceived = $achievedtotal + $historyamt_total;
                    if ($maximumlimit != '' && $maximumlimit != '0') {
                        if ($totalamtreceived >= $maximumlimit) {
                            $proceed = false;
                        }
                    }
                }

                
                //Once Time or Repeat Checking - End
                //Bonus Validation Checking Code - Start
                if ($periodstatus == 1 && $proceed == true) {
                    $bonus_active = true;
                    if (array_key_exists("package id", $bonuscriteriaarray[$i])) {
                        $package_id   = $bonuscriteriaarray[$i]['package id'];
                        $bonus_active = MHasPurchased::hasPurchased($User, $package_id, $matrix_id);
                    }
                    if (array_key_exists("levels", $bonuscriteriaarray[$i])) {
                        $levelscntpar   = $bonuscriteriaarray[$i]['levels'];
                        $levelscntparse=explode('-',$levelscntpar);
                        $targetlevelscnt=trim($levelscntparse[1]);
                        $targetlevelparse=explode('LL',trim($levelscntparse[0]));
                        $targetlevel=$targetlevelparse[1];
                        $bonus_active = MGetLevel::getLevel($User,$matrix_id,$memroot,$targetlevelscnt,$targetlevel);
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
                                $gpv_value  = $bonuscriteriaarray[$i]['GPV points'];
                                $condition  = ">=";
                                $levelarray = $bonus_active = MHasPerioidicLineGPV::hasPerioidicLineGPV($User, $gpv_value, $matrix_id, $condition);
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
                        $bonus_user_id = $User;
                        $sponser_from  = 0;
                        if ($bonuscriteriaarray[$i]['bonus_to'] == 1) {
                            $sponsored_sql = "SELECT direct_id FROM " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table          
                                WHERE members_id='" . $User . "'AND matrix_id='" . $matrix_id . "'";
                            $sponsor_query = new Bin_Query();
                            $sponsor_query->executeQuery($sponsored_sql);
                            $sponsor_records = $sponsor_query->records;
                            $bonus_user_id   = $sponsor_records[0]['direct_id'];
                            $sponser_from    = $User;
                        }
                        $bonusid         = $bonuscriteriaarray[$i]['bonusid'];
                        $currentDateTime = date('Y-m-d H:i:s');
                        $period          = $bonuscriteriaarray[$i]['period'];
                        $periodvalue     = "";
                        if ($period == 1) {
                            $periodvalue = "Daily";
                        } elseif ($period == 2) {
                            $periodvalue = "Weekly";
                        } elseif ($period == 3) {
                            $periodvalue = "Monthly";
                        } elseif ($period == 4) {
                            $periodvalue = "Quarterly";
                        } elseif ($period == 5) {
                            $periodvalue = "Half Yearly";
                        } elseif ($period == 5) {
                            $periodvalue = "Yearly";
                        }
                        $objs = new Bin_Query();
                        $sqls = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "bonus_cron(user_id,bonusid,type,sponser_from) 
                            VALUES('" . $bonus_user_id . "','" . $bonusid . "','" . $periodvalue . "','" . $sponser_from . "')";
                        $objs->updateQuery($sqls);

                        if($dailybonus_cron=='0'){
                            $dailybonus_cron_field = $bonusid . ",";   
                        }else{
                            $dailybonus_cron_field = $dailybonus_cron . $bonusid . ",";
                        }
                        $updmember_query       = new Bin_Query();
                        $updmember_sql         = "UPDATE `" . $_ENV['PROMLM_PREFIX'] . "members_table` SET `dailybonus_cron` = '" . $dailybonus_cron_field . "' WHERE members_id=" . $User;
                        $updmember_query->updateQuery($updmember_sql);
                        
                    }
                }

                $ur_query = new Bin_Query();
                $ur_sql   = "UPDATE `" . $_ENV['PROMLM_PREFIX'] . "members_table` SET `bonus_cron` = 1 WHERE members_id='" . $member_records[$memcnt]['members_id']."'";
                $ur_query->updateQuery($ur_sql);
            } 
                       
            
        }

        echo "cron excueted";
        //Bonus Validation Checking Code - End
        //  $userselectivearray[] = $User;
        //  for ($ur = 0; $ur < count((array)$userselectivearray); $ur++) {            
        //  }
    }
}
?>