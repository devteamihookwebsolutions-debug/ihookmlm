<?php
/**
 * This class contains public static functions related to ShopifyAutoship
 *
 * @package         MShopifyAutoship 
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement: 
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php
namespace Model\Scheduler;
use Query\Bin_Query;
use Model\Middleware\MSiteDetails;
use Model\Middleware\MMembersDetails;
class MShopifyAutoship
{
    /**
     * This public static function is used for shopifyAutoship
     * @return HTML data
     */
    public static function shopifyAutoship()
    {
        $sql = "SELECT * FROM  " . $_ENV['PROMLM_PREFIX'] . "shopify_autoship_product_details WHERE DATE(`next_autoship_on`) = CURDATE()";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records;
        for ($i = 0; $i < count((array)$records); $i++) {
            $product_id       = $records[$i]['product_id'];
            $quantity         = $records[$i]['quantity'];
            $autoship_details = $records[$i]['autoship_details'];
            $members_id       = $records[$i]['members_id'];
            $userdetails      = MMembersDetails::getUserDetails($members_id);
            $customer_id      = $userdetails['members_shopify_id'];
            $sitesettings     = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="shop_name"');
            $store_url        = $sitesettings[0]['sitesettings_value'];
            $sitesettings     = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="access_token"');
            $access_token     = $sitesettings[0]['sitesettings_value'];
            $sitesettings     = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="api_key"');
            $api_key          = $sitesettings[0]['sitesettings_value'];
            $url              = "https://" . $api_key . ":" . $access_token . "@" . $store_url . ".myshopify.com/admin/products/" . $product_id . ".json";
            $ch               = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json'
            ));
            $result      = curl_exec($ch);
            $products    = json_decode($result, 2);
            $variants_id = $products['product']['variants'][0]['id'];
            if ($autoship_details == '1') {
                $next_autoship_on = Date('Y-m-d', strtotime("+7 days"));
            } elseif ($autoship_details == '2') {
                $next_autoship_on = Date('Y-m-d', strtotime("+30 days"));
            } elseif ($autoship_details == '3') {
                $next_autoship_on = Date('Y-m-d', strtotime("+60 days"));
            } elseif ($autoship_details == '4') {
                $next_autoship_on = Date('Y-m-d', strtotime("+90 days"));
            }
            $data = array(
                'order' => array(
                    'line_items' => array(
                        0 => array(
                            'variant_id' => $variants_id,
                            'quantity' => $quantity
                        )
                    ),
                    'customer' => array(
                        'id' => $customer_id
                    ),
                    'financial_status' => 'paid'
                )
            );
            $url  = "https://" . $api_key . ":" . $access_token . "@" . $store_url . ".myshopify.com/admin/orders.json";
            $json = json_encode($data);
            $ch   = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json'
            ));
            $result    = curl_exec($ch);
            $obje      = new Bin_Query();
            $sqlstatus = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "shopify_autoship_product_details SET next_autoship_on=" . $next_autoship_on . " WHERE autoship_id=" . $records[$i]['autoship_id'] . "";
            $obje->updateQuery($sqlstatus);
        }
        echo "Cron Executed";
    }
}
?>