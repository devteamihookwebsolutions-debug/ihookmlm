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
