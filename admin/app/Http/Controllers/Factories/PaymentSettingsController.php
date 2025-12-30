<?php

/**
 * This class contains public functions related to Total Commission reports
 *
 * @package
 * @category        Controller
 * @author
 * @link
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
 *****************************************************************************/
?>
<?php
namespace Admin\App\Http\Controllers\Factories;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Factories\MPaymentSettings;
use Admin\App\Models\Middleware\MCryptoGraphy;
use Illuminate\Http\Request;
use Admin\App\Models\Member\Admin;
use Admin\App\Models\Member\Payment;
use Admin\App\Models\Member\Bankwire;
use Illuminate\Support\Facades\Hash;
use Admin\App\Models\Member\Banner;
use Exception;

class PaymentSettingsController extends Controller
{
    public static function showPaymentSettings()
    {
        // dd('fucntion reached or not');

    try {

        $paymentSettings = MPaymentSettings::showPaymentSettingsList();
        // dd($paymentSettings);
        $bankwireSettings = MPaymentSettings::getBankwirePaymentSettings();

        return view('factories.paymentsettings', [
            'payment_settings' => $paymentSettings,
            'bankwire_payment_settings' => $bankwireSettings,
            'success' => session('success'),
            'error_message' => session('error_message')
        ]);

    } catch (\Exception $e) {

        return redirect()
            ->route('paymentsettings')
            ->with('error_message', $e->getMessage());
    }
}
public function updatePaymentSettings(Request $request)
{
    // dd('function reached or not');
    $request->validate([
        'otpvalid' => 'required',
        'paymentsettings_id' => 'required|integer'
    ]);
    $admin = Admin::where('admin_status', 'enable')->first();

    if (!$admin) {
        return back()->with('error_message', 'Admin not found');
    }

if ($request->otpvalid != $admin->admin_otp_decrypt) {
    return back()->with('error_message', 'Invalid OTP');
}
    $payment = Payment::find($request->paymentsettings_id);
    if (!$payment) {
        return back()->with('error_message', 'Payment setting not found');
    }

    $gateway = $payment->paymentsettings_default_name;


    $status = $request->paymentsettings_status == 1 ? 'Active' : 'Suspend';
    $instantpayout = $request->instantpayout_status == 1 ? 'Active' : 'Suspend';
    $mode = $request->paymentsettings_mode ?? $payment->paymentsettings_mode;

    $accname = null;
    $accnum = null;
    $payout_apivalues = json_encode([]);


    switch ($gateway) {

        case 'paypal':
            $accname = $request->paymentsettings_name;
            // dd($accname);
            $accnum  = $request->pppaymentsettings_accnum;
            // dd($accnum);
            $payout_apivalues = json_encode(['paypal_username' => $accnum]);
            // dd($payout_apivalues);
            break;

        case 'bankwire':
            $accname = $request->bwpaymentsettings_accname;
            $accnum  = $request->bwpaymentsettings_accnum;
            $payout_apivalues = json_encode(['note' => 'bankwire does not require API values']);
            break;

        case 'payza':
            $accname = $request->pzpaymentsettings_accname;
            $accnum  = $request->pzpaymentsettings_accnum;
            break;

        case 'perfectmoney':
            $accname = $request->pmpaymentsettings_accname;
            $accnum  = $request->pmpaymentsettings_accnum;
            $payout_apivalues = json_encode(['perfectmoney_access_id'=>'','perfectmoney_acc_pass'=>'']);
            break;

        case 'bitcoin':
        case 'bitpay':
            $accnum = MCryptoGraphy::encryptionDataExt($request->bipaymentsettings_accname);
            $payout_apivalues = json_encode([
                'btc_code' => $request->btc_code,
                'public_key' => $request->public_key,
                'private_key' => $request->private_key,
                'status' => $status
            ]);
            break;

        case 'okpay':
            $accname = $request->okpaymentsettings_accname;
            $accnum  = MCryptoGraphy::encryptionDataExt($request->okpaymentsettings_accnum);
            break;

        case 'skrill':
            $accnum = $request->skpaymentsettings_accnum;
            break;

        case 'payeer':
            $accname = $request->payeerpaymentsettings_accname;
            $accnum  = MCryptoGraphy::encryptionDataExt($request->payeerpaymentsettings_accnum);
            $payout_apivalues = json_encode([
                'payeer_api_id' => $request->payeer_api_id,
                'payeer_api_key' => $request->payeer_api_key
            ]);
            break;

        case 'solidtrustpay':
            $accname = $request->stppaymentsettings_accname;
            $accnum  = $request->stppaymentsettings_accnum;
            break;

        case 'webmoney':
            $accname = $request->wmpaymentsettings_accname;
            $accnum  = $request->wmpaymentsettings_accnum;
            break;

        case 'cheque':
            $accname = $request->chequepaymentsettings_accname;
            break;

        case 'e_wallet':
        case 'e_pin':
        case 'admin_credit':
            $accname = 'SYSTEM';
            break;

        case 'authorizenet':
            $accname = $request->aunetpaymentsettings_accname;
            $accnum  = $request->aunetpaymentsettings_accnum;
            break;

          case 'paypalpro':

            // keep existing values by default
            $accname = $payment->paymentsettings_accname;
            $accnum  = $payment->paymentsettings_accnum;

            // username update
                $accname = $request->paypalpropaymentsettings_accname;
                $accnum = $request->paypalpropaymentsettings_accnum;



            $payout_apivalues = json_encode([
                'paypal_username'  => $accname,
                'paypal_password'  => $accnum,
                'paypal_signature' => $request->paypal_signature,
                'paypal_mode'      => $mode
            ]);

            break;


    case 'advcash':
    $accname = $request->advpaymentsettings_accname;

    if ($request->filled('advcash_password')) {
        $accnum = MCryptoGraphy::encryptionDataExt($request->advcash_password);
    }

    $payout_apivalues = json_encode([
        'advcash_username' => $accname,
        'advcash_password' => $accnum
    ]);
    break;


        case 'coinpayment':
            $accname = $request->paymentsettings_accname;
            $accnum  = $request->paymentsettings_accnum;
            $payout_apivalues = json_encode([
                'merchant_id' => $accname,
                'ipn_secret' => MCryptoGraphy::encryptionDataExt($request->ipn_secret),
                'btc_code' => $request->btc_code,
                'status' => $mode
            ]);
            break;

       case 'blockio':
    if ($request->filled('paymentsettings_accname')) {
        $accname = MCryptoGraphy::encryptionDataExt(
            $request->paymentsettings_accname
        );
    }

    if ($request->filled('blockio_pin')) {
        $accnum = MCryptoGraphy::encryptionDataExt(
            $request->blockio_pin
        );
    }

    $payout_apivalues = json_encode([
        'blockio_apikey' => $accname,
        'blockio_pin'    => $accnum
    ]);
    break;


        case 'stripe':
        case 'chargebee':
        case 'binance':
            $accname = $request->paymentsettings_accname;
            $accnum  = $request->paymentsettings_accnum;
            break;
    }
    $payment->update([
        'paymentsettings_accname' => $accname,
        'paymentsettings_accnum' => $accnum,
        'paymentsettings_status' => $status,
        'instantpayout_status' => $instantpayout,
        'payout_apivalues' => $payout_apivalues,
        'paymentsettings_mode' => $mode
    ]);

    if ($gateway === 'bankwire') {
        Bankwire::updateOrCreate(
            ['bankwire_id' => 1],
            [
                'bankwire_address' => $request->bankwire_address,
                'bankwire_swift_code' => $request->bankwire_swift_code,
                'bankwire_route' => $request->bankwire_route
            ]
        );
    }

    $admin->update(['admin_otp' => '']);

    return back()->with('success', 'Payment Settings updated successfully');
}


public function sendOTPPayment(Request $request)
{
    // Optional: Add gateway validation if needed
    $gateway = $request->input('gateway');
    $result = MPaymentSettings::sendOTPPayment();

    if ($result) {
        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully'
        ], 200);
    }

    return response()->json([
        'status' => false,
        'message' => 'Failed to send OTP'
    ], 500);
}
public function paymentValidateOTP(Request $request)
{
    $request->validate([
        'otpvalid' => 'required|digits:6'
    ]);

    $admin = Admin::where('admin_type', 1)->first();

    if ($admin && (string)$request->otpvalid === (string)$admin->admin_otp_decrypt) {
        return response()->json([
            'data' => true,
            'message' => 'OTP Verified'
        ]);
    }

    return response()->json([
        'data' => false,
        'message' => 'Invalid OTP'
    ], 200);
}

    }

