<?php
// app/Models/Dashboard/DashboardBlock1Overview.php

namespace User\App\Models\Dashboard;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use User\App\Models\Rank\RankSetting;

class DashboardBlock1Overview
{
    public static function getTotalCommission(?int $memberId): array
    {
        if (!$memberId) {
            return ['total_amount' => 0.0, 'percentage_change' => 0.0];
        }

        $prefix = config('services.ihook.prefix');

        // Total Commission
        $total = DB::table("{$prefix}_history_table as h")
            ->join("{$prefix}_history_type_table as t", 'h.history_type', '=', 't.history_type_name')
            ->where('h.history_member_id', $memberId)
            ->where('t.history_credit_type', 1)
            ->sum('h.history_amount');

        // This Week
        $thisWeek = DB::table("{$prefix}_history_table as h")
            ->join("{$prefix}_history_type_table as t", 'h.history_type', '=', 't.history_type_name')
            ->where('h.history_member_id', $memberId)
            ->where('t.history_credit_type', 1)
            ->whereRaw('YEARWEEK(h.history_datetime, 1) = YEARWEEK(CURDATE(), 1)')
            ->sum('h.history_amount');

        // Last Week
        $lastWeek = DB::table("{$prefix}_history_table as h")
            ->join("{$prefix}_history_type_table as t", 'h.history_type', '=', 't.history_type_name')
            ->where('h.history_member_id', $memberId)
            ->where('t.history_credit_type', 1)
            ->whereRaw('YEARWEEK(h.history_datetime, 1) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK, 1)')
            ->sum('h.history_amount');

        $change = $lastWeek > 0
            ? round((($thisWeek - $lastWeek) / $lastWeek) * 100, 2)
            : ($thisWeek > 0 ? 100 : 0);

        return [
            'total_amount'      => (float) $total,
            'percentage_change' => $change,
        ];
    }

    /**
     * SPARKLINE: Commission (Last 7 Days)
     */
    public static function getSparklineCommission(?int $memberId): array
    {
        if (!$memberId) return array_fill(0, 7, 0);

        $prefix = config('services.ihook.prefix');
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $amt = DB::table("{$prefix}_history_table as h")
                ->join("{$prefix}_history_type_table as t", 'h.history_type', '=', 't.history_type_name')
                ->where('h.history_member_id', $memberId)
                ->where('t.history_credit_type', 1)
                ->whereDate('h.history_datetime', $date)
                ->sum('h.history_amount');
            $data[] = (float) $amt;
        }
        // dd($data);

