<?php

/**
 * This class contains public functions related to MWithdrawalHistory
 *
 * @package         MWithdrawalHistory
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
