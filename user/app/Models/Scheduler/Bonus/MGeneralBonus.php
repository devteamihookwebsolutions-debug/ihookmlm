<?php
/**
 * This class contains public static functions related to Bonus .
 *
 * @package         MGeneralBonus
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
class MGeneralBonus{
    /**
     * This public static function is used  to check general bonus
     * @param int $criteria
     * @param int $criteriavalue
     * @param int $member_id
     * @param int $matrix_id
     * @return Boolean data
    */

    public static function generalBonus($criteria, $criteriavalue, $member_id, $matrix_id)
    {
        $criteriaArray = array(
            "PV",
            "GPV",
            "Period Status",
            "Number of New Referrals"
        );
        if (!in_array($criteria, $criteriaArray)) {
            return "Wrong Criteria";
        }
        if (!is_array($criteriavalue)) {
            return "Criteria Value Must Be An Array";
        } else {
            if (count($criteriavalue) <= 0) {
                return "Criteria Value Array Must Not Be Empty";
            }
        }
        $member_sql   = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "members_table WHERE members_id='" . $member_id . "'";
        $member_query = new Bin_Query();
        $member_query->executeQuery($member_sql);
        $memberobj = $member_query->records;
        if (count($memberobj) == 0) {
            return "Invalid Member Id";
        }
        $matrix_sql   = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "matrix_type_table WHERE matrix_type_id='" . $matrix_id . "'";
        $matrix_query = new Bin_Query();
        $matrix_query->executeQuery($matrix_sql);
        $matrixobj = $matrix_query->records;
        if (count($matrixobj) == 0) {
            return "Invalid Matrix Id";
        }
        //Parameter Validation - End
        //PV - Start        
        if ($criteria == "PV") {
            //PV Criteria Validation
            if (count($criteriavalue) != 3) {
                return "PV Criteria Received Undefined Values";
            } else {
                if (!isset($criteriavalue['value']) || !isset($criteriavalue['from']) || !isset($criteriavalue['to'])) {
                    return "PV Criteria Received Undefined Values";
                } else {
                    $value = $criteriavalue['value'];
                    if (!is_numeric($value) || $value <= 0) {
                        return "PV Value Should Be Numberic And Above 0";
                    }
                }
            }
            //PV Criteria Validation
            //PV Calculation Starts
            $pv_sql   = "SELECT SUM(history_amount) AS total_pv FROM " . $_ENV['PROMLM_PREFIX'] . "history_table 
                WHERE history_type='pv' AND (history_datetime>='" . $criteriavalue['from'] . "' AND 
                    history_datetime<='" . $criteriavalue['to'] . "') AND history_member_id='" . $member_id . "' AND 
                    history_matrix_id='" . $matrix_id . "'";
            $pv_query = new Bin_Query();
            $pv_query->executeQuery($pv_sql);
            $pvobj    = $pv_query->records[0];
            $total_pv = $pvobj['total_pv'];
            if ($total_pv >= $criteriavalue['value']) {
                return "true";
            } else {
                return "false";
            }
            //PV Calculation End
        }
        //PV End        
    }
}
?>    