<?php

namespace Admin\App\Models\Middleware;

use Illuminate\Support\Facades\DB;

class MTotalPV
{
    /**
     * Get total PV
     *
     * @param int $memberId
     * @param int $matrixId
     * @return float|int
     */
    public static function getTotalPV(int $memberId, int $matrixId)
    {
        return DB::table(env('IHOOK_PREFIX') . '_history_table')
            ->where('history_member_id', $memberId)
            ->where('history_type', 'pv')
            ->where('history_matrix_id', $matrixId)
            ->sum('history_amount');
    }

    /**
     * Get total PV with date range
     *
     * @param int $memberId
     * @param int $matrixId
     * @param string $startDate
     * @param string $endDate
     * @return float|int
     */
    public static function getTotalPVWithDateRange(
        int $memberId,
        int $matrixId,
        string $startDate,
        string $endDate
    ) {
        $startDate = date('Y-m-d H:i:s', strtotime($startDate));
        $endDate   = date('Y-m-d 23:59:59', strtotime($endDate));

        return DB::table(env('IHOOK_PREFIX') . '_history_table')
            ->where('history_member_id', $memberId)
            ->where('history_type', 'pv')
            ->where('history_matrix_id', $matrixId)
            ->whereBetween('history_datetime', [$startDate, $endDate])
            ->sum('history_amount');
    }
}
