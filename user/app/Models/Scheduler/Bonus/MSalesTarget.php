<?php
/**
 * This class contains public static functions related to Bonus .
 *
 * @package         MSalesTarget
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
use Model\Middleware\MMembersDetails;
class MSalesTarget{
    /**
     * This public static function is used  to check total product sold
     * @param int $User
     * @param int $targetamount
     * @param int $matrix_id
     * @param string $condition
     * @return Boolean data
    */
    public static function salesTarget($User, $matrix_id, $targetamount, $condition)
    {
        $total_order     = 0;
        $members_shop=MMembersDetails::getPartMembersDetails('members_shop_id',$User);
        $members_shop_id = $members_shop['members_shop_id'];
        $sql             = "SELECT sum(paymenthistory_amount) as total FROM " . $_ENV['PROMLM_PREFIX'] . "paymenthistory_table WHERE paymenthistory_member_id='" . $User . "'  AND matrix_id='" . $matrix_id . "' and paymenthistory_status='paid'";
        $obj             = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records;
        if ($records[0]['total'] != NULL) {
            $total = $records[0]['total'];
        } else {
            $total = 0;
        }
        $sql_user = "SELECT SUM(b.meta_value) as total FROM `" . $_ENV['STORE_PREFIX'] . "posts` AS a
        LEFT JOIN   `" . $_ENV['STORE_PREFIX'] . "postmeta` AS b ON  b.meta_key='_order_total' AND b.post_id=a.ID
        WHERE a.ID='" . $members_shop_id . " AND a.post_type='shop_order' AND a.post_status='wc-completed'";
        $obj_user = new Bin_Query();
        $obj_user->executeQuery($sql_user);
        $records_total = $obj_user->records;
        $total_order = $records_total[0]['total'];
        $final_total = $total + $total_order;
        if ($condition == "<") {
            if ($final_total < $targetamount) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == "<=") {
            if ($final_total <= $targetamount) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == ">") {
            if ($final_total > $targetamount) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == ">=") {
            if ($final_total >= $targetamount) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == "==") {
            if ($final_total == $targetamount) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == "!=") {
            if ($final_total != $targetamount) {
                return true;
            } else {
                return false;
            }
        }
    }
}
?>    