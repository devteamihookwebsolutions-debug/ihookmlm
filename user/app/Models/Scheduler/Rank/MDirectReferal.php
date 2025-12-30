<?php

namespace User\App\Models\Scheduler\Rank;

use Illuminate\Support\Facades\DB;

class MDirectReferal
{
    /**
     * Count direct referrals
     *
     * @param int $member_id
     * @param int $matrix_id
     * @return int
     */
    public static function directReferal($member_id, $matrix_id)
    {
        return DB::table(env('IHOOK_PREFIX') . '_matrix_members_link_table')
            ->where('direct_id', $member_id)
            ->where('matrix_id', $matrix_id)
            ->count();
    }

    /**
     * Count direct referrals within date range
     *
     * @param int $member_id
     * @param int $matrix_id
     * @param string|null $start_date
     * @param string|null $end_date
     * @return int
     */
    public static function directReferalWithDateRange($member_id, $matrix_id, $start_date = null, $end_date = null)
    {
        $query = DB::table(env('IHOOK_PREFIX') . '_matrix_members_link_table')
            ->where('direct_id', $member_id)
            ->where('matrix_id', $matrix_id)
            ->where('members_subscription_status', '1');

        if (!empty($start_date) && !empty($end_date)) {
            $query->whereBetween('matrix_doj', [$start_date, $end_date]);
        }

        return $query->count();
    }
}
