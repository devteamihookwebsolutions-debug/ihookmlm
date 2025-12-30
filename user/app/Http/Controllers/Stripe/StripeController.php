<?php

namespace User\App\Http\Controllers\Stripe;

use Auth;
use Aws\Api\Service;
use User\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Subscription;
use Stripe\Customer;
use Stripe\Price;
use Stripe\Product;
use Stripe\Invoice;
use Stripe\PaymentIntent;
use Admin\App\Models\Member\Matrix;

class StripeController extends Controller
{
public function __construct()
{
    Log::info('StripeController __construct called');

     $prefix = config('services.ihook.prefix', 'ihook');

    // FIX 1: Add ->first() here!
    $stripeDetails = DB::table("{$prefix}_paymentsettings_table")
        ->where('paymentsettings_name', 'Credit/Debit Card (Stripe)')
        ->where('paymentsettings_status', 'Active')
        ->first();

    $secretKey = $stripeDetails->paymentsettings_accnum ?? '';

    if (empty($secretKey)) {
        Log::error('Stripe Secret Key is empty in database', [
            'row_data' => (array)$stripeDetails
        ]);
        throw new \Exception('Stripe Secret Key not found in database.');
    }

    // Set the API key
    Stripe::setApiKey($secretKey);

    Log::info('Stripe gateway initialized successfully with DB key', [
        'key_preview' => substr($secretKey, 0, 10) . '...' . substr($secretKey, -4),
        'mode'        => str_starts_with($secretKey, 'sk_test_') ? 'Test' : 'Live'
    ]);
}
    private function getOrCreatePackagePrice($packageId, $packageName, $amount)
    {
         $prefix = config('services.ihook.prefix', 'ihook');

        $unitAmount = (int)($amount * 100);

        $package = DB::table("{$prefix}_package_table")
            ->where('package_id', $packageId)
            ->first();

        if (!$package) {
            Log::error("Package not found for ID: $packageId");
            throw new \Exception("Package not found");
        }

        $metadata = [
            'Package Name'              => $package->package_name ?? 'Unknown',
            'Package Price'             => (string)($package->package_price ?? '0'),
            'Package Direct Commission' => (string)($package->package_direct_commission ?? '0'),
            'Package Tax'               => (string)($package->package_tax ?? '0'),
            'Package Status'            => ($package->package_status ?? 1) == 1 ? 'Active' : 'Inactive',
            'Package Type'              => (string)($package->package_type ?? ''),
            'Package Description'       => (string)($package->package_description ?? ''),
            'Payment Gateway'           => (string)($package->payment_gateway ?? 'stripe'),
            'Package Image'             => (string)($package->package_image ?? ''),
            'Registration Type'         => (string)($package->registration_type ?? ''),
            'Upgrade Type'              => (string)($package->upgrade_type ?? ''),
        ];

        $products = Product::all(['limit' => 100]);
        $existingProduct = null;

        foreach ($products->data as $prod) {
            if ($prod->active) {
                if (isset($prod->metadata['Package Name']) && $prod->metadata['Package Name'] === $package->package_name) {
                    $existingProduct = $prod;
                    break;
                }
                if ($prod->name === $packageName &&
                    $prod->description === ($package->package_description ?? 'Monthly recurring subscription package')) {
                    $existingProduct = $prod;
                    break;
                }
            }
        }

        if (!$existingProduct) {
            $existingProduct = Product::create([
                'name'        => $packageName,
                'description' => $package->package_description ?? 'Monthly recurring subscription package',
                'metadata'    => $metadata,
                'active'      => true,
                'images'      => isset($package->package_image) && !empty($package->package_image)
                    ? [url($package->package_image)]
                    : [],
            ]);

            Log::info('Created new Stripe Product', [
                'product_id' => $existingProduct->id,
                'name'       => $packageName,
                'metadata'   => $metadata
            ]);
        } else {
            Log::info('Reusing existing Stripe Product', [
                'product_id' => $existingProduct->id,
                'name'       => $packageName,
            ]);
        }

        $prices = Price::all([
            'product' => $existingProduct->id,
            'active'  => true,
            'type'    => 'recurring',
            'limit'   => 100
        ]);

        foreach ($prices->data as $price) {
            if (
                $price->unit_amount == $unitAmount &&
                $price->recurring->interval == 'month' &&
                $price->currency == 'usd'
            ) {
                Log::info('Reusing existing Price', ['price_id' => $price->id]);
                return $price->id;
            }
        }

        $newPrice = Price::create([
            'product'     => $existingProduct->id,
            'unit_amount' => $unitAmount,
            'currency'    => 'usd',
            'recurring'   => ['interval' => 'month'],
            'nickname'    => $packageName . ' - Monthly',
            'metadata'    => $metadata,
        ]);

        Log::info('Created new recurring Price', [
            'price_id' => $newPrice->id,
            'amount'   => $amount,
            'metadata' => $metadata
        ]);

        return $newPrice->id;
    }

