<?php

namespace User\App\Http\Controllers\Paypal;

use Admin\App\Models\Middleware\MPaymentGatewayDetails;
use User\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Omnipay\Omnipay;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Admin\App\Models\Member\Matrix;

class PayPalController extends Controller
{
    private $gateway;

    public function __construct()
    {
        Log::info('PayPalController __construct called');

        $prefix = config('services.ihook.prefix', 'ihook');

        // Get PayPal gateway settings from DB
        $paymentdetails = MPaymentGatewayDetails::getPaymentGatewayDetails([
            'paymentsettings_name' => 'Paypal Pro',
            'paymentsettings_status' => 'Active',
        ]);

        if (!$paymentdetails) {
            Log::error('No active PayPal gateway found in database');
            throw new \Exception('PayPal payment gateway not configured.');
        }

        // Decode API values
        $apiValues = json_decode($paymentdetails->payout_apivalues ?? '{}', true);

        // Get credentials
        $secret = $paymentdetails->paymentsettings_accname ?? '';
        $clientId   = $apiValues['paypal_signature'] ?? '';
        $mode     = strtolower($apiValues['paypal_mode'] ?? 'sandbox');

        // Log credentials (mask secret for security)
        Log::info('PayPal credentials loaded', [
            'clientId' => substr($clientId, 0, 6) . '...' . substr($clientId, -6),
            'secret'   => substr($secret, 0, 6) . '...' . substr($secret, -6),
            'mode'     => $mode,
        ]);

        // Validate credentials
        if (empty($clientId) || empty($secret)) {
            Log::error('PayPal Client ID or Secret missing in DB');
            throw new \Exception('PayPal credentials are incomplete.');
        }

        // Create gateway
        $this->gateway = Omnipay::create('PayPal_Rest');

        $this->gateway->setClientId($clientId);
        $this->gateway->setSecret($secret);

        // IMPORTANT: Set correct mode based on DB config
        // 'sandbox' or 'live'
        $isTestMode = ($mode === 'sandbox');
        $this->gateway->setTestMode($isTestMode);

        Log::info('PayPal gateway initialized', [
            'testMode' => $isTestMode ? 'true (sandbox)' : 'false (live)',
        ]);
    }

