<?php

/**
 * This class contains public functions related to MGetLevel
 *
 * @package         MGetLevel
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace Model\Scheduler\Bonus;
use Query\Bin_Query;

class MGetLevel{
    /**
     * This public static function is used  to check target for rank
     * @param int $members_id
     * @param int $matrix_id
     * @return Boolean data
    */
    public static function getLevel($member_id, $matrix_id,$memroot,$targetlevelscnt,$targetlevel)
    {
        $levelreqroot=$memroot+$targetlevel;
        $sql = "SELECT members_parents FROM
                " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table WHERE
                FIND_IN_SET('" . $member_id . "',`members_parents`)
                AND root ='".$levelreqroot."'
                AND matrix_id='" . $matrix_id . "'";
        $obj         = new Bin_Query();
        $obj->executeQuery($sql);
        $records          = $obj->records;
        $countlev            = count((array)$records);
        if ($countlev >= $targetlevelscnt) {
            return true;
        } else {
            return false;
        }

    }
}
?>
