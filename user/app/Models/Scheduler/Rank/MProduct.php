<?php

/**
 * This class contains public functions related to MProduct
 *
 * @package         MProduct
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

namespace User\App\Models\Scheduler\Rank;
use Admin\App\Models\Middleware\MMemberDetails;
use Illuminate\Support\Facades\DB;

class MProduct
{
    /**
     * Count completed orders for a member
     */
    public static function product($member_id, $matrix_id = null)
    {
        $members_shop = MMemberDetails::getPartMembersDetails('members_shop_id', $member_id);
        $members_shop_id = $members_shop['members_shop_id'];
         $prefix = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');

        return DB::table($storeprefix . '_posts as a')
            ->leftJoin($storeprefix . '_postmeta as b', function ($join) {
                $join->on('b.post_id', '=', 'a.ID')
                     ->where('b.meta_key', '_customer_user');
            })
            ->leftJoin($storeprefix . '_postmeta as c', function ($join) {
                $join->on('c.post_id', '=', 'b.post_id')
                     ->where('c.meta_key', '_order_total');
            })
            ->where('b.meta_value', $members_shop_id)
            ->where('a.post_type', 'shop_order')
            ->where('a.post_status', 'wc-completed')
            ->count();
    }

    /**
     * Count completed orders within date range
     */
    public static function countSalesWithDateRange($member_id, $matrix_id, $start_date, $end_date)
    {
        $members_shop = MMemberDetails::getPartMembersDetails('members_shop_id', $member_id);
        $members_shop_id = $members_shop['members_shop_id'];
        $storeprefix = config('services.ihook.store_prefix');

        $start = date('Y-m-d H:i:s', strtotime($start_date));
        $end   = date('Y-m-d 23:59:59', strtotime($end_date));

        return DB::table($storeprefix . '_posts as a')
            ->leftJoin($storeprefix . '_postmeta as b', function ($join) {
                $join->on('b.post_id', '=', 'a.ID')
                     ->where('b.meta_key', '_customer_user');
            })
            ->leftJoin($storeprefix . '_postmeta as c', function ($join) {
                $join->on('c.post_id', '=', 'b.post_id')
                     ->where('c.meta_key', '_order_total');
            })
            ->where('b.meta_value', $members_shop_id)
            ->where('a.post_type', 'shop_order')
            ->where('a.post_status', 'wc-completed')
            ->whereBetween('a.post_date', [$start, $end])
            ->count();
    }

    /**
     * Count products sold (completed orders)
     */
    public static function productSold($member_id, $matrix_id = null)
    {
        $members_shop = MMemberDetails::getPartMembersDetails('members_shop_id', $member_id);
        $members_shop_id = $members_shop['members_shop_id'];
        $storeprefix = config('services.ihook.store_prefix');

        return DB::table($storeprefix . '_posts as a')
            ->leftJoin($storeprefix . '_postmeta as b', function ($join) use ($members_shop_id) {
                $join->on('b.post_id', '=', 'a.ID')
                     ->where('b.meta_key', '_customer_user')
                     ->where('b.meta_value', $members_shop_id);
            })
            ->leftJoin($storeprefix . '_woocommerce_order_items as c', function ($join) {
                $join->on('c.order_id', '=', 'b.post_id')
                     ->where('c.order_item_type', 'line_item');
            })
            ->leftJoin($storeprefix . '_woocommerce_order_itemmeta as d', function ($join) {
                $join->on('d.order_item_id', '=', 'c.order_item_id')
                     ->where('d.meta_key', '_qty');
            })
            ->where('a.post_status', 'wc-completed')
            ->whereNotNull('b.meta_id')
            ->count('a.ID');
    }

    /**
     * Count products sold within date range
     */
    public static function productSoldWithDateRange($member_id, $matrix_id, $start_date, $end_date)
    {
        $members_shop = MMemberDetails::getPartMembersDetails('members_shop_id', $member_id);
        $members_shop_id = $members_shop['members_shop_id'];
        $storeprefix = config('services.ihook.store_prefix');

        $start = date('Y-m-d H:i:s', strtotime($start_date));
        $end   = date('Y-m-d 23:59:59', strtotime($end_date));

        return DB::table($storeprefix . '_posts as a')
            ->leftJoin($storeprefix . '_postmeta as b', function ($join) use ($members_shop_id) {
                $join->on('b.post_id', '=', 'a.ID')
                     ->where('b.meta_key', '_customer_user')
                     ->where('b.meta_value', $members_shop_id);
            })
            ->leftJoin($storeprefix . '_woocommerce_order_items as c', function ($join) {
                $join->on('c.order_id', '=', 'b.post_id')
                     ->where('c.order_item_type', 'line_item');
            })
            ->leftJoin($storeprefix . '_woocommerce_order_itemmeta as d', function ($join) {
                $join->on('d.order_item_id', '=', 'c.order_item_id')
                     ->where('d.meta_key', '_qty');
            })
            ->where('a.post_status', 'wc-completed')
            ->whereNotNull('b.meta_id')
            ->whereBetween('a.post_date', [$start, $end])
            ->count('a.ID');
    }
}
