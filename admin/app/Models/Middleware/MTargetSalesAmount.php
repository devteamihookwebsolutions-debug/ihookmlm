<?php

/**
 * This class contains public functions related to MTargetSalesAmount
 *
 * @package         MTargetSalesAmount
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Models\Middleware;
use Illuminate\Support\Facades\DB;

class MTargetSalesAmount
{
    /**
     * OLD: Personal sales + paid payment history
     *
     * @param int $members_id
     * @param int $matrix_id
     * @return float|int
     */
    public static function salesTargetByAmountOld($members_id, $matrix_id)
    {
        // Sum of paid payment history
        $total = DB::table(env('IHOOK_PREFIX') . '_paymenthistory_table')
            ->where('paymenthistory_member_id', $members_id)
            ->where('matrix_id', $matrix_id)
            ->where('paymenthistory_status', 'paid')
            ->sum('paymenthistory_amount');

        // Personal shop sales
        $shop_sales = DB::table(env('IHOOK_PREFIX') . '_matrix_members_link_table')
            ->where('members_id', $members_id)
            ->where('matrix_id', $matrix_id)
            ->value('personal_sales') ?? 0;

        return $shop_sales + $total;
    }

    /**
     * NEW: Downline PV sales target
     *
     * @param int $members_id
     * @param int $matrix_id
     * @return float|int
     */
    public static function salesTargetByAmount($members_id, $matrix_id)
    {
        return DB::table(env('IHOOK_PREFIX') . '_history_table as a')
            ->leftJoin(
                env('IHOOK_PREFIX') . '_matrix_members_link_table as b',
                'b.members_id',
                '=',
                'a.history_member_id'
            )
            ->whereRaw('FIND_IN_SET(?, b.members_parents)', [$members_id])
            ->where('a.history_type', 'pv')
            ->where('a.history_matrix_id', $matrix_id)
            ->sum('a.history_amount');
    }

    /**
     * Downline PV sales target with date range
     *
     * @param int $members_id
     * @param int $matrix_id
     * @param string $start_date
     * @param string $end_date
     * @return float|int
     */
    public static function salesTargetByAmountWithDateRange(
        $members_id,
        $matrix_id,
        $start_date,
        $end_date
    ) {
        $start = date('Y-m-d H:i:s', strtotime($start_date));
        $end   = date('Y-m-d 23:59:59', strtotime($end_date));

        return DB::table(env('IHOOK_PREFIX') . '_history_table as a')
            ->leftJoin(
                env('IHOOK_PREFIX') . '_matrix_members_link_table as b',
                'b.members_id',
                '=',
                'a.history_member_id'
            )
            ->whereRaw('FIND_IN_SET(?, b.members_parents)', [$members_id])
            ->where('a.history_type', 'pv')
            ->where('a.history_matrix_id', $matrix_id)
            ->whereBetween('a.history_datetime', [$start, $end])
            ->sum('a.history_amount');
    }
}
