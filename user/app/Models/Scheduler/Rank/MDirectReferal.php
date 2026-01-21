<?php

/**
 * This class contains public functions related to MDirectReferal
 *
 * @package         MDirectReferal
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
