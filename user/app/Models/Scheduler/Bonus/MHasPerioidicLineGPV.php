<?php
/**
 * This class contains public static functions related to Bonus .
 *
 * @package         MHasPerioidicLineGPV
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
use Model\Middleware\MTotalGPV;
class MHasPerioidicLineGPV{
    /**
     * This public static function is used  to check periodic gpv available or not
     * @param int $User
     * @param array $levelarray
     * @param int $gpv_value
     * @param int $matrix_id
     * @param string $condition
     * @return Boolean data
    */
    public static function hasPerioidicLineGPV($User, $gpv_value, $matrix_id, $condition)
    {
            $totalgpv = MTotalGPV::getTotalGPV($User,$matrix_id);
            if ($condition == "<") {
                if ($totalgpv < $gpv_value) {
                    return true;
                } else {
                    return false;
                }
            } else if ($condition == "<=") {
                if ($totalgpv <= $gpv_value) {
                    return true;
                } else {
                    return false;
                }
            } else if ($condition == ">") {
                if ($totalgpv > $gpv_value) {
                    return true;
                } else {
                    return false;
                }
            } else if ($condition == ">=") {
                if ($totalgpv >= $gpv_value) {
                    return true;
                } else {
                    return false;
                }
            } else if ($condition == "==") {
                if ($totalgpv == $gpv_value) {
                    return true;
                } else {
                    return false;
                }
            } else if ($condition == "!=") {
                if ($totalgpv != $gpv_value) {
                    return true;
                } else {
                    return false;
                }
            }
    }
    
}
?>    