<?php

namespace Admin\App\Models\PaymentConquest;

use Admin\App\Models\Member\PaymentHistory;
use Admin\App\Models\Member\Matrix;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\MemberLinks;
use Admin\App\Models\Member\MatrixConfiguration;
use Admin\App\Models\PaymentConquest\MMembersMatrixLevelComplete;
use Admin\App\Models\Middleware\MMatrixConfiguration;
use Admin\App\Models\PaymentConquest\MPackageRegisterSuccess;
use Admin\App\Models\PaymentConquest\MOneTimeRegisterSuccess;
use Admin\App\Models\PaymentConquest\MInstantBinary;

use DB;
use Illuminate\Support\Facades\Log;
use DateTime;

class MPaymentSuccess
{
    public static function afterPaymentSuccesssCommission(
        $members_id,
        $matrix_id,
        $members_subscription_plan,
        $paymenthistory_mode,
        $paymenthistory_type,
        $paymenthistory_amount,
        $package_price,
        $paymenthistory_id,
        $transaction_id,
        $matrix_type_id,
        $matrix_name,
        $payment_amt_exclusive
        ) {

        Log::info('[PaymentSuccess] START', [
            'members_id' => $members_id,
            'matrix_id' => $matrix_id,
            'paymenthistory_id' => $paymenthistory_id,
            'matrix_type_id' => $matrix_type_id,
            'payment_amt_exclusive' => $payment_amt_exclusive,
        ]);

        if ($paymenthistory_id <= 0) {
            Log::warning('[PaymentSuccess] Invalid paymenthistory_id', ['paymenthistory_id' => $paymenthistory_id]);
            return true;
        }

        // Update payment status
        $payment = PaymentHistory::find($paymenthistory_id);
        if (!$payment) {
            Log::error('[PaymentSuccess] PaymentHistory not found', ['paymenthistory_id' => $paymenthistory_id]);
            return true;
        }

        $payment->paymenthistory_status = 'paid';
        $payment->save();

        Log::info('[PaymentSuccess] Payment status updated to PAID', [
            'paymenthistory_id' => $paymenthistory_id,
            'transaction_id' => $transaction_id
        ]);

        // Update matrix member link
        $matrixLink = MemberLinks::where('members_id', $members_id)
            ->where('matrix_id', $matrix_id)
            ->first();

        if (!$matrixLink) {
            Log::error('[PaymentSuccess] MemberLinks not found', [
                'members_id' => $members_id,
                'matrix_id' => $matrix_id
            ]);
            return true;
        }

        Log::info('[PaymentSuccess] MemberLinks found', [
            'link_id' => $matrixLink->link_id,
            'direct_id' => $matrixLink->direct_id,
            'spillover_id' => $matrixLink->spillover_id
        ]);

        // Update member link status
        $matrixUpdate = MemberLinks::find($matrixLink->link_id);
        $matrixUpdate->members_account_status = 1;
        $matrixUpdate->members_status = 1;
        $matrixUpdate->members_subscription_status = 1;
        $matrixUpdate->save();

        Log::info('[PaymentSuccess] MemberLinks status activated', ['link_id' => $matrixLink->link_id]);

        // Fetch member info
        $member = Member::find($matrixLink->members_id);
        if (!$member) {
            Log::error('[PaymentSuccess] Member not found', ['members_id' => $members_id]);
            return true;
        }

        $memberName   = $member->members_username;
        $direct_id    = $matrixLink->direct_id;
        $spillover_id = $matrixLink->spillover_id ?? 0;
        $moduletype   = $matrixLink->moduletype;

        if ($spillover_id == '') $spillover_id = 0;

        Log::info('[PaymentSuccess] Member details loaded', [
            'members_id' => $members_id,
            'username' => $memberName,
            'direct_id' => $direct_id,
            'spillover_id' => $spillover_id,
            'moduletype' => $moduletype
        ]);

        // Default leg of direct upline
        $directLink = MemberLinks::where('members_id', $direct_id)->first();
        $default_leg = $directLink?->default_leg ?? 0;

        Log::info('[PaymentSuccess] Direct upline default_leg', [
            'direct_id' => $direct_id,
            'default_leg' => $default_leg
        ]);

        // Get entry criteria
        $entry_criteria_data = MMatrixConfiguration::getMatrixConfigurationDetails($matrix_id, 'members_account_type');
        $entry_criteria = $entry_criteria_data[0]['matrix_value'] ?? null;

        Log::info('[PaymentSuccess] Entry criteria fetched', [
            'matrix_id' => $matrix_id,
            'entry_criteria' => $entry_criteria
        ]);

        // Check level completion
        $levelcompletecheck = MMembersMatrixLevelComplete::checkLevelComp($members_id, $matrix_id);

        Log::info('[PaymentSuccess] Level completion check', [
            'members_id' => $members_id,
            'matrix_id' => $matrix_id,
            'level_complete' => $levelcompletecheck
        ]);

        if ($levelcompletecheck != '1') {
            Log::info('[PaymentSuccess] Level NOT completed yet. Skipping commissions.', [
                'members_id' => $members_id,
                'matrix_id' => $matrix_id
            ]);
            return true;
        }

        Log::info('[PaymentSuccess] Level COMPLETED. Proceeding with commissions.', [
            'members_id' => $members_id,
            'matrix_id' => $matrix_id
        ]);

        // Set spillover logic
        if ($matrix_type_id != 6 && $spillover_id == 0 && $direct_id > 0) {
            Log::info('[PaymentSuccess] Spillover condition met. Applying spillover.', [
                'matrix_type_id' => $matrix_type_id,
                'default_leg' => $default_leg
            ]);

            if ($default_leg == 5 && ($matrix_type_id == 1 || $matrix_type_id == 2)) {
                Log::info('[PaymentSuccess] Calling setSpillover (default_leg 5)', compact('members_id', 'direct_id', 'matrix_id', 'matrix_type_id'));
                MSpillover::setSpillover($members_id, $direct_id, $matrix_id, $matrix_type_id);
            } elseif ($default_leg == 0 && $matrix_type_id == 3) {
                Log::info('[PaymentSuccess] Calling setSpillover (matrix_type 3)', compact('members_id', 'direct_id', 'matrix_id', 'matrix_type_id'));
                MSpillover::setSpillover($members_id, $direct_id, $matrix_id, $matrix_type_id);
            } else {
                Log::info('[PaymentSuccess] Calling setSpilloverbyLeg', [
                    'members_id', 'direct_id', 'matrix_id', 'matrix_type_id', 'default_leg'
                ]);
                MSpillover::setSpilloverByLeg($members_id, $direct_id, $matrix_id, $matrix_type_id, $default_leg, $spillover_id);
            }
        } else {
            Log::info('[PaymentSuccess] Spillover NOT applied', [
                'matrix_type_id' => $matrix_type_id,
                'spillover_id' => $spillover_id,
                'direct_id' => $direct_id
            ]);
        }
        $membersPaidAccountType = DB::table('ihook_matrix_configuration_table')
            ->where('matrix_key', 'members_paid_account_type')
            ->value('matrix_value');

        $membersPaidAccountType = $membersPaidAccountType == '1' ? 1 : 0;
        $selectedPackageId = $payment->paymenthistory_package_id ?? 0;

        Log::info('[PaymentSuccess] Registration Type Detection', [
            'members_paid_account_type' => $membersPaidAccountType,
            'selected_package_id' => $selectedPackageId,
            'payment_amount' => $payment_amt_exclusive
        ]);

        if ($membersPaidAccountType == 0 && $selectedPackageId == 0) {
            // FREE / ONE TIME REGISTRATION
            Log::info('[PaymentSuccess] Triggering ONE TIME Registration Commissions (Free)');
            MOneTimeRegisterSuccess::oneTimeRegisterSuccess(
                $members_id,
                $direct_id,
                $matrix_id,
                1,
                $payment_amt_exclusive,
                $memberName,
                $matrix_type_id
            );

            } else {
                // Package Based Registration (Paid packages mode)
                Log::info('[PaymentSuccess] Package Registration Commission Triggered', [
                    'members_id'                => $members_id,
                    'direct_id'                 => $direct_id,
                    'matrix_id'                 => $matrix_id,
                    'payment_amt_exclusive'     => $payment_amt_exclusive,
                    'members_subscription_plan' => $members_subscription_plan,
                    'memberName'                => $memberName,
                    'matrix_type_id'            => $matrix_type_id,
                    'members_paid_account_type' => $membersPaidAccountType
                ]);

                MPackageRegisterSuccess::packageRegisterSuccess(
                    $members_id,
                    $direct_id,
                    $matrix_id,
                    $entry_criteria ?? 2,
                    $payment_amt_exclusive,
                    $members_subscription_plan,
                    $memberName,
                    $matrix_type_id
                );
            }
        if ($matrix_type_id == 1) {
            Log::info('[PaymentSuccess] Binary Matrix - Instant Binary Commission', [
                'parents' => $matrixLink->members_parents,
                'members_id' => $members_id,
                'matrix_id' => $matrix_id,
                'amount' => $payment_amt_exclusive
            ]);
            MInstantBinary::binarySplitFun($matrixLink->members_parents, $members_id, $matrix_id, $payment_amt_exclusive, $memberName);
        }

        Log::info('[PaymentSuccess] Triggering Joining Commission', [
            'members_id' => $members_id,
            'matrix_id' => $matrix_id,
            'amount' => $payment_amt_exclusive
        ]);
        MJoiningCommission::sentJoiningCommission($members_id, $matrix_id, $payment_amt_exclusive);

        Log::info('[PaymentSuccess] ALL COMMISSIONS PROCESSED SUCCESSFULLY', [
            'members_id' => $members_id,
            'matrix_id' => $matrix_id,
            'paymenthistory_id' => $paymenthistory_id
        ]);

        return true;
    }
}
