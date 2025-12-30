<?php
namespace User\App\Http\Controllers\Reports;

use User\App\Http\Controllers\Controller;
use User\App\Models\Reports\MWithdrawalHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WithdrawalHistoryController extends Controller
{
    public function withdrawalHistory(Request $request)
    {
        try {

            // Validate inputs
            $request->validate([
                'start-date' => 'nullable|date',
                'end-date'   => 'nullable|date|after_or_equal:start-date',
                'status'     => 'nullable|in:1,2', 
            ]);


            $startdate = $request->input('start-date');
            $enddate   = $request->input('end-date');

            // Logged-in user ID
            $user_id = Auth::user()->members_id;

            // Status filter
            $status = $request->input('status');  

            // Call model
            $withdrawalHistory = MWithdrawalHistory::withdrawalHistory(
                $user_id, 
                $startdate, 
                $enddate,
                $status       
            );

            // dd($withdrawalHistory);
            return view('user::reports.withdrawalhistory', [
                'startdate'         => $startdate,
                'enddate'           => $enddate,
                'status'            => $status,
                'withdrawalHistory' => $withdrawalHistory,
            ]);

        } catch (\Exception $e) {

            \Log::error('Withdrawal History Error: ' . $e->getMessage());

            session()->flash('error_message', 'Failed to load withdrawal history.');
            return redirect()->route('user.dashboard');
        }
    }
}
