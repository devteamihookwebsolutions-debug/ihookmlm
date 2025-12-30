<?php

namespace App\Models\Middleware;

use Illuminate\Support\Facades\DB;

class MDownlineSales
{
    /**
     * Get total downline MLM sales
     *
     * @param int $members_id
     * @param int $matrix_id
     * @return float|int
     */
    public static function getDownlineMLMSales($members_id, $matrix_id)
    {
        return DB::table(env('IHOOK_PREFIX') . '_matrix_members_link_table as a')
            ->leftJoin(
                env('IHOOK_PREFIX') . '_paymenthistory_table as b',
                'b.paymenthistory_member_id',
                '=',
                'a.members_id'
            )
            ->whereRaw('FIND_IN_SET(?, a.members_parents)', [$members_id])
            ->where('a.matrix_id', $matrix_id)
            ->where('b.paymenthistory_status', 'paid')
            ->whereIn('b.paymenthistory_type', ['upgrade', 'subscription'])
            ->sum('b.paymenthistory_amount');
    }
}