        return $data;
    }

    /**
     * TOTAL ORDERS (WooCommerce)
     */
    public static function getTotalOrders(?int $shopId): array
    {
        if (!$shopId) {
            return ['total_orders_all_time' => 0, 'percentage_change' => 0.0];
        }

        $store = config('services.ihook.store_prefix');

        $all = DB::table("{$store}_posts as p")
            ->join("{$store}_postmeta as pm", function ($join) {
                $join->on('pm.post_id', '=', 'p.ID')
                     ->where('pm.meta_key', '=', '_customer_user');
            })
            ->where('pm.meta_value', $shopId)
            ->whereIn('p.post_status', ['wc-completed', 'wc-processing', 'wc-pending'])
            ->where('p.post_type', 'shop_order')
            ->count();

        $thisWeek = DB::table("{$store}_posts as p")
            ->join("{$store}_postmeta as pm", function ($join) {
                $join->on('pm.post_id', '=', 'p.ID')
                     ->where('pm.meta_key', '=', '_customer_user');
            })
            ->where('pm.meta_value', $shopId)
            ->whereRaw('YEARWEEK(p.post_date,1) = YEARWEEK(CURDATE(),1)')
            ->whereIn('p.post_status', ['wc-completed', 'wc-processing', 'wc-pending'])
            ->count();

        $lastWeek = DB::table("{$store}_posts as p")
            ->join("{$store}_postmeta as pm", function ($join) {
                $join->on('pm.post_id', '=', 'p.ID')
                     ->where('pm.meta_key', '=', '_customer_user');
            })
            ->where('pm.meta_value', $shopId)
            ->whereRaw('YEARWEEK(p.post_date,1) = YEARWEEK(CURDATE()-INTERVAL 1 WEEK,1)')
            ->count();

        $change = $lastWeek > 0 ? round((($thisWeek - $lastWeek) / $lastWeek) * 100, 2) : 0;

        return [
            'total_orders_all_time' => $all,
            'percentage_change'     => $change,
        ];

    }

    /**
     * SPARKLINE: Orders
     */
    public static function getSparklineOrders(?int $shopId): array
    {
        if (!$shopId) return array_fill(0, 7, 0);

        $store = config('services.ihook.store_prefix');
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = DB::table("{$store}_posts as p")
                ->join("{$store}_postmeta as pm", function ($join) {
                    $join->on('pm.post_id', '=', 'p.ID')
                         ->where('pm.meta_key', '=', '_customer_user');
                })
                ->where('pm.meta_value', $shopId)
                ->whereDate('p.post_date', $date)
                ->whereIn('p.post_status', ['wc-completed', 'wc-processing'])
                ->count();
            $data[] = $count;
        }
        return $data;
    }

    /**
     * TOTAL PACKAGE PURCHASED
     */
    public static function getTotalPackagePurchased(?int $memberId): array
    {
        if (!$memberId) {
            return ['total_amount' => 0.0, 'percentage_change' => 0.0];
        }

        $prefix = config('services.ihook.prefix');

        $total = DB::table("{$prefix}_paymenthistory_table")
            ->where('paymenthistory_member_id', $memberId)
            ->where('paymenthistory_status', 'paid')
            ->whereIn('paymenthistory_type', ['upgrade', 'subscription'])
            ->sum('paymenthistory_amount');
            // dd($total);

        $thisWeek = DB::table("{$prefix}_paymenthistory_table")
            ->where('paymenthistory_member_id', $memberId)
            ->where('paymenthistory_status', 'paid')
            ->whereRaw('YEARWEEK(paymenthistory_date,1) = YEARWEEK(CURDATE(),1)')
            ->sum('paymenthistory_amount');

        $lastWeek = DB::table("{$prefix}_paymenthistory_table")
            ->where('paymenthistory_member_id', $memberId)
            ->whereRaw('YEARWEEK(paymenthistory_date,1) = YEARWEEK(CURDATE()-INTERVAL 1 WEEK,1)')
            ->sum('paymenthistory_amount');

        $change = $lastWeek > 0 ? round((($thisWeek - $lastWeek) / $lastWeek) * 100, 2) : 0;
// dd($change);
        return [
            'total_amount'      => (float) $total,
            'percentage_change' => $change,
        ];
    }

    /**
     * SPARKLINE: Packages
     */
    public static function getSparklinePackages(?int $memberId): array
    {
        if (!$memberId) return array_fill(0, 7, 0);

        $prefix = config('services.ihook.prefix');
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $amt = DB::table("{$prefix}_paymenthistory_table")
                ->where('paymenthistory_member_id', $memberId)
                ->where('paymenthistory_status', 'paid')
                ->whereDate('paymenthistory_date', $date)
                ->sum('paymenthistory_amount');
            $data[] = (float) $amt;
        }
        return $data;
    }

    /**
     * TOTAL DIRECT DOWNLINES
     */
    public static function getTotalDirectDownlines(?int $memberId): array
    {
        if (!$memberId) {
            return ['total_direct_all_time' => 0, 'percentage_change' => 0.0];
        }

        $prefix = config('services.ihook.prefix');

        $total = DB::table("{$prefix}_matrix_members_link_table")
            ->where('direct_id', $memberId)
            ->count();


        $thisWeek = DB::table("{$prefix}_matrix_members_link_table")
            ->where('direct_id', $memberId)
            ->whereRaw('YEARWEEK(matrix_doj,1) = YEARWEEK(CURDATE(),1)')
            ->count();

        $lastWeek = DB::table("{$prefix}_matrix_members_link_table")
            ->where('direct_id', $memberId)
            ->whereRaw('YEARWEEK(matrix_doj,1) = YEARWEEK(CURDATE()-INTERVAL 1 WEEK,1)')
            ->count();

        $change = $lastWeek > 0 ? round((($thisWeek - $lastWeek) / $lastWeek) * 100, 2) : 0;

        return [
            'total_direct_all_time' => $total,
            'percentage_change'     => $change,
        ];
    }

    /**
     * SPARKLINE: Downlines
     */
    public static function getSparklineDownlines(?int $memberId): array
    {
        if (!$memberId) return array_fill(0, 7, 0);

        $prefix = config('services.ihook.prefix');
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = DB::table("{$prefix}_matrix_members_link_table")
                ->where('direct_id', $memberId)
                ->whereDate('matrix_doj', $date)
                ->count();
            $data[] = $count;
        }
        return $data;
    }

    public static function getWalletBalance(int $memberId, int $walletType): float
    {
        if (!$memberId) return 0.0;

        $prefix = config('services.ihook.prefix');

        $balance = DB::table("{$prefix}_history_table as h")
            ->join("{$prefix}_history_type_table as htt", function($join) {
                $join->on('h.history_type', '=', 'htt.history_type_name');
            })
            ->where('h.history_member_id', $memberId)
            ->where('h.history_wallet_type', $walletType)
            ->selectRaw("
                COALESCE(SUM(CASE WHEN htt.history_credit_type = 1 THEN h.history_amount ELSE 0 END), 0)
                -
                COALESCE(SUM(CASE WHEN htt.history_debit_type = 1 THEN h.history_amount ELSE 0 END), 0)
                AS wallet_balance
            ")
            ->value('wallet_balance');

        return round($balance ?? 0, 2);
    }

    public static function getTotalWalletBalance(int $memberId): float
    {
        if (!$memberId) return 0.0;

        $eWallet = self::getWalletBalance($memberId, 1); // E-Wallet
        $cWallet = self::getWalletBalance($memberId, 2); // Cash Wallet

        return round($eWallet + $cWallet, 2);
    }

    public static function getReplicatedUrl(?int $memberId): string
    {
        if (!$memberId) return '#';

        $prefix = config('services.ihook.prefix');
        $subdomain = DB::table("{$prefix}_members_table")
            ->where('members_id', $memberId)
            ->value('members_subdomain');

        return $subdomain
            ? "https://{$subdomain}." . config('services.ihook.domain')
            : '#';
    }

    public static function getCountrySalesData(?int $shopId): array
    {
        if (!$shopId) return [];

        $store = config('services.ihook.store_prefix');

        return DB::table("{$store}_postmeta as pm_country")
            ->join("{$store}_posts as p", 'pm_country.post_id', '=', 'p.ID')
            ->join("{$store}_postmeta as pm_user", function ($join) {
                $join->on('pm_user.post_id', '=', 'p.ID')
                     ->where('pm_user.meta_key', '=', '_customer_user');
            })
            ->where('pm_user.meta_value', $shopId)
            ->where('pm_country.meta_key', '_billing_country')
            ->whereIn('p.post_status', ['wc-completed', 'wc-processing'])
            ->where('p.post_type', 'shop_order')
            ->select('pm_country.meta_value as iso_a2', DB::raw('COUNT(*) as value'))
            ->groupBy('pm_country.meta_value')
            ->get()
            ->toArray();
    }

    // New: For rank percentage (based on member stats vs conditions)
    public static function getRankPercentage(int $rankId, int $memberId): float
    {
        $rank = DB::table(config('services.ihook.prefix') . '_ranksetting')
            ->where('rank_id', $rankId)
            ->first();

        if (!$rank || !$rank->conditions) return 0.0;

        $conditions = json_decode($rank->conditions, true);
        $stats = self::getMemberStats($memberId);

        $achieved = 0;
        foreach ($conditions as $key => $req) {
            if (($stats[$key] ?? 0) >= $req) $achieved++;
        }

        return count($conditions) ? round(($achieved / count($conditions)) * 100, 2) : 0.0;
    }
    public static function getMemberStats($memberId)
{
    $prefix = config('services.ihook.prefix');

    return [
        1 => DB::table("{$prefix}_matrix_members_link_table")->where('direct_id', $memberId)->count(),
        2 => DB::table("{$prefix}_matrix_members_link_table")
            ->where('members_id', '!=', $memberId)
            ->whereRaw('FIND_IN_SET(?, members_parents)', [$memberId])
            ->count(),
        3 => DB::table(config('services.ihook.store_prefix').'_posts')
            ->where('post_author', $memberId)
            ->where('post_type', 'shop_order')
            ->count(),
        7 => (float) DB::table("{$prefix}_history_table")
            ->where('history_member_id', $memberId)
            ->where('history_type', 'pv')
            ->sum('history_amount'),
        8 => (float) DB::table("{$prefix}_history_table")
            ->where('history_member_id', $memberId)
            ->where('history_type', 'gpv')
            ->sum('history_amount'),
    ];
}

    // New: For next rank requirements HTML (returns Blade partial as string)
    public static function getRankDetailsRequirements(int $rankId, int $memberId): string
    {
        $rank = DB::table(config('services.ihook.prefix') . '_ranksetting')
            ->where('rank_id', $rankId)
            ->first();

        $conditions = json_decode($rank->conditions ?? '[]', true);
        $stats = self::getMemberStats($memberId);

        $html = '';
        foreach ($conditions as $key => $req) {
            $current = $stats[$key] ?? 0;
            $progress = min(100, round(($current / $req) * 100, 2));
            $label = self::getRankConditionLabel($key); // Helper to get names like 'Direct Referrals'

            $html .= "
                <div class='flex justify-between items-center mb-3'>
                    <div class='text-base font-semibold text-black dark:text-white'>{$label}</div>
                    <div class='text-base font-semibold text-black dark:text-white'>{$current} / {$req}</div>
                </div>
                <div class='border border-neutral-300 rounded-lg p-5 mb-5'>
                    <div class='progress-bar'>
                        <div class='w-full bg-neutral-200 rounded-full h-2.5 dark:bg-neutral-900'>
                            <div class='bg-neutral-600 h-2.5 rounded-full dark:bg-neutral-300' style='width: {$progress}%'></div>
                        </div>
                    </div>
                </div>
            ";
        }

        return $html;
    }


    // Helper for rank condition labels
    private static function getRankConditionLabel(string $key): string
    {
        return match ($key) {
            '1' => 'Direct Referrals',
            '2' => 'Group Referrals',
            '3' => 'Number of Sales',
            // Add all as per your switch in JS
            default => 'Unknown',
        };
    }

}
