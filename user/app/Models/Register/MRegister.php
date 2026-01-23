<?php

/**
 * This class contains public functions related to MRegister
 *
 * @package         MRegister
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace User\App\Models\Register;

use Admin\App\Models\Member\Matrix;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\State;
use Admin\App\Models\Member\Country;
use Admin\App\Models\Member\MemberLinks;
use Admin\App\Models\Member\MatrixConfiguration;
use Admin\App\Models\Middleware\MMatrixDetails;
use Admin\App\Models\Middleware\MMatrixConfiguration;
use Admin\App\Models\Middleware\MMatrixMemberLink;
use Admin\App\Models\Middleware\MPaymentGatewayDetails;
use Admin\App\Models\Middleware\MPackageDetails;
use Admin\App\Models\Middleware\MUserNotifyStatus;
use Admin\App\Models\PaymentConquest\MInsertPaymentHistory;
use Admin\App\Models\PaymentConquest\MPaymentSuccess;
use Admin\App\Models\Middleware\MSiteDetails;
use Admin\App\Models\Middleware\MFormatNumber;
use Admin\App\Models\Middleware\MSendMail;
use Illuminate\Support\Facades\DB;
// use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use User\App\Models\Register\Middleware\MRegisterMembersInsert;

class MRegister
{
    public function checkUserSponsor(Request $request)
    {
        $request->validate([
            'members_username' => 'required|string|max:255',
            'sponsor_id'       => 'required|string|max:255',
        ]);

        $membersUsername = trim($request->input('members_username'));
        $sponsorUsername = trim($request->input('sponsor_id'));
        // dd($sponsorUsername);
        $matrixId        = session('register.matrix_id');

        if (Member::where('members_username', $membersUsername)->exists()) {
            return redirect('/register')->with('error_message', __('User Name already exists'));
        }

        $sponsor = Member::where('members_username', $sponsorUsername)
            ->where('members_verified', 1)
            ->where('members_status', 1)
            ->first();

        if (!$sponsor) {
            return redirect('/register')->with('error_message', __('Invalid sponsor'));
        }

        $matrixMember = MemberLinks::where('members_id', $sponsor->members_id)
            ->where('members_account_status', 1)
            ->where('matrix_id', $matrixId)
            ->first();

        if (!$matrixMember) {
            return redirect('/register')->with('error_message', __('Invalid sponsor'));
        }
    }

    public static function redirectMembers(Request $request)
    {
        Log::info('redirectMembers() started');

        $data = $request->all();

        // 1. Get Default Matrix
        $defaultMatrix = Matrix::where('matrix_default', 1)->first();
        if (!$defaultMatrix) {
            Log::error('No default matrix found!');
            throw new Exception('Default matrix not configured');
        }

        $matrix_id      = $defaultMatrix->matrix_id;
        $matrix_type_id = $defaultMatrix->matrix_type_id ?? 1;
        $matrix_name    = $defaultMatrix->matrix_name ?? 'Default Matrix';

        // 2. Insert Member First
        $members_id = MRegisterMembersInsert::insertMembers($request, $matrix_id);
        if ($members_id <= 0) {
            Log::error('Member insertion failed', ['members_id' => $members_id]);
            return false;
        }
        Log::info('Member inserted successfully', ['members_id' => $members_id]);

        $membersPaidAccountType = DB::table('ihook_matrix_configuration_table')
            ->where('matrix_key', 'members_paid_account_type')
            ->value('matrix_value');

        $packageId          = $request->input('Package');
        $package_price      = 0;
        $direct_commission  = 0;
        $package_name       = 'Free Registration';
        $transaction_id     = '#FREE' . now()->format('YmdHis') . $members_id;

        if ($membersPaidAccountType == 1) {
            if (!$packageId) {
                Log::error('Package selection required but missing (paid account type)');
                throw new Exception('Please select a registration package.');
            }

            $package = MPackageDetails::getPackageDetails($packageId);
            if (!$package) {
                Log::error('Invalid or inactive package selected', ['package_id' => $packageId]);
                throw new Exception('Invalid package selected. Please try again.');
            }

            $package_price      = $package->package_price ?? 0;
            $direct_commission  = $package->package_direct_commission ?? 0;
            $package_name       = $package->package_name ?? 'Unknown Package';
            $transaction_id     = '#' . now()->format('YmdHis') . $members_id;

            Log::info('Paid registration - Package selected', [
                'package_id' => $packageId,
                'price'      => $package_price,
                'commission' => $direct_commission
            ]);

        } else {
            // FREE REGISTRATION - No package needed
            Log::info('Free registration allowed (members_paid_account_type = 0)', [
                'members_id' => $members_id
            ]);

            // Optional: Assign a free package ID if you have one
            // $packageId = 999; // example free package
            $packageId = null;
        }

         $paymentStatus = ($membersPaidAccountType == 1) ? 'pending' : 'notpaid';
        $paymentMethod = isset($data['payment']) ? (int)$data['payment'] : null;
        $skipPaymentMethods = [1, 16, 21];

        if (in_array($paymentMethod, $skipPaymentMethods, true)) {
            Log::info('Skipping payment history insert for payment method', [
            'payment_method' => $paymentMethod,
            'members_id'     => $members_id
            ]);
            $paymenthistory_id = 1; // dummy positive id to satisfy later checks
        } else {
            $insertPayment = new MInsertPaymentHistory();
            // Use a safe random token instead of mt_rand with a very large max
            $randomRef = bin2hex(random_bytes(10));
            $paymenthistory_id = $insertPayment->getInsertPaymentHistory(
            $members_id,
            $package_price,
            $direct_commission,
            $randomRef,
            'user_register',
            $paymentStatus,
            $matrix_id,
            $packageId,
            $transaction_id,
            $direct_commission,
            $data['payment'] ?? 'free_registration'
            );
        }

        if (!$paymenthistory_id || $paymenthistory_id <= 0) {
            Log::error('Failed to insert payment history', ['members_id' => $members_id]);
            throw new Exception('Payment record creation failed');
        }

        Log::info('Payment history inserted', [
            'paymenthistory_id' => $paymenthistory_id,
            'status'           => $paymentStatus
        ]);
        // 5. Insert Payment History
        if ($membersPaidAccountType == 1) {
            $paymentStatus = 'pending';
        } else {
            $paymentStatus = 'paid';
        }
        // 6. For Free Registration - Skip Payment Gateway & Give Instant Access
        if ($membersPaidAccountType == 0) {
            Log::info('Free registration - Processing instant activation & commissions');

            $response = MPaymentSuccess::afterPaymentSuccesssCommission(
                $members_id,
                $matrix_id,
                $packageId ?? 0,
                'free_registration',
                'package_purchase',
                0,
                $transaction_id,
                $paymenthistory_id,
                $matrix_type_id,
                $matrix_name,
                $transaction_id,
                0
            );

            if ($response) {
                Log::info('Free registration commissions processed successfully');
            }

            return true;
        }

        // 7. For Paid Registration - Check Payment Gateway
        $paymentMode = $data['payment'] ?? '';
        $gateway     = MPaymentGatewayDetails::getPaymentGatewayDetail($paymentMode);
        $gatewayName = $gateway->paymentsettings_default_name ?? 'unknown';

        if (in_array($gatewayName, ['bankwire', 'cheque', 'admin_credits', 'blockio'])) {
            Log::info('Offline payment selected - awaiting admin approval', ['gateway' => $gatewayName]);
            return true;
        }

        // Online Payment - Process commissions immediately
        Log::info('Online payment - processing commissions', ['gateway' => $gatewayName]);

        $response = MPaymentSuccess::afterPaymentSuccesssCommission(
            $members_id,
            $matrix_id,
            $packageId,
            $paymentMode,
            'package_purchase',
            $package_price,
            $transaction_id,
            $paymenthistory_id,
            $matrix_type_id,
            $matrix_name,
            $transaction_id,
            $package_price
        );

        if ($response) {
            Log::info('All commissions processed successfully!');
        } else {
            Log::warning('Commission processing returned false', ['members_id' => $members_id]);
        }


       $paymenthistory_amount     = MFormatNumber::formatPaymentAmount($member->final_fee ?? 0, 2);
    $site_currency = MSiteDetails::getSiteSettingValue('site_currency');
        //Plan purchase mail
        if($paymenthistory_id > 0)
        {
            // dd($paymenthistory_id);
        $prefix = config('ihook.prefix', 'ihook');
        $email_notification_user = MSiteDetails::getSiteSettingValue('email_notification_user');
        // dd($email_notification_user);
        $push_notification_admin = MSiteDetails::getSiteSettingValue('push_notification_admin');

        $push_notification_user  = MSiteDetails::getSiteSettingValue('push_notification_user');

        if ($email_notification_user == '1') {
            $member = Member::find($members_id);
            if ($member) {
            // Member info
            $members_email=$member->members_email ?:'-';
            $memberusername = $member->members_username ?:'-';
            $membersCity    = $member->members_city ?: '-';
            $membersState   = $member->members_state ?: '-';
            $membersZip     = $member->members_zip ?: '-';
            $membersAddr    = $member->members_address ?: '-';
            $fee            = $member->fee ?? 0;
            $registerFee    = $member->registerfee ?? 0;
            $totalTaxRate   = max(0, $fee - $registerFee);
            $totalCoupon    = max(0, $member->coupon_discount ?? 0);

            // Country
       if (!empty($member->members_country)) {
            $countryName = Country::where('sortname', $member->members_country)
                ->value('country_master_name') ?? '-';
        } else {
            $countryName = '-';
        }

        // dd($countryName);
            // State
      $stateName = !empty($member->members_state)
            ? State::where('state_id', $member->members_state)->value('state_name') ?? '-'
            : '-';

        // dd($stateName);
            } else {
                // Handle case if member not found
                $membersCity = $membersState = $membersZip = $membersAddr = $countryName = $stateName = '-';
                $totalTaxRate = $totalCoupon = 0;
            }
             $mailLang = session('sitelang_id', 1);
             // 2 Try to fetch invoice template first
            $mailRecord = DB::table($prefix .'_invoicetemplates_table')
                ->where('invoice_status', 1)
                ->where('invoice_lang', $mailLang)
                ->first();

             if (!$mailRecord) {
                    $mailRecord = DB::table($prefix .'_mailtemplates_table')
                        ->where('mail_default_name', 'plan_purchase_mail')
                        ->where('mail_status', 1)
                        ->where('mail_lang', $mailLang)
                        ->first();
                }

                // 4 If still not found, fallback to default language '1'
                if (!$mailRecord) {
                    $mailRecord = DB::table($prefix.'_mailtemplates_table')
                        ->where('mail_default_name', 'plan_purchase_mail')
                        ->where('mail_status', 1)
                        ->where('mail_lang', 1)
                        ->first();
                }

        $matrixDescriptionMsg = MatrixConfiguration::where('matrix_id', $matrix_id)
        ->where('matrix_key', 'matrix_description')
        ->value('matrix_value') ?? '-';
        $message = $mailRecord->mail_content ?? '';
        $replacements = [
            '[name]'           => $memberusername,
            '[planame]'        => $matrix_name,
            '[planprice]'      => $site_currency . $paymenthistory_amount,
            '[plandescription]' => $matrixDescriptionMsg,
            '[address]'        => $membersAddr,
            '[city]'           => $membersCity,
            '[state]'          => $stateName,
            '[country]'        => $countryName,
            '[zipcode]'        => $membersZip,
            '[totalprice]'     => $site_currency . $paymenthistory_amount,
            '[subtotal]'       => $site_currency . ($fee ?? 0),
            '[tax]'            => $site_currency . ($taxRate ?? 0),
            '[coupon]'         => $site_currency . ($totalCoupon ?? 0),
        ];
        $message = str_replace(array_keys($replacements), array_values($replacements), $message);
            MSendMail::send($mailRecord, $members_email, $message, '', '');
           }
        }


        Log::info('redirectMembers() completed successfully');
        return true;
    }
}
