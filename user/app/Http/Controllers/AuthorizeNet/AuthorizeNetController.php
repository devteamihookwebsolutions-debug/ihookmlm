<?php

namespace User\App\Http\Controllers\AuthorizeNet;

use Auth;
use User\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use net\authorize\api\constants\ANetEnvironment;

class AuthorizeNetController extends Controller
{
    protected $loginId;
    protected $transactionKey;
    protected $sandbox;

 public function __construct()
{
    Log::info('AuthorizeNetController __construct called');

    $prefix = config('services.ihook.prefix', 'ihook');

    $authNetDetails = DB::table("{$prefix}_paymentsettings_table")
        ->where('paymentsettings_name', 'authorizenet')
        ->where('paymentsettings_status', 'Active')
        ->first();

    if (!$authNetDetails) {
        Log::error('Authorize.Net gateway not found or not active in database');
        throw new \Exception('Authorize.Net payment gateway not configured.');
    }

    $this->loginId = trim($authNetDetails->paymentsettings_accname ?? '');
    $this->transactionKey = trim($authNetDetails->paymentsettings_accnum ?? '');

    // sandbox or live
    $mode = strtolower(trim($authNetDetails->paymentsettings_mode ?? 'sandbox'));
    $this->sandbox = ($mode === 'live' || $mode === 'production') ? false : true;

    if (empty($this->loginId) || empty($this->transactionKey)) {
        Log::error('Authorize.Net credentials missing in database', [
            'login_id_empty' => empty($this->loginId),
            'transaction_key_empty' => empty($this->transactionKey),
        ]);
        throw new \Exception('Authorize.Net API credentials not found in database.');
    }

    Log::info('Authorize.Net gateway initialized successfully from DB', [
        'login_id_preview' => substr($this->loginId, 0, 4) . '...' . substr($this->loginId, -4),
        'mode'             => $this->sandbox ? 'Sandbox' : 'Live'
    ]);
}

    private function getMerchantAuthentication()
    {
        $merchant = new AnetAPI\MerchantAuthenticationType();
        $merchant->setName($this->loginId);
        $merchant->setTransactionKey($this->transactionKey);
        return $merchant;
    }

