<?php
/**
 * This class contains public static functions related to Banner .
 *
 * @package         MShopifyEshop
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
namespace Admin\App\Models\Shopify;

use Admin\App\Display\Shopify\DShopifyEshop;
use Admin\App\Models\Middleware\MSiteDetails;
class MShopifyEshop {
    /**
     * This public static function is used  to shopifyProducts
    */
    public static function showProductList() {
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="shop_name"');
        $store_url = $sitesettings[0]['sitesettings_value'];
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="access_token"');
        $access_token = $sitesettings[0]['sitesettings_value'];
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="api_key"');
        $api_key = $sitesettings[0]['sitesettings_value'];
        $url = "https://" . $api_key . ":" . $access_token . "@" . $store_url . ".myshopify.com/admin/products.json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',));
        $result = curl_exec($ch);
        $records = json_decode($result, 2);
        curl_close ($ch);
        $shop_url = $store_url . '.myshopify.com';
        return DShopifyEshop::showProductList($records['products'], $shop_url);
    }

    public static function editEshopProducts($eshop_id){
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="shop_name"');
          $store_url = $sitesettings[0]['sitesettings_value'];
          $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="access_token"');
          $access_token = $sitesettings[0]['sitesettings_value'];
          $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="api_key"');
          $api_key = $sitesettings[0]['sitesettings_value'];
          $url = "https://" . $api_key . ":" . $access_token . "@" . $store_url . ".myshopify.com/admin/products.json";
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',));
          $result = curl_exec($ch);
          $records = json_decode($result, 2);
          curl_close ($ch);
          return DShopifyEshop::editEshopProducts($records['products'],$eshop_id);
      }
}
?>
