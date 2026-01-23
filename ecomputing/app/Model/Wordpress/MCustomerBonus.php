<?php

/**
 * This class contains public functions related to MCustomerBonus
 *
 * @package         MCustomerBonus
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

class MCustomerBonus
{
    public function sendCustomerBonus($customers_shop_id, $order_id, $amount)
    {
        // Laravel config prefixes
        $prefix = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');

        // completed date — prefer request input (was from $_POST in original)
        $completeddate = request()->input('completeddate');

        // get customer
        $customer = DB::table($prefix . '_customers')
            ->where('customers_shop_id', $customers_shop_id)
            ->first();

        if (! $customer) {
            return;
        }

        $customers_id = $customer->customers_id;
        $customers_username = $customer->customers_username;
        $customers_sponsor_id = $customer->customers_sponsor_id;

        // load meta fields
        $metaRows = DB::table($prefix . '_customerbonus_meta')->get();

        // initialize variables to avoid undefined notices
        $cab_bonus_name = $cab_bonus_percentage = $cab_bonus_percentage_type = $cab_bonus_status = $cab_bonus_wallet_type = null;
        $retail_commission_name = $retail_commission_percenatge = $retail_commission_percentage_type = $retail_commission_status = $retail_commission_wallet_type = null;

        foreach ($metaRows as $row) {
            switch ($row->meta_key) {
                case 'cab_bonus_name':
                    $cab_bonus_name = $row->meta_value;
                    break;
                case 'cab_bonus_percentage':
                    $cab_bonus_percentage = $row->meta_value;
                    break;
                case 'cab_bonus_percentage_type':
                    $cab_bonus_percentage_type = $row->meta_value;
                    break;
                case 'cab_bonus_status':
                    $cab_bonus_status = $row->meta_value;
                    break;
                case 'cab_bonus_wallet_type':
                    $cab_bonus_wallet_type = $row->meta_value;
                    break;
                case 'retail_commission_name':
                    $retail_commission_name = $row->meta_value;
                    break;
                case 'retail_commission_percenatge':
                    $retail_commission_percenatge = $row->meta_value;
                    break;
                case 'retail_commission_percentage_type':
                    $retail_commission_percentage_type = $row->meta_value;
                    break;
                case 'retail_commission_status':
                    $retail_commission_status = $row->meta_value;
                    break;
                case 'retail_commission_wallet_type':
                    $retail_commission_wallet_type = $row->meta_value;
                    break;
            }
        }

        // check if order has the paid date (matches original logic)
        $recordsordercheck = 0;
        if ($completeddate !== null) {
            $recordsordercheck = DB::table($storeprefix . '_postmeta')
                ->where('post_id', $order_id)
                ->where('meta_key', '_paid_date')
                ->where('meta_value', $completeddate)
                ->count();
        }

        // Customer Acquisition Bonus (CAB)
        if ($cab_bonus_status == '1' && $recordsordercheck == 1) {
            $customerOrdersCount = DB::table($storeprefix . '_postmeta')
                ->where('meta_key', '_customer_user')
                ->where('meta_value', $customers_shop_id)
                ->count();

            if ($customerOrdersCount == 1) { // first sale
                if ($cab_bonus_percentage_type === '%') {
                    $commission_amt = $amount * ((float) $cab_bonus_percentage / 100);
                } else {
                    $commission_amt = (float) $cab_bonus_percentage;
                }

                $history_description = ($cab_bonus_name ?? 'CAB') . ' - bonus earned from ' . $customers_username . ' Order ID #' . $order_id;
                $history_type = 'customer_acquisition_bonus';
                $history_wallet_type = $cab_bonus_wallet_type;
                $transaction_id = '#' . substr(number_format(time() * rand(), 0, '', ''), 0, 9);

                DB::table($prefix . '_history_table')->insert([
                    'history_member_id' => $customers_sponsor_id,
                    'history_customers_ref_id' => $customers_id,
                    'history_amount' => $commission_amt,
                    'history_type' => $history_type,
                    'history_description' => $history_description,
                    'history_datetime' => DB::raw('NOW()'),
                    'history_transaction_id' => $transaction_id,
                    'history_wallet_type' => $history_wallet_type,
                    'history_order_id' => $order_id,
                ]);
            }
        }

        // Retail commission
        if ($retail_commission_status == '1' && $recordsordercheck == 1) {
            if ($retail_commission_percentage_type === '%') {
                $commission_amt = $amount * ((float) $retail_commission_percenatge / 100);
            } else {
                $commission_amt = (float) $retail_commission_percenatge;
            }

            $history_description = ($retail_commission_name ?? 'Retail Commission') . ' - commission earned from ' . $customers_username . ' Order ID #' . $order_id;
            $history_type = 'customer_retail_commission';
            $history_wallet_type = $retail_commission_wallet_type;
            $transaction_id = '#' . substr(number_format(time() * rand(), 0, '', ''), 0, 9);

            DB::table($prefix . '_history_table')->insert([
                'history_member_id' => $customers_sponsor_id,
                'history_customers_ref_id' => $customers_id,
                'history_amount' => $commission_amt,
                'history_type' => $history_type,
                'history_description' => $history_description,
                'history_datetime' => DB::raw('NOW()'),
                'history_transaction_id' => $transaction_id,
                'history_wallet_type' => $history_wallet_type,
                'history_order_id' => $order_id,
            ]);
        }
    }

}
