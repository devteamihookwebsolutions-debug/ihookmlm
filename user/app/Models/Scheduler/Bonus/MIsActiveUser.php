<?php
/**
 * This class contains public static functions related to Bonus .
 *
 * @package         MIsActiveUser
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
class MIsActiveUser{
    /**
     * This public static function is used  to check user is active or not
     * @param int $members_id
     * @return Boolean data
    */
public static function isActiveUser($members_id)
    {
        $member_sql   = "SELECT count(*) as total FROM " . $_ENV['PROMLM_PREFIX'] . "members_table WHERE members_id='" . $members_id . "' AND members_status=1";
        $member_query = new Bin_Query();
        $member_query->executeQuery($member_sql);
        $total = $member_query->records[0]['total'];
        if ($total == 0) {
            return false;
        } else {
            return true;
        }
    }
}
?>    