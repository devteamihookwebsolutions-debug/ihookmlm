<?php
/**
 * This class contains public static functions related to Banner .
 *
 * @package         MShopProduct
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

use Admin\App\Models\Shopify\MShopifyEshop;
use Admin\App\Models\Wordpress\MWordPressEshop;
class MShopProduct {

    public static function showEshopProducts()
    {
        if ($_SESSION['site_settings']['cart_id']['cart_configure_id'] == 1) {
            return MWordPressEshop::showProductList();
        }
        if ($_SESSION['site_settings']['cart_id']['cart_configure_id'] == 2) {
            return MShopifyEshop::showProductList();
        }
    }

    public static function editEshopProducts($eshop_id){
        if ($_SESSION['site_settings']['cart_id']['cart_configure_id'] == 1) {
            return MWordPressEshop::editEshopProducts($eshop_id);
        }
        if ($_SESSION['site_settings']['cart_id']['cart_configure_id'] == 2) {
            return MShopifyEshop::editEshopProducts($eshop_id);
        }
    }
}
?>
