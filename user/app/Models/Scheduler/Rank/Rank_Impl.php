<?php

namespace User\App\Models\Scheduler\Rank;

use Illuminate\Support\Facades\DB;
use Admin\App\Models\Middleware\MTargetSalesAmount;
use Admin\App\Models\Middleware\MTotalGPV;
use Admin\App\Models\Middleware\MTotalPV;
use Illuminate\Support\Facades\Log;
use User\App\Models\Scheduler\Rank\MDirectReferal;
use User\App\Models\Scheduler\Rank\MGetLevel;
use User\App\Models\Scheduler\Rank\MGroupReferal;
use User\App\Models\Scheduler\Rank\MProduct;
use User\App\Models\Scheduler\Rank\MTarget;

class Rank_Impl
{
    /**
     * Check if member qualifies for the given rank
     *
     * @param int $member_id
     * @param int $matrix_id
     * @param int $rankid  (next rank to check)
     * @return int  Returns $rankid if qualified, 0 if not
     */
    public static function upgradeRank($member_id, $matrix_id, $rankid)
    {
        $count = 0;
        $totalConditions = 0;

        Log::info("Rank check started for Member ID: {$member_id}, Matrix ID: {$matrix_id}, Target Rank: {$rankid}");

        $excludeKeys = [
            'rank_title', 'bonus', 'wallet_type', 'commission', 'directbonus',
            'networkbonus', 'maxbonus', 'rank_icon_path', 'rank_color',
            'cryptocurrency', 'matrix_id', 'rank_icon', 'wallet'
        ];

        $prefix = env('IHOOK_PREFIX');

        $records = DB::table("{$prefix}_ranksetting")
            ->where('rank_id', $rankid)
            ->where('matrix_id', $matrix_id)
            ->whereNotIn('rank_key', $excludeKeys)
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();

        // Convert stdClass to array
        $records = json_decode(json_encode($records), true);

        $totalConditions = count($records);

        Log::info("Found {$totalConditions} qualification conditions for rank {$rankid}");

        if ($totalConditions == 0) {
            Log::info("No conditions defined for rank {$rankid} → auto qualify");
            return $rankid;
        }

        foreach ($records as $condition) {
            $key = $condition['rank_key'];
            $required = (float) $condition['rank_value'];
            $achieved = 0;

            if ($key == 1) {
                // Direct Referrals
                $achieved = (float) MDirectReferal::directReferal($member_id, $matrix_id);
            } elseif ($key == 2) {
                // Group Referrals (Total Downline)
                $achieved = (float) MGroupReferal::groupReferal($member_id, $matrix_id);
            } elseif ($key == 3) {
                // Personal Product Purchase Count
                $achieved = (float) MProduct::product($member_id, $matrix_id);
            } elseif ($key == 4) {
                // Products Sold Count
                $achieved = (float) MProduct::productSold($member_id, $matrix_id);
            } elseif ($key == 5) {
                // Target (custom)
                $achieved = (float) MTarget::target($member_id, $matrix_id);
            } elseif ($key == 6) {
                // Members in specific level
                $level = (int) $condition['rank_value'];
                $achieved = (float) MGetLevel::getLevel($member_id, $matrix_id, $level);
            } elseif ($key == 7 || $key == 11) {
                // Personal PV or similar
                $achieved = (float) MTotalPV::getTotalPV($member_id, $matrix_id);
            } elseif ($key == 8) {
                // Group PV
                $achieved = (float) MTotalGPV::getTotalGPV($member_id, $matrix_id);
            } elseif ($key == 9 || $key == 10) {
                // Sales Target by Amount
                $achieved = (float) MTargetSalesAmount::salesTargetByAmount($member_id, $matrix_id);
            }

            Log::info("Condition rank_key={$key}: Required >= {$required}, Achieved = {$achieved} " . ($required <= $achieved ? 'PASS' : 'FAIL'));

            if ($required <= $achieved) {
                $count++;
            }
        }

        if ($count == $totalConditions && $totalConditions > 0) {
            Log::info("Member {$member_id} QUALIFIED for rank {$rankid} ({$count}/{$totalConditions} conditions met)");
            return $rankid;
        } else {
            Log::info("Member {$member_id} NOT qualified for rank {$rankid} ({$count}/{$totalConditions} conditions met)");
            return 0;
        }
    }
}
