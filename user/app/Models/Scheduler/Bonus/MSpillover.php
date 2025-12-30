<?php
/**
 * This class contains public static functions related to Bonus .
 *
 * @package         MSpillover
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
class MSpillover{
    /**
     * This public static function is used  to check spillover
     * @param int $User
     * @param int $spillcnt
     * @param int $condition
     * @param int $matrix_id
     * @return Boolean data
    */

    public static function spillover($User, $matrix_id, $spillcnt, $condition)
    {
        $totalspillovercnt = 0;
        $totalcnt          = self::spilloverCnt($User, $matrix_id, $totalspillovercnt);
        if ($condition == "<") {
            if ($totalcnt < $spillcnt) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == "<=") {
            if ($totalcnt <= $spillcnt) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == ">") {
            if ($totalcnt > $spillcnt) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == ">=") {
            if ($totalcnt >= $spillcnt) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == "==") {
            if ($totalcnt == $spillcnt) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == "!=") {
            if ($totalcnt != $spillcnt) {
                return true;
            } else {
                return false;
            }
        }
    }
    /**
     * This public static function is used  to get spillover count
     * @param int $members_id
     * @param int $totalspillovercnt
     * @param int $matrix_id
     * @return Boolean data
    */
    public static function spilloverCnt($members_id, $matrix_id, $totalspillovercnt)
    {

        $sqltot   = "SELECT count(*) as total FROM " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table where FIND_IN_SET('" . $members_id . "',members_parents) and matrix_id='" . $matrix_id . "'";
        $querytot = new Bin_Query();
        $querytot->executeQuery($sqltot);
        return $totalspillovercnt = $querytot->records[0]['total'];


        // $sql = "SELECT members_id FROM " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table 
        // WHERE spillover_id='" . $members_id . "' AND matrix_id='" . $matrix_id . "'";
        // $obj = new Bin_Query();
        // $obj->executeQuery($sql);
        // $records = $obj->records;
        // if (count((array)$records) > 0) {
        //     for ($i = 0; $i < count((array)$records); $i++) {
        //         $totalspillovercnt = $totalspillovercnt + count((array)$records);
        //         if ($records[$i]["members_id"] > 0)
        //             self::spilloverCnt($records[$i]["members_id"], $matrix_id, $totalspillovercnt);
        //     }
        // }
        // return $totalspillovercnt;
    }

}
?>    