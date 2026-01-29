<?php
/**
 * This class contains public static functions related to Banner .
 *
 * @package         MShopProduct
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?>
<?php
namespace Admin\App\Models\ShopAncillary;

use Admin\App\Models\Shopify\MShopifyUserInsert;
use Admin\App\Models\Wordpress\MWordPressUserInsert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Log;

class MShopUserInsert
{
    public static function insertShopUsers(
        $members_username,
        $members_password,
        $plain_password,
        $members_email,
        $members_doj,
        $members_firstname,
        $members_lastname,
        $members_phone,
        $members_address,
        $members_city,
        $members_zip,
        $members_state,
        $members_country,
    ) {

        $prefix      = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');

        $cartConfigureId = session('site_settings.cart_id.cart_configure_id');

        if ($cartConfigureId === null || $cartConfigureId === '') {
            $cartConfigureId = DB::table($prefix . '_sitesettings_table')
                ->where('sitesettings_name', 'cart_id')
                ->value('sitesettings_value');

            $cartConfigureId = $cartConfigureId !== null ? (int)$cartConfigureId : 0;

            Log::info('cartConfigureId fetched from database', [
                'cartConfigureId' => $cartConfigureId,
                'username'        => $members_username
            ]);
        } else {
            Log::info('cartConfigureId from session', [
                'cartConfigureId' => $cartConfigureId,
                'username'        => $members_username
            ]);
        }

        Log::info('insertShopUsers called', [
            'username'       => $members_username,
            'email'          => $members_email,
            'doj'            => $members_doj,
            'cartConfigureId' => $cartConfigureId,
            'ip'             => Request::ip()
        ]);
        // dd($cartConfigureId);

     if ($cartConfigureId == 1) {
    Log::info('Redirecting to WordPress user creation', ['username' => $members_username]);

    $registrationData = [
        'first_name' => $members_firstname,
        'last_name'  => $members_lastname,
        'phone'      => $members_phone,
        'address'    => $members_address,
        'city'       => $members_city,
        'state'      => $members_state,
        'zipcode'    => $members_zip,
        'country'    => $members_country,
    ];

    $wp_user_id = MWordPressUserInsert::wpRestInsert(
        $members_username,
        $plain_password,
        $members_email,
        $members_doj,
        $registrationData
    );

    Log::info('WordPress user creation result', [
        'username'   => $members_username,
        'wp_user_id' => $wp_user_id,
        'wp-password' => $plain_password
    ]);

    Log::info('Sent registration data to WooCommerce sync', [
        'registration_data' => $registrationData
    ]);

    return $wp_user_id ?: 0;
}

        if ($cartConfigureId == 2) {

            Log::info('Shopify user creation flow started', ['username' => $members_username]);

            // Get Shopify settings
            $store_url = DB::table($prefix . '_sitesettings_table')
                ->where('sitesettings_name', 'shop_name')
                ->value('sitesettings_value');

            $access_token = DB::table($prefix . '_sitesettings_table')
                ->where('sitesettings_name', 'access_token')
                ->value('sitesettings_value');

            $api_key = DB::table($prefix . '_sitesettings_table')
                ->where('sitesettings_name', 'api_key')
                ->value('sitesettings_value');

            Log::info('Shopify credentials fetched', [
                'store_url' => $store_url,
                'has_access_token' => !empty($access_token),
                'has_api_key' => !empty($api_key)
            ]);

            if ($store_url && $access_token && $api_key) {

                $shopify_shop_id = MShopifyUserInsert::insertShopifyuser(
                    $members_username,
                    $members_password,
                    $members_email,
                    $members_doj,
                    Request::ip(),          // members_ip_address
                    $members_firstname,
                    $members_lastname,
                    null,                   // state (not provided)
                    $members_city,
                    $members_address,
                    null,                   // address2
                    null,                   // address3
                    $members_phone,
                    $members_zip,
                    null,                   // country
                    null,                   // group_id
                    null,                   // alternate_email
                    null,                   // matrix_id
                    'web',                  // members_from
                    'uploads/customers/avatar.png',
                    'uploads/customers/thumb/avatar.png',
                    null,                   // id_proof
                    null,                   // pan_tax_document
                    $store_url,
                    $access_token,
                    $api_key
                );

                Log::info('Shopify user creation result', [
                    'username' => $members_username,
                    'shopify_customer_id' => $shopify_shop_id
                ]);

                return $shopify_shop_id;
            } else {
                Log::warning('Shopify credentials missing', [
                    'store_url' => $store_url,
                    'has_access_token' => !empty($access_token),
                    'has_api_key' => !empty($api_key)
                ]);
            }
        }

        Log::warning('No valid cartConfigureId or credentials found', [
            'cartConfigureId' => $cartConfigureId,
            'username' => $members_username
        ]);

        return 0;
    }
}
