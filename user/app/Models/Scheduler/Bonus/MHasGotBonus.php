<?php
/**
 * This class contains public static functions related to Bonus .
 *
 * @package         MHasGotBonus
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
class MHasGotBonus{
    /**
     * This public static function is used  to check got bonus
     * @param int $User
     * @param int $from_datetime
     * @param int $to_datetime
     * @param string $bonusname
     * @return Boolean data
    */
public static function hasGotBonus($User, $bonusname, $from_datetime, $to_datetime)
    {
        $bonus_sql   = "SELECT count(*) as total FROM " . $_ENV['PROMLM_PREFIX'] . "history_table 
            WHERE history_type='" . $bonusname . "' AND (history_datetime>='" . $from_datetime . "' AND 
                history_datetime<='" . $to_datetime . "') AND history_member_id='" . $User . "' AND 
                history_matrix_id='" . $matrix_id . "'";
        $bonus_query = new Bin_Query();
        $bonus_query->executeQuery($bonus_sql);
        $bonusobj = $bonus_query->records[0]['total'];
        if ($bonusobj > 0) {
            return true;
        } else {
            return false;
        }
    }
}
?>    