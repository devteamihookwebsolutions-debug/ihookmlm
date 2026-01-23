<?php

/**
 * This class contains public functions related to EwalletHistoryController
 *
 * @package         EwalletHistoryController
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace User\App\Http\Controllers\Reports;

use User\App\Http\Controllers\Controller;
use User\App\Models\Reports\MEwalletHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;

class EwalletHistoryController  extends Controller
{

public function ewalletHistory(Request $request)
{

        // Validate inputs
        $request->validate([
            'start-date' => 'nullable|date',
            'end-date'   => 'nullable|date|after_or_equal:start-date',
        ]);

        // Default dates if not provided
        // $startdate = $request->input('start-date') ?? now()->subDays(30)->format('Y-m-d');
        // $enddate   = $request->input('end-date') ?? now()->format('Y-m-d');
            $startdate = $request->input('start-date');
            $enddate   = $request->input('end-date');
        // Logged-in user
        $user_id = Auth::user()->members_id;
        //  dd($user_id);
        // Fetch history using scope
        $ewalletHistory = MEwalletHistory::ewalletHistory($user_id, $startdate, $enddate);
        //  dd($ewalletHistory);
        // Return Blade view
        return view('user::reports.ewallethistory', [
            'startdate'      => $startdate,
            'enddate'        => $enddate,
            'ewallethistory' => $ewalletHistory
        ]);

}
}
