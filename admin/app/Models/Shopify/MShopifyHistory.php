<?php
/**
 * This class contains public static functions related to shopify history.
 *
 * @package         MShopifyHistory
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
?><?php
namespace Admin\App\Models\Shopify;

use Admin\App\Display\Shopify\DShopifyHistory;
use Admin\App\Models\Middleware\MSiteDetails;

class MShopifyHistory {

    public static function getPurchaseHistory() {
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="shop_name"');
        $store_url = $sitesettings[0]['sitesettings_value'];
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="access_token"');
        $access_token = $sitesettings[0]['sitesettings_value'];
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="api_key"');
        $api_key = $sitesettings[0]['sitesettings_value'];


        $url = "https://" . $api_key . ":" . $access_token . "@" . $store_url . ".myshopify.com/admin/orders.json?status=any&fulfillment_status=any";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',));
        $result = curl_exec($ch);
        $orders = json_decode($result, 2);
        curl_close ($ch);
        return DShopifyHistory::getPurchaseHistory($orders['orders']);
    }

    public static function getOrderDetails($order_id) {
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="shop_name"');
        $store_url = $sitesettings[0]['sitesettings_value'];
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="access_token"');
        $access_token = $sitesettings[0]['sitesettings_value'];
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="api_key"');
        $api_key = $sitesettings[0]['sitesettings_value'];
        $url = "https://" . $api_key . ":" . $access_token . "@" . $store_url . ".myshopify.com/admin/orders/" . $order_id . ".json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',));
        $result = curl_exec($ch);
        $orderdetails = json_decode($result, 2);
        curl_close ($ch);
        return DShopifyHistory::showOrderDetails($orderdetails['order']);
    }
}
?>
