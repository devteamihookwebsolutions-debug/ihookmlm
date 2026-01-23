<?php
/**
 * This class contains public static functions related to E-SHOP .
 *
 * @package         MShopOrders
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright        Copyright (c) 2025 - 2026, Ihook.
 * @version        Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?>
<?php
namespace Admin\App\Models\ShopAncillary;

use Admin\App\Models\Shopify\MShopifyOrders;
use Admin\App\Models\Wordpress\MWordPressOrders;
class MShopOrders {

    public static function insertEshopOrder($members_firstname, $members_lastname, $members_address, $members_address2, $members_address3, $members_city, $members_state, $members_zip, $members_country, $members_email, $members_phone,$product_id,$quantity)
    {
        if ($_SESSION['site_settings']['cart_id']['cart_configure_id'] == 1) {
            return MWordPressOrders::insertWordPressOrders($members_firstname, $members_lastname, $members_address, $members_address2, $members_address3, $members_city, $members_state, $members_zip, $members_country, $members_email, $members_phone,$product_id,$quantity,'Cash on delivery');
        }
        if ($_SESSION['site_settings']['cart_id']['cart_configure_id'] == 2) {
            return MShopifyOrders::insertShopifyOrders($members_firstname, $members_lastname, $members_address, $members_address2, $members_address3, $members_city, $members_state, $members_zip, $members_country, $members_email, $members_phone,$product_id,$quantity,'Cash on delivery');
        }
    }
}
?>
