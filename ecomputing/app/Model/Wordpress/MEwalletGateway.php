<?php

/**
 * This class contains public functions related to MEwalletGateway
 *
 * @package         MEwalletGateway
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
?><?php
namespace Ecomputing\App\Model\Wordpress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MEwalletGateway
{

    public function checkWalletBalance()
    {
        Log::info('Laravel: checkWalletBalance called', request()->all());
        $prefix = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');

        $apiun   = request('apiusername');
        $apipwd  = request('apipassword');
        $un      = trim(request('username', ''));
        $pwd     = trim(request('password', ''));
        $total   = request('total', 0);
        $orderid = request('orderid', '');
        $transid = 'WPE_' . $orderid;

        // Site settings from DB
        $apiun_db  = DB::table($prefix . '_sitesettings_table')->where('sitesettings_name', 'ewallet-apiusername')->value('sitesettings_value');
        $apipwd_db = DB::table($prefix . '_sitesettings_table')->where('sitesettings_name', 'ewallet-apipassword')->value('sitesettings_value');
        $apista_db = DB::table($prefix . '_sitesettings_table')->where('sitesettings_name', 'ewallet-gateway_status')->value('sitesettings_value');

        if ($apista_db == 1) {
            if ($apiun_db === $apiun && $apipwd_db === $apipwd) {
                $member = DB::table($prefix . '_members_table')
                    ->select('members_id', 'members_transaction_password')
                    ->where('members_username', $un)
                    ->first();

                if ($member && sodium_crypto_pwhash_str_verify(trim($member->members_transaction_password), $pwd)) {
                    $history_wallet_type = '2';
                    $balance_amount = self::getWalletCurrentBalance($member->members_id, $history_wallet_type);

                    if (floatval($balance_amount) >= floatval($total)) {
                        DB::table($prefix . '_history_table')->insert([
                            'history_member_id'    => $member->members_id,
                            'history_type'         => 'ewalletdeducts',
                            'history_description'  => 'E-Wallet Purchase Through Gateway',
                            'history_datetime'     => date('Y-m-d H:i:s'),
                            'history_amount'       => $total,
                            'history_wallet_type'  => '2',
                            'history_transaction_id' => $transid,
                        ]);
                        echo '200'; // Success amount
                        exit;
                    } else {
                        echo '300'; // Insufficient amount
                        exit;
                    }
                } else {
                    echo '404'; // Wrong credentials
                    exit;
                }
            } else {
                echo '400'; // Wrong API
                exit;
            }
        } else {
            echo '500'; // E-Wallet Not authorized
            exit;
        }
    }
    public function getWalletCurrentBalance($user_id, $history_wallet_type)
   {
        $prefix = config('services.ihook.prefix');
        $histTypeTable = $prefix . '_history_type_table';
        $recordshistypebalance = DB::table($histTypeTable)->get();

        $credittype = '1=0';
        $debittype = '1=0';

        if ($recordshistypebalance->isNotEmpty()) {
            $creditarray = [];
            $debitarray = [];
            foreach ($recordshistypebalance as $row) {
                $history_credit_type = $row->history_credit_type;
                $history_debit_type = $row->history_debit_type;
                $history_type_name = $row->history_type_name;
                if ($history_credit_type) {
                    $creditarray[] = "history_type='{$history_type_name}'";
                }
                if ($history_debit_type) {
                    $debitarray[] = "history_type='{$history_type_name}'";
                }
            }
            if (!empty($creditarray)) {
                $credittype = implode(' OR ', $creditarray);
            }
            if (!empty($debitarray)) {
                $debittype = implode(' OR ', $debitarray);
            }
        }

        // Build separate WHERE clauses for credits and debits and compute net balance
        $whereCredit = "WHERE history_member_id='{$user_id}' AND history_wallet_type='{$history_wallet_type}' AND ({$credittype})";
        $whereDebit  = "WHERE history_member_id='{$user_id}' AND history_wallet_type='{$history_wallet_type}' AND ({$debittype})";

        $wallet_credit_amount = $this->getWalletBalanceDetails($whereCredit);
        $wallet_debit_amount  = $this->getWalletBalanceDetails($whereDebit);

        return (float) ($wallet_credit_amount - $wallet_debit_amount);
    }

    public function getWalletBalanceDetails($where)
    {
            $prefix = config('services.ihook.prefix');
            $table = $prefix . '_history_table';

            // Normalize and remove leading WHERE to use whereRaw safely
            $condition = preg_replace('/^\s*WHERE\s+/i', '', trim($where));
            $condition = $condition === '' ? '1=1' : $condition;

            // Use Laravel's query builder to sum the history_amount
            $total = DB::table($table)->whereRaw($condition)->sum('history_amount');

            return (float) ($total ?: 0);
    }


}
