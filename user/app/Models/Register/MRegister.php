<?php
namespace User\App\Models\Register;

use Admin\App\Models\Member\Matrix;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\MemberLinks;
use Admin\App\Models\Member\MatrixConfiguration;
use Admin\App\Models\Middleware\MMatrixDetails;
use Admin\App\Models\Middleware\MMatrixConfiguration;
use Admin\App\Models\Middleware\MMatrixMemberLink;
use Admin\App\Models\Middleware\MPaymentGatewayDetails;
use Admin\App\Models\Middleware\MPackageDetails;
use Admin\App\Models\PaymentConquest\MInsertPaymentHistory;
use Admin\App\Models\PaymentConquest\MPaymentSuccess;
use DB;
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

        Log::info('redirectMembers() completed successfully');
        return true;
    }
}
