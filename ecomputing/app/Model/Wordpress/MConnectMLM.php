<?php

/**
 * This class contains public functions related to MConnectMLM
 *
 * @package         MConnectMLM
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

use Admin\App\Models\CustomerManager\MInsertCustomerDetails;
use Admin\App\Models\Middleware\MCryptoGraphy;
use Admin\App\Models\Middleware\MMatrixConfiguration;
use Admin\App\Models\Middleware\MMatrixDetails;
use Illuminate\Support\Facades\DB;
use User\App\Models\Middleware\MCheckTrigger;

class MConnectMLM
{
    /**
     * This public function is used  to create new tables
     * @param array $recods
     *
     */
    public static function wpGetOrders()
    {
        $prefix = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');
        $data = json_decode($_POST['data'], true);

        $productData = json_decode($_POST['productData'], true);
        $metaData = json_decode($_POST['metaData'], true);
        $postmeta = json_decode($_POST['postmeta'], true);
        $resultorderitems = json_decode($_POST['resultorderitems'], true);
        $resultordermeta = json_decode($_POST['resultordermeta'], true);
        $allposts = json_decode($_POST['postsall'], true);
        $referral_rep_id = $_POST['sponsor'];
        $referral_url = $_POST['direct_url'];
        $partyid = $_POST['party_id'];
        $order_user_email = $_POST['order_user_email'];
        $customer_user_id = 0;
        $sponsor_members_shop_id = 0;
        $sponsor_members_shop_id = 0;
        $members_shop_id = 0;
        $order_id = $data['id']; // Order ID

        //personal order shop id check
        $members_email = trim($data['billing']['email']);

        $validate_rec_row = DB::table($prefix . '_members_table')
            ->where('members_email', $members_email)
            ->orderBy('members_id', 'desc')
            ->first();

        $validate_rec = $validate_rec_row ? [(array) $validate_rec_row] : [];

        if (!empty($validate_rec) && $validate_rec[0]['members_shop_id'] > 0) {
            $members_shop_id = $validate_rec[0]['members_shop_id'];
        } else {

            $validate_rec = DB::table($prefix.'_customers')
                ->where('customers_email', $members_email)
                ->orderBy('customers_id', 'desc')
                ->first();

            if ($validate_rec && !empty($validate_rec->customers_shop_id) && $validate_rec->customers_shop_id > 0) {
                $customers_shop_id = $validate_rec->customers_shop_id;

            } else {

                if ($sponsor_members_shop_id == 0) {
                    $matrixDetails = new MMatrixDetails();
                    // call as instance and pass conditions as an array (method expects array)
                    $defaultmatrixdetails = $matrixDetails->getWhereMatrixDetails([
                        'where' => 'matrix_default="1" AND matrix_status="1"'
                    ]);
                    $ddefaultmatrixid       = $defaultmatrixdetails[0]['matrix_id'];
                    //get from matrix configuration
                    $defaultmatrixmemberstatus = MMatrixConfiguration::getMatrixConfigurationDetails($ddefaultmatrixid, 'default_sponsor');
                    $customer_sponsor_id          = $defaultmatrixmemberstatus[0]['matrix_value'];
                } else {
                    $customer_sponsor_id = $sponsor_members_shop_id;
                }

                // Create customer here
                $billing_data = $data['billing'];
                $shipping_data = $data['shipping'];
                $customers_username       = $billing_data['email']; // or generate username logic
                $customers_password       = substr(md5(time()), 0, 8); // example
                $customers_firstname      = $billing_data['first_name'];
                $customers_lastname       = $billing_data['last_name'];
                $customers_email          = $billing_data['email'];
                $customers_alternate_email = ''; // if available
                $customers_phone          = $billing_data['phone'];
                $customers_ip_address     = $_SERVER['REMOTE_ADDR'] ?? '';
                $customers_address        = $billing_data['address_1'];
                $customers_address2       = $billing_data['address_2'];
                $customers_address3       = ''; // optional
                $customers_city           = $billing_data['city'];
                $customers_state          = $billing_data['state'];
                $customers_zip            = $billing_data['postcode'];
                $customers_country        = $billing_data['country'];
                $customers_image          = '';
                $customers_thumb_image    = '';
                $customers_lang           = 'en';
                $customers_shop_id        = 0; // or dynamic
                $sponsor_id               = $customer_sponsor_id; // or get from referral
                $customers_shopify_id     = ''; // if relevant
                $shipname     = $shipping_data['first_name'] . ' ' . $shipping_data['last_name'];
                $shipaddress  = $shipping_data['address_1'];
                $shipaddress2 = $shipping_data['address_2'];
                $shipaddress3 = '';
                $shipcountry  = $shipping_data['country'];
                $shipstate    = $shipping_data['state'];
                $shipcity     = $shipping_data['city'];
                $shipzipcode  = $shipping_data['postcode'];
                $shipphone    = $shipping_data['phone'];

                //start: insert in userdetails
                $customers_password_crypt = MCryptoGraphy::encryptionData($customers_password);
                $customer_user_id = MInsertCustomerDetails::insertCustomerDetails($customers_username, $customers_password_crypt, $customers_email, $customers_ip_address, $customers_firstname, $customers_lastname, $customers_state, $customers_city, $customers_address, $customers_address2, $customers_address3, $customers_phone, $customers_zip, $customers_country, $customers_alternate_email, $customers_password, $sponsor_id, $shipname, $shipaddress, $shipaddress2, $shipaddress3, $shipcountry, $shipstate, $shipcity, $shipzipcode, $shipphone);
                //end: insert in userdetails

                // Run insert and get the inserted ID
            }
        }

        //personal order shop id check


        // Sponsor check start
        if (isset($_POST['sponsor'])) {
            $members_subdomain = $_ENV['CARTBASEPATH'].'/'.$referral_rep_id;

            $getdirect_rec_row = DB::table($prefix.'_members_table')
                ->where('members_subdomain', $members_subdomain)
                ->first();
            $getdirect_rec = $getdirect_rec_row ? [(array) $getdirect_rec_row] : [];
            // Check if a record is found before accessing index 0
            $sponsor_members_shop_id = $getdirect_rec[0]['members_shop_id'];
        }


        for ($i = 0; $i < count((array)$allposts); $i++) {
            $postID = $allposts[$i]['ID'];

            // Check if post already exists (Laravel DB)
            $count = DB::table($storeprefix . '_posts')->where('ID', $postID)->count();

            if ($count == 0) {
                $row = $allposts[$i];

                DB::table($storeprefix . '_posts')->insert([
                    'ID'                      => $row['ID'] ?? null,
                    'post_author'             => $row['post_author'] ?? null,
                    'post_date'               => $row['post_date'] ?? null,
                    'post_date_gmt'           => $row['post_date_gmt'] ?? null,
                    'post_content'            => $row['post_content'] ?? null,
                    'post_title'              => $row['post_title'] ?? null,
                    'post_excerpt'            => $row['post_excerpt'] ?? null,
                    'post_status'             => $row['post_status'] ?? null,
                    'comment_status'          => $row['comment_status'] ?? null,
                    'ping_status'             => $row['ping_status'] ?? null,
                    'post_password'           => $row['post_password'] ?? null,
                    'post_name'               => $row['post_name'] ?? null,
                    'to_ping'                 => $row['to_ping'] ?? null,
                    'pinged'                  => $row['pinged'] ?? null,
                    'post_modified'           => $row['post_modified'] ?? null,
                    'post_modified_gmt'       => $row['post_modified_gmt'] ?? null,
                    'post_content_filtered'   => $row['post_content_filtered'] ?? null,
                    'post_parent'             => $row['post_parent'] ?? null,
                    'guid'                    => $row['guid'] ?? null,
                    'menu_order'              => $row['menu_order'] ?? 0,
                    'post_type'               => $row['post_type'] ?? null,
                    'post_mime_type'          => $row['post_mime_type'] ?? null,
                    'comment_count'           => $row['comment_count'] ?? 0,
                    'customer_user_id'        => $customer_user_id,
                    'members_shop_id'         => $members_shop_id,
                    'sponsor_members_shop_id' => $sponsor_members_shop_id,
                ]);
            }
        }

        $timestamp = strtotime($data['date_created']['date']);
        $title = date("F j, Y, g:i a", $timestamp);

        $dbName = DB::connection()->getDatabaseName();
        $storeDbPrefix = $dbName . '.' . $storeprefix;

        // check existing order post
        $postTable = $storeDbPrefix . '_posts';
        $postmetaTable = $storeDbPrefix . '_postmeta';
        $orderItemsTable = $storeDbPrefix . '_woocommerce_order_items';
        $orderItemmetaTable = $storeDbPrefix . '_woocommerce_order_itemmeta';

        $existingPost = DB::table($postTable)->where('ID', $data['id'])->first();

        if ($existingPost) {
            // update post
            DB::table($postTable)->where('ID', $data['id'])->update([
            'post_author'           => 1,
            'post_date'             => $data['date_created']['date'],
            'post_date_gmt'         => $data['date_created']['date'],
            'post_content'          => '',
            'post_title'            => 'Order &ndash; ' . $title,
            'post_excerpt'          => $data['customer_note'],
            'post_status'           => 'wc-' . $data['status'],
            'comment_status'        => 'open',
            'ping_status'           => 'closed',
            'post_password'         => $data['order_key'],
            'post_name'             => 'order-' . $title,
            'to_ping'               => '',
            'pinged'                => '',
            'post_modified'         => $data['date_modified']['date'],
            'post_modified_gmt'     => $data['date_modified']['date'],
            'post_content_filtered' => '',
            'post_parent'           => $data['parent_id'],
            'guid'                  => ($_POST['siteurl'] ?? '') . '/?post_type=shop_order&#038;p=' . $data['id'],
            'menu_order'            => '0',
            'post_type'             => 'shop_order',
            'post_mime_type'        => '',
            'comment_count'         => '1'
            ]);

            // remove existing meta
            DB::table($postmetaTable)->where('post_id', $data['id'])->delete();

            $billing_data = $data['billing'];
            $shipping_data = $data['shipping'];
            $order_id = $data['id'];

            // insert billing meta
            foreach ($billing_data as $key => $value) {
            DB::table($postmetaTable)->insert([
                'post_id' => $order_id,
                'meta_key' => '_billing_' . $key,
                'meta_value' => is_scalar($value) ? (string)$value : json_encode($value),
            ]);
            }

            // insert shipping meta
            foreach ($shipping_data as $key => $value) {
            DB::table($postmetaTable)->insert([
                'post_id' => $order_id,
                'meta_key' => '_shipping_' . $key,
                'meta_value' => is_scalar($value) ? (string)$value : json_encode($value),
            ]);
            }

            // order meta fields
            $order_meta_fields = [
            '_payment_method'                 => $data['payment_method'] ?? null,
            '_payment_method_title'           => $data['payment_method_title'] ?? null,
            '_transaction_id'                 => $data['transaction_id'] ?? null,
            '_customer_ip_address'            => $data['customer_ip_address'] ?? null,
            '_customer_user_agent'            => $data['customer_user_agent'] ?? null,
            '_created_via'                    => $data['created_via'] ?? null,
            '_customer_note'                  => $data['customer_note'] ?? null,
            '_date_completed'                 => $data['date_completed']['date'] ?? null,
            '_date_paid'                      => $data['date_paid']['date'] ?? null,
            '_cart_hash'                      => $data['cart_hash'] ?? null,
            '_order_stock_reduced'            => $data['order_stock_reduced'] ?? null,
            '_download_permissions_granted'   => $data['download_permissions_granted'] ?? null,
            '_new_order_email_sent'           => $data['new_order_email_sent'] ?? null,
            '_recorded_sales'                 => $data['recorded_sales'] ?? null,
            '_recorded_coupon_usage_counts'   => $data['recorded_coupon_usage_counts'] ?? null,
            '_order_number'                   => $data['number'] ?? null,
            '_discount_total'                 => $data['discount_total'] ?? null,
            '_discount_tax'                   => $data['discount_tax'] ?? null,
            '_shipping_total'                 => $data['shipping_total'] ?? null,
            '_shipping_tax'                   => $data['shipping_tax'] ?? null,
            '_cart_tax'                       => $data['cart_tax'] ?? null,
            '_order_total'                    => $data['total'] ?? null,
            '_total_tax'                      => $data['total_tax'] ?? null,
            '_customer_user'                  => $data['customer_id'] ?? null,
            'partyid'                         => $partyid ?? null,
            '_affiliate_username'             => $postmeta[0]['_affiliate_username'] ?? null,
            ];

            foreach ($order_meta_fields as $mkey => $mvalue) {
            if ($mvalue !== null) {
                DB::table($postmetaTable)->insert([
                'post_id' => $order_id,
                'meta_key' => $mkey,
                'meta_value' => is_scalar($mvalue) ? (string)$mvalue : json_encode($mvalue),
                ]);
            }
            }

            // remove existing order items and their meta for this sync, then re-insert from payload
            for ($i = 0; $i < count((array)$resultorderitems); $i++) {
            $orderItemId = $resultorderitems[$i]['order_item_id'];
            DB::table($orderItemsTable)->where('order_item_id', $orderItemId)->delete();
            DB::table($orderItemmetaTable)->where('order_item_id', $orderItemId)->delete();
            }

            for ($i = 0; $i < count((array)$resultorderitems); $i++) {
            DB::table($orderItemsTable)->insert([
                'order_item_id' => $resultorderitems[$i]['order_item_id'],
                'order_item_name' => $resultorderitems[$i]['order_item_name'],
                'order_item_type' => $resultorderitems[$i]['order_item_type'],
                'order_id' => $resultorderitems[$i]['order_id'],
            ]);
            }

            for ($j = 0; $j < count((array)$resultordermeta); $j++) {
            DB::table($orderItemmetaTable)->insert([
                'meta_id' => $resultordermeta[$j]['meta_id'],
                'order_item_id' => $resultordermeta[$j]['order_item_id'],
                'meta_key' => $resultordermeta[$j]['meta_key'],
                'meta_value' => $resultordermeta[$j]['meta_value'],
            ]);
            }
        } else {
            // post doesn't exist - insert only meta/items as provided
            $billing_data = $data['billing'];
            $shipping_data = $data['shipping'];
            $order_id = $data['id'];

            foreach ($billing_data as $key => $value) {
            DB::table($postmetaTable)->insert([
                'post_id' => $order_id,
                'meta_key' => '_billing_' . $key,
                'meta_value' => is_scalar($value) ? (string)$value : json_encode($value),
            ]);
            }

            foreach ($shipping_data as $key => $value) {
            DB::table($postmetaTable)->insert([
                'post_id' => $order_id,
                'meta_key' => '_shipping_' . $key,
                'meta_value' => is_scalar($value) ? (string)$value : json_encode($value),
            ]);
            }

            $order_meta_fields = [
            '_payment_method'                 => $data['payment_method'] ?? null,
            '_payment_method_title'           => $data['payment_method_title'] ?? null,
            '_transaction_id'                 => $data['transaction_id'] ?? null,
            '_customer_ip_address'            => $data['customer_ip_address'] ?? null,
            '_customer_user_agent'            => $data['customer_user_agent'] ?? null,
            '_created_via'                    => $data['created_via'] ?? null,
            '_customer_note'                  => $data['customer_note'] ?? null,
            '_date_completed'                 => $data['date_completed']['date'] ?? null,
            '_date_paid'                      => $data['date_paid']['date'] ?? null,
            '_cart_hash'                      => $data['cart_hash'] ?? null,
            '_order_stock_reduced'            => $data['order_stock_reduced'] ?? null,
            '_download_permissions_granted'   => $data['download_permissions_granted'] ?? null,
            '_new_order_email_sent'           => $data['new_order_email_sent'] ?? null,
            '_recorded_sales'                 => $data['recorded_sales'] ?? null,
            '_recorded_coupon_usage_counts'   => $data['recorded_coupon_usage_counts'] ?? null,
            '_order_number'                   => $data['number'] ?? null,
            '_discount_total'                 => $data['discount_total'] ?? null,
            '_discount_tax'                   => $data['discount_tax'] ?? null,
            '_shipping_total'                 => $data['shipping_total'] ?? null,
            '_shipping_tax'                   => $data['shipping_tax'] ?? null,
            '_cart_tax'                       => $data['cart_tax'] ?? null,
            '_order_total'                    => $data['total'] ?? null,
            '_total_tax'                      => $data['total_tax'] ?? null,
            '_customer_user'                  => $data['customer_id'] ?? null,
            'partyid'                         => $partyid ?? null,
            '_affiliate_username'             => $postmeta[0]['_affiliate_username'] ?? null,
            ];

            foreach ($order_meta_fields as $mkey => $mvalue) {
            if ($mvalue !== null) {
                DB::table($postmetaTable)->insert([
                'post_id' => $order_id,
                'meta_key' => $mkey,
                'meta_value' => is_scalar($mvalue) ? (string)$mvalue : json_encode($mvalue),
                ]);
            }
            }

            for ($i = 0; $i < count((array)$resultorderitems); $i++) {
            DB::table($orderItemsTable)->insert([
                'order_item_id' => $resultorderitems[$i]['order_item_id'],
                'order_item_name' => $resultorderitems[$i]['order_item_name'],
                'order_item_type' => $resultorderitems[$i]['order_item_type'],
                'order_id' => $resultorderitems[$i]['order_id'],
            ]);
            }

            for ($j = 0; $j < count((array)$resultordermeta); $j++) {
            DB::table($orderItemmetaTable)->insert([
                'meta_id' => $resultordermeta[$j]['meta_id'],
                'order_item_id' => $resultordermeta[$j]['order_item_id'],
                'meta_key' => $resultordermeta[$j]['meta_key'],
                'meta_value' => $resultordermeta[$j]['meta_value'],
            ]);
            }
        }

        if (isset($_POST['sponsor']) && $_POST['sponsor'] != '') {
            DB::table($storeprefix . '_posts')
                ->where('ID', $order_id)
                ->update([
                    'members_shop_id' => $members_shop_id,
                    'sponsor_members_shop_id' => $sponsor_members_shop_id,
                ]);
        }
        if ($data['status'] == 'completed') {
            MCheckTrigger::getTriggerDetails('shop_purchase', 1, $members_email);
        }
    }

    //start product
    public static function wpGetProduct($datas)
    {
        $prefix = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');

        $data_json = json_decode($datas['data'], true);
        $post_id = $data_json['ID'] ?? $datas['id'] ?? null;
        $data_image_meta = json_decode($datas['image_meta'], true) ?: [];
        $data_meta = json_decode($datas['meta'], true) ?: [];
        $data_terms = json_decode($datas['terms'], true) ?: [];
        $data_result_image_path = json_decode($datas['result_image_path'], true) ?: [];
        $data_termmeta = json_decode($datas['termmeta'], true) ?: [];
        $data_relation = json_decode($datas['relation'], true) ?: [];
        $data_taxonomy = json_decode($datas['taxonomy'], true) ?: [];
        $data_image_row = json_decode($datas['attachment'], true) ?: [];

        $termsTable = $storeprefix . '_terms';
        $termmetaTable = $storeprefix . '_termmeta';
        $relationTable = $storeprefix . '_term_relationships';
        $taxonomyTable = $storeprefix . '_term_taxonomy';
        $postsTable = $storeprefix . '_posts';
        $postmetaTable = $storeprefix . '_postmeta';

        // Insert terms (insertOrIgnore to mimic INSERT IGNORE)
        foreach ($data_terms as $term) {
            DB::table($termsTable)->insertOrIgnore([
                'term_id'    => $term['term_id'] ?? null,
                'name'       => $term['name'] ?? null,
                'slug'       => $term['slug'] ?? null,
                'term_group' => $term['term_group'] ?? 0,
            ]);
        }

        // Insert termmeta
        foreach ($data_termmeta as $tmeta) {
            DB::table($termmetaTable)->insertOrIgnore([
                'meta_id'   => $tmeta['meta_id'] ?? null,
                'term_id'   => $tmeta['term_id'] ?? null,
                'meta_key'  => $tmeta['meta_key'] ?? null,
                'meta_value'=> $tmeta['meta_value'] ?? null,
            ]);
        }

        // Insert term relationships
        foreach ($data_relation as $rel) {
            DB::table($relationTable)->insertOrIgnore([
                'object_id'        => $rel['object_id'] ?? null,
                'term_taxonomy_id' => $rel['term_taxonomy_id'] ?? null,
                'term_order'       => $rel['term_order'] ?? 0,
            ]);
        }

        // Insert term taxonomy
        foreach ($data_taxonomy as $tax) {
            DB::table($taxonomyTable)->insertOrIgnore([
                'term_taxonomy_id' => $tax['term_taxonomy_id'] ?? null,
                'term_id'          => $tax['term_id'] ?? null,
                'taxonomy'         => $tax['taxonomy'] ?? null,
                'description'      => $tax['description'] ?? null,
                'parent'           => $tax['parent'] ?? 0,
                'count'            => $tax['count'] ?? 0,
            ]);
        }

        // Ensure thumbnail attachment exists (if provided)
        if (!empty($data_meta['_thumbnail_id'])) {
            $thumbId = $data_meta['_thumbnail_id'];
            $exists = DB::table($postsTable)->where('ID', $thumbId)->exists();
            if (!$exists && !empty($data_image_row[0])) {

                $row = $data_image_row[0];
                DB::table($postsTable)->insert([
                    'ID'                    => $thumbId,
                    'post_author'           => $row['post_author'] ?? ($data_json['post_author'] ?? null),
                    'post_date'             => $row['post_date'] ?? ($data_json['post_date'] ?? null),
                    'post_date_gmt'         => $row['post_date_gmt'] ?? ($data_json['post_date_gmt'] ?? null),
                    'post_content'          => $row['post_content'] ?? ($data_json['post_content'] ?? null),
                    'post_title'            => $row['post_title'] ?? ($data_json['post_title'] ?? null),
                    'post_excerpt'          => $row['post_excerpt'] ?? ($data_json['post_excerpt'] ?? null),
                    'post_status'           => $row['post_status'] ?? 'inherit',
                    'comment_status'        => $row['comment_status'] ?? null,
                    'ping_status'           => $row['ping_status'] ?? null,
                    'post_password'         => $row['post_password'] ?? null,
                    'post_name'             => $row['post_name'] ?? null,
                    'to_ping'               => $row['to_ping'] ?? null,
                    'pinged'                => $row['pinged'] ?? null,
                    'post_modified'         => $row['post_modified'] ?? ($data_json['post_modified'] ?? null),
                    'post_modified_gmt'     => $row['post_modified_gmt'] ?? ($data_json['post_modified_gmt'] ?? null),
                    'post_content_filtered' => $row['post_content_filtered'] ?? null,
                    'post_parent'           => $post_id,
                    'guid'                  => $row['guid'] ?? null,
                    'menu_order'            => $row['menu_order'] ?? 0,
                    'post_type'             => $row['post_type'] ?? 'attachment',
                    'post_mime_type'        => $row['post_mime_type'] ?? null,
                    'comment_count'         => $row['comment_count'] ?? 0,
                ]);

                // insert image meta if provided
                foreach ($data_image_meta as $imgMeta) {
                    DB::table($postmetaTable)->insert([
                        'post_id'    => $thumbId,
                        'meta_key'   => $imgMeta['meta_key'] ?? null,
                        'meta_value' => is_scalar($imgMeta['meta_value'] ?? null) ? (string)($imgMeta['meta_value'] ?? '') : json_encode($imgMeta['meta_value']),
                    ]);
                }
            }
        }

        // Main post insert/update (skip auto-draft)
        if (($data_json['post_status'] ?? '') !== 'auto-draft' && $post_id) {
            $postExists = DB::table($postsTable)->where('ID', $post_id)->exists();

            $postData = [
                'ID'                    => $data_json['ID'] ?? $post_id,
                'post_author'           => $data_json['post_author'] ?? null,
                'post_date'             => $data_json['post_date'] ?? null,
                'post_date_gmt'         => $data_json['post_date_gmt'] ?? null,
                'post_content'          => $data_json['post_content'] ?? null,
                'post_title'            => $data_json['post_title'] ?? null,
                'post_excerpt'          => $data_json['post_excerpt'] ?? null,
                'post_status'           => $data_json['post_status'] ?? null,
                'comment_status'        => $data_json['comment_status'] ?? null,
                'ping_status'           => $data_json['ping_status'] ?? null,
                'post_password'         => $data_json['post_password'] ?? null,
                'post_name'             => $data_json['post_name'] ?? null,
                'to_ping'               => $data_json['to_ping'] ?? null,
                'pinged'                => $data_json['pinged'] ?? null,
                'post_modified'         => $data_json['post_modified'] ?? null,
                'post_modified_gmt'     => $data_json['post_modified_gmt'] ?? null,
                'post_content_filtered' => $data_json['post_content_filtered'] ?? null,
                'post_parent'           => $data_json['post_parent'] ?? null,
                'guid'                  => $data_json['guid'] ?? null,
                'menu_order'            => $data_json['menu_order'] ?? 0,
                'post_type'             => $data_json['post_type'] ?? null,
                'post_mime_type'        => $data_json['post_mime_type'] ?? null,
                'comment_count'         => $data_json['comment_count'] ?? 0,
            ];

            if (!$postExists) {
                DB::table($postsTable)->insert($postData);
            } else {
                // update (exclude ID from update payload)
                $updateData = $postData;
                unset($updateData['ID']);
                DB::table($postsTable)->where('ID', $post_id)->update($updateData);

                // remove existing meta so we can re-insert fresh
                DB::table($postmetaTable)->where('post_id', $post_id)->delete();
            }

            // Insert post meta (insert all keys provided)
            foreach ($data_meta as $mkey => $mvalue) {
                DB::table($postmetaTable)->insert([
                    'post_id'    => $post_id,
                    'meta_key'   => $mkey,
                    'meta_value' => is_scalar($mvalue) ? (string)$mvalue : json_encode($mvalue),
                ]);
            }
        }

        // Replace child posts (attachments) - delete existing and insert provided
        DB::table($postsTable)->where('post_parent', $post_id)->delete();
        foreach ($data_result_image_path as $img) {
            DB::table($postsTable)->insert([
                'ID'                    => $img['ID'] ?? null,
                'post_author'           => $img['post_author'] ?? null,
                'post_date'             => $img['post_date'] ?? null,
                'post_date_gmt'         => $img['post_date_gmt'] ?? null,
                'post_content'          => $img['post_content'] ?? null,
                'post_title'            => $img['post_title'] ?? null,
                'post_excerpt'          => $img['post_excerpt'] ?? null,
                'post_status'           => $img['post_status'] ?? null,
                'comment_status'        => $img['comment_status'] ?? null,
                'ping_status'           => $img['ping_status'] ?? null,
                'post_password'         => $img['post_password'] ?? null,
                'post_name'             => $img['post_name'] ?? null,
                'to_ping'               => $img['to_ping'] ?? null,
                'pinged'                => $img['pinged'] ?? null,
                'post_modified'         => $img['post_modified'] ?? null,
                'post_modified_gmt'     => $img['post_modified_gmt'] ?? null,
                'post_content_filtered' => $img['post_content_filtered'] ?? null,
                'post_parent'           => $img['post_parent'] ?? $post_id,
                'guid'                  => $img['guid'] ?? null,
                'menu_order'            => $img['menu_order'] ?? 0,
                'post_type'             => $img['post_type'] ?? null,
                'post_mime_type'        => $img['post_mime_type'] ?? null,
                'comment_count'         => $img['comment_count'] ?? 0,
            ]);
        }

        return true;
    }

    public static function wpGetUser($datum)
    {
        $prefix = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');

        $data_row = json_decode($datum['result_user'], true);
        $data_meta = json_decode($datum['result_user_meta'], true);
        $user_id = $datum['id'];

        $row = $data_row[0] ?? [];
        if (empty($row)) {
            return false;
        }

        $userData = [
            'ID'                  => $row['ID'] ?? $user_id,
            'user_login'          => $row['user_login'] ?? null,
            'user_pass'           => $row['user_pass'] ?? null,
            'user_nicename'       => $row['user_nicename'] ?? null,
            'user_email'          => $row['user_email'] ?? null,
            'user_url'            => $row['user_url'] ?? null,
            'user_registered'     => $row['user_registered'] ?? null,
            'user_activation_key' => $row['user_activation_key'] ?? null,
            'user_status'         => $row['user_status'] ?? null,
            'display_name'        => $row['display_name'] ?? null,
        ];

        DB::table($storeprefix . '_users')->insertOrIgnore($userData);

        // Insert selected usermeta keys
        $usermetaarray = self::getUserMetaarray();
        foreach ((array)$data_meta as $meta) {
            if (!isset($meta['meta_key'])) {
                continue;
            }
            if (in_array($meta['meta_key'], $usermetaarray)) {
                DB::table($storeprefix . '_usermeta')->insert([
                    'user_id'    => $user_id,
                    'meta_key'   => $meta['meta_key'],
                    'meta_value' => is_scalar($meta['meta_value'] ?? '') ? (string)($meta['meta_value'] ?? '') : json_encode($meta['meta_value']),
                ]);
            }
        }

        return true;
    }
    public static function wpUserUpdate($datum)
    {
        $prefix = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');

        $data_row = json_decode($datum['result_user'], true);
        $data_meta = json_decode($datum['result_user_meta'], true);
        $user_id = $datum['id'];

        $row = $data_row[0] ?? [];
        if (empty($row)) {
            return false;
        }

        $userData = [
            'ID'                  => $row['ID'] ?? $user_id,
            'user_login'          => $row['user_login'] ?? null,
            'user_pass'           => $row['user_pass'] ?? null,
            'user_nicename'       => $row['user_nicename'] ?? null,
            'user_email'          => $row['user_email'] ?? null,
            'user_url'            => $row['user_url'] ?? null,
            'user_registered'     => $row['user_registered'] ?? null,
            'user_activation_key' => $row['user_activation_key'] ?? null,
            'user_status'         => $row['user_status'] ?? null,
            'display_name'        => $row['display_name'] ?? null,
        ];

        // Insert if not exists, otherwise update
        $exists = DB::table($storeprefix . '_users')->where('ID', $user_id)->exists();
        if ($exists) {
            $updateData = $userData;
            unset($updateData['ID']);
            DB::table($storeprefix . '_users')->where('ID', $user_id)->update($updateData);
        } else {
            DB::table($storeprefix . '_users')->insert($userData);
        }

        // Replace selected usermeta
        DB::table($storeprefix . '_usermeta')->where('user_id', $user_id)->delete();

        $usermetaarray = self::getUserMetaarray();
        foreach ((array)$data_meta as $meta) {
            if (!isset($meta['meta_key'])) {
                continue;
            }
            if (\in_array($meta['meta_key'], $usermetaarray, true)) {
                DB::table($storeprefix . '_usermeta')->insert([
                    'user_id'    => $user_id,
                    'meta_key'   => $meta['meta_key'],
                    'meta_value' => is_scalar($meta['meta_value'] ?? '') ? (string)($meta['meta_value'] ?? '') : json_encode($meta['meta_value']),
                ]);
            }
        }

        return true;
    }
    public static function getUserMetaarray()
    {
        $usermetaarray = array('nickname','first_name','last_name','description','rich_editing','syntax_highlighting','comment_shortcuts','admin_color','use_ssl','show_admin_bar_front','locale','wp_capabilities','wp_user_level');
        return $usermetaarray;
    }
    public static function wpTrashPost($datas)
    {
        $prefix = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');

        $data_json = json_decode($datas['result_post'], true) ?: [];
        $data_meta = json_decode($datas['result_post_meta'], true) ?: [];
        $post_id = $datas['id'] ?? ($data_json['ID'] ?? null);

        if (!$post_id) {
            return false;
        }

        $updateData = [
            'post_author'           => $data_json['post_author'] ?? null,
            'post_date'             => $data_json['post_date'] ?? null,
            'post_date_gmt'         => $data_json['post_date_gmt'] ?? null,
            'post_content'          => $data_json['post_content'] ?? null,
            'post_title'            => $data_json['post_title'] ?? null,
            'post_excerpt'          => $data_json['post_excerpt'] ?? null,
            'comment_status'        => $data_json['comment_status'] ?? null,
            'ping_status'           => $data_json['ping_status'] ?? null,
            'post_password'         => $data_json['post_password'] ?? null,
            'post_name'             => $data_json['post_name'] ?? null,
            'to_ping'               => $data_json['to_ping'] ?? null,
            'pinged'                => $data_json['pinged'] ?? null,
            'post_modified'         => $data_json['post_modified'] ?? null,
            'post_modified_gmt'     => $data_json['post_modified_gmt'] ?? null,
            'post_content_filtered' => $data_json['post_content_filtered'] ?? null,
            'post_parent'           => $data_json['post_parent'] ?? null,
            'guid'                  => $data_json['guid'] ?? null,
            'menu_order'            => $data_json['menu_order'] ?? 0,
            'post_type'             => $data_json['post_type'] ?? null,
            'post_mime_type'        => $data_json['post_mime_type'] ?? null,
            'comment_count'         => $data_json['comment_count'] ?? 0,
        ];

        // Update post
        $updated = DB::table($storeprefix . '_posts')->where('ID', $post_id)->update($updateData);

        if ($updated !== false) {
            // Remove existing meta then re-insert selected meta keys
            DB::table($storeprefix . '_postmeta')->where('post_id', $post_id)->delete();

            // If the class provides getPostMetaarray(), use it to filter keys; otherwise insert all provided meta.
            $stockarray = null;
            if (method_exists(self::class, 'getPostMetaarray')) {
                $stockarray = self::getPostMetaarray();
            }

            foreach ((array)$data_meta as $key => $value) {
                if ($stockarray === null || \in_array($key, $stockarray, true)) {
                    DB::table($storeprefix . '_postmeta')->insert([
                        'post_id'    => $post_id,
                        'meta_key'   => $key,
                        'meta_value' => is_scalar($value) ? (string)$value : json_encode($value),
                    ]);
                }
            }
        }

        return true;
    }
    public static function wpProductAddUpdate($datas)
    {
        $prefix = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');

        $data_json = json_decode($datas['data'], true) ?: [];
        $data_meta = json_decode($datas['meta'], true) ?: [];
        $data_terms = json_decode($datas['terms'], true) ?: [];
        $data_termmeta = json_decode($datas['termmeta'], true) ?: [];
        $data_relation = json_decode($datas['relation'], true) ?: [];
        $data_taxonomy = json_decode($datas['taxonomy'], true) ?: [];
        $data_image_row = json_decode($datas['attachment'], true) ?: [];
        $data_image_meta = json_decode($datas['image_meta'], true) ?: [];
        $data_result_image_path = json_decode($datas['result_image_path'], true) ?: [];

        $termsTable = $storeprefix . '_terms';
        $termmetaTable = $storeprefix . '_termmeta';
        $relationTable = $storeprefix . '_term_relationships';
        $taxonomyTable = $storeprefix . '_term_taxonomy';
        $postsTable = $storeprefix . '_posts';
        $postmetaTable = $storeprefix . '_postmeta';

        DB::transaction(function () use (
            $termsTable, $termmetaTable, $relationTable, $taxonomyTable,
            $postsTable, $postmetaTable,
            $data_terms, $data_termmeta, $data_relation, $data_taxonomy,
            $data_image_row, $data_image_meta, $data_result_image_path,
            $data_meta, $data_json
        ) {
            // Insert terms
            foreach ($data_terms as $term) {
                DB::table($termsTable)->insertOrIgnore([
                    'term_id'    => $term['term_id'] ?? null,
                    'name'       => $term['name'] ?? null,
                    'slug'       => $term['slug'] ?? null,
                    'term_group' => $term['term_group'] ?? 0,
                ]);
            }

            // Insert termmeta
            foreach ($data_termmeta as $tmeta) {
                DB::table($termmetaTable)->insertOrIgnore([
                    'meta_id'   => $tmeta['meta_id'] ?? null,
                    'term_id'   => $tmeta['term_id'] ?? null,
                    'meta_key'  => $tmeta['meta_key'] ?? null,
                    'meta_value'=> isset($tmeta['meta_value']) && is_scalar($tmeta['meta_value']) ? (string)$tmeta['meta_value'] : json_encode($tmeta['meta_value'] ?? null),
                ]);
            }

            // Insert term relationships
            foreach ($data_relation as $rel) {
                DB::table($relationTable)->insertOrIgnore([
                    'object_id'        => $rel['object_id'] ?? null,
                    'term_taxonomy_id' => $rel['term_taxonomy_id'] ?? null,
                    'term_order'       => $rel['term_order'] ?? 0,
                ]);
            }

            // Insert term taxonomy
            foreach ($data_taxonomy as $tax) {
                DB::table($taxonomyTable)->insertOrIgnore([
                    'term_taxonomy_id' => $tax['term_taxonomy_id'] ?? null,
                    'term_id'          => $tax['term_id'] ?? null,
                    'taxonomy'         => $tax['taxonomy'] ?? null,
                    'description'      => $tax['description'] ?? null,
                    'parent'           => $tax['parent'] ?? 0,
                    'count'            => $tax['count'] ?? 0,
                ]);
            }

            $post_id = $datas['id'] ?? ($data_json['ID'] ?? null);
            if ($post_id) {
                $existing = DB::table($postsTable)->where('ID', $post_id)->first();

                // If no existing post, insert attachment (image) row if provided
                if (!$existing) {
                    if (!empty($data_image_row[0])) {
                        $row = $data_image_row[0];
                        DB::table($postsTable)->insert([
                            'ID'                    => $row['ID'] ?? null,
                            'post_author'           => $row['post_author'] ?? ($data_json['post_author'] ?? null),
                            'post_date'             => $row['post_date'] ?? ($data_json['post_date'] ?? null),
                            'post_date_gmt'         => $row['post_date_gmt'] ?? ($data_json['post_date_gmt'] ?? null),
                            'post_content'          => isset($row['post_content']) && is_scalar($row['post_content']) ? (string)$row['post_content'] : json_encode($row['post_content'] ?? null),
                            'post_title'            => $row['post_title'] ?? ($data_json['post_title'] ?? null),
                            'post_excerpt'          => isset($row['post_excerpt']) && is_scalar($row['post_excerpt']) ? (string)$row['post_excerpt'] : json_encode($row['post_excerpt'] ?? null),
                            'post_status'           => $row['post_status'] ?? 'inherit',
                            'comment_status'        => $row['comment_status'] ?? null,
                            'ping_status'           => $row['ping_status'] ?? null,
                            'post_password'         => $row['post_password'] ?? null,
                            'post_name'             => $row['post_name'] ?? null,
                            'to_ping'               => $row['to_ping'] ?? null,
                            'pinged'                => $row['pinged'] ?? null,
                            'post_modified'         => $row['post_modified'] ?? ($data_json['post_modified'] ?? null),
                            'post_modified_gmt'     => $row['post_modified_gmt'] ?? ($data_json['post_modified_gmt'] ?? null),
                            'post_content_filtered' => isset($row['post_content_filtered']) && is_scalar($row['post_content_filtered']) ? (string)$row['post_content_filtered'] : json_encode($row['post_content_filtered'] ?? null),
                            'post_parent'           => $row['post_parent'] ?? $post_id,
                            'guid'                  => $row['guid'] ?? null,
                            'menu_order'            => $row['menu_order'] ?? 0,
                            'post_type'             => $row['post_type'] ?? 'attachment',
                            'post_mime_type'        => $row['post_mime_type'] ?? null,
                            'comment_count'         => $row['comment_count'] ?? 0,
                        ]);

                        // image meta
                        foreach ($data_image_meta as $imgMeta) {
                            DB::table($postmetaTable)->insert([
                                'post_id'    => $imgMeta['post_id'] ?? $row['ID'] ?? $post_id,
                                'meta_key'   => $imgMeta['meta_key'] ?? null,
                                'meta_value' => isset($imgMeta['meta_value']) && is_scalar($imgMeta['meta_value']) ? (string)$imgMeta['meta_value'] : json_encode($imgMeta['meta_value'] ?? null),
                            ]);
                        }
                    }
                } else {
                    // update existing attachment info if provided
                    if (!empty($data_image_row[0])) {
                        $row = $data_image_row[0];
                        DB::table($postsTable)->where('ID', $post_id)->update([
                            'post_author'           => $row['post_author'] ?? ($data_json['post_author'] ?? null),
                            'post_date'             => $row['post_date'] ?? ($data_json['post_date'] ?? null),
                            'post_date_gmt'         => $row['post_date_gmt'] ?? ($data_json['post_date_gmt'] ?? null),
                            'post_content'          => isset($row['post_content']) && is_scalar($row['post_content']) ? (string)$row['post_content'] : json_encode($row['post_content'] ?? null),
                            'post_title'            => $row['post_title'] ?? ($data_json['post_title'] ?? null),
                            'post_excerpt'          => isset($row['post_excerpt']) && is_scalar($row['post_excerpt']) ? (string)$row['post_excerpt'] : json_encode($row['post_excerpt'] ?? null),
                            'comment_status'        => $row['comment_status'] ?? null,
                            'ping_status'           => $row['ping_status'] ?? null,
                            'post_password'         => $row['post_password'] ?? null,
                            'post_name'             => $row['post_name'] ?? null,
                            'to_ping'               => $row['to_ping'] ?? null,
                            'pinged'                => $row['pinged'] ?? null,
                            'post_modified'         => $row['post_modified'] ?? null,
                            'post_modified_gmt'     => $row['post_modified_gmt'] ?? null,
                            'post_content_filtered' => isset($row['post_content_filtered']) && is_scalar($row['post_content_filtered']) ? (string)$row['post_content_filtered'] : json_encode($row['post_content_filtered'] ?? null),
                            'post_parent'           => $row['post_parent'] ?? $post_id,
                            'guid'                  => $row['guid'] ?? null,
                            'menu_order'            => $row['menu_order'] ?? 0,
                            'post_type'             => $row['post_type'] ?? null,
                            'post_mime_type'        => $row['post_mime_type'] ?? null,
                            'comment_count'         => $row['comment_count'] ?? 0,
                        ]);

                        // replace postmeta for this post
                        DB::table($postmetaTable)->where('post_id', $post_id)->delete();
                        foreach ($data_image_meta as $imgMeta) {
                            DB::table($postmetaTable)->insert([
                                'post_id'    => $imgMeta['post_id'] ?? $post_id,
                                'meta_key'   => $imgMeta['meta_key'] ?? null,
                                'meta_value' => isset($imgMeta['meta_value']) && is_scalar($imgMeta['meta_value']) ? (string)$imgMeta['meta_value'] : json_encode($imgMeta['meta_value'] ?? null),
                            ]);
                        }
                    }
                }
            }

            // Replace child posts (attachments)
            if ($post_id) {
                DB::table($postsTable)->where('post_parent', $post_id)->delete();

                foreach ($data_result_image_path as $img) {
                    DB::table($postsTable)->insert([
                        'ID'                    => $img['ID'] ?? null,
                        'post_author'           => $img['post_author'] ?? null,
                        'post_date'             => $img['post_date'] ?? null,
                        'post_date_gmt'         => $img['post_date_gmt'] ?? null,
                        'post_content'          => isset($img['post_content']) && is_scalar($img['post_content']) ? (string)$img['post_content'] : json_encode($img['post_content'] ?? null),
                        'post_title'            => $img['post_title'] ?? null,
                        'post_excerpt'          => isset($img['post_excerpt']) && is_scalar($img['post_excerpt']) ? (string)$img['post_excerpt'] : json_encode($img['post_excerpt'] ?? null),
                        'post_status'           => $img['post_status'] ?? null,
                        'comment_status'        => $img['comment_status'] ?? null,
                        'ping_status'           => $img['ping_status'] ?? null,
                        'post_password'         => $img['post_password'] ?? null,
                        'post_name'             => $img['post_name'] ?? null,
                        'to_ping'               => $img['to_ping'] ?? null,
                        'pinged'                => $img['pinged'] ?? null,
                        'post_modified'         => $img['post_modified'] ?? null,
                        'post_modified_gmt'     => $img['post_modified_gmt'] ?? null,
                        'post_content_filtered' => isset($img['post_content_filtered']) && is_scalar($img['post_content_filtered']) ? (string)$img['post_content_filtered'] : json_encode($img['post_content_filtered'] ?? null),
                        'post_parent'           => $img['post_parent'] ?? $post_id,
                        'guid'                  => $img['guid'] ?? null,
                        'menu_order'            => $img['menu_order'] ?? 0,
                        'post_type'             => $img['post_type'] ?? null,
                        'post_mime_type'        => $img['post_mime_type'] ?? null,
                        'comment_count'         => $img['comment_count'] ?? 0,
                    ]);
                }
            }

            // Insert PV point and SKU meta if provided
            if ($post_id && isset($data_meta['_pv_point'])) {
                DB::table($postmetaTable)->insert([
                    'post_id'    => $post_id,
                    'meta_key'   => '_pv_point',
                    'meta_value' => is_scalar($data_meta['_pv_point']) ? (string)$data_meta['_pv_point'] : json_encode($data_meta['_pv_point']),
                ]);
            }

            if ($post_id && isset($data_meta['_sku'])) {
                DB::table($postmetaTable)->insert([
                    'post_id'    => $post_id,
                    'meta_key'   => '_sku',
                    'meta_value' => is_scalar($data_meta['_sku']) ? (string)$data_meta['_sku'] : json_encode($data_meta['_sku']),
                ]);
            }
        });

        return true;
    }
    public static function wpreFundOrders()
    {
        $prefix = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');

        $allposts = json_decode($_POST['postsall'] ?? '[]', true) ?: [];
        if (empty($allposts) || !isset($allposts[0])) {
            return false;
        }

        $row = $allposts[0];

        $insertData = [
            'ID'                    => $row['ID'] ?? null,
            'post_author'           => $row['post_author'] ?? null,
            'post_date'             => $row['post_date'] ?? null,
            'post_date_gmt'         => $row['post_date_gmt'] ?? null,
            'post_content'          => isset($row['post_content']) && is_scalar($row['post_content']) ? trim((string)$row['post_content']) : json_encode($row['post_content'] ?? null),
            'post_title'            => $row['post_title'] ?? null,
            'post_excerpt'          => isset($row['post_excerpt']) && is_scalar($row['post_excerpt']) ? trim((string)$row['post_excerpt']) : json_encode($row['post_excerpt'] ?? null),
            'post_status'           => $row['post_status'] ?? null,
            'comment_status'        => $row['comment_status'] ?? null,
            'ping_status'           => $row['ping_status'] ?? null,
            'post_password'         => $row['post_password'] ?? null,
            'post_name'             => $row['post_name'] ?? null,
            'to_ping'               => $row['to_ping'] ?? null,
            'pinged'                => $row['pinged'] ?? null,
            'post_modified'         => $row['post_modified'] ?? null,
            'post_modified_gmt'     => $row['post_modified_gmt'] ?? null,
            'post_content_filtered' => isset($row['post_content_filtered']) && is_scalar($row['post_content_filtered']) ? trim((string)$row['post_content_filtered']) : json_encode($row['post_content_filtered'] ?? null),
            'post_parent'           => $row['post_parent'] ?? null,
            'guid'                  => $row['guid'] ?? null,
            'menu_order'            => $row['menu_order'] ?? 0,
            'post_type'             => $row['post_type'] ?? null,
            'post_mime_type'        => $row['post_mime_type'] ?? null,
            'comment_count'         => $row['comment_count'] ?? 0,
        ];

        DB::table($storeprefix . '_posts')->insert($insertData);

        return true;
    }
    /* For Personal Sales Mongo*/
    public static function wpUpdateOrderVolume($data)
    {
        $prefix = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');

        $order_data = json_decode($data['data'], true);
        if (empty($order_data)) {
            return false;
        }

        $total = isset($order_data['total']) ? (float)$order_data['total'] : 0.0;
        $customer_id = isset($order_data['customer_id']) ? $order_data['customer_id'] : 0;

        // find members_id by shop id
        $members_id = DB::table($prefix . '_members_table')
            ->where('members_shop_id', $customer_id)
            ->value('members_id');

        if (empty($members_id)) {
            return false;
        }

        // get sponsor and parents
        $link = DB::table($prefix . '_matrix_members_link_table')
            ->where('members_id', $members_id)
            ->select('direct_id', 'members_parents')
            ->first();

        $sponsor_id = $link->direct_id ?? 0;
        $members_parents = $link->members_parents ?? '';

        // update personal sales (DB)
        if ($customer_id > 0) {
            DB::table($prefix . '_matrix_members_link_table')
                ->where('members_id', $members_id)
                ->increment('personal_sales', $total);

            // Mongo: increment Personal Order Value
            try {
                $collectionname = 'members';
                $bulk = new \MongoDB\Driver\BulkWrite();
                $bulk->update(
                    ['members_id' => (int)$members_id],
                    ['$inc' => ['Personal Order Value' => (float)$total]],
                    ['multi' => false, 'upsert' => true]
                );
                $manager = new \MongoDB\Driver\Manager($_ENV['MONGO_DRIVE']);
                $manager->executeBulkWrite($_ENV['MONGO_DBNAME'] . '.' . $collectionname, $bulk);
            } catch (\Throwable $e) {
                // silent failure for mongo updates to avoid breaking main flow
            }
        }

        // update direct sales (DB)
        if ($sponsor_id > 0) {
            DB::table($prefix . '_matrix_members_link_table')
                ->where('members_id', $sponsor_id)
                ->increment('direct_sales', $total);

            // Mongo: increment Direct Distributors Order Volume
            try {
                $collectionname = 'members';
                $bulk_direct = new \MongoDB\Driver\BulkWrite();
                $bulk_direct->update(
                    ['members_id' => (int)$sponsor_id],
                    ['$inc' => ['Direct Distributors Order Volume' => (float)$total]],
                    ['multi' => false, 'upsert' => true]
                );
                $manager = new \MongoDB\Driver\Manager($_ENV['MONGO_DRIVE']);
                $manager->executeBulkWrite($_ENV['MONGO_DBNAME'] . '.' . $collectionname, $bulk_direct);
            } catch (\Throwable $e) {
                // ignore
            }
        }

        // update total downline sales (DB)
        if (!empty($members_parents)) {
            // prepare array of int ids
            $parents_array = array_filter(array_map('intval', array_map('trim', explode(',', $members_parents))));
            if (!empty($parents_array)) {
                // increment total_sales for all parents
                DB::table($prefix . '_matrix_members_link_table')
                    ->whereIn('members_id', $parents_array)
                    ->increment('total_sales', $total);

                // Mongo: increment Total Downline Order Volume for all parents
                try {
                    $collectionname = 'members';
                    $bulk_total = new \MongoDB\Driver\BulkWrite();
                    $bulk_total->update(
                        ['members_id' => ['$in' => $parents_array]],
                        ['$inc' => ['Total Downline Order Volume' => (float)$total]],
                        ['multi' => true, 'upsert' => false]
                    );
                    $manager = new \MongoDB\Driver\Manager($_ENV['MONGO_DRIVE']);
                    $manager->executeBulkWrite($_ENV['MONGO_DBNAME'] . '.' . $collectionname, $bulk_total);
                } catch (\Throwable $e) {
                    // ignore
                }
            }
        }

        return true;
    }

}
