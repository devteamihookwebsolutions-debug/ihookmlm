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
class MShopUserInsert{


public static function insertShopUsers(
    $members_username,
    $members_password,
    $members_email,
    $members_doj,
    $members_firstname,
    $members_lastname,
    $members_phone,
    $members_address,
    $members_city,
    $members_zip
) {

    $prefix      = config('services.ihook.prefix');
    $storeprefix = config('services.ihook.store_prefix');

    // Cart configure id from Laravel session
    $cartConfigureId = session('site_settings.cart_id.cart_configure_id');

    if ($cartConfigureId == 1) {
        return MWordPressUserInsert::wpRestInsert(
            $members_username,
            $members_password,
            $members_email,
            $members_doj
        );
    }


    if ($cartConfigureId == 2) {

        // Get Shopify settings
        $store_url = DB::table($prefix . '_sitesettings')
            ->where('sitesettings_name', 'shop_name')
            ->value('sitesettings_value');

        $access_token = DB::table($prefix . '_sitesettings')
            ->where('sitesettings_name', 'access_token')
            ->value('sitesettings_value');

        $api_key = DB::table($prefix . '_sitesettings')
            ->where('sitesettings_name', 'api_key')
            ->value('sitesettings_value');

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

            return $shopify_shop_id;
        }
    }

    return 0;
}

}

