<?php
/**
 * This class contains public static functions related to Bonus .
 *
 * @package         MIsMemberSince
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
class MIsMemberSince{
    /**
     * This public static function is used  to check member since
     * @param int $members_id
     * @param int $days
     * @return Boolean data
    */
    public static function isMemberSince($members_id, $days, $condition)
    {
        $member_sql   = "SELECT date(members_doj) as doj FROM " . $_ENV['PROMLM_PREFIX'] . "members_table WHERE members_id='" . $members_id . "'";
        $member_query = new Bin_Query();
        $member_query->executeQuery($member_sql);
        $memberobj = $member_query->records;
        if (count($memberobj) != 0) {
            $members_doj = $memberobj[0]['doj'];
            $currentDateTime = date('Y-m-d');
            $date1           = new DateTime($members_doj);
            $date2           = new DateTime($currentDateTime);
            $diff            = $date2->diff($date1)->format("%a");
            if ($condition == "<") {
                if ($days < $diff) {
                    return true;
                } else {
                    return false;
                }
            } else if ($condition == "<=") {
                if ($days <= $diff) {
                    return true;
                } else {
                    return false;
                }
            } else if ($condition == ">") {
                if ($days > $diff) {
                    return true;
                } else {
                    return false;
                }
            } else if ($condition == ">=") {
                if ($days >= $diff) {
                    return true;
                } else {
                    return false;
                }
            } else if ($condition == "==") {
                if ($days == $diff) {
                    return true;
                } else {
                    return false;
                }
            } else if ($condition == "!=") {
                if ($days != $diff) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }
}
?>    