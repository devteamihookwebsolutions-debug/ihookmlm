<?php
/**
 * This class contains public static functions related to Banner .
 *
 * @package         MWordPressEshop
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
namespace Admin\App\Models\Wordpress;

use Admin\App\Models\Middleware\MSiteDetails;
class MWordPressUserInsert {
    /**
     * This public static function is used to insert new user details for wordpress
     * @param string $members_username
     * @param string $members_password
     * @param string $members_email
     * @param string $members_doj
     * @return int
     */
    public static function wpRestInsert($members_username, $wp_password, $members_email, $members_doj)
    {
        $key_where = "WHERE sitesettings_name ='woocommerce_key' ";
        $sitesettings = MSiteDetails::getSiteSettingsDetails($key_where);
        $woocommerce_key = trim($sitesettings[0]['sitesettings_value']);
        $secret_where = "WHERE sitesettings_name ='woocommerce_secret' ";
        $sitesettings = MSiteDetails::getSiteSettingsDetails($secret_where);
        $woocommerce_secret = trim($sitesettings[0]['sitesettings_value']);
        $key_where = "WHERE sitesettings_name ='woocommerce_path' ";
        $sitesettings = MSiteDetails::getSiteSettingsDetails($key_where);
        $path = trim($sitesettings[0]['sitesettings_value']);
        $postdata = '{
                  "email": "' . $members_email . '",
                  "first_name": "' . $members_username . '",
                  "password":"' . $wp_password . '",
                  "last_name": "' . $members_username . '",
                  "username": "' . $members_username . '"
                }';
        $url = "" . $path . "/wp-json/wc/v3/customers?consumer_key=" . $woocommerce_key . "&consumer_secret=" . $woocommerce_secret . "";
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $url, CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "POST", CURLOPT_POSTFIELDS => $postdata,
                CURLOPT_HTTPHEADER => array("cache-control: no-cache", "content-type: application/json", "postman-token: 59a6f202-ddd2-e493-73b0-a3018d0c0976"),
            )
        );
        $response = curl_exec($curl);
        $data_json = json_decode($response, 2);
        // print_R($data_json); exit;
        $err = curl_error($curl);
        curl_close($curl);
        return $data_json['id'];
    }
}
?>
