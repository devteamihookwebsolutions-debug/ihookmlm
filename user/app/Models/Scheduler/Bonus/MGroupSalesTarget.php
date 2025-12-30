<?php
/**
 * This class contains public static functions related to Bonus .
 *
 * @package         MGroupSalesTarget
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
use Model\Middleware\MDownlineSales;

class MGroupSalesTarget{
    /**
     * This public static function is used  to check total product sold
     * @param int $User
     * @param int $targetamount
     * @param int $matrix_id
     * @param string $condition
     * @return Boolean data
    */
   public static function groupSalesTarget($User, $matrix_id, $grouptargetamount, $condition)
    {
        $total_order  = 0;
        $mlm_sales = MDownlineSales::getDownlineMLMSales($User, $matrix_id);
        $total   = $records[0]['total'];

        $sql   = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table where members_id = '".$User."' and matrix_id='" . $matrix_id . "'";
        $query = new Bin_Query();
        $query->executeQuery($sql);
        $records = $query->records;
        $total_order = $records[0]['total_sales'];
        
        $final_total = $total + $total_order;
        if ($condition == "<") {
            if ($final_total < $grouptargetamount) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == "<=") {
            if ($final_total <= $grouptargetamount) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == ">") {
            if ($final_total > $grouptargetamount) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == ">=") {
            if ($final_total >= $grouptargetamount) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == "==") {
            if ($final_total == $grouptargetamount) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == "!=") {
            if ($final_total != $grouptargetamount) {
                return true;
            } else {
                return false;
            }
        }
    }
   
}
?>    