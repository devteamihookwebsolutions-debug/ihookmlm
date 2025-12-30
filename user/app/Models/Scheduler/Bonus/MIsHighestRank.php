<?php
/**
 * This class contains public static functions related to Bonus .
 *
 * @package         MIsHighestRank
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
class MIsHighestRank{
    /**
     * This public static function is used  to check highest rank
     * @param int $User
     * @param int $rank_id
     * @param int $rank_id
     * @return Boolean data
    */
    public static function isHighestRank($User, $rank_id)
    {
        $rank_sql   = "SELECT count(*) as total FROM " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table 
            WHERE members_id='" . $User . "' AND matrix_id='" . $matrix_id . "' 
            AND rankid='" . $rank_id . "'";
        $rank_query = new Bin_Query();
        $rank_query->executeQuery($rank_sql);
        $rank_obj = $rank_query->records[0]['total'];
        if ($rank_obj > 0) {
            return true;
        } else {
            return false;
        }
    }
}
?>    