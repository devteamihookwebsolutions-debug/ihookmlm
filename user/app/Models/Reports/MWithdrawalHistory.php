<?php

namespace User\App\Models\Reports;
use User\App\Display\Reports\DWithdrawalHistory;
use User\App\Models\History;
use User\App\Models\WalletType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MWithdrawalHistory
{
public static function withdrawalHistory($user_id, $startdate = null, $enddate = null)
{
    // dd($user_id);

        $query = History::where('history_member_id', $user_id)
            ->where(function($q){
                $q->where('history_type', 'withdrawal')
                  ->orWhere('history_type', 'withdraw_pending');
            });

        // Date filter
        if (!empty($startdate) && !empty($enddate)) {
            $query->whereBetween(DB::raw("DATE(history_datetime)"), [$startdate, $enddate]);
        }

        // Status filter
        if (!empty($status)) {

            if ($status == 2) {
                // Pending only
                $query->where('history_type', 'withdraw_pending');
            } else {
                // Completed only
                $query->where('history_type', '!=', 'withdraw_pending');
            }
        }

        $records = $query->orderBy('history_datetime', 'desc')->get();
        // dd($records);
        return DWithdrawalHistory::withdrawalhistory($records);
    }


  
}


