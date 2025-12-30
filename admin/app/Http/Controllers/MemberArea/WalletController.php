<?php

namespace Admin\App\Http\Controllers\MemberArea;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\MemberArea\MemberHistrory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class WalletController extends Controller
{
    protected $currency;

    public function __construct()
    {
        $this->currency = Session::get('site_settings.site_currency', '$');
        Log::info('WalletController initialized | Currency: ' . $this->currency);
    }

    // === Payout History (unchanged) ===
    public function payoutHistory($memberId)
    {
        Log::info("=== PAYOUT HISTORY START ===", ['member_id' => $memberId]);

        try {
            $historyTable  = 'ihook_history_table';
            $accountsTable = 'ihook_members_accounts_table';

            $records = DB::table("{$historyTable} AS h")
                ->where('h.history_member_id', $memberId)
                ->whereIn('h.history_type', ['withdrawal', 'withdraw_pending'])
                ->orderByDesc('h.history_datetime')
                ->get();

            return $this->renderPayout($records, $accountsTable);
        } catch (\Exception $e) {
            Log::error('Payout error: ' . $e->getMessage());
            return $this->emptyRow('payout', 'Error loading data');
        }
    }

    private function renderPayout($records, $accountsTable)
    {
        if ($records->isEmpty()) return $this->emptyRow('payout');

        $walletNames = [1 => __('C-Wallet'), 2 => __('E-Wallet')];
        $html = '';

        foreach ($records as $i => $r) {
            $sno = $i + 1;
            $date = Carbon::parse($r->history_datetime)->format('d M Y');
            $status = $r->history_type === 'withdrawal'
                ? '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Paid</span>'
                : '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Pending</span>';

            $accountDetails = $r->history_description === 'withdrawal commission paid' || !$r->account_id
                ? __('Admin Account')
                : $this->getAccountDetails($r->account_id, $accountsTable);

            $walletName = $walletNames[$r->history_wallet_type] ?? '-';

            $html .= "<tr>
                <td>{$sno}</td>
                <td>" . htmlspecialchars($r->history_transaction_id ?? '') . "</td>
                <td>" . htmlspecialchars($this->currency . ' ' . number_format($r->history_amount ?? 0, 2)) . "</td>
                <td>" . htmlspecialchars($walletName) . "</td>
                <td>{$accountDetails}</td>
                <td>{$status}</td>
                <td>" . htmlspecialchars($date) . "</td>
            </tr>";
        }

        return $html;
    }

    private function getAccountDetails($accountId, $table)
    {
        $acc = DB::table($table)->where('account_id', $accountId)->first();
        if (!$acc || !$acc->account_details) return '—';

        $details = json_decode($acc->account_details, true) ?? [];
        $output = '';
        foreach ($details as $k => $v) {
            if (!in_array($k, ['paymentsettings_id', 'do', 'action'])) {
                $k = ucwords(str_replace('_', ' ', $k));
                $output .= "{$k}: {$v}<br>";
            }
        }
        return $output ?: '—';
    }

public function showUserEwallet($memberId)
{
    Log::info("Fetching E-Wallet History for Member ID: {$memberId}");

    $rows = DB::table('ihook_history_table')
        ->where('history_member_id', $memberId)
        ->where('history_wallet_type', 2) // E-Wallet
        ->orderByDesc('history_datetime')
        ->select([
            'history_transaction_id',
            'history_amount',
            'history_description',
            'history_datetime',
            'history_type'
        ])
        ->get();

    if ($rows->isEmpty()) {
        return '<tr><td colspan="5" class="text-center text-gray-500 py-4">No E-Wallet records found.</td></tr>';
    }

    $html = '';
    foreach ($rows as $i => $row) {
        $sno = $i + 1;
        $amount = number_format($row->history_amount, 2);
        $date = Carbon::parse($row->history_datetime)->format('d M Y');
        $description = htmlspecialchars($row->history_description ?? '—');
        $txnId = htmlspecialchars($row->history_transaction_id ?? '—');

        // Optional: Color code based on type
        $amountClass = in_array($row->history_type, ['withdrawal', 'fundtransferred']);
        $html .= "<tr>
            <td class=\"px-4 py-3\">{$sno}</td>
            <td class=\"px-4 py-3 font-mono text-xs\">{$txnId}</td>
            <td class=\"px-4 py-3 font-medium {$amountClass}\">{$this->currency}{$amount}</td>
            <td class=\"px-4 py-3 max-w-xs truncate\" title=\"{$description}\">{$description}</td>
            <td class=\"px-4 py-3 text-gray-600\">{$date}</td>
        </tr>";
    }

    return $html;
}
}
