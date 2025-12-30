<?php

namespace Admin\App\Http\Controllers\CustomerBonus;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\CustomerBonus\CustomerBonus;
use Admin\App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerBonusController extends Controller
{
    /**
     * Display the customer bonus settings form
     */
    public function showCustomerBonus(Request $request)
    {
        // Fetch bonus details
        $cusbonusdetails = CustomerBonus::getBonusDetails();

        // Fetch wallet types
        $wallets = Wallet::all();

        // CSRF token for form security
        $token_id = csrf_token();
        $token_value = $request->session()->token();

        return view('customerbonus.showcustomerbonus', compact(
            'cusbonusdetails',
            'wallets',
            'token_id',
            'token_value'
        ));
    }

    /**
     * Update customer bonus settings
     */
    public function updateCustomerBonus(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'cab_bonus_name' => 'required|string|max:255',
            'cab_bonus_percentage' => 'required|numeric|min:0',
            'cab_bonus_percentage_type' => 'required|in:flat,%',
            'cab_bonus_wallet_type' => 'nullable|exists:ihook_wallettype,wallet_type_id',
            'cab_bonus_status' => 'required|in:0,1',
            'retail_commission_name' => 'required|string|max:255',
            'retail_commission_percenatge' => 'required|numeric|min:0',
            'retail_commission_percentage_type' => 'required|in:flat,%',
            'retail_commission_wallet_type' => 'nullable|exists:ihook_wallettype,wallet_type_id',
            'retail_commission_status' => 'required|in:0,1',
        ]);

        // Prepare data for update
        $data = [
            'cab_bonus_name' => $validated['cab_bonus_name'],
            'cab_bonus_percentage' => $validated['cab_bonus_percentage'],
            'cab_bonus_percentage_type' => $validated['cab_bonus_percentage_type'],
            'cab_bonus_wallet_type' => $validated['cab_bonus_wallet_type'] ?? '',
            'cab_bonus_status' => $validated['cab_bonus_status'],
            'retail_commission_name' => $validated['retail_commission_name'],
            'retail_commission_percenatge' => $validated['retail_commission_percenatge'],
            'retail_commission_percentage_type' => $validated['retail_commission_percentage_type'],
            'retail_commission_wallet_type' => $validated['retail_commission_wallet_type'] ?? '',
            'retail_commission_status' => $validated['retail_commission_status'],
        ];

        // Update or create records in the database
        CustomerBonus::updateBonusDetails($data);

        // Set success message
        Session::flash('success', 'Customer bonus settings updated successfully.');

        return redirect()->route('customerbonus.show');
    }
}