<?php

/**
 * This class contains public functions related to MProductLevelCommission
 *
 * @package         MProductLevelCommission
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
namespace Ecomputing\App\Model\Wordpress;
use Admin\App\Models\Middleware\MCryptoConverter;
use Admin\App\Models\Middleware\MMatrixConfiguration;
use Admin\App\Models\Middleware\MMatrixDetails;
use Illuminate\Support\Facades\DB;

class MProductLevelCommission
{

    public static function sendProductLevelCommission()
    {
        $members_shop_id = trim(request()->post('user_id'));
        $order_id        = trim(request()->post('order_id'));
        $amount          = trim(request()->post('amount'));
        $completeddate   = date('Y-m-d');

        $prefix = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');

        // Check if already updated
        $orderCheck = DB::table($storeprefix . '_postmeta')
            ->where('post_id', $order_id)
            ->where('meta_key', '_paid_date')
            ->where('meta_value', $completeddate)
            ->exists();

        if (!$orderCheck) {
            return false;
        }

        // Get member details
        $member = DB::table($prefix . '_members_table')
            ->where('members_shop_id', $members_shop_id)
            ->first();

        if (!$member) {
            return false;
        }

        $members_id       = $member->members_id;
        $members_username = $member->members_username;

        // Get matrix link plan
        $linkplan = DB::table($prefix . '_matrix_members_link_table')
            ->where('members_id', $members_id)
            ->get();

        $largermembercount = 0;
        $largermatrix_id   = 0;

        foreach ($linkplan as $link) {
            $matrix_id = $link->matrix_id;

            $downlinecount = DB::table($prefix . '_matrix_members_link_table')
                ->where('matrix_id', $matrix_id)
                ->whereRaw("FIND_IN_SET(?, members_parents)", [$members_id])
                ->count();

            if ($downlinecount > $largermembercount) {
                $largermembercount = $downlinecount;
                $largermatrix_id   = $matrix_id;
            }
        }

        if ($largermatrix_id <= 0 && isset($matrix_id)) {
            $largermatrix_id = $matrix_id;
        }

        // Get max level
        $maxlevel = DB::table($prefix . '_productlevelcommission_table')
            ->where('matrix_id', $matrix_id)
            ->max('productlevelcommission_line_no');

        $dynamiccompressiondata = MMatrixConfiguration::getMatrixConfigurationDetails($matrix_id, 'product_dynamic_compression_status');
        $dynamic_compression_status = $dynamiccompressiondata[0]['matrix_value'] ?? 0;

        $matrixdetails = MMatrixDetails::getMatrixDetails($matrix_id);
        $matrix_type_id = $matrixdetails['matrix_type_id'] ?? 0;

        $directcheck = ($matrix_type_id == 3 && $dynamic_compression_status != '1') ? 'direct_id' : 'spillover_id';

        self::insertProductLevelCommission(
            $largermatrix_id,
            $members_id,
            1,
            $amount,
            $members_username,
            $maxlevel,
            $dynamic_compression_status,
            $directcheck
        );

        return true;
    }

    public static function insertProductLevelCommission($matrix_id, $members_id, $level, $amount, $members_username, $maxlevel, $dynamic_compression_status, $directcheck)
    {
        $prefix = config('services.ihook.prefix');

        // Get member matrix record
        $matrixRecord = DB::table($prefix . '_matrix_members_link_table')
            ->where('members_id', $members_id)
            ->where('matrix_id', $matrix_id)
            ->first();

        if (!$matrixRecord) {
            return false;
        }

        $spillover_id = $matrixRecord->{$directcheck} ?? 0;
        $members_account_status = $matrixRecord->members_account_status;

        // Get product level commission
        $productLevel = DB::table($prefix . '_productlevelcommission_table')
            ->where('matrix_id', $matrix_id)
            ->where('productlevelcommission_line_no', $level)
            ->where('product_levelcommission_status', '1')
            ->first();

        if (!$productLevel) {
            return false;
        }

        $commission_amt = ($productLevel->productlevelcommission_method == '%')
            ? ($amount * $productLevel->productlevelcommission_amount) / 100
            : $productLevel->productlevelcommission_amount;

        $description = "Product Level {$level} commission has been earned from {$members_username}";

        if ($spillover_id > 0 && $commission_amt > 0 && $members_account_status == '1') {
            // Get cryptocurrency
            $currency_id = $productLevel->currency_id;
            $cryptocurrency = DB::table($prefix . '_crypto_currency_and_token')
                ->where('crypto_currency_id', $currency_id)
                ->value('crypto_default_name');

            $crypto_qty = 0;
            if ($cryptocurrency) {
                $btc_crypto_balance = MCryptoConverter::cryptoConverter($cryptocurrency);
                $cryptovalue = str_replace(',', '', $btc_crypto_balance);
                $crypto_qty = $cryptovalue != '0' ? $commission_amt / $cryptovalue : 0;
                $crypto_qty = number_format($crypto_qty, 6, '.', '');
            }

            // Insert history
            DB::table($prefix . '_history_table')->insert([
                'history_member_id'    => $spillover_id,
                'history_amount'       => $commission_amt,
                'history_type'         => 'productlevelcommission',
                'history_description'  => $description,
                'history_datetime'     => now(),
                'history_payment'      => 0,
                'history_wallet_type'  => $productLevel->productlevelcommission_wallet_type,
                'history_transaction_id'=> '#' . substr(number_format(time() * rand(), 0, '', ''), 0, 9),
                'crypto_qty'           => $crypto_qty,
                'currency_id'          => $currency_id,
            ]);
        }

        // Increase level for next recursive call
        if ($dynamic_compression_status == '1' && $members_account_status == '1') {
            $level++;
        } elseif ($dynamic_compression_status != '1') {
            $level++;
        }

        // Recursive call to the next upline
        if ($spillover_id > 0) {
            self::insertProductLevelCommission($matrix_id, $spillover_id, $level, $amount, $members_username, $maxlevel, $dynamic_compression_status, $directcheck);
        }

        return true;
    }

}