    public function pay(Request $request)
    {
        $prefix = config('services.ihook.prefix', 'ihook');

        Log::info('=== STRIPE PAY METHOD CALLED ===', $request->all());

        $paidType = DB::table("{$prefix}_matrix_configuration_table")
            ->where('matrix_key', 'members_paid_account_type')
            ->value('matrix_value');

        $selectedPackageId = $request->input('Package', '0');
        $amount = '0.00';
        $registerFee = '0.00';
        $registerFeeEnabled = false;
        $packageName = 'Subscription Package';

        Session::put('register', $request->all());

        $registerData = $request->all();
        $username = $registerData['user_name'] ?? '';
        $firstname = $registerData['first_name'] ?? '';
        $lastname = $registerData['last_name'] ?? '';
        $directSponsorId = $registerData['default_sponsor'] ?? '1';
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
            $packageName = 'Registration Fee (One-Time)'; // One-time description
        }

        if ((float)$amount <= 0 && (float)$registerFee <= 0) {
            return redirect()->back()->with('error', 'Invalid amount.');
        }

        Session::put('selected_package_amount', $amount);
        Session::put('selected_package_id', $selectedPackageId);
        Session::put('register_fee_enabled', $registerFeeEnabled);
        Session::put('register_fee_amount', $registerFee);
        Session::put('package_name', $packageName);

        if (!$email) {
            return redirect()->back()->with('error', 'Email required.');
        }

        $sponsorFullName = 'Admin';

        $finalSponsorId = Session::get('final_sponsor_id', $directSponsorId);

        if ($finalSponsorId && $finalSponsorId != '1') {
            $link = DB::table("{$prefix}_matrix_members_link_table")
                ->where('members_id', $finalSponsorId)
                ->first(['spillover_id', 'direct_id']);

            $sponsorIdToUse = null;

            if ($link) {
                if ($link->spillover_id) {
                    $sponsorIdToUse = $link->spillover_id;
                } elseif ($link->direct_id) {
                    $sponsorIdToUse = $link->direct_id;
                }
            }

            if ($sponsorIdToUse) {
                $sponsor = DB::table("{$prefix}_members_table")
                    ->where('members_id', $sponsorIdToUse)
                    ->first(['members_firstname', 'members_lastname']);

                if ($sponsor) {
                    $sponsorFullName = trim(($sponsor->members_firstname ?? '') . ' ' . ($sponsor->members_lastname ?? ''));
                    $sponsorFullName = $sponsorFullName ?: 'Unknown Sponsor';
                }
            }
        }

        Session::put('sponsor_username', $sponsorFullName);

        try {
            $lineItems = [];
            $mode = $paidType == '1' ? 'subscription' : 'payment';

            $metadata = [
                'Member Username'      => $username,
                'Member First Name'    => $firstname,
                'Member Last Name'     => $lastname,
                'Package Name'         => $packageName,
                'Sponsor Username'     => $sponsorFullName,
                'Site URL'             => url('/'),
                'Email Address'        => $email,
                'Payment Type'         => $paidType == '1' ? 'Subscription' : 'Registration Fee',
            ];

            if ($paidType == '1') {
                $priceId = $this->getOrCreatePackagePrice($selectedPackageId, $packageName, $amount);
                $lineItems[] = [
                    'price'    => $priceId,
                    'quantity' => 1,
                ];
            }

            if ($registerFeeEnabled && (float)$registerFee > 0) {
                $lineItems[] = [
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name'     => 'Registration Fee (One-Time)',
                            'metadata' => $metadata,
                        ],
                        'unit_amount'  => (int)($registerFee * 100),
                    ],
                    'quantity' => 1,
                ];
            }

            $params = [
                'payment_method_types' => ['card'],
                'customer_email'       => $email,
                'mode'                 => $mode,
                'line_items'           => $lineItems,
                'success_url'          => route('user.stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'           => route('user.stripe.cancel'),
                'metadata'             => $metadata,
            ];

            if ($mode === 'subscription') {
                $params['subscription_data'] = [
                    'metadata' => $metadata,
                ];
            } else {
                $params['payment_intent_data'] = [
                    'metadata'    => $metadata,
                    'description' => 'Registration Fee (One-Time)', // <-- FIX: One-time description
                ];
            }

            $checkout_session = CheckoutSession::create($params);

            Log::info('Stripe Checkout Session Created', [
                'session_id'   => $checkout_session->id,
                'mode'         => $mode,
                'package_name' => $packageName,
                'username'     => $username,
            ]);

            return redirect($checkout_session->url, 303);

        } catch (\Exception $e) {
            Log::error('Stripe Checkout Creation Failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Payment initialization failed.');
        }
    }

    public function success(Request $request)
    {
        $prefix = config('services.ihook.prefix', 'ihook');

        Log::info('=== STRIPE SUCCESS CALLED ===', $request->all());

        $session_id = $request->query('session_id');
        if (!$session_id) {
            return redirect()->route('user.registration')->with('error', 'Session missing.');
        }

        try {
            $session = CheckoutSession::retrieve($session_id, [
                'expand' => [
                    'subscription',
                    'customer',
                    'payment_intent',
                    'line_items',
                    'invoice'
                ]
            ]);

            $paidType = DB::table("{$prefix}_matrix_configuration_table")
                ->where('matrix_key', 'members_paid_account_type')
                ->value('matrix_value');

            $customer = $session->customer;
            $customerId = is_string($customer) ? $customer : $customer?->id;

            $subscriptionId = null;
            $transactionId = $session->id; // Default

            if ($paidType == '1') {
                $subscription = $session->subscription;
                if (is_string($subscription)) {
                    $subscription = Subscription::retrieve($subscription);
                }

                if (!in_array($subscription->status, ['active', 'trialing'])) {
                    return redirect()->route('user.registration')->with('error', 'Subscription not active.');
                }

                $subscriptionId = $subscription->id;
                $transactionId = $subscriptionId;
            }

            if ($session->payment_status !== 'paid' && $paidType == '0') {
                return redirect()->route('user.registration')->with('error', 'Payment not completed.');
            }

            // Prepare Data
            $registerData = Session::get('register', []);
            $username = $registerData['user_name'] ?? '';
            $firstname = $registerData['first_name'] ?? '';
            $lastname = $registerData['last_name'] ?? '';
            $sponsorId = $registerData['default_sponsor'] ?? '1';
            $packageName = Session::get('package_name', 'Gold');
            $selectedPackageId = Session::get('selected_package_id', 0);

            $sponsorFullName = 'Admin';

            if ($sponsorId && $sponsorId != '1') {
                $link = DB::table("{$prefix}_matrix_members_link_table")
                    ->where('members_id', $sponsorId)
                    ->first(['spillover_id', 'direct_id']);

                $sponsorIdToUse = null;

                if ($link) {
                    if ($link->spillover_id) {
                        $sponsorIdToUse = $link->spillover_id;
                    } elseif ($link->direct_id) {
                        $sponsorIdToUse = $link->direct_id;
                    }
                }

                if ($sponsorIdToUse) {
                    $sponsor = DB::table("{$prefix}_members_table")
                        ->where('members_id', $sponsorIdToUse)
                        ->first(['members_firstname', 'members_lastname']);

                    if ($sponsor) {
                        $sponsorFullName = trim(($sponsor->members_firstname ?? '') . ' ' . ($sponsor->members_lastname ?? ''));
                        $sponsorFullName = $sponsorFullName ?: 'Unknown Sponsor';
                    }
                }
            }

            $metadata = [
                'Member Username'      => $username,
                'Member First Name'    => $firstname,
                'Member Last Name'     => $lastname,
                'Package Name'         => $packageName,
                'Sponsor Username'     => $sponsorFullName,
                'Site URL'             => url('/'),
                'Email Address'        => $session->customer_email,
                'Payment Type'         => $paidType == '1' ? 'Subscription' : 'Registration Fee',
            ];

            if ($customerId) {
                Customer::update($customerId, ['metadata' => $metadata]);
            }
            if ($subscriptionId) {
                Subscription::update($subscriptionId, ['metadata' => $metadata]);
            }
            if ($session->invoice) {
                Invoice::update($session->invoice, ['metadata' => $metadata]);
            }

            // FIX: Update Payment Intent metadata
            $paymentIntentId = $session->payment_intent;
            if ($paymentIntentId) {
                try {
                    $pi = PaymentIntent::retrieve($paymentIntentId);
                    PaymentIntent::update($pi->id, ['metadata' => $metadata]);

                    Log::info('Payment Intent metadata updated successfully', [
                        'pi_id' => $pi->id,
                        'metadata' => $metadata
                    ]);
                } catch (\Exception $piError) {
                    Log::error('Failed to update PI metadata', ['error' => $piError->getMessage()]);
                }
            } else {
                Log::warning('No Payment Intent ID found in session', ['session_id' => $session_id]);
            }

            $hashedTransactionId = Hash::make($transactionId);

            Log::info('Stripe Payment Success', [
                'customer_id'     => $customerId,
                'subscription_id' => $subscriptionId,
                'transaction_id'  => $transactionId,
                'username'        => $username,
            ]);

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
            ];

            if ($paidType == '1') {
                $linkData['stripe_subid'] = $subscriptionId;
                $linkData['stripe_cusid'] = $customerId;
            }

            DB::table("{$prefix}_matrix_members_link_table")
                ->where('members_id', $members_id)
                ->update($linkData);

            $defaultMatrix = Matrix::where('matrix_default', 1)->first();
            $matrix_id = $defaultMatrix ? $defaultMatrix->matrix_id : 1;


            DB::table("{$prefix}_paymenthistory_table")->insert([
                'paymenthistory_member_id' => (int)$members_id,
                'paymenthistory_amount'    => Session::get('selected_package_amount', 0) + Session::get('register_fee_amount', 0),
                'payment_amt_exclusive'    => number_format(
                    (float) Session::get('selected_package_amount', 0) + (float) Session::get('register_fee_amount', 0),
                    2,
                    '.',
                    ''
                ),
                'paymenthistory_mode'      => 21,
                'paymenthistory_trans_id'  => $transactionId,
                'paymenthistory_type'      => 'user_register',
                'identify_type'            => 'stripe',
                'paymenthistory_status'    => 'paid',
                'paymenthistory_plan_id'   => $selectedPackageId,
                'matrix_id'                => $matrix_id,
                'transaction_id'           => $hashedTransactionId,
                'paymenthistory_date'      => now(),
                'created_on'               => now(),
                'payment_gateway_response' => json_encode($session->toArray()),
            ]);

            Session::forget([
                'register', 'selected_package_amount', 'selected_package_id',
                'register_fee_enabled', 'register_fee_amount', 'package_name',
                'final_sponsor_id', 'sponsor_username'
            ]);

            return redirect()->route('user.thankyou')
                ->with('success_message', 'Payment and registration successful!');

        } catch (\Exception $e) {
            Log::error('Stripe success processing failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->route('user.registration')->with('error', 'Payment processing failed.');
        }
    }

    public function cancel()
    {
        Log::info('=== STRIPE CANCELLED ===');
        return redirect()->route('user.registration')->with('error', 'Payment was cancelled.');
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

        $subscriptionId = $memberLink->stripe_subid ?? null;

        if (!$subscriptionId) {
            return redirect()->back()->with('error', 'No active subscription.');
        }

        try {
            Subscription::update($subscriptionId, ['cancel_at_period_end' => true]);

            DB::table("{$prefix}_matrix_members_link_table")
                ->where('members_id', $user->members_id)
                ->update([
                    'stripe_subid' => null,
                    'members_subscription_status' => 3,
                    'members_account_status' => 2,
                ]);

            return redirect()->back()->with('success', 'Subscription cancelled successfully.');
        } catch (\Exception $e) {
            Log::error('Cancel subscription failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to cancel subscription.');
        }
    }
}
