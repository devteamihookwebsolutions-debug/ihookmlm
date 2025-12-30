<?php
namespace User\App\Http\Controllers\Reports;

use User\App\Http\Controllers\Controller;
use User\App\Models\Reports\MCashwalletHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;

class CashwalletHistoryController  extends Controller
{

public function cashWalletHistory(Request $request)
{
    // dd('requesjklashd');
    try {
        // Validate inputs
        $request->validate([
            'start-date' => 'nullable|date',
            'end-date'   => 'nullable|date|after_or_equal:start-date',
        ]);

        // Default dates if not provided
        $startdate = $request->input('start-date');
        $enddate   = $request->input('end-date');

        // Logged-in user
        $user_id = Auth::user()->members_id;
        //  dd($user_id);
        // Fetch history using scope
        $cashwalletHistory = MCashwalletHistory::cashWalletHistory($user_id, $startdate, $enddate);
        //  dd($ewalletHistory);
        // Return Blade view
        return view('user::reports.cashwallethistory', [
            'startdate'      => $startdate,
            'enddate'        => $enddate,
            'cashwallethistory' => $cashwalletHistory
        ]);
    } catch (Exception $e) {
        \Log::error('C-Wallet History Error: ' . $e->getMessage());

        session()->flash('error_message', 'Failed to load e-wallet history. Please try again.');
        return redirect()->route('user.dashboard');
    }
}

public function leadContact()
{
    // dd('request');
    try {

        // Call model function
        $bonus = MCashwalletHistory::leadcontact();

        // Clear old messages
        session()->forget(['success_message', 'error_message']);

        // Return Blade view
        return view('user::reports.leadcontact2', [
            'bonus' => $bonus
        ]);

    } catch (\Exception $e) {

        // Add error message
        session()->flash('error_message', $e->getMessage());

        // Redirect to dashboard
        return redirect()->route('user.dashboard');
    }
}

}
