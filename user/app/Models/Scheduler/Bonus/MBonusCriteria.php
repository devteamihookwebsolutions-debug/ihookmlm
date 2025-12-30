<?php
/**
 * This class contains public static functions related to Bonus .
 *
 * @package         MBonusCriteria
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
?><?php
namespace Model\Scheduler\Bonus;
use Query\Bin_Query;
class MBonusCriteria{
    /**
     * This public static function is used  to check bonus criteria
     * @param int $matrix_id
     * @param int $bonustype
     * @param int $type
     * @return Boolean data
    */
     public static function bonusCriteria($matrix_id, $bonustype, $type)
    {
        $query             = new Bin_Query();
        $totalcustomfields = array();
        $customfields      = array();
        if ($type == "INSTANT") {
            $sql_site = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "bonus where periodstatus=0 AND  bonus_status=0 AND matrix_id=" . $matrix_id . " AND workson='" . $bonustype . "'";
        } else if ($type == "CRON") {
            $sql_site = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "bonus where periodstatus=1 AND bonus_status=0  AND workson='" . $bonustype . "'";
        }
        $query->executeQuery($sql_site);
        $records = $query->records;
        for ($i = 0; $i < count((array)$records); $i++) {
            $bonusid                      = $records[$i]['bonusid'];
            $customfields['bonusid']      = $records[$i]['bonusid'];
            $customfields['matrix_id']    = $records[$i]['matrix_id'];
            $customfields['workson']      = $records[$i]['workson'];
            $customfields['bonus_to']     = $records[$i]['bonus_to'];
            $customfields['maximumlimit'] = $records[$i]['maximumlimit'];
            $customfields['periodstatus'] = $records[$i]['periodstatus'];
            $customfields['reward']       = $records[$i]['reward'];
            $customfields['amount']       = $records[$i]['amount'];
            $customfields['giftname']     = $records[$i]['giftname'];
            $customfields['bonustype']    = $records[$i]['bonustype'];
            $customfields['period']       = $records[$i]['period'];
            $customfields['bonustime']    = $records[$i]['bonustime'];
            $customfields['bonusday']     = $records[$i]['bonusday'];
            $customfields['bonusmonth']   = $records[$i]['bonusmonth'];
            $customfields['bonus_status'] = $records[$i]['bonus_status'];
            $customfields['bonus_name'] = $records[$i]['bonus_name'];
            $customfields['accountype'] = $records[$i]['accountype'];
            $customfields['admin_approve_bonus'] = $records[$i]['admin_approve_bonus'];
            $customfields['crypto_currency'] = $records[$i]['crypto_currency'];
            $customfields['crypto_currency_id'] = $records[$i]['crypto_currency_id'];
            $query2                       = new Bin_Query();
            $sql_site2                    = "SELECT metakey,metavalue FROM " . $_ENV['PROMLM_PREFIX'] . "bonus_customfields where bonusid=" . $bonusid;
            $query2->executeQuery($sql_site2);
            $customrecords = $query2->records;
            for ($j = 0; $j < count((array)$customrecords); $j++) {
                $metakey                = str_replace("_", " ", $customrecords[$j]['metakey']);
                $metavalue              = $customrecords[$j]['metavalue'];
                $customfields[$metakey] = $metavalue;
            }
            $totalcustomfields[$i] = $customfields;
        }
        return $totalcustomfields;
    }
}
?>    