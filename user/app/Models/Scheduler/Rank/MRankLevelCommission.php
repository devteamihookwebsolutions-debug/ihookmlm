<?php

namespace User\App\Models\Scheduler\Rank;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use User\App\Models\Scheduler\Bonus\MHasDownlines;
use User\App\Models\Scheduler\Rank\Rank_Impl;

class MRankLevelCommission
{
    public static function processLevelCommissions()
    {
        Log::info('Rank Level Commission Cron Started');

        $prefix = config('services.ihook.prefix', 'ihook');

        // Get credit history types
        $creditHistoryTypes = DB::table("{$prefix}_history_type_table")
            ->where('history_credit_type', 1)
            ->pluck('history_type_name')
            ->toArray();

        if (empty($creditHistoryTypes)) {
            Log::warning('No credit history types defined');
            return;
        }

        $creditCondition = implode(' OR ', array_map(fn($type) => "b.history_type = ?", $creditHistoryTypes));

        $ranks = DB::table("{$prefix}_rank_levelcommission")
            ->distinct()
            ->pluck('rank_id');

        $processedAnyMember = false;

        foreach ($ranks as $rank_id) {
            Log::info("Processing Rank ID: {$rank_id}");

            $members = DB::table("{$prefix}_members_table as mt")
                ->join("{$prefix}_matrix_members_link_table as mml", 'mml.members_id', '=', 'mt.members_id')
                ->select('mt.members_id', 'mml.matrix_id')
                ->where('mml.rankid', $rank_id)
                ->where('mt.levelcommission_cron', 0)
                ->where('mt.levelcommission_satisfied', 0)
                ->get();

            if ($members->isEmpty()) {
                Log::info("No pending members found for Rank {$rank_id}");
                continue;
            }

            $processedAnyMember = true;

            foreach ($members as $member) {
                $memberId = $member->members_id;
                $matrixId = $member->matrix_id;

                Log::info("=== START: Processing Member ID {$memberId} for Rank {$rank_id} ===");

                // Step 1: Re-verify rank qualification
                $qualified = Rank_Impl::upgradeRank($memberId, $matrixId, $rank_id);

                if (!$qualified) {
                    Log::info("Member {$memberId} FAILED rank qualification check → Skipped");
                    self::markAsProcessed($memberId);
                    Log::info("=== END: Member {$memberId} - SKIPPED (Rank Failed) ===\n");
                    continue;
                }

                Log::info("Member {$memberId} PASSED rank qualification check");

                // Step 2: Check if level commission settings exist
                $levelCommissions = DB::table("{$prefix}_rank_levelcommission")
                    ->where('rank_id', $rank_id)
                    ->orderBy('level')
                    ->get();

                if ($levelCommissions->isEmpty()) {
                    Log::info("Member {$memberId} → No level commission settings for Rank {$rank_id} → Skipped");
                    self::markAsProcessed($memberId);
                    Log::info("=== END: Member {$memberId} - SKIPPED (No Settings) ===\n");
                    continue;
                }

                // Step 3: Downline requirement check
                $levelCriteria = $levelCommissions->pluck('level')
                    ->mapWithKeys(fn($lvl) => [$lvl => 1])
                    ->toArray();

                $hasDownlines = MHasDownlines::hasDownlines($memberId, $levelCriteria, $matrixId, '>=');

                if (!$hasDownlines) {
                    Log::info("Member {$memberId} FAILED downline requirement (needs at least 1 in levels: " . implode(', ', array_keys($levelCriteria)) . ") → Skipped");
                    self::markAsProcessed($memberId);
                    Log::info("=== END: Member {$memberId} - SKIPPED (Downline Failed) ===\n");
                    continue;
                }

                Log::info("Member {$memberId} PASSED downline requirement");

                // Step 4: Get root
                $root = DB::table("{$prefix}_matrix_members_link_table")
                    ->where('members_id', $memberId)
                    ->where('matrix_id', $matrixId)
                    ->value('root');

                if (is_null($root)) {
                    Log::info("Member {$memberId} → Root not found → Skipped");
                    self::markAsProcessed($memberId);
                    Log::info("=== END: Member {$memberId} - SKIPPED (Root Missing) ===\n");
                    continue;
                }

                $totalPaid = 0;

                foreach ($levelCommissions as $comm) {
                    $level = $comm->level;
                    $percent = $comm->commission;

                    if ($percent <= 0) continue;

                    $levelRoot = $root + $level;

                    $totalSales = DB::table("{$prefix}_matrix_members_link_table as a")
                        ->join("{$prefix}_history_table as b", 'a.members_id', '=', 'b.history_member_id')
                        ->whereRaw("FIND_IN_SET(?, a.members_parents)", [$memberId])
                        ->where('a.root', $levelRoot)
                        ->where('a.matrix_id', $matrixId)
                        ->where('a.members_account_status', 1)
                        ->whereRaw("({$creditCondition})", $creditHistoryTypes)
                        ->sum('b.history_amount');

                    $salesAmount = $totalSales ?? 0;

                    if ($salesAmount <= 0) {
                        Log::info("Member {$memberId} → Level {$level}: No sales found (0.00) → No payout");
                        continue;
                    }

                    $bonus = round($salesAmount * ($percent / 100), 2);
                    $totalPaid += $bonus;

                    if ($bonus > 0) {
                        $description = "Rank Level Commission {$percent}% from Level {$level}";
                        $txId = '#' . substr(str_shuffle('0123456789'), 0, 9);

                        DB::table("{$prefix}_history_table")->insert([
                            'history_type'            => 'levelcommission',
                            'history_member_id'       => $memberId,
                            'history_description'     => $description,
                            'history_datetime'        => Carbon::now(),
                            'history_amount'          => $bonus,
                            'history_matrix_id'       => $matrixId,
                            'history_transaction_id'  => $txId,
                            'history_wallet_type'     => 1,
                        ]);

                        Log::info("PAID {$bonus} to Member {$memberId} → Level {$level} ({$percent}% of {$salesAmount})");
                    }
                }

                if ($totalPaid > 0) {
                    Log::info("Member {$memberId} → Total Level Commission Paid: {$totalPaid}");
                } else {
                    Log::info("Member {$memberId} → Qualified but no payout (zero sales in levels)");
                }

                // Mark as processed
                DB::table("{$prefix}_members_table")
                    ->where('members_id', $memberId)
                    ->update([
                        'levelcommission_cron'       => 1,
                        'levelcommission_satisfied'  => 1,
                    ]);

                Log::info("=== END: Member {$memberId} - PROCESSED (Total Paid: {$totalPaid}) ===\n");
            }
        }

        if (!$processedAnyMember) {
            DB::table("{$prefix}_members_table")
                ->update(['levelcommission_cron' => 0,'levelcommission_satisfied'=> 0]);

            Log::info('No new members qualified today → Reset cron flags for pending ones');
        }

        Log::info('Rank Level Commission Cron Completed');
    }

    private static function markAsProcessed(int $memberId)
    {
        $prefix = config('services.ihook.prefix', 'ihook');

        DB::table("{$prefix}_members_table")
            ->where('members_id', $memberId)
            ->update(['levelcommission_cron' => 1]);
    }
}
