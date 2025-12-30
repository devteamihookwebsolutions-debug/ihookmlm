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

        // Get total PV (kept as-is)
        $totalPv = MTotalPV::getTotalPV($memberId, $matrixId);

        // Payment history total
        $totalPayment = DB::table(env('IHOOK_PREFIX') . '_paymenthistory_table')
            ->where('paymenthistory_member_id', $memberId)
            ->where('matrix_id', $matrixId)
            ->where('paymenthistory_status', 'paid')
            ->sum('paymenthistory_amount');

        // WooCommerce order total
        $totalOrder = DB::table(env('IHOOK_STORE_PREFIX') . '_posts as a')
            ->leftJoin(env('IHOOK_STORE_PREFIX') . '_postmeta as b', function ($join) {
                $join->on('b.post_id', '=', 'a.ID')
                     ->where('b.meta_key', '_customer_user');
            })
            ->leftJoin(env('IHOOK_STORE_PREFIX') . '_postmeta as c', function ($join) {
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
