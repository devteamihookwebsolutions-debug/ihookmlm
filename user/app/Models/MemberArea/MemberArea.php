<?php

namespace Admin\App\Models\MemberArea;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MemberArea
{
    /**
     * -------------------------------------------------
     *  Revenue Summary (commissions, bonuses, payouts)
     * -------------------------------------------------
     */
    public static function getRevenueData(int $memberId): string
    {
        // 1. All credit entries (commissions, bonuses, fund-received …)
        $credits = DB::table($_ENV['IHOOK_PREFIX'] . 'ihook_history_table as h')
            ->join($_ENV['IHOOK_PREFIX'] . 'ihook_history_type_table as t', 'h.history_type_id', '=', 't.history_type_id')
            ->where('h.history_member_id', $memberId)
            ->where('t.history_credit_type', 1)
            ->selectRaw('SUM(h.history_amount) as total, t.history_name')
            ->groupBy('t.history_name')
            ->pluck('total', 'history_name');

        // 2. All debit entries (withdrawals, deductions …)
        $debits = DB::table($_ENV['IHOOK_PREFIX'] . 'ihook_history_table as h')
            ->join($_ENV['IHOOK_PREFIX'] . 'ihook_history_type_table as t', 'h.history_type_id', '=', 't.history_type_id')
            ->where('h.history_member_id', $memberId)
            ->where('t.history_debit_type', 1)
            ->selectRaw('SUM(h.history_amount) as total, t.history_name')
            ->groupBy('t.history_name')
            ->pluck('total', 'history_name');

        // 3. Build the HTML table
        $html = '<table class="datatable-table w-full">';
        $html .= '<thead><tr><th class="text-left">Type</th><th class="text-right">Amount</th></tr></thead><tbody>';

        foreach ($credits as $name => $amt) {
            $html .= "<tr><td class=\"text-left\">{$name}</td><td class=\"text-right text-green-600\">+" . number_format($amt, 2) . "</td></tr>";
        }
        foreach ($debits as $name => $amt) {
            $html .= "<tr><td class=\"text-left\">{$name}</td><td class=\"text-right text-red-600\">-" . number_format($amt, 2) . "</td></tr>";
        }

        $html .= '</tbody></table>';

        return $html ?: '<p class="text-gray-500 text-center">No revenue data</p>';
    }

    /**
     * -------------------------------------------------
     *  Yearly Sales Summary (WooCommerce orders)
     * -------------------------------------------------
     */
    public static function getSalesData(int $memberId): string
    {
        // Get WooCommerce customer_id (members_shop_id)
        $shopId = DB::table($_ENV['IHOOK_PREFIX'] . 'members_table')
            ->where('members_id', $memberId)
            ->value('members_shop_id');

        if (!$shopId) {
            return '<p class="text-gray-500 text-center">No shop linked</p>';
        }

        // All completed orders for this customer
        $orders = DB::table($_ENV['WP_DBNAME'] . '.' . $_ENV['STORE_PREFIX'] . 'posts as p')
            ->join($_ENV['WP_DBNAME'] . '.' . $_ENV['STORE_PREFIX'] . 'postmeta as pm', function ($join) use ($shopId) {
                $join->on('p.ID', '=', 'pm.post_id')
                     ->where('pm.meta_key', '=', '_customer_user')
                     ->where('pm.meta_value', '=', $shopId);
            })
            ->join($_ENV['WP_DBNAME'] . '.' . $_ENV['STORE_PREFIX'] . 'postmeta as tot', function ($join) {
                $join->on('p.ID', '=', 'tot.post_id')
                     ->where('tot.meta_key', '=', '_order_total');
            })
            ->where('p.post_type', 'shop_order')
            ->where('p.post_status', 'wc-completed')
            ->selectRaw('YEAR(p.post_date) as yr, SUM(CAST(tot.meta_value AS DECIMAL(10,2))) as total')
            ->groupBy('yr')
            ->orderBy('yr', 'desc')
            ->get();

        if ($orders->isEmpty()) {
            return '<p class="text-gray-500 text-center">No sales data</p>';
        }

        // Build table
        $html = '<table class="datatable-table w-full">';
        $html .= '<thead><tr><th class="text-left">Year</th><th class="text-right">Total Sales</th></tr></thead><tbody>';

        foreach ($orders as $o) {
            $html .= "<tr><td class=\"text-left\">{$o->yr}</td><td class=\"text-right\">" . number_format($o->total, 2) . "</td></tr>";
        }

        $html .= '</tbody></table>';
        return $html;
    }
}
