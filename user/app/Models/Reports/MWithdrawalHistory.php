<?php

namespace User\App\Models\Reports;

use User\App\Display\Reports\DWithdrawalHistory;
use User\App\Models\History;
use User\App\Models\WalletType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MWithdrawalHistory
{
    /**
     * Get total APPROVED / COMPLETED withdrawal amount for a member
     *
     * @param int $memberId
     * @return float
     */
    public static function getTotalWithdrawn($memberId)
    {
        $prefix = config('services.ihook.prefix');

        return (float) DB::table("{$prefix}_history_table as h")
            ->where('h.history_member_id', $memberId)
            ->where('h.history_type', 'withdrawal')           // completed withdrawals
            // If your system also uses 'withdrawcompleted' or another type, add it:
            // ->orWhere('h.history_type', 'withdrawcompleted')
            ->sum('h.history_amount');
    }


    public static function withdrawalHistory($user_id, $startdate = null, $enddate = null, $status = null)
    {
        $query = History::where('history_member_id', $user_id)
            ->where(function($q) {
                $q->where('history_type', 'withdrawal')
                  ->orWhere('history_type', 'withdraw_pending');
            });

        // Date filter
        if ($startdate && $enddate) {
            $query->whereBetween(DB::raw("DATE(history_datetime)"), [$startdate, $enddate]);
        }

        if ($status !== null) {
            if ($status == 2) {
                // Pending only
                $query->where('history_type', 'withdraw_pending');
            } else {
                // Completed only
                $query->where('history_type', 'withdrawal');
            }
        }

        $records = $query->orderBy('history_datetime', 'desc')->get();

        return DWithdrawalHistory::withdrawalhistory($records);
    }
}
