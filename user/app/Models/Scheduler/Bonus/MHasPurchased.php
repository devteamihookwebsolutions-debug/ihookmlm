<?php

/**
 * This class contains public functions related to MHasPurchased
 *
 * @package         MHasPurchased
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
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
class MHasPurchased{
    /**
     * This public static function is used  to check purchased
     * @param int $members_id
     * @param int $package_id
     * @param int $matrix_id
     * @return Boolean data
    */
public static function hasPurchased($members_id, $package_id, $matrix_id)
    {
        $purchase_sql   = "SELECT count(*) as total FROM " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table WHERE members_id='" . $members_id . "'
            AND matrix_id='" . $matrix_id . "' AND members_subscription_plan='" . $package_id . "'";
        $purchase_query = new Bin_Query();
        $purchase_query->executeQuery($purchase_sql);
        $total = $purchase_query->records[0]['total'];
        if ($total != 0) {
            return true;
        } else {
            return false;
        }
    }
}
?>