    private function getEnvironment()
    {
        return $this->sandbox ? ANetEnvironment::SANDBOX : ANetEnvironment::PRODUCTION;
    }

public function pay(Request $request)
{
    Log::info('=== AUTHORIZENET PAY METHOD CALLED ===', $request->except(['card_number', 'cvv']));
    $prefix = config('services.ihook.prefix', 'ihook');

    $paidType = DB::table("{$prefix}_matrix_configuration_table")
        ->where('matrix_key', 'members_paid_account_type')
        ->value('matrix_value');

    $selectedPackageId = $request->input('Package', '0');
    $amount = '0.00';
    $registerFee = '0.00';
    $registerFeeEnabled = false;
    $packageName = 'Subscription Package';

    $registerData = Session::get('register', []);
    $username = $registerData['user_name'] ?? '';
    $firstname = $registerData['first_name'] ?? '';
    $lastname = $registerData['last_name'] ?? '';
    $email = $registerData['email'] ?? '';

    if ($paidType == '1') {
        $package = DB::table("{$prefix}_package_table")
            ->where('package_id', $selectedPackageId)
            ->where('package_status', 1)
            ->first();
        if (!$package) {
            return redirect()->back()->with('error', 'Invalid package selected.');
        }
        $amount = number_format((float)$package->package_price, 2, '.', '');
        $packageName = $package->package_name ?? 'Gold';
    } elseif ($paidType == '0') {
        $registrationFee = DB::table("{$prefix}_matrix_configuration_table")
            ->where('matrix_key', 'registration_fee')
            ->value('matrix_value');
        $registerFee = number_format((float)$registrationFee ?? 0, 2, '.', '');
        $registerFeeEnabled = true;
        $packageName = 'Registration Fee (One-Time)';
    }

    $finalAmount = $registerFeeEnabled ? $registerFee : $amount;
    if ((float)$finalAmount <= 0) {
        return redirect()->back()->with('error', 'Invalid amount.');
    }

    // Card details
    $cleanCardNumber = preg_replace('/\D/', '', $request->input('card_number'));
    $expMonth = $request->input('exp_month');
    $expYear = $request->input('exp_year');
    $cvv = $request->input('cvv');
    $holderName = $request->input('card_holder_name');

    $sponsorFullName = Session::get('sponsor_username', 'Admin');

    $metadata = [
        'Member Username'   => $username,
        'Member First Name' => $firstname,
        'Member Last Name'  => $lastname,
        'Package Name'      => $packageName,
        'Sponsor Username'  => $sponsorFullName,
        'Email Address'     => $email,
        'Payment Type'      => $paidType == '1' ? 'Subscription' : 'Registration Fee',
        'Site URL'          => url('/'),
        'Package ID'        => $selectedPackageId,
    ];

    $merchantAuthentication = $this->getMerchantAuthentication();
    $refId = 'ref' . time();

    // Billing Address
    $billTo = new AnetAPI\CustomerAddressType();
    $billTo->setFirstName($firstname);
    $billTo->setLastName($lastname);
    $billTo->setEmail($email);
    $billTo->setAddress($registerData['address'] ?? '');
    $billTo->setCity($registerData['city'] ?? '');
    $billTo->setState($registerData['state'] ?? '');
    $billTo->setZip($registerData['zipcode'] ?? '');
    $billTo->setCountry($registerData['country'] ?? '');
    $billTo->setPhoneNumber($registerData['phone'] ?? '');

    // Shipping Address (only for one-time payment)
    $shipTo = new AnetAPI\CustomerAddressType();
    $shipTo->setFirstName($firstname);
    $shipTo->setLastName($lastname);
    $shipTo->setAddress($registerData['shipping_address'] ?? $registerData['address'] ?? '');
    $shipTo->setCity($registerData['shipping_city'] ?? $registerData['city'] ?? '');
    $shipTo->setState($registerData['shipping_state'] ?? $registerData['state'] ?? '');
    $shipTo->setZip($registerData['shipping_zip'] ?? $registerData['zipcode'] ?? '');
    $shipTo->setCountry($registerData['shipping_country'] ?? $registerData['country'] ?? '');

    $creditCard = new AnetAPI\CreditCardType();
    $creditCard->setCardNumber($cleanCardNumber);
    $creditCard->setExpirationDate("$expYear-$expMonth");
    $creditCard->setCardCode($cvv);

    $payment = new AnetAPI\PaymentType();
    $payment->setCreditCard($creditCard);

    $customer = new AnetAPI\CustomerDataType();
    $customer->setType('individual');
    $customer->setEmail($email);

    $transactionId = null;
    $subscriptionId = null;
    $customerProfileId = null;
    $paymentProfileId = null;
    $authCode = null;

    try {
        // Step 1: Find or Create Customer Profile
        $customerProfileId = $this->findOrCreateCustomerProfile($merchantAuthentication, $email, $username, $firstname, $lastname);

        // Step 2: Find or Create Payment Profile
        $paymentProfileId = $this->findOrCreatePaymentProfile(
            $merchantAuthentication,
            $customerProfileId,
            $billTo,
            $payment,
            $cleanCardNumber
        );

        $invoiceNumber = null;
        $transactionId = null;
        $subscriptionId = null;
        $authCode = null;

        if ($paidType == '1') { // Subscription - NO shipTo allowed
            $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
            $interval->setLength(1);
            $interval->setUnit('months');

            $schedule = new AnetAPI\PaymentScheduleType();
            $schedule->setInterval($interval);
            $schedule->setStartDate(new \DateTime(Carbon::now()->addDays(1)->format('Y-m-d')));
            $schedule->setTotalOccurrences(9999);

            $arbSubscription = new AnetAPI\ARBSubscriptionType();
            $arbSubscription->setName($packageName);
            $arbSubscription->setAmount($amount);
            $arbSubscription->setPaymentSchedule($schedule);

            $profile = new AnetAPI\CustomerProfileIdType();
            $profile->setCustomerProfileId($customerProfileId);
            $profile->setCustomerPaymentProfileId($paymentProfileId);
            $arbSubscription->setProfile($profile);

            $order = new AnetAPI\OrderType();
            $order->setInvoiceNumber('SUB-' . time());
            $arbSubscription->setOrder($order);
            $invoiceNumber = $order->getInvoiceNumber();

            $arbRequest = new AnetAPI\ARBCreateSubscriptionRequest();
            $arbRequest->setMerchantAuthentication($merchantAuthentication);
            $arbRequest->setRefId($refId);
            $arbRequest->setSubscription($arbSubscription);

            $arbController = new AnetController\ARBCreateSubscriptionController($arbRequest);
            $arbResponse = $arbController->executeWithApiResponse($this->getEnvironment());

            if ($arbResponse->getMessages()->getResultCode() == 'Ok') {
                $subscriptionId = $arbResponse->getSubscriptionId();
                $transactionId = $subscriptionId;
                Log::info('Pure ARB Subscription Created - NO IMMEDIATE CHARGE', [
                    'subscription_id' => $subscriptionId,
                    'customer_profile_id' => $customerProfileId,
                    'payment_profile_id' => $paymentProfileId
                ]);
            } else {
                $error = $arbResponse->getMessages()->getMessage()[0]->getText();
                throw new \Exception("Subscription Failed: $error");
            }
        } else {
            $transactionRequest = new AnetAPI\TransactionRequestType();
            $transactionRequest->setTransactionType('authCaptureTransaction');
            $transactionRequest->setAmount($finalAmount);
            $transactionRequest->setPayment($payment);
            $transactionRequest->setBillTo($billTo);
            $transactionRequest->setShipTo($shipTo);
            Log::info('One-Time Payment with shipTo', [
                'shipping_address' => $shipTo->getAddress(),
                'shipping_city' => $shipTo->getCity(),
                'shipping_state' => $shipTo->getState(),
                'shipping_zip' => $shipTo->getZip(),
                'shipping_country' => $shipTo->getCountry()
            ]);
            $transactionRequest->setCustomer($customer);

            $order = new AnetAPI\OrderType();
            $order->setInvoiceNumber('INV-' . time());
            $transactionRequest->setOrder($order);
            $invoiceNumber = $order->getInvoiceNumber();

            $createRequest = new AnetAPI\CreateTransactionRequest();
            $createRequest->setMerchantAuthentication($merchantAuthentication);
            $createRequest->setTransactionRequest($transactionRequest);

            $controller = new AnetController\CreateTransactionController($createRequest);
            $response = $controller->executeWithApiResponse($this->getEnvironment());

            if ($response && $response->getMessages()->getResultCode() == "Ok") {
                $tresponse = $response->getTransactionResponse();
                $transactionId = $tresponse->getTransId();
                $authCode = $tresponse->getAuthCode();

                Log::info('One-Time Payment SUCCESS with shipTo', [
                    'transaction_id' => $transactionId,
                    'auth_code' => $authCode,
                    'amount' => $finalAmount,
                    'invoice_number' => $invoiceNumber
                ]);
            } else {
                throw new \Exception('Transaction Failed: ' . ($response->getMessages()->getMessage()[0]->getText() ?? 'Unknown error'));
            }
        }

        // Step 4: Save to DB (same as before)
        $hashedTransactionId = Hash::make($transactionId);



        $registerController = app(\User\App\Http\Controllers\Register\RegisterController::class);
        $members_id = $registerController->completeRegistrationAfterPayment($request, $transactionId, Session::get('selected_package_amount'));

        if (!$members_id || !is_numeric($members_id)) {
            Log::error('Registration failed - no members_id');
            return redirect()->route('user.registration')->with('error', 'Registration failed.');
        }

        $linkData = [
            'members_subscription_plan' => $selectedPackageId,
            'members_subscription_status' => 1,
            'members_subscription_date' => now(),
            'members_account_status' => 1,
            'authorize_cusid' => $customerProfileId,
            'authorize_subid' => $subscriptionId,
        ];

        DB::table("{$prefix}_matrix_members_link_table")
            ->where('members_id', $members_id)
            ->update($linkData);

        $direct_commission = DB::table("{$prefix}_package_table")
            ->where('package_id', $selectedPackageId)
            ->value('package_direct_commission') ?? 0;

        $defaultMatrix = \Admin\App\Models\Member\Matrix::where('matrix_default', 1)->first();
        $matrix_id = $defaultMatrix ? $defaultMatrix->matrix_id : 1;

        DB::table("{$prefix}_paymenthistory_table")->insert([
            'paymenthistory_member_id' => (int)$members_id,
            'paymenthistory_amount'    => $finalAmount,
            'payment_amt_exclusive'    => number_format((float)$finalAmount, 2, '.', ''),
            'paymenthistory_mode'      => 16,
            'paymenthistory_trans_id'  => $transactionId,
            'paymenthistory_type'      => 'user_register',
            'identify_type'            => 'authorizenet',
            'paymenthistory_status'    => 'paid',
            'paymenthistory_plan_id'   => $selectedPackageId,
            'matrix_id'                => $matrix_id,
            'transaction_id'           => $hashedTransactionId,
            'paymenthistory_date'      => now(),
            'created_on'               => now(),
            'payment_gateway_response' => json_encode([
                'metadata' => $metadata,
                'customer_profile_id' => $customerProfileId,
                'payment_profile_id' => $paymentProfileId,
                'transaction_id' => $transactionId,
                'auth_code' => $authCode,
                'subscription_id' => $subscriptionId,
                'invoice_number' => $invoiceNumber ?? 'N/A',
                'full_response' => json_encode($response ?? $arbResponse ?? []),
            ]),
        ]);

        Session::forget([
            'register', 'selected_package_amount', 'selected_package_id',
            'register_fee_enabled', 'register_fee_amount', 'package_name',
            'final_sponsor_id', 'sponsor_username'
        ]);

        return redirect()->route('user.thankyou')
            ->with('success_message', 'Payment and registration successful!');
    } catch (\Exception $e) {
        Log::error('Authorize.Net Payment Processing Failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return redirect()->back()->with('error', 'Payment processing failed: ' . $e->getMessage());
    }
}

    // Helper: Find or Create Customer Profile
    private function findOrCreateCustomerProfile($merchantAuthentication, $email, $username, $firstname, $lastname)
    {
        $customerProfileId = null;

        // Try to find existing profile by email
        $request = new AnetAPI\GetCustomerProfileIdsRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $controller = new AnetController\GetCustomerProfileIdsController($request);
        $response = $controller->executeWithApiResponse($this->getEnvironment());

        if ($response->getMessages()->getResultCode() == 'Ok') {
            $ids = $response->getIds() ?? [];
            foreach ($ids as $id) {
                $profileRequest = new AnetAPI\GetCustomerProfileRequest();
                $profileRequest->setMerchantAuthentication($merchantAuthentication);
                $profileRequest->setCustomerProfileId($id);
                $profileController = new AnetController\GetCustomerProfileController($profileRequest);
                $profileResponse = $profileController->executeWithApiResponse($this->getEnvironment());

                if ($profileResponse->getMessages()->getResultCode() == 'Ok') {
                    $profile = $profileResponse->getProfile();
                    if ($profile && $profile->getEmail() === $email) {
                        $customerProfileId = $id;
                        Log::info('Found existing Customer Profile', ['profile_id' => $customerProfileId]);
                        return $customerProfileId;
                    }
                }
            }
        }

        // Create new profile if not found
        $uniqueId = substr(str_replace(['-', '_'], '', $username ?: 'guest') . md5(time()), 0, 20);

        $profile = new AnetAPI\CustomerProfileType();
        $profile->setMerchantCustomerId($uniqueId);
        $profile->setEmail($email);
        $profile->setDescription("Customer: $firstname $lastname");

        $createRequest = new AnetAPI\CreateCustomerProfileRequest();
        $createRequest->setMerchantAuthentication($merchantAuthentication);
        $createRequest->setProfile($profile);

        $createController = new AnetController\CreateCustomerProfileController($createRequest);
        $createResponse = $createController->executeWithApiResponse($this->getEnvironment());

        if ($createResponse->getMessages()->getResultCode() == 'Ok') {
            $customerProfileId = $createResponse->getCustomerProfileId();
            Log::info('New Customer Profile Created', ['profile_id' => $customerProfileId]);
            return $customerProfileId;
        }

        throw new \Exception('Failed to create/find Customer Profile');
    }

    // Helper: Find or Create Payment Profile
    private function findOrCreatePaymentProfile($merchantAuthentication, $customerProfileId, $billTo, $payment, $cardNumber)
    {
        $paymentProfileId = null;

        // Try to find existing payment profile
        $profileRequest = new AnetAPI\GetCustomerProfileRequest();
        $profileRequest->setMerchantAuthentication($merchantAuthentication);
        $profileRequest->setCustomerProfileId($customerProfileId);
        $profileController = new AnetController\GetCustomerProfileController($profileRequest);
        $profileResponse = $profileController->executeWithApiResponse($this->getEnvironment());

        if ($profileResponse->getMessages()->getResultCode() == 'Ok') {
            $existingProfiles = $profileResponse->getProfile()->getPaymentProfiles() ?? [];
            foreach ($existingProfiles as $pp) {
                $card = $pp->getPayment()->getCreditCard();
                if ($card && substr($card->getCardNumber(), -4) === substr($cardNumber, -4)) {
                    $paymentProfileId = $pp->getCustomerPaymentProfileId();
                    Log::info('Found existing Payment Profile', ['payment_profile_id' => $paymentProfileId]);
                    return $paymentProfileId;
                }
            }
        }

        // Create new payment profile
        $paymentProfile = new AnetAPI\CustomerPaymentProfileType();
        $paymentProfile->setBillTo($billTo);
        $paymentProfile->setPayment($payment);

        $createRequest = new AnetAPI\CreateCustomerPaymentProfileRequest();
        $createRequest->setMerchantAuthentication($merchantAuthentication);
        $createRequest->setCustomerProfileId($customerProfileId);
        $createRequest->setPaymentProfile($paymentProfile);

        // IMPORTANT: Use 'testMode' for sandbox (not 'none'!)
        $createRequest->setValidationMode('none');
        $controller = new AnetController\CreateCustomerPaymentProfileController($createRequest);
        $response = $controller->executeWithApiResponse($this->getEnvironment());

        if ($response->getMessages()->getResultCode() == 'Ok') {
            $paymentProfileId = $response->getCustomerPaymentProfileId();
            Log::info('New Payment Profile Created', ['payment_profile_id' => $paymentProfileId]);
            return $paymentProfileId;
        }

        $errorMsg = $response->getMessages()->getMessage()[0]->getText() ?? 'Unknown';
        Log::error('Payment Profile Creation Failed', ['error' => $errorMsg]);
        throw new \Exception('Failed to create Payment Profile: ' . $errorMsg);
    }

       public function cancelSubscription(Request $request)
       {
        $prefix = config('services.ihook.prefix', 'ihook');

        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'Please login.');
        }

