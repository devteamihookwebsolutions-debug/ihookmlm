<?php
/**
 * This class contains public static functions related to Bonus .
 *
 * @package         MCommonBonus
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

class MCommonBonus
{
    /**
     * This public static function is used  to module bonus
     * @param string $bonustype
     * @return Boolean data
    */
    public static function commonBonusCron($type)
    {
        $dailybonus_sql   = "SELECT " . $_ENV['IHOOK_PREFIX'] . "bonus_cron.*," . $_ENV['IHOOK_PREFIX'] . "bonus.* FROM " . $_ENV['IHOOK_PREFIX'] . "bonus_cron
        LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "bonus ON " . $_ENV['IHOOK_PREFIX'] . "bonus.bonusid = " . $_ENV['IHOOK_PREFIX'] . "bonus_cron.bonusid
        WHERE type='" . $type . "'";
        $dailybonus_query = new Bin_Query();
        $dailybonus_query->executeQuery($dailybonus_sql);
        $dailybonus_records = $dailybonus_query->records;
        for ($achieved = 0; $achieved < count((array)$dailybonus_records); $achieved++) {
            $bonusid       = $dailybonus_records[$achieved]['bonusid'];
            $user_id       = $dailybonus_records[$achieved]['user_id'];
            $sponser_from  = $dailybonus_records[$achieved]['sponser_from'];
            $crypto_qty = trim($dailybonus_records[$achieved]['crypto_currency']);
            $currency_id = trim($dailybonus_records[$achieved]['crypto_currency_id']);
            $bonus_user_id = $user_id;
            if ($sponser_from != 0) {
                $bonus_user_id = $sponser_from;
            }
            $bonustype = $dailybonus_records[$achieved]['workson'];
            $amount    = $dailybonus_records[$achieved]['amount'];
            $giftname  = $dailybonus_records[$achieved]['giftname'];
            if ($amount != 0 && $giftname == "") {
                $bonusresult = 0;
                $amount      = $dailybonus_records[$achieved]['amount'];
                $giftname    = "";
            } else {
                $bonusresult = 1;
                $amount      = 0;
                $giftname    = $dailybonus_records[$achieved]['giftname'];
            }

            $admin_approve_bonus         = trim($dailybonus_records[$achieved]['admin_approve_bonus']);
            if ($admin_approve_bonus == '1') { //bonus will send after admin approve
                //Code to insert bonus achieved table - start
                $currentDateTime = date('Y-m-d H:i:s');
                $objs            = new Bin_Query();
                $sqls            = "INSERT INTO " . $_ENV['IHOOK_PREFIX'] . "bonusachieved(bonusid,user_id,bonustype,bonusresult,bonusamt,bonusgift,achieveddate,sponser_from,crypto_currency,crypto_currency_id)
                    VALUES('" . $bonusid . "','" . $bonus_user_id . "','" . $bonustype . "','" . $bonusresult . "','" . $amount . "','" . $giftname . "','" . $currentDateTime . "','" . $sponser_from . "','".$crypto_qty."','".$currency_id."')";
                $objs->updateQuery($sqls);
                //Code to insert bonus achieved table - end
            } else {

                $user_id = $user_id;
                $bonustype = trim($dailybonus_records[$achieved]['bonustype']);
                $bonusid = trim($dailybonus_records[$achieved]['bonusid']);
                $bonusamt = trim($dailybonus_records[$achieved]['amount']);
                $achieveddate = trim($dailybonus_records[$achieved]['achieveddate']);
                $accountype = trim($dailybonus_records[$achieved]['accountype']);
                $sponser_from = trim($dailybonus_records[$achieved]['bonus_to']);
                $bonus_name = trim($dailybonus_records[$achieved]['bonus_name']);
                $matrix_id = trim($dailybonus_records[$achieved]['matrix_id']);
                $crypto_qty = trim($dailybonus_records[$achieved]['crypto_currency']);
                $currency_id = trim($dailybonus_records[$achieved]['crypto_currency_id']);

                $matrixdetails = MMatrixDetails::getMatrixDetails($matrix_id);
                $matrix_name = $matrixdetails['matrix_name'];
                if ($sponser_from != 0) {
                    $sponsor_sql = "SELECT members_username,dailybonus_cron FROM " . $_ENV['IHOOK_PREFIX'] . "members_table WHERE members_id=" . $sponser_from;
                    $sponsor_obj = new Bin_Query();
                    $sponsor_obj->executeQuery($sponsor_sql);
                    $sponsor_records = $sponsor_obj->records;
                    $direct_user = $sponsor_records[0]['members_username'];
                    $dailybonus_cron = $sponsor_records[0]['dailybonus_cron'];
                    $member_upd_id = $sponser_from;
                    $history_description = $bonus_name.' - '. __('Bonus earned from').'&nbsp;'.$direct_user . " - " .strtolower($bonustype).'&nbsp;'.strtolower(__('through')).'&nbsp;'.$matrix_name.'&nbsp;'.strtolower(__('Plan'));
                } elseif ($sponser_from == 0) {
                    $user_sql = "SELECT members_username,dailybonus_cron FROM " . $_ENV['IHOOK_PREFIX'] . "members_table WHERE members_id=" . $user_id;
                    $user_obj = new Bin_Query();
                    $user_obj->executeQuery($user_sql);
                    $user_records = $user_obj->records;
                    $dailybonus_cron = $user_records[0]['dailybonus_cron'];
                    $member_upd_id = $user_id;
                    $history_description = $bonus_name.' - '.__('Bonus earned from').'&nbsp;'.strtolower($bonustype).'&nbsp;'.strtolower(__('through')).'&nbsp;'.$matrix_name.'&nbsp;'.strtolower(__('Plan'));
                }
                $replace = $bonusid . ",";
                $history_member_id = $user_id;
                $history_type = 'custombonus';
                $history_amount = $bonusamt;
                $history_wallet_type = $accountype;
                $format_history_amount = MFormatNumber::formatingNumberCurrency($history_amount);
                $query_bonushistory = new Bin_Query();
                $sql_bonushistory = "INSERT INTO `" . $_ENV['IHOOK_PREFIX'] . "history_table` (`history_member_id`, `history_type`,`history_description`,`history_datetime`, `history_amount`,`history_wallet_type`,`bonusid`,`history_transaction_id`,`crypto_qty`,`currency_id`)
                        VALUES ('" . $history_member_id . "','" . $history_type . "','" . $history_description . "',NOW(),'" . $format_history_amount . "','" . $history_wallet_type . "','" . $bonusid . "','#" . substr(number_format(time() * rand(), 0, '', ''), 0, 9) . "','".$crypto_qty."','".$currency_id."')";
                $query_bonushistory->updateQuery($sql_bonushistory);
            }
        }

        //Code to Delete bonus_Cron
        $del_objs = new Bin_Query();
        $del_sqls = "DELETE FROM " . $_ENV['IHOOK_PREFIX'] . "bonus_cron WHERE type='" . $type . "'";
        $del_objs->updateQuery($del_sqls);
        //Code to delete bonus_cron
        echo "cron executed";

    }
}
?>
