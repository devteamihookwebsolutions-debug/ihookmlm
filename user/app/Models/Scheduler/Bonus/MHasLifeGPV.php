<?php
/**
 * This class contains public static functions related to Bonus .
 *
 * @package         MHasLifeGPV
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
class MHasLifeGPV{
    /**
     * This public static function is used  to check periodic gpv available or not
     * @param array $Userarray
     * @param int $gpv_value
     * @param int $matrix_id
     * @param string $condition
     * @return Boolean data
    */
 public static function hasLifeGPV($Userarray, $gpv_value, $matrix_id, $condition)
    {
        if (!is_array($Userarray)) {
            return false;
        }
        $arr_members = implode(",", $Userarray);
        $pv_sql      = "SELECT SUM(history_amount) AS total_pv FROM " . $_ENV['PROMLM_PREFIX'] . "history_table 
            WHERE history_type='pv' AND  history_member_id IN (" . $arr_members . ") AND 
                history_matrix_id='" . $matrix_id . "'";
        $pv_query    = new Bin_Query();
        $pv_query->executeQuery($pv_sql);
        $pvobj    = $pv_query->records[0];
        $total_pv = $pvobj['total_pv'];
        if ($condition == "<") {
            if ($total_pv < $gpv_value) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == "<=") {
            if ($total_pv <= $gpv_value) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == ">") {
            if ($total_pv > $gpv_value) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == ">=") {
            if ($total_pv >= $gpv_value) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == "==") {
            if ($total_pv == $gpv_value) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == "!=") {
            if ($total_pv != $gpv_value) {
                return true;
            } else {
                return false;
            }
        }
    }
}
?>    