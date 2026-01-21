<?php

/**
 * This class contains public functions related to WithdrawalPaymentSettingsController
 *
 * @package         WithdrawalPaymentSettingsController
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Http\Controllers\Withdrawal;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Middleware\MCryptoGraphy;
use Admin\App\Models\Withdrawal\MWithdrawalPaymentSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Session;
use User\App\Models\Admin;

class WithdrawalPaymentSettingsController extends Controller
{
    public function index()
    {
        $payment_settings_raw = MWithdrawalPaymentSettings::where('paymentsettings_status', '!=', 'Deleted')
            ->orderBy('paymentsettings_id')
            ->get();

        Log::info("Withdrawal Payment Settings index loaded", [
            'total_gateways' => $payment_settings_raw->count(),
            'admin_id'       => session('admin_id') ?? 'guest',
        ]);

        // Create pre-fill data
        $preFill = [];

        foreach ($payment_settings_raw as $setting) {
            $id = $setting->paymentsettings_id;
            $gateway = strtolower(trim($setting->paymentsettings_default_name ?? $setting->paymentsettings_name ?? 'unknown'));

            // Decode safely
            $apiData = is_array($setting->payout_apivalues)
                ? $setting->payout_apivalues
                : (json_decode($setting->payout_apivalues ?? '{}', true) ?? []);

            $preFill[$id] = [
                'gateway'              => $gateway,
                'mode'                 => $setting->paymentsettings_mode ?? 'sandbox',
                'status'               => $setting->paymentsettings_status,
                'instantpayout_status' => $setting->instantpayout_status,
                'fields'               => [],
            ];

            Log::info("Processing gateway", [
                'id'      => $id,
                'gateway' => $gateway,
                'raw_accname' => $setting->paymentsettings_accname,
                'raw_accnum'  => $setting->paymentsettings_accnum,
                'api_data_keys' => array_keys($apiData),
            ]);

            switch ($gateway) {

                case 'paypal':
                    $preFill[$id]['fields'] = [
                        'pppaymentsettings_accname' => $setting->paymentsettings_accname ?? '',
                        'pppaymentsettings_accnum'  => $apiData['paypal_client'] ?? $setting->paymentsettings_accnum ?? '',
                        'paypal_client_secret'      => $apiData['paypal_client_secret'] ?? 'Not set',
                ];
                    Log::info("PayPal pre-fill data", [
                        'id'   => $id,
                        'email'         => $preFill[$id]['fields']['pppaymentsettings_accname'],
                        'client_id'     => $preFill[$id]['fields']['pppaymentsettings_accnum'],
                        'client_secret' => $preFill[$id]['fields']['paypal_client_secret'],
                    ]);
                    break;

                case 'perfectmoney':
                case 'perfect money':
                    $preFill[$id]['fields'] = [
                        'pmpaymentsettings_accnum'  => $apiData['pm_accountno'] ?? $setting->paymentsettings_accnum ?? '',
                        'pmpaymentsettings_accname' => $apiData['pm_walletid'] ?? $setting->paymentsettings_accname ?? '',
                        'pm_accountpassword'        => $apiData['pm_accountpassword'] ?? 'Not set',
                    ];
                    Log::info("Perfect Money pre-fill data", [
                        'id'             => $id,
                        'account_number' => $preFill[$id]['fields']['pmpaymentsettings_accnum'],
                        'wallet_id'      => $preFill[$id]['fields']['pmpaymentsettings_accname'],
                        'password'       => $preFill[$id]['fields']['pm_accountpassword'],
                    ]);
                    break;

                case 'payeer':
                    $preFill[$id]['fields'] = [
                        'pm_accountno'    => $apiData['payeer_accountno'] ?? '',
                        'payeer_api_id'   => $apiData['payeer_api_id'] ?? '',
                        'payeer_api_key'  => $apiData['payeer_api_key'] ?? 'Not set',
                    ];
                    Log::info("Payeer pre-fill data", [
                        'id'           => $id,
                        'account_no'   => $preFill[$id]['fields']['pm_accountno'],
                        'api_id'       => $preFill[$id]['fields']['payeer_api_id'],
                        'api_key'      => $preFill[$id]['fields']['payeer_api_key'],
                    ]);
                    break;

                case 'advcash':
                    $preFill[$id]['fields'] = [
                        'adv_email'        => $apiData['adv_email'] ?? '',
                        'adv_api_name'     => $apiData['adv_api_name'] ?? '',
                        'adv_api_password' => $apiData['adv_api_password'] ?? 'Not set',
                    ];
                    Log::info("AdvCash pre-fill data", [
                        'id'          => $id,
                        'email'       => $preFill[$id]['fields']['adv_email'],
                        'api_name'    => $preFill[$id]['fields']['adv_api_name'],
                        'api_password'=> $preFill[$id]['fields']['adv_api_password'],
                    ]);
                    break;

                case 'coinpayment':
                case 'coinpayments':
                    $preFill[$id]['fields'] = [
                        'public_key'  => $apiData['public_key'] ?? 'Not set',
                        'private_key' => $apiData['private_key'] ?? 'Not set',
                    ];
                    Log::info("CoinPayment pre-fill data", [
                        'id'          => $id,
                        'public_key'  => $preFill[$id]['fields']['public_key'],
                        'private_key' => $preFill[$id]['fields']['private_key'],
                    ]);
                    break;
                case 'stripe':
                    $preFill[$id]['fields'] = [
                        'public_key'  => $apiData['public_key'] ?? $setting->paymentsettings_accname ?? 'Not set',
                        'private_key' => $apiData['private_key'] ?? $setting->paymentsettings_accnum ?? 'Not set',
                    ];
                    Log::info("Stripe pre-fill data", [
                        'id'          => $id,
                        'public_key'  => $preFill[$id]['fields']['public_key'],
                        'private_key' => $preFill[$id]['fields']['private_key'],
                    ]);
                    break;

                case 'payquicker':
                    $preFill[$id]['fields'] = [
                        'pppaymentsettings_accnum' => $setting->paymentsettings_accname ?? '',
                        'paypal_client'            => $apiData['client_id'] ?? '',
                        'paypal_client_secret'     => $apiData['secret'] ?? 'Not set',
                    ];
                    Log::info("Payquicker pre-fill data", [
                        'id'               => $id,
                        'email'            => $preFill[$id]['fields']['pppaymentsettings_accnum'],
                        'client_id'        => $preFill[$id]['fields']['paypal_client'],
                        'secret'           => $preFill[$id]['fields']['paypal_client_secret'],
                    ]);
                    break;

                default:
                    $preFill[$id]['fields'] = [
                        'default_accname' => $setting->paymentsettings_accname ?? '',
                        'default_accnum'  => $setting->paymentsettings_accnum ?? '',
                    ];
                    Log::info("Default gateway pre-fill", [
                        'id'      => $id,
                        'gateway' => $gateway,
                        'accname' => $preFill[$id]['fields']['default_accname'],
                        'accnum'  => $preFill[$id]['fields']['default_accnum'],
                    ]);
                    break;
            }
        }

        Log::info("Pre-fill data prepared for all gateways", [
            'total_processed' => count($preFill),
            'gateways'        => array_keys($preFill),
        ]);

        return view('withdrawal.withdrawpaymentsettings', [
            'payment_settings' => $payment_settings_raw,
            'preFill'          => $preFill
        ]);
    }

    public function sendOtp(Request $request)
    {
        Log::info("sendOtp started | session admin_id: " . session('admin_id'));

        $admin_id = session('admin_id');
        if (!$admin_id) {
            Log::warning("No admin_id in session");
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please login again.'
            ], 401);
        }

        $admin = Admin::where('admin_id', $admin_id)->first();
        if (!$admin) {
            Log::error("Admin not found for admin_id = {$admin_id}");
            return response()->json([
                'success' => false,
                'message' => 'Admin not found'
            ], 404);
        }

        // Prevent OTP spam
        if (session('otp_sent_at') && now()->diffInSeconds(session('otp_sent_at')) < 60) {
            return response()->json([
                'success' => true,
                'message' => 'OTP already sent recently. Check your email.'
            ]);
        }

        $otp = random_int(100000, 999999);
        Log::info("Generated OTP: {$otp}");

        // Store OTP in session
        session([
            'otp_value'       => $otp,
            'otp_email'       => $admin->admin_email,
            'otp_sent_at'     => now(),
            'otp_valid_until' => now()->addMinutes(1),
        ]);
        try {
            Mail::send('withdrawal.mail.otp-verification-mail', [
                'otp' => $otp,
                'otp_email' => $admin->admin_email,
            ], function ($message) use ($admin) {
                $message->to($admin->admin_email)
                        ->subject('Withdrawal Settings Update - OTP Verification');
            });

            Log::info("OTP email sent successfully to {$admin->admin_email}");

            return response()->json([
                'success' => true,
                'message' => 'OTP sent! Check your email (valid for 60 seconds).'
            ]);
        } catch (\Exception $e) {
            Log::error("Mail failed: " . $e->getMessage());

            session()->forget(['otp_value', 'otp_email', 'otp_sent_at', 'otp_valid_until']);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP. Please try again.'
            ], 500);
        }

    }

    public function verifyOtp(Request $request)
{
    Log::info("verifyOtp called", $request->all());

    $request->validate([
        'otp' => 'required|digits:6',
    ]);

    $admin_id = session('admin_id');
    if (!$admin_id) {
        return response()->json(['success' => false, 'message' => 'Session expired'], 401);
    }

    $storedOtp   = session('otp_value');
    $otpEmail    = session('otp_email');
    $validUntil  = session('otp_valid_until');

    Log::info("Session OTP data", [
        'stored_otp'   => $storedOtp,
        'otp_email'    => $otpEmail,
        'valid_until'  => $validUntil ? $validUntil->toDateTimeString() : null
    ]);

    if (!$storedOtp || !$validUntil) {
        return response()->json([
            'success' => false,
            'message' => 'No active OTP request. Please send a new OTP.'
        ], 400);
    }

    if (now()->greaterThan($validUntil)) {
        session()->forget(['otp_value', 'otp_email', 'otp_sent_at', 'otp_valid_until']);
        return response()->json([
            'success' => false,
            'message' => 'OTP has expired. Please request a new one.'
        ], 400);
    }

    $enteredOtp = (int) $request->otp;
    $storedOtpInt = (int) $storedOtp;

    if ($enteredOtp !== $storedOtpInt) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid OTP'
        ], 422);
    }

    if (!session('withdraw_otp_verified_at')) {
        session(['withdraw_otp_verified_at' => now()]);
    }

    Log::info("OTP verified successfully (reusable within validity)");

    return response()->json([
        'success' => true,
        'message' => 'OTP verified successfully'
    ]);
    }

    public function update(Request $request)
    {
      $prefix = config('services.ihook.prefix');

        if (!session('withdraw_otp_verified_at')) {
            return redirect()->back()->with('error', 'OTP ');
        }

        $request->validate([
            'paymentsettings_id'   => 'required|integer|exists:' . $prefix . '_withdrawpaymentsettings_table,paymentsettings_id',
            'paymentsettings_mode' => 'nullable|in:live,sandbox',
        ]);

        $id = $request->paymentsettings_id;
        $setting = MWithdrawalPaymentSettings::findOrFail($id);

        $gateway = strtolower(trim($setting->paymentsettings_default_name ?? $setting->paymentsettings_name ?? ''));

        // பழைய values
        $accname = $setting->paymentsettings_accname ?? '';
        $accnum  = $setting->paymentsettings_accnum ?? '';

        $decoded = is_array($setting->payout_apivalues)
            ? $setting->payout_apivalues
            : (is_object($setting->payout_apivalues)
                ? (array) $setting->payout_apivalues
                : (json_decode($setting->payout_apivalues ?? '{}', true) ?? []));

        // Default update values
        $updateData = [
            'paymentsettings_mode'     => $request->input('paymentsettings_mode', $setting->paymentsettings_mode ?? 'sandbox'),
            'paymentsettings_status'   => $request->filled('paymentsettings_status') ? 'Active' : 'Suspend',
            'instantpayout_status'     => $request->filled('instantpayout_status')   ? 'Active' : 'Suspend',
        ];

        $payout_apivalues = null;

        switch ($gateway) {
case 'paypal':
            $oldAccname = $accname;
            $oldAccnum  = $accnum;

            $accname = trim($request->input('pppaymentsettings_accname', $accname));
            $accnum  = trim($request->input('pppaymentsettings_accnum', $accnum));

            $client_secret = trim($request->input('paypal_client_secret', ''));
            if ($client_secret !== '') {
                $decoded['paypal_client_secret'] = MCryptoGraphy::encryptionDataExt($client_secret);
                Log::info("PayPal client_secret updated (encrypted)", ['new_secret' => '***']);
            }
            $decoded['paypal_client'] = $accnum;

            $payout_apivalues = json_encode($decoded, JSON_UNESCAPED_SLASHES);

            Log::info("PayPal updated", [
                'old_accname' => $oldAccname,
                'new_accname' => $accname,
                'old_accnum'  => $oldAccnum,
                'new_accnum'  => $accnum,
                'new_payout'  => $payout_apivalues,
            ]);
            break;
            // 2. Bankwire
            case 'bankwire':
                $accname = trim($request->input('bwpaymentsettings_accname', $accname));
                $accnum  = trim($request->input('bwpaymentsettings_accnum', $accnum));
                break;

            // 3. Payza
            case 'payza':
                $accname = trim($request->input('pzpaymentsettings_accname', $accname));
                $accnum  = trim($request->input('pzpaymentsettings_accnum', $accnum));
                break;

            // 4. Perfect Money
            case 'perfectmoney':
            case 'perfect money':
                $accnum  = trim($request->input('pmpaymentsettings_accnum', $accnum));
                $accname = trim($request->input('pmpaymentsettings_accname', $accname));

                $password = trim($request->input('pm_accountpassword', ''));
                if ($password !== '') {
                    $decoded['pm_accountpassword'] = MCryptoGraphy::encryptionDataExt($password);
                }

                $walletid = trim($request->input('pmpaymentsettings_accname', $accname)); // Wallet ID
                $decoded['pm_walletid'] = $walletid;
                $decoded['pm_accountno'] = $accnum;
                $payout_apivalues = json_encode($decoded, JSON_UNESCAPED_SLASHES);
                break;

            // 6. Bitpay Bitcoin
            case 'bitcoin':
            case 'bitpay bitcoin':
                $decoded['bitcoinmode']    = trim($request->input('bitcoinmode', $decoded['bitcoinmode'] ?? ''));
                $decoded['btc_code']       = trim($request->input('btc_code', $decoded['btc_code'] ?? ''));
                $decoded['public_key']     = trim($request->input('public_key', $decoded['public_key'] ?? ''));
                $decoded['private_key']    = trim($request->input('private_key', $decoded['private_key'] ?? ''));
                $decoded['blockio_apikey'] = trim($request->input('blockio_apikey', $decoded['blockio_apikey'] ?? ''));
                $decoded['blockio_pin']    = trim($request->input('blockio_pin', $decoded['blockio_pin'] ?? ''));
                $decoded['status']         = $updateData['paymentsettings_mode'];
                $payout_apivalues = json_encode($decoded, JSON_UNESCAPED_SLASHES);
                break;

            // 9. Payeer
            case 'payeer':
                $accname = trim($request->input('payeerpaymentsettings_accname', $accname));
                $accnum  = trim($request->input('payeerpaymentsettings_accnum', $accnum));

                $decoded['payeer_accountno'] = trim($request->input('payeer_accountno', $decoded['payeer_accountno'] ?? ''));
                $decoded['payeer_api_id']    = trim($request->input('payeer_api_id', $decoded['payeer_api_id'] ?? ''));
                $decoded['payeer_api_key']   = trim($request->input('payeer_api_key', $decoded['payeer_api_key'] ?? ''));
                $payout_apivalues = json_encode($decoded, JSON_UNESCAPED_SLASHES);
                break;

            // 10. Solid Trust Pay
            case 'solidtrustpay':
                $accname = trim($request->input('stppaymentsettings_accname', $accname) ?: $accname);
                $accnum  = trim($request->input('stppaymentsettings_accnum', $accnum) ?: $accnum);
                break;

            // 11. Web Money
            case 'webmoney':
                $accname = trim($request->input('wmpaymentsettings_accname', $accname) ?: $accname);
                $accnum  = trim($request->input('wmpaymentsettings_accnum', $accnum) ?: $accnum);
                break;

            // 16. Authorizenet
            case 'authorizenet':
                $accname = trim($request->input('aunetpaymentsettings_accname', $accname) ?: $accname);
                $accnum  = trim($request->input('aunetpaymentsettings_accnum', $accnum) ?: $accnum);
                break;

            // 17. Paypal Pro
            case 'paypalpro':
                $decoded['paypal_username']  = trim($request->input('paypal_username', $decoded['paypal_username'] ?? ''));
                $decoded['paypal_password']  = trim($request->input('paypal_password', $decoded['paypal_password'] ?? ''));
                $decoded['paypal_signature'] = trim($request->input('paypal_signature', $decoded['paypal_signature'] ?? ''));
                $decoded['paypal_mode']      = trim($request->input('paypal_mode', $decoded['paypal_mode'] ?? ''));
                $payout_apivalues = json_encode($decoded, JSON_UNESCAPED_SLASHES);
                break;

            // 18. AdvCash
            case 'advcash':
                $accname = trim($request->input('advpaymentsettings_accname', $accname) ?: $accname);
                $accnum  = trim($request->input('advpaymentsettings_accname', $accnum) ?: $accnum);

                $adv_password = trim($request->input('adv_api_password', ''));
                if ($adv_password !== '') {
                    $decoded['adv_api_password'] = MCryptoGraphy::encryptionDataExt($adv_password);
                }
                $decoded['adv_email']    = trim($request->input('adv_email', $decoded['adv_email'] ?? ''));
                $decoded['adv_api_name'] = trim($request->input('adv_api_name', $decoded['adv_api_name'] ?? ''));
                $payout_apivalues = json_encode($decoded, JSON_UNESCAPED_SLASHES);
                break;

            // 19. Coin Payment
            case 'coinpayment':
            case 'coinpayments':
                $public_key  = trim($request->input('public_key', ''));
                $private_key = trim($request->input('private_key', ''));

                if ($public_key !== '') {
                    $decoded['public_key'] = MCryptoGraphy::sslEncryptionData($public_key);
                }
                if ($private_key !== '') {
                    $decoded['private_key'] = MCryptoGraphy::sslEncryptionData($private_key);
                }
                $payout_apivalues = json_encode($decoded, JSON_UNESCAPED_SLASHES);
                break;

            // 20. BlockIo
            case 'blockio':
                $decoded['blockio_apikey']    = trim($request->input('blockio_apikey', $decoded['blockio_apikey'] ?? ''));
                $decoded['blockio_pin']       = trim($request->input('blockio_pin', $decoded['blockio_pin'] ?? ''));
                $decoded['blockio_coin_mode'] = trim($request->input('blockio_coin_mode', $decoded['blockio_coin_mode'] ?? 'bitcoin'));
                $decoded['status']            = $updateData['paymentsettings_mode'];
                $payout_apivalues = json_encode($decoded, JSON_UNESCAPED_SLASHES);
                break;

            // 21. Stripe
            case 'stripe':
                $stripe_secret = trim($request->input('private_key', ''));
                if ($stripe_secret !== '') {
                    $accnum = MCryptoGraphy::encryptionDataExt($stripe_secret);
                }
                break;

            // 22. Chargebee
            case 'chargebee':
                $accname = trim($request->input('chargebeepaymentsettings_accname', $accname) ?: $accname);
                $accnum  = trim($request->input('chargebeepaymentsettings_accnum', $accnum) ?: $accnum);
                break;

            // 23. Payquicker
            case 'payquicker':
                $accname = trim($request->input('pppaymentsettings_accnum', $accname)); // Email ID
                $accnum  = trim($request->input('pppaymentsettings_accnum', $accnum));  // fallback

                $client_id = trim($request->input('paypal_client', ''));
                $secret    = trim($request->input('paypal_client_secret', ''));

                if ($client_id !== '' || $secret !== '') {
                    $decoded['client_id'] = $client_id;
                    if ($secret !== '') {
                        $decoded['secret'] = MCryptoGraphy::encryptionDataExt($secret);
                    }
                    $payout_apivalues = json_encode($decoded, JSON_UNESCAPED_SLASHES);
                }
                break;

            default:
                $accname = trim($request->input('paymentsettings_accname', $accname));
                $accnum  = trim($request->input('paymentsettings_accnum', $accnum));
                break;
        }

        // Final update array
        $updateData = array_merge($updateData, [
            'paymentsettings_accname' => $accname,
            'paymentsettings_accnum'  => $accnum,
            'payout_apivalues'        => $payout_apivalues ?? $setting->payout_apivalues,
        ]);

        try {
            $setting->update($updateData);

            session()->forget([
                'otp_value', 'otp_email', 'otp_sent_at', 'otp_valid_until',
                'withdraw_otp_verified_at'
            ]);

            return redirect()->route('admin.withdraw-payments.index')
                ->with('success', 'Withdraw Payment Settings.');
        } catch (\Exception $e) {
            Log::error('Withdrawal settings update failed', [
                'id'      => $id,
                'gateway' => $gateway,
                'error'   => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Payment Settings is not Updated.')
                ->withInput();
        }
    }
}
