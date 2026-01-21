<?php

/**
 * This class contains public functions related to MGroupReferal
 *
 * @package         MGroupReferal
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

class MGroupReferal
{
    protected static function getTable(): string
    {
        return config('services.ihook.prefix', '') . '_matrix_members_link_table';
    }

    public static function groupReferal(int $member_id, int $matrix_id): int
    {
        return DB::table(static::getTable())
            ->where('matrix_id', $matrix_id)
            ->whereRaw("FIND_IN_SET(?, members_parents)", [$member_id])
            ->count();
    }

    public static function groupReferalWithDateRange(
        int $member_id,
        int $matrix_id,
        ?string $start_date = null,
        ?string $end_date = null
    ): int {
        $query = DB::table(static::getTable())
            ->where('matrix_id', $matrix_id)
            ->whereRaw("FIND_IN_SET(?, members_parents)", [$member_id])
            ->where('members_subscription_status', '1');

        if ($start_date && $end_date) {
            $query->whereBetween('matrix_doj', [$start_date, $end_date]);
        }

        return $query->count();
    }
}
