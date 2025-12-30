<?php

namespace Admin\App\Models\PaymentConquest;

use Admin\App\Models\Member\MemberLinks;
use Admin\App\Models\Member\History;
use Admin\App\Models\Middleware\MCryptoExchange;
use Admin\App\Models\Middleware\MMatrixConfiguration;
use Admin\App\Models\Middleware\MPackageDetails;
use Admin\App\Models\Middleware\MFormatNumber;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MSentDirectCommissionSuccess
{
    /**
     * Send Direct Referral Commission (Laravel + Eloquent Version)
     *
     * @param int $member_id          → New registered member
     * @param int $direct_id          → Sponsor (upline)
     * @param int $matrix_id
     * @param string $entry_criteria  → '1' = one-time, else = package based
     * @param float $paymenthistory_amount
     * @param int $package_id
     * @param string $membername
     * @return bool
     */
    public static function sentDirectCommission(
        $member_id,
        $direct_id,
        $matrix_id,
        $entry_criteria,
        $paymenthistory_amount,
        $finalCommissionAmount,
        $package_id,
        $membername
    ) {
        // Ensure amount is float
        $paymentAmount = (float) $paymenthistory_amount;

        $commissionValue = 0.0;
        $commissionType  = 'flat'; // 'flat' or '%'
        $walletType      = 1;
        $cryptoCurrencyId = null;
        $cryptoQty       = 0;

        try {
            if ($entry_criteria == '1') {
                $type = MMatrixConfiguration::getMatrixConfigurationDetails($matrix_id, 'direct_referrel_commission_type');
                $value = MMatrixConfiguration::getMatrixConfigurationDetails($matrix_id, 'direct_referrel_commission');
                $wallet = MMatrixConfiguration::getMatrixConfigurationDetails($matrix_id, 'direct_referrel_commission_wallet_type');
                $cryptoCurrencyId = MMatrixConfiguration::getMatrixConfigurationDetails($matrix_id, 'cryptocurrency');

                $commissionType = ($type === '1' || $type === '%') ? '%' : 'flat';
                $commissionValue = (float) preg_replace('/[^0-9.]/', '', $value ?? '0');
                $walletType = ($wallet == '1') ? 1 : 2;

            } else {
                // Package-based commission
                    $package = MPackageDetails::getParamPackageDetails('*', [
                        'package_id' => $package_id,
                        'matrix_id'  => $matrix_id
                    ]);

                if (!$package) {
                    Log::info('Direct Commission: Trying without matrix_id filter', ['package_id' => $package_id]);
                    $package = MPackageDetails::getParamPackageDetails('*', [
                        'package_id' => $package_id
                    ]);
                }

                if (!$package) {
                    Log::warning('Direct Commission: Package really not found', [
                        'package_id' => $package_id,
                        'matrix_id'  => $matrix_id
                    ]);
                    return false;
                }

                $rawValue = $package->package_direct_commission ?? 0;
                $commissionValue = (float) preg_replace('/[^0-9.]/', '', (string)$rawValue);
                $commissionType = ($package->package_direct_commission_method === '%') ? '%' : 'flat';
                $walletType = (int) ($package->package_direct_commission_wallet_type ?? 1);
                $cryptoCurrencyId = $package->crypto_currency_id ?? null;
            }

                $baseAmount = $paymentAmount;

                if ($entry_criteria == '1') {
                    if ($commissionType === '%') {
                        $finalCommission = $paymentAmount * ($commissionValue / 100);
                    } else {
                        $finalCommission = $commissionValue;
                    }
                } else {
                    if ($commissionType === '%') {
                        $finalCommission = $paymentAmount * ($commissionValue / 100);
                    } else {
                        $finalCommission = $commissionValue;
                    }
                }

                $finalCommission = round($finalCommission, 8);

                if ($finalCommissionAmount > 0) {
                    $finalCommission = (float) $finalCommissionAmount;
                }


            if (!empty($cryptoCurrencyId)) {
                $cryptoQty = MCryptoExchange::cryptoExchange($cryptoCurrencyId);
            }

            // Check if sponsor is active in this matrix
            $isActive = MemberLinks::where('members_id', $direct_id)
                ->where('matrix_id', $matrix_id)
                ->where('members_account_status', 1)
                ->exists();

            if (!$isActive) {
                Log::info('Direct Commission: Sponsor not active in matrix', ['direct_id' => $direct_id]);
                return false;
            }


            History::insert([
                    'history_member_id'       => $direct_id,
                    'history_amount'          => MFormatNumber::cleanForDatabase($finalCommission), // 100% safe!
                    'history_type'            => 'directcommission' ,
                    'history_description'     => "Direct referral commission has been earned by referring {$membername}",
                    'history_datetime'        => now(),
                    'history_payment'         => 0,
                    'history_wallet_type'     => $walletType,
                    'history_matrix_id'       => $matrix_id,
                    'history_members_ref_id'  => $member_id,
                    'history_transaction_id'  => '#' . strtoupper(Str::random(9)), // 10 chars max!
                    'crypto_qty'              => $cryptoQty,
                    'currency_id'             => $cryptoCurrencyId ? (int)$cryptoCurrencyId : null,
            ]);

            Log::info('Direct Commission Successfully Credited', [
                'to_member'    => $direct_id,
                'from_member'  => $member_id,
                'amount'       => $finalCommission,
                'package_id'   => $package_id,
                'matrix_id'    => $matrix_id
            ]);

            return true;

        } catch (Exception $e) {
            Log::error('Direct Commission Failed', [
                'error'      => $e->getMessage(),
                'member_id'  => $member_id,
                'direct_id'  => $direct_id,
                'package_id' => $package_id,
                'trace'      => $e->getTraceAsString()
            ]);
            return false;
        }
    }
}
