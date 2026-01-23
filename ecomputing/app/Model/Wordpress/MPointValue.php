<?php

/**
 * This class contains public functions related to MPointValue
 *
 * @package         MPointValue
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
use Illuminate\Support\Facades\DB;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Manager as MongoManager;
class MPointValue
{

    public static function sendProductPV()
    {
        $members_shop_id = trim(request()->post('user_id'));
        $order_id        = trim(request()->post('order_id'));
        $amount          = trim(request()->post('amount'));
        $completeddate   = trim(request()->post('completeddate'));

        $prefix      = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');

        // Check if already updated
        $orderCheck = DB::table($storeprefix . '_postmeta')
            ->where('post_id', $order_id)
            ->where('meta_key', '_paid_date')
            ->first();

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

        // Get matrix link
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

        if ($largermatrix_id <= 0) {
            $largermatrix_id = isset($matrix_id) ? $matrix_id : 0;
        }

        // Get order items
        $orderItems = DB::table($storeprefix . '_woocommerce_order_items')
            ->where('order_id', $order_id)
            ->orderBy('order_item_id', 'asc')
            ->get();

        foreach ($orderItems as $item) {
            if ($item->order_item_type === 'shipping') {
                continue;
            }

            // Get quantity
            $qty = DB::table($storeprefix . '_woocommerce_order_itemmeta')
                ->where('order_item_id', $item->order_item_id)
                ->where('meta_key', '_qty')
                ->value('meta_value');

            // Get product ID
            $product_id = DB::table($storeprefix . '_woocommerce_order_itemmeta')
                ->where('order_item_id', $item->order_item_id)
                ->where('meta_key', '_product_id')
                ->value('meta_value');

            // Get PV point
            $pv = DB::table($storeprefix . '_postmeta')
                ->where('post_id', $product_id)
                ->where('meta_key', '_pv_point')
                ->value('meta_value');

            $tot_pv = self::getproduct_pv($order_id); // Assuming this method exists
            $totalpv = $tot_pv; // Total PV to credit

            if ($totalpv > 0) {
                $description = "PV has been earned from your shop order ID #{$order_id}";
                DB::table($prefix . '_history_table')->insert([
                    'history_member_id' => $members_id,
                    'history_amount'    => $totalpv,
                    'history_type'      => 'pv',
                    'history_description'=> $description,
                    'history_datetime'  => now(),
                    'history_payment'   => 0,
                    'history_order_id'  => $order_id,
                    'history_matrix_id' => $largermatrix_id,
                ]);
            }

            if ($members_id > 0) {
                // MongoDB Update PV
                $bulk = new BulkWrite;
                $bulk->update(
                    ['members_id' => (int)$members_id],
                    ['$inc' => ['PV' => (int)$totalpv]],
                    ['multi' => true, 'upsert' => true]
                );
                $manager = new MongoManager(env('MONGO_DRIVE'));
                $manager->executeBulkWrite(env('MONGO_DBNAME') . 'members', $bulk);
            }

            // Update GPV for upline
            $matrixLink = DB::table($prefix . '_matrix_members_link_table')
                ->where('members_id', $members_id)
                ->where('matrix_id', $largermatrix_id)
                ->first();

            if ($matrixLink && !empty($matrixLink->members_parents)) {
                $parents = array_map('intval', explode(',', $matrixLink->members_parents));

                DB::table($prefix . '_matrix_members_link_table')
                    ->whereIn('members_id', $parents)
                    ->where('matrix_id', $largermatrix_id)
                    ->increment('gpv', $totalpv);

                // MongoDB update GPV
                $bulk_total = new BulkWrite;
                $bulk_total->update(
                    ['members_id' => ['$in' => $parents]],
                    ['$inc' => ['GPV' => (int)$totalpv]],
                    ['multi' => true, 'upsert' => true]
                );
                $manager = new MongoManager(env('MONGO_DRIVE'));
                $manager->executeBulkWrite(env('MONGO_DBNAME') . 'members', $bulk_total);
            }
        }

        return true;
    }



    public static function getproduct_pv($order_id)
    {
        $prefix = config('services.ihook.prefix');

        // Get PV file path from feature_table
        $path = DB::table($prefix . '_feature_table')
            ->where('feature_name', 'pv_file_path')
            ->value('feature_description');

        if (!$path) {
            return 0; // Return 0 if path not found
        }

        // Prepare POST data
        $data = [
            'order_id' => $order_id
        ];

        // cURL request
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => $path,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $data,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSLVERSION     => CURL_SSLVERSION_TLSv1_2,
            CURLOPT_HEADER         => false
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        // Return PV value (assume it's numeric)
        return is_numeric($response) ? (float)$response : 0;
    }

}
