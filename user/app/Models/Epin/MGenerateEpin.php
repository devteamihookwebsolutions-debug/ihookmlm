<?php

namespace User\App\Models\Epin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Admin\App\Models\Middleware\MMemberDetails;

class MGenerateEpin
{
    public static function insertCreatedRequestEpin($request)
        {
            Log::info('E-Pin Generation Started', $request->all());

            // Fix 1: Get prefix properly
            $prefix = env('IHOOK_PREFIX');
            if (empty($prefix)) {
                Log::error('IHOOK_PREFIX not set in .env');
                Session::flash('error_message', 'System configuration error. Contact admin.');
                return false;
            }

            Log::info('Using DB Prefix: ' . $prefix);

            $reg_fee = $request->input('epin_amount_package') ?: $request->input('epin_amount');
            $reg_fee = trim($reg_fee);

            if (empty($reg_fee) || !is_numeric($reg_fee) || $reg_fee <= 0) {
                Log::warning('Invalid epin amount', ['amount' => $reg_fee]);
                Session::flash('error_message', 'Invalid E-Pin amount.');
                return false;
            }

            $user = Auth::user();
            $user_id = $user->members_id;
            $epin_count = (int)$request->epin_count;

            if ($epin_count <= 0 || $epin_count > 1000) {
                Session::flash('error_message', 'Invalid E-Pin count.');
                return false;
            }

            $wallet_type = $request->has('wallet_type') ? 1 : 2;

            $type_parts = explode(',', $request->epin_type);
            $package_id = $type_parts[0] ?? 0;
            $matrix_id  = $type_parts[1] ?? 0;
    // dd($matrix_id);
            if ($package_id === '100000000000001') {
                // E-Wallet Topup
                $epin_package   = 0;
                $epin_matrix_id = 0;
            } else {
                $epin_package   = $package_id;
                $epin_matrix_id = $matrix_id;
            }

            $total_amount = $epin_count * $reg_fee;

            $userDetails = MMemberDetails::getUserDetails($user_id);
            $request_epin_to_member_id = $userDetails['members_related_area_franchise_id']
                ?? $userDetails['members_related_district_franchise_id']
                ?? $user_id;

            Log::info('E-Pin Data Prepared', [
                'user_id' => $user_id,
                'count' => $epin_count,
                'amount_each' => $reg_fee,
                'total' => $total_amount,
                'package' => $epin_package,
                'matrix' => $epin_matrix_id,
                'wallet_type' => $wallet_type,
            ]);

            DB::beginTransaction();

            try {
                // 1. Insert Request
                $request_id = DB::table("{$prefix}_request_epin_table")->insertGetId([
                    'request_epin_member_id'     => $user_id,
                    'request_epin_count'         => $epin_count,
                    'request_epin_amount'        => $reg_fee,
                    'request_epin_date'          => now(),
                    'request_epin_package'       => $epin_package,
                    'request_epin_matrix_id'     => $epin_matrix_id,
                    'request_epin_status'        => 0,
                    'request_epin_to_member_id'  => $request_epin_to_member_id,
                    'request_epin_code'          => '',
                ]);

                Log::info('Request inserted', ['request_id' => $request_id]);

                // 2. Deduct Wallet
                $trx = '#' . substr(str_shuffle('0123456789'), 0, 9);

                $history_id = DB::table("{$prefix}_history_table")->insertGetId([
                    'history_member_id'       => $user_id,
                    'history_amount'          => $total_amount,
                    'history_type'            => 'epinpurchasededuct',
                    'history_description'     => 'E-Pin Generation',
                    'history_datetime'        => now(),
                    'history_payment'         => 0,
                    'history_plan_id'         => $request_id,
                    'history_transaction_id'  => $trx,
                    'history_wallet_type'     => $wallet_type,
                    'currency_id'             => 1,
                ]);

                Log::info('Wallet deducted', ['trx' => $trx, 'amount' => $total_amount, 'history_id' => $history_id]);

                Log::info('Wallet deducted', ['trx' => $trx, 'amount' => $total_amount]);

                // 3. Generate E-Pins
                $chars = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
                $generated = [];

                for ($i = 0; $i < $epin_count; $i++) {
                    $code = substr(str_shuffle($chars), 0, 10);

                DB::table("{$prefix}_epin_table")->insert([
                        'epin_member_id'   => $user_id,
                        'epin_user_id'     => $user_id,
                        'epin_code'        => $code,
                        'epin_amount'      => $reg_fee,
                        'epin_date'        => now(),
                        'epin_package'     => $epin_package,
                        'epin_matrix_id'   => $epin_matrix_id,
                        'epin_status'      => 0,
                        'payment_history_id' => $history_id,
                        'epin_used_date'     =>now(),
                    ]);

                    $generated[] = $code;
                }

                DB::commit();

                Log::info('E-Pins Generated Successfully', ['codes' => $generated]);

                Session::flash('success_message', "$epin_count E-Pins generated successfully!");
                return true;

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('E-PIN GENERATION FAILED', [
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);

                Session::flash('error_message', 'Failed to generate E-Pins. Check logs.');
                return false;
            }
    }

    public static function getPackageAmount($packageId, $typeId)
    {
        $prefix = env('IHOOK_PREFIX');

        if ($typeId == '1') {
            return DB::table("{$prefix}_package_table")
                ->where('package_id', $packageId)
                ->value('package_price') ?? 0;
        }

        $config = DB::table("{$prefix}_matrix_configuration_table")
            ->where('matrix_id', $packageId)
            ->where('matrix_key', 'registration_fee')
            ->value('matrix_value');

        return $config ?? 0;
    }
}