        $memberLink = DB::table("{$prefix}_matrix_members_link_table")
            ->where('members_id', $user->members_id)
            ->first();

        $subscriptionId = $memberLink->authorize_subid ?? null;

        if (!$subscriptionId) {
            return redirect()->back()->with('error', 'No active subscription.');
        }

        try {
            $merchantAuthentication = $this->getMerchantAuthentication();

            $cancelRequest = new AnetAPI\ARBCancelSubscriptionRequest();
            $cancelRequest->setMerchantAuthentication($merchantAuthentication);
            $cancelRequest->setSubscriptionId($subscriptionId);

            $controller = new AnetController\ARBCancelSubscriptionController($cancelRequest);
            $response = $controller->executeWithApiResponse($this->getEnvironment());

            if ($response->getMessages()->getResultCode() == 'Ok') {
                DB::table("{$prefix}_matrix_members_link_table")
                    ->where('members_id', $user->members_id)
                    ->update([
                        'authorize_subid' => null,
                        'members_subscription_status' => 3,
                        'members_account_status' => 2,
                    ]);

                return redirect()->back()->with('success', 'Subscription cancelled successfully.');
            } else {
                $error = $response->getMessages()->getMessage()[0]->getText();
                return redirect()->back()->with('error', 'Failed to cancel subscription: ' . $error);
            }
        } catch (\Exception $e) {
            Log::error('Cancel subscription failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to cancel subscription.');
        }
    }
}
