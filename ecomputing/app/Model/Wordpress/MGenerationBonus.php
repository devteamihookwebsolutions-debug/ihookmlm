<?php

/**
 * This class contains public functions related to MGenerationBonus
 *
 * @package         MGenerationBonus
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
use Admin\App\Models\Middleware\MCryptoConverter;
use Illuminate\Support\Facades\DB;

class MGenerationBonus
{

    public function sendGenerationBonus()
    {
        $prefix = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');

        $customerid = trim(request()->input('user_id'));
        $completeddate = trim(request()->input('completeddate'));
        $order_id = trim(request()->input('order_id'));

        // check if already updated
        $recordsordercheck = DB::table($storeprefix . '_postmeta')
            ->where('post_id', $order_id)
            ->where('meta_key', '_paid_date')
            ->where('meta_value', $completeddate)
            ->count();

        if ($recordsordercheck == 1) {
            $matrixIds = DB::table($prefix . '_generation_bonuslinktable')
                ->where('metakey', 'generationalbonus_status')
                ->where('metavalue', '1')
                ->groupBy('matrix_id')
                ->pluck('matrix_id')
                ->toArray();

            if (count($matrixIds) > 0) {
                foreach ($matrixIds as $matrix_id) {
                    $resultarray = [];

                    $gendetail = DB::table($prefix . '_generation_bonuslinktable')
                        ->select('metakey', 'metavalue', 'matrix_id')
                        ->where('matrix_id', $matrix_id)
                        ->get();

                    if ($gendetail && $gendetail->count() > 0) {
                        foreach ($gendetail as $row) {
                            $resultarray[$row->metakey] = $row->metavalue;
                        }
                    }

                    $memberdea = DB::table($prefix . '_members_table')
                        ->where('members_shop_id', $customerid)
                        ->first();

                    if (!$memberdea) {
                        continue;
                    }

                    $membername = $memberdea->members_username ?? null;
                    $member_id = $memberdea->members_id ?? null;

                    $memberlinkdetil = DB::table($prefix . '_matrix_members_link_table')
                        ->select('rankid', 'spillover_id', 'matrix_id')
                        ->where('members_id', $member_id)
                        ->where('matrix_id', $matrix_id)
                        ->first();

                    if (!$memberlinkdetil) {
                        continue;
                    }

                    $spillover_id = $memberlinkdetil->spillover_id;
                    $matrix_id = $memberlinkdetil->matrix_id;
                    $own_rankid = $memberlinkdetil->rankid;

                    $memberlinkdetil_spill = DB::table($prefix . '_matrix_members_link_table')
                        ->select('rankid', 'spillover_id', 'matrix_id')
                        ->where('members_id', $spillover_id)
                        ->where('matrix_id', $matrix_id)
                        ->first();

                    $spill_rankid = $memberlinkdetil_spill->rankid ?? null;

                    // get order total details from postmeta table
                    $order_total = DB::table($storeprefix . '_postmeta')
                        ->where('post_id', $order_id)
                        ->where('meta_key', '_order_total')
                        ->value('meta_value');

                    $owncr = $own_rankid . '_own';
                    $ownpercentage = isset($resultarray[$owncr]) ? $resultarray[$owncr] : 0;
                    $admincr = $own_rankid . '_admin';
                    $adminpercentage = isset($resultarray[$admincr]) ? $resultarray[$admincr] : 0;
                    $spillcr = $own_rankid . '_' . $spill_rankid;
                    $spillpercentage = isset($resultarray[$spillcr]) ? $resultarray[$spillcr] : 0;

                    $methodcommi = $own_rankid . '_method';
                    $comethod = $this->getGenerationsBonusDetails($matrix_id, $methodcommi);

                    if ($comethod == '1') {
                        $commission_amount = ($order_total * ($spillpercentage / 100));
                        $owncommission_amount = ($order_total * ($ownpercentage / 100));
                        $admincommission_amount = ($order_total * ($adminpercentage / 100));
                    } else {
                        $commission_amount = $spillpercentage;
                        $owncommission_amount = $ownpercentage;
                        $admincommission_amount = $adminpercentage;
                    }

                    $wallet = $this->getGenerationsBonusDetails($matrix_id, 'wallet');

                    $memberdetail = DB::table($prefix . '_members_table')
                        ->where('members_id', $member_id)
                        ->first();

                    // currency
                    $cryptocurrency1 = $this->getGenerationsBonusDetails($matrix_id, 'cryptocurrency');
                    $cryptocurrency = '';
                    if ($cryptocurrency1 != '') {
                        $cryptocurrency = DB::table($prefix . '_crypto_currency_and_token')
                            ->where('crypto_currency_id', $cryptocurrency1)
                            ->value('crypto_default_name');
                    }

                    // commission to spillover
                    if ($commission_amount > 0) {
                        $crypto_qty = null;
                        if (!empty($cryptocurrency)) {
                            $btc_crypto_balance = MCryptoConverter::cryptoConverter($cryptocurrency);
                            $cryptovalue = str_replace(',', '', $btc_crypto_balance);
                            if ($cryptovalue != '0' && $cryptovalue !== '') {
                                $crypto_qty = number_format($commission_amount / $cryptovalue, 6, '.', '');
                            } else {
                                $crypto_qty = 0;
                            }
                        }

                        $time = date('y-m-d h');
                        $dec = 'Generationbonus  to membername ' . ($memberdetail->members_username ?? '');

                        $directcount = DB::table($prefix . '_history_table')
                            ->where('history_member_id', $spillover_id)
                            ->where('history_amount', $commission_amount)
                            ->where('history_type', 'generationbonus')
                            ->where('history_description', $dec)
                            ->where('history_matrix_id', $matrix_id)
                            ->where('history_members_ref_id', $member_id)
                            ->whereRaw("DATE_FORMAT(history_datetime,'%y-%m-%d %H') = ?", [$time])
                            ->where('history_wallet_type', $wallet)
                            ->count();

                        if ($directcount == 0) {
                            DB::table($prefix . '_history_table')->insert([
                                'history_member_id' => $spillover_id,
                                'history_amount' => $commission_amount,
                                'history_type' => 'generationbonus',
                                'history_description' => $dec,
                                'history_wallet_type' => $wallet,
                                'history_datetime' => DB::raw('NOW()'),
                                'history_payment' => 0,
                                'history_transaction_id' => '#' . substr(number_format(time() * rand(), 0, '', ''), 0, 9),
                                'history_plan_id' => '0',
                                'history_matrix_id' => $matrix_id,
                                'history_members_ref_id' => $member_id,
                                'history_rank_level' => $own_rankid,
                                'crypto_qty' => $crypto_qty,
                                'currency_id' => $cryptocurrency1
                            ]);
                        }
                    }

                    // own commission
                    if ($owncommission_amount > 0) {
                        $crypto_qty = null;
                        if (!empty($cryptocurrency)) {
                            $btc_crypto_balance = MCryptoConverter::cryptoConverter($cryptocurrency);
                            $cryptovalue = str_replace(',', '', $btc_crypto_balance);
                            if ($cryptovalue != '0' && $cryptovalue !== '') {
                                $crypto_qty = number_format($owncommission_amount / $cryptovalue, 6, '.', '');
                            } else {
                                $crypto_qty = 0;
                            }
                        }

                        $dec1 = 'Generationbonus for own commission to membername ' . ($memberdetail->members_username ?? '');
                        $time = date('y-m-d h');

                        $directcount = DB::table($prefix . '_history_table')
                            ->where('history_member_id', $member_id)
                            ->where('history_amount', $owncommission_amount)
                            ->where('history_type', 'generationbonus')
                            ->where('history_description', $dec1)
                            ->where('history_matrix_id', $matrix_id)
                            ->where('history_members_ref_id', $member_id)
                            ->whereRaw("DATE_FORMAT(history_datetime,'%y-%m-%d %H') = ?", [$time])
                            ->where('history_wallet_type', $wallet)
                            ->where('history_rank_level', $own_rankid)
                            ->count();

                        if ($directcount == 0) {
                            DB::table($prefix . '_history_table')->insert([
                                'history_member_id' => $member_id,
                                'history_amount' => $owncommission_amount,
                                'history_type' => 'generationbonus',
                                'history_description' => $dec1,
                                'history_wallet_type' => $wallet,
                                'history_datetime' => DB::raw('NOW()'),
                                'history_payment' => 0,
                                'history_transaction_id' => '#' . substr(number_format(time() * rand(), 0, '', ''), 0, 9),
                                'history_plan_id' => '0',
                                'history_matrix_id' => $matrix_id,
                                'history_members_ref_id' => $member_id,
                                'history_rank_level' => $own_rankid,
                                'crypto_qty' => $crypto_qty,
                                'currency_id' => $cryptocurrency1
                            ]);
                        }
                    }

                    // admin commission
                    if ($admincommission_amount > 0) {
                        $dec2 = 'Generationbonus for admin commission to membername ' . ($memberdetail->members_username ?? '');
                        $time = date('y-m-d h');

                        $directcount = DB::table($prefix . '_paymenthistory_table')
                            ->where('paymenthistory_member_id', $member_id)
                            ->where('paymenthistory_amount', $admincommission_amount)
                            ->where('paymenthistory_mode', 2)
                            ->where('paymenthistory_status', 'paid')
                            ->where('paymenthistory_type', 'generationbonus')
                            ->whereRaw("DATE_FORMAT(paymenthistory_date,'%y-%m-%d %H') = ?", [$time])
                            ->count();

                        if ($directcount == 0) {
                            DB::table($prefix . '_paymenthistory_table')->insert([
                                'paymenthistory_member_id' => $member_id,
                                'paymenthistory_amount' => $admincommission_amount,
                                'paymenthistory_trans_id' => '#' . substr(number_format(time() * rand(), 0, '', ''), 0, 9),
                                'paymenthistory_mode' => 2,
                                'paymenthistory_date' => DB::raw('NOW()'),
                                'paymenthistory_status' => 'paid',
                                'paymenthistory_type' => 'generationbonus'
                            ]);
                        }
                    }
                }
            }
        }
    }
    /**
     * This public function is used to get generation bonus details
     * @param int $genid
     * @param int $getvaluse
     * @return array $records
     */
    public function getGenerationsBonusDetails($genid, $getvaluse)
    {
        $prefix = config('services.ihook.prefix');

        $record = DB::table($prefix . '_generation_bonuslinktable')
            ->where('matrix_id', $genid)
            ->where('metakey', $getvaluse)
            ->value('metavalue');

        return $record !== null ? $record : '';
    }
}
?>
