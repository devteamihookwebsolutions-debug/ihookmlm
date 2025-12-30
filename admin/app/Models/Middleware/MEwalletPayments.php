<?php

namespace Admin\App\Models\Ewallet;

use Illuminate\Support\Facades\DB;
use User\App\Models\PaymentHistory;

use Admin\App\Display\Ewallet\DEwalletPayments;

class MEwalletPayments
{
 
public static function showEwalletManagement()
{
    $aColumns = [
        'paymenthistory_id',
        'paymenthistory_member_id',
        'paymenthistory_amount',
        'paymenthistory_mode',
        'paymenthistory_trans_id',
        'paymenthistory_type',
        'paymenthistory_status',
        'paymenthistory_date',
        'payment_user_request_currency_id',
        'payment_user_request_amount'
    ];

    $perPage = 10;

    // Use the PaymentHistory model
    $query = PaymentHistory::select($aColumns)
        ->whereIn('paymenthistory_type', ['ewalletcredits']);

    // Get paginated results
    $records = $query->paginate($perPage);

    // Get total distinct count
    $iTotal = (clone $query)
        ->distinct('paymenthistory_id')
        ->count('paymenthistory_id');

    //Return formatted data
    return DEwalletPayments::showEwalletManagement($records, $iTotal);
}

public static function activateEwalletPayment(Request $request)
{
    try {
        // Get ID from request
        $paymenthistory_id = $request->input('sub1');

        if (!$paymenthistory_id) {
            return response()->json(['error' => 'Missing payment ID'], 400);
        }

        // Start DB Transaction
        DB::beginTransaction();

        // Update paymenthistory_table status
        $updated = DB::table('ihook_paymenthistory_table')
            ->where('paymenthistory_id', $paymenthistory_id)
            ->update(['paymenthistory_status' => 'paid']);

        if (!$updated) {
            DB::rollBack();
            return response()->json(['error' => 'Payment not found or already updated'], 404);
        }

        // Fetch updated payment details
        $payment = DB::table('ihook_paymenthistory_table')
            ->where('paymenthistory_id', $paymenthistory_id)
            ->first();

        if (!$payment) {
            DB::rollBack();
            return response()->json(['error' => 'Payment details not found'], 404);
        }

        // Prepare data for history insertion
        $trans_id = '#' . substr(number_format(time() * rand(), 0, '', ''), 0, 9);
        $desc = __('Purchase of E-wallet Credits');
        $history_wallet_type = 2;

        // Optional: format amount safely
        $formatted_amount = MFormatNumber::formatingNumberCurrency($payment->paymenthistory_amount ?? 0);

        // Insert new history record
        DB::table('ihook_history_table')->insert([
            'history_member_id'     => $payment->paymenthistory_member_id,
            'history_amount'        => $formatted_amount,
            'history_type'          => 'ewalletcredits',
            'history_description'   => $desc,
            'history_datetime'      => now(),
            'history_payment'       => 0,
            'history_transaction_id'=> $trans_id,
            'history_wallet_type'   => $history_wallet_type,
            'crypto_qty'            => $payment->crypto_qty ?? 0,
            'currency_id'           => $payment->currency_id ?? null,
        ]);

        //  Commit DB Transaction
        DB::commit();

        // Add success message and response
        Session::flash('success_message', __('Payment has been activated successfully'));

        return response()->json([
            'success' => true,
            'message' => __('Payment has been activated successfully'),
            'transaction_id' => $trans_id,
        ], 200);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'error' => 'An unexpected error occurred: ' . $e->getMessage(),
        ], 500);
    }
}
}