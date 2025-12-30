<?php

namespace User\App\Http\Controllers\Epin;

use Admin\App\Models\Middleware\MCryptoCurrency;
use Admin\App\Models\Middleware\MCryptoWalletBalance;
use Admin\App\Models\Middleware\MFormatNumber;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use User\App\Http\Controllers\Controller;
use User\App\Models\Epin\MEpinHistory;
use User\App\Models\Epin\MGenerateEpin;

class GenerateEpinController extends Controller
{
    public function showRequestEpin(Request $request)
    {
        $member = Auth::user();
        $output = [];

        // Flash error handling
        if (session('error')) {
            $output['error_message'] = session('error');
        }

        $cwallet_balance = $this->getWalletBalance($member->members_id, '2');
        $ewallet_balance = $this->getWalletBalance($member->members_id, '1');

        $output['cwallet_balance'] = MFormatNumber::formatingNumberCurrency($cwallet_balance);
        $output['ewallet_balance'] = MFormatNumber::formatingNumberCurrency($ewallet_balance);
        $output['balance'] = $output['cwallet_balance'];

        $output['hasTransactionPassword'] = !empty($member->members_transaction_password);
        $output['epintype'] = MEpinHistory::getEpinType();

        return view('user::epin.epincreate', $output);
    }

    private function getWalletBalance($memberId, $walletType)
    {
        $prefix = config('app.db_prefix', env('IHOOK_PREFIX', ''));

        $balance = DB::table("{$prefix}_history_table as h")
            ->join("{$prefix}_history_type_table as htt", function($join) {
                $join->on('h.history_type', '=', 'htt.history_type_name');
            })
            ->where('h.history_member_id', $memberId)
            ->where('h.history_wallet_type', $walletType)
            ->selectRaw("
                COALESCE(SUM(CASE WHEN htt.history_credit_type = 1 THEN h.history_amount ELSE 0 END), 0)
                -
                COALESCE(SUM(CASE WHEN htt.history_debit_type = 1 THEN h.history_amount ELSE 0 END), 0)
                AS wallet_balance
            ")
            ->value('wallet_balance');

        return $balance ?? 0;
    }

 public function validateCreateRequestEpin(Request $request)
{
    $member = Auth::user();

    $request->validate([
        'epin_type'            => 'required',
        'epin_amount'          => 'required|numeric|min:1',
        'epin_count'           => 'required|integer|min:1|max:1000',
        'transaction_password'=> 'required',
    ]);

    if (empty($member->members_transaction_password)) {
        return response()->json([
            'success' => false,
            'message' => 'Transaction password not set!',
            'errors' => ['transaction_password' => ['Transaction password is not set.']]
        ], 422);
    }

    if (!Hash::check($request->transaction_password, $member->members_transaction_password)) {
        return response()->json([
            'success' => false,
            'message' => 'Incorrect transaction password!',
            'errors' => ['transaction_password' => ['Incorrect transaction password!']]
        ], 422);
    }

    $walletType = $request->wallet_type == '1' ? '1' : '2';
    $currentBalance = $this->getWalletBalance($member->members_id, $walletType);
    $totalAmount = $request->epin_amount * $request->epin_count;

    if ($currentBalance < $totalAmount) {
        return response()->json([
            'success' => false,
            'message' => 'Insufficient balance!',
            'errors' => ['epin_amount' => ['Insufficient wallet balance. Required: ' . $totalAmount]]
        ], 422);
    }

    try {
        $result = MGenerateEpin::insertCreatedRequestEpin($request);

        return response()->json([
            'success' => true,
            'message' => 'E-Pins generated successfully!',
            'total_pins' => $request->epin_count,
            'deducted_amount' => $totalAmount,
            'new_balance' => $currentBalance - $totalAmount,
        ], 200);

    } catch (Exception $e) {
        \Log::error('E-Pin creation failed: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Failed to generate E-Pins. Please try again.',
        ], 500);
    }
}

    public function getPackageAmount($packageId, $typeId)
    {
        try {
            $amount = MGenerateEpin::getPackageAmount($packageId, $typeId);

            return response($amount, 200)->header('Content-Type', 'text/plain');
        } catch (Exception $e) {
            \Log::error('Epin amount error: ' . $e->getMessage());
            return response('0', 500);
        }
    }
    public function verifyTransactionPassword(Request $request)
    {
        $user = Auth::user();

        if (!$user || empty($user->members_transaction_password)) {
            return response()->json(['success' => false]);
        }

        $isValid = Hash::check($request->transaction_password, $user->members_transaction_password);

        return response()->json(['success' => $isValid]);
    }
}