    public function pay(Request $request)
    {
        Log::info('PayPalController::pay() called', $request->all());
        $prefix = config('services.ihook.prefix', 'ihook');

        // Get amount from package or registration fee
        $paidType = DB::table("{$prefix}_matrix_configuration_table")
            ->where('matrix_key', 'members_paid_account_type')
            ->value('matrix_value');

        $amount = '0.00';

        if ($paidType == '1') {
            $selectedPackageId = $request->input('Package', '0');
            $packagePrice = DB::table("{$prefix}_package_table")
                ->where('package_id', $selectedPackageId)
                ->where('package_status', 1)
                ->value('package_price');
            $amount = $packagePrice ?? '0.00';
        } elseif ($paidType == '0') {
            $registrationFee = DB::table("{$prefix}_matrix_configuration_table")
                ->where('matrix_key', 'registration_fee')
                ->value('matrix_value');
            $amount = $registrationFee ?? '0.00';
        }

        $amount = number_format((float)$amount, 2, '.', '');

        if ((float)$amount <= 0) {
            return redirect()->back()->with('error', 'Invalid amount for payment.');
        }

        // Store session data
        Session::put('register', $request->all());
        Session::put('selected_package_amount', $amount);
        Session::put('selected_package_id', $request->input('Package', 0));

        try {
            Log::info('Initiating PayPal purchase', [
                'amount'    => $amount,
                'currency'  => 'USD',
                'returnUrl' => route('user.paypal.success'),
                'cancelUrl' => route('user.paypal.error'),
            ]);

            $response = $this->gateway->purchase([
                'amount'      => $amount,
                'currency'    => 'USD',
                'description' => $paidType == '1' ? 'Package Purchase' : 'Registration Fee',
                'returnUrl'   => route('user.paypal.success'),
                'cancelUrl'   => route('user.paypal.error'),
                'noShipping'  => 1,
            ])->send();

            Log::info('PayPal response received', [
                'isSuccessful' => $response->isSuccessful(),
                'isRedirect'   => $response->isRedirect(),
                'message'      => $response->getMessage(),
                'data'         => $response->getData(),
            ]);

            if ($response->isRedirect()) {
                Log::info('Redirecting to PayPal...');
                return $response->redirect();
            } else {
                $error = $response->getMessage() ?: 'PayPal payment initiation failed';
                Log::error('PayPal payment failed', ['error' => $error]);
                return redirect()->back()->with('error', $error);
            }
        } catch (\Exception $e) {
            Log::error('PayPal exception', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Payment initiation failed: ' . $e->getMessage());
        }
    }

    public function success(Request $request)
    {
        $prefix = config('services.ihook.prefix', 'ihook');
        Log::info('PayPalController::success() HIT', $request->all());

        if (!$request->has('paymentId') || !$request->has('PayerID')) {
            return redirect()->route('user.registration')->with('error', 'Payment incomplete.');
        }

        try {
            $transaction = $this->gateway->completePurchase([
                'payer_id'             => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ]);

            $response = $transaction->send();

            if ($response->isSuccessful()) {
                $data = $response->getData();

                $saleData = $data['transactions'][0]['related_resources'][0]['sale'] ?? null;
                $transactionId = $saleData['id'] ?? $data['id'];

                $amount = $data['transactions'][0]['amount']['total'];
                $hashedTransactionId = Hash::make($transactionId);

                $payerEmail = $data['payer']['payer_info']['email'] ?? 'unknown@paypal.com';

                Log::info('PayPal payment SUCCESS', [
                    'transaction_id' => $transactionId,
                    'amount'         => $amount,
                    'email'          => $payerEmail
                ]);

                // Update payment settings
                DB::table("{$prefix}_paymentsettings_table")
                    ->where('paymentsettings_id', 1)
                    ->update([
                        'paymentsettings_accname' => $payerEmail,
                        'paymentsettings_accnum'  => $transactionId,
                        'paymentsettings_status'  => 'Active',
                    ]);

                $registerController = app(\User\App\Http\Controllers\Register\RegisterController::class);
                $members_id = $registerController->completeRegistrationAfterPayment($request, $transactionId, $amount);

                if (!$members_id || !is_numeric($members_id)) {
                    Log::error('Failed to get members_id after PayPal');
                    return redirect()->route('user.registration')->with('error', 'Registration failed.');
                }

                $defaultMatrix = Matrix::where('matrix_default', 1)->first();
                $matrix_id = $defaultMatrix ? $defaultMatrix->matrix_id : 1;
                $packageId = Session::get('selected_package_id', 0);

                DB::table("{$prefix}_paymenthistory_table")->insert([
                    'paymenthistory_member_id'       => (int)$members_id,
                    'paymenthistory_amount'          => $amount,
                    'payment_amt_exclusive'          => number_format((float)$amount, 2, '.', ''),
                    'paymenthistory_mode'            => 1,
                    'paymenthistory_trans_id'        => $transactionId,
                    'paymenthistory_type'            => 'user_register',
                    'identify_type'                  => 'paypal',
                    'paymenthistory_status'          => 'paid',
                    'paymenthistory_plan_id'         => $packageId,
                    'matrix_id'                      => $matrix_id,
                    'transaction_id'                 => $hashedTransactionId,
                    'paymenthistory_date'            => now(),
                    'created_on'                     => now(),
                    'payment_gateway_response'       => json_encode($data),
                ]);

                Log::info('PayPal payment history inserted successfully', [
                    'members_id'     => $members_id,
                    'matrix_id'      => $matrix_id,
                    'transaction_id' => $transactionId
                ]);

                return redirect()->route('user.thankyou')
                    ->with('success_message', 'Payment and registration successful via PayPal!');

            } else {
                return redirect()->route('user.registration')->with('error', 'Payment failed: ' . $response->getMessage());
            }
        } catch (\Exception $e) {
            Log::error('PayPal success error', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString()
            ]);
            return redirect()->route('user.registration')->with('error', 'Payment processing failed.');
        }
    }

    public function error()
    {
        Log::warning('PayPal payment cancelled');
        return redirect()->route('user.registration')->with('error', 'Payment was cancelled.');
    }
}
