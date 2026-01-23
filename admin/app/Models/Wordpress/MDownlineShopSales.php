<?php
/**
 * This class contains public static functions related to total downline shop sales
 *
 * @package         MDwonlineSales
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?><?php
namespace Admin\App\Models\Wordpress;
use Illuminate\Support\Facades\DB;
class MDownlineShopSales{
    /**
     * This public static function is used  to total downline shop sales
     * @param int $members_id
     * @param int $matrix_id
     * @return int
     */

    public static function getDownlineShopSales($members_id, $matrix_id)
    {
        // Get table prefixes from config
        $storePrefix = config('services.ihook.store_prefix');
        $mlmPrefix   = config('services.ihook.prefix');
        $total = DB::table($storePrefix . '_posts as a')
            ->leftJoin($storePrefix . '_postmeta as b', function ($join) {
                $join->on('b.post_id', '=', 'a.ID')
                    ->where('b.meta_key', '=', '_customer_user');
            })
            ->leftJoin($storePrefix . '_postmeta as c', function ($join) {
                $join->on('c.post_id', '=', 'b.post_id')
                    ->where('c.meta_key', '=', '_order_total');
            })
            ->leftJoin($mlmPrefix . '_members_table as d', 'd.members_shop_id', '=', 'b.meta_value')
            ->leftJoin($mlmPrefix . '_matrix_members_link_table as e', 'e.members_id', '=', 'd.members_id')
            ->whereRaw('FIND_IN_SET(?, e.members_parents)', [$members_id])
            ->where('e.matrix_id', $matrix_id)
            ->where('a.post_type', 'shop_order')
            ->where('a.post_status', 'wc-completed')
            ->sum(DB::raw('c.meta_value'));

        return $total ?? 0;
    }

}
