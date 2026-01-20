<?php

/**
 * This class contains public functions related to TransactionHistoryController
 *
 * @package         TransactionHistoryController
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace User\App\Http\Controllers\Reports;

use User\App\Http\Controllers\Controller;
use User\App\Models\Reports\MTransactionHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TransactionHistoryController extends Controller
{
    public function showTransactionHistory(Request $request)
    {
        // dd('function reached');
            $output['transaction_type'] = MTransactionHistory::getTransactionType();
            // dd($output);
            // Validate inputs
            $request->validate([
                'start-date' => 'nullable|date',
                'end-date'   => 'nullable|date|after_or_equal:start-date',
                'status'     => 'nullable|in:1,2',   // 1=completed, 2=pending
                'type'       => 'nullable|string',    // Add type validation
            ]);

            // Default dates (last 30 days)
            // $startdate = $request->input('start-date') ?? now()->subDays(30)->format('Y-m-d');
            // $enddate   = $request->input('end-date') ?? now()->format('Y-m-d');

            // // Default dates for query only, NOT for input fields
            $startdate = $request->input('start-date');
            $enddate   = $request->input('end-date');



            // Logged-in user ID
            $user_id = Auth::user()->members_id;

            // Status and type filters
            $status = $request->input('status'); // status from dropdown
            $type   = $request->input('type');   // type from dropdown

            // Call model
            $transactionhistory = MTransactionHistory::TransactionHistory(
                $user_id,
                $startdate,
                $enddate,
                $status,
                $type
            );
            // dd($transactionhistory);

            return view('user::reports.transactionhistory', [
                'startdate'          => $startdate,
                'enddate'            => $enddate,
                'status'             => $status,
                'type'               => $type,
                'transactionhistory' => $transactionhistory,
                'transaction_type'   => $output['transaction_type']
            ]);


    }
    public function viewCommissionInvoice()
{
    // dd('function reached');
    try {

        // Call your model function
        $invoice = MTransactionHistory::createpdf();

        // Return blade view
        return view('user::reports.commissioninvoice', [
            'invoice' => $invoice
        ]);

    } catch (\Exception $e) {

        // Store error message in session
        session()->flash('error_message', $e->getMessage());

        // Redirect to dashboard
        return redirect()->route('user.dashboard');
    }
}

}
