<?php

namespace Admin\App\Models\Middleware;
use Illuminate\Support\Facades\DB;
use App\Models\Middleware\MDownlineSales;

class MGroupSalesTargetAmount
{
    /**
     * Get total group sales (self + downline)
     *
     * @param int $member_id
     * @param int $matrix_id
     * @return float|int
     */
    public static function groupSalesTarget($member_id, $matrix_id)
    {
        // Get member's own shop sales
        $shop_sales = DB::table(env('IHOOK_PREFIX') . '_matrix_members_link_table')
            ->where('members_id', $member_id)
            ->where('matrix_id', $matrix_id)
            ->value('total_sales') ?? 0;

        // Get downline MLM sales
        $mlm_sales = MDownlineSales::getDownlineMLMSales($member_id, $matrix_id);

        // Total group sales
        return $shop_sales + $mlm_sales;
    }
}
