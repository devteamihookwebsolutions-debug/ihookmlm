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
