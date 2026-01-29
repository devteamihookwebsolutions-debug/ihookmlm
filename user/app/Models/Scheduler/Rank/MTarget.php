<?php

/**
 * This class contains public functions related to MTarget
 *
 * @package         MTarget
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
use Illuminate\Support\Facades\DB;
use Admin\App\Models\Middleware\MMemberDetails;
use Admin\App\Models\Middleware\MTotalPV;

class MTarget
{
    /**
     * Check target for rank
     *
     * @param int $memberId
     * @param int $matrixId
     * @return float|int
     */
    public static function target(int $memberId, int $matrixId)
    {
        // Get member shop ID
        $membersShop = MMemberDetails::getPartMembersDetails('members_shop_id', $memberId);
        $membersShopId = $membersShop['members_shop_id'] ?? null;
        $storeprefix = config('services.ihook.store_prefix');
         $prefix = config('services.ihook.prefix');

        // Get total PV (kept as-is)
        $totalPv = MTotalPV::getTotalPV($memberId, $matrixId);

        // Payment history total
        $totalPayment = DB::table($prefix . '_paymenthistory_table')
            ->where('paymenthistory_member_id', $memberId)
            ->where('matrix_id', $matrixId)
            ->where('paymenthistory_status', 'paid')
            ->sum('paymenthistory_amount');

        // WooCommerce order total
        $totalOrder = DB::table($storeprefix . '_posts as a')
            ->leftJoin($storeprefix . '_postmeta as b', function ($join) {
                $join->on('b.post_id', '=', 'a.ID')
                     ->where('b.meta_key', '_customer_user');
            })
            ->leftJoin($storeprefix . '_postmeta as c', function ($join) {
                $join->on('c.post_id', '=', 'b.post_id')
                     ->where('c.meta_key', '_order_total');
            })
            ->where('b.meta_value', $membersShopId)
            ->where('a.post_type', 'shop_order')
            ->where('a.post_status', 'wc-completed')
            ->sum('c.meta_value');

        // Final total
        return $totalPayment + $totalOrder;
    }
}
