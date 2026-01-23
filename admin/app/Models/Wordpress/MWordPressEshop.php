<?php
/**
 * This class contains public static functions related to Banner .
 *
 * @package         MWordPressEshop
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
namespace Admin\App\Models\Wordpress;

use Admin\App\Display\Wordpress\DWordPressEshop;
use Admin\App\Models\Middleware\MSiteDetails;
class MWordPressEshop {

    public static function showProductList(){
      $key_where = "WHERE sitesettings_name ='woocommerce_key' ";
      $sitesettings = MSiteDetails::getSiteSettingsDetails($key_where);
      $woocommerce_key = $sitesettings[0]['sitesettings_value'];
      $secret_where = "WHERE sitesettings_name ='woocommerce_secret' ";
      $sitesettings = MSiteDetails::getSiteSettingsDetails($secret_where);
      $woocommerce_secret = $sitesettings[0]['sitesettings_value'];
      $key_where = "WHERE sitesettings_name ='woocommerce_path' ";
      $sitesettings = MSiteDetails::getSiteSettingsDetails($key_where);
      $path = $sitesettings[0]['sitesettings_value'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path.'/wp-json/wc/v3/products?consumer_key='.$woocommerce_key.'&consumer_secret='.$woocommerce_secret);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $records=json_decode($result);
        return DWordPressEshop::showProductList($records);
    }

    public static function editEshopProducts($eshop_id){
        $key_where = "WHERE sitesettings_name ='woocommerce_key' ";
      $sitesettings = MSiteDetails::getSiteSettingsDetails($key_where);
      $woocommerce_key = $sitesettings[0]['sitesettings_value'];
      $secret_where = "WHERE sitesettings_name ='woocommerce_secret' ";
      $sitesettings = MSiteDetails::getSiteSettingsDetails($secret_where);
      $woocommerce_secret = $sitesettings[0]['sitesettings_value'];
      $key_where = "WHERE sitesettings_name ='woocommerce_path' ";
      $sitesettings = MSiteDetails::getSiteSettingsDetails($key_where);
      $path = $sitesettings[0]['sitesettings_value'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path.'/wp-json/wc/v3/products?consumer_key='.$woocommerce_key.'&consumer_secret='.$woocommerce_secret);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $records=json_decode($result);

        return DWordPressEshop::editEshopProducts($records,$eshop_id);
    }
}
?>
