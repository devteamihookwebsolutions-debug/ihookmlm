<?php
/**
 * This class contains public static functions related to Bonus .
 *
 * @package         MHasSponsored
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
class MHasSponsored{
    /**
     * This public static function is used  to check sponsored
     * @param int $User
     * @param int $matrix_id
     * @param int $account_status
     * @param date $from_datetime
     * @param date $to_datetime
     * @param int $sponsoredcnt
     * @param string $condition
     * @return Boolean data
    */
public static function hasSponsored($User, $matrix_id, $account_status, $from_datetime, $to_datetime, $sponsoredcnt, $condition)
    {
        if ($account_status != 3) {
            if ($from_datetime != "" && $to_datetime != "") {
                $sponsored_sql = "SELECT count(*) as total FROM " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table          
                    WHERE direct_id='" . $User . "' AND (matrix_doj>='" . $from_datetime . "' AND matrix_doj<='" . $to_datetime . "') 
                    AND matrix_id='" . $matrix_id . "' AND members_account_status='" . $account_status . "'";
            } else {
                $sponsored_sql = "SELECT count(*) as total FROM " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table          
                    WHERE direct_id='" . $User . "' AND matrix_id='" . $matrix_id . "' AND members_account_status='" . $account_status . "'";
            }
        } else {
            if ($from_datetime != "" && $to_datetime != "") {
                $sponsored_sql = "SELECT count(*) as total FROM " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table          
                    WHERE direct_id='" . $User . "' AND (matrix_doj>='" . $from_datetime . "' AND matrix_doj<='" . $to_datetime . "') 
                    AND matrix_id='" . $matrix_id . "'";
            } else {
                $sponsored_sql = "SELECT count(*) as total FROM " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table          
                        WHERE direct_id='" . $User . "' AND matrix_id='" . $matrix_id . "'";
            }
        }
        $sponsored_query = new Bin_Query();
        $sponsored_query->executeQuery($sponsored_sql);
        $total = $sponsored_query->records[0]['total'];
        if ($total != 0) {
            $totalcnt = $total;
            if ($condition == "<") {
                if ($totalcnt < $sponsoredcnt) {
                    return true;
                } else {
                    return false;
                }
            } else if ($condition == "<=") {
                if ($totalcnt <= $sponsoredcnt) {
                    return true;
                } else {
                    return false;
                }
            } else if ($condition == ">") {
                if ($totalcnt > $sponsoredcnt) {
                    return true;
                } else {
                    return false;
                }
            } else if ($condition == ">=") {
                if ($totalcnt >= $sponsoredcnt) {
                    return true;
                } else {
                    return false;
                }
            } else if ($condition == "==") {
                if ($totalcnt == $sponsoredcnt) {
                    return true;
                } else {
                    return false;
                }
            } else if ($condition == "!=") {
                if ($totalcnt != $sponsoredcnt) {
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