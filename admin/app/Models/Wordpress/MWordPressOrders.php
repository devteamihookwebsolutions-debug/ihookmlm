<?php
/**
 * This class contains functions related to wordpress orders .
 *
 * @package         MWordPressOrders
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

use Admin\App\Models\Middleware\MSiteDetails;
use Illuminate\Http\Client\HttpClientException;
class MWordPressOrders {

    public static function insertWordPressOrders($members_firstname, $members_lastname, $members_address, $members_address2, $members_address3, $members_city, $members_state, $members_zip, $members_country, $members_email, $members_phone,$product_id,$quantity,$payment)
    {
        $key_where          = "WHERE sitesettings_name ='woocommerce_key' ";
        $sitesettings       = MSiteDetails::getSiteSettingsDetails($key_where);
        $woocommerce_key    = $sitesettings[0]['sitesettings_value'];
        $secret_where       = "WHERE sitesettings_name ='woocommerce_secret' ";
        $sitesettings       = MSiteDetails::getSiteSettingsDetails($secret_where);
        $woocommerce_secret = $sitesettings[0]['sitesettings_value'];
        $key_where          = "WHERE sitesettings_name ='woocommerce_path' ";
        $sitesettings       = MSiteDetails::getSiteSettingsDetails($key_where);
        $path               = $sitesettings[0]['sitesettings_value'];
        //fetch user details
        try {
            $postdata = '{
                    "payment_method" : "' . $payment . '",
                    "payment_method_title" : "' . $payment . '",
                    "set_paid" : true,
                    "billing" : {
                       "first_name": "' . $members_firstname . '",
                        "last_name" : "' . $members_lastname . '",
                        "address_1" : "' . $members_address . '",
                        "address_2" : "' . $members_address2 . '",
                        "address_3" : "' . $members_address3 . '",
                        "city": "' . $members_city . '",
                        "state" : "' . $members_state . '",
                        "postcode" : "' . $members_zip . '",
                        "country" : "' . $country . '",
                        "email" : "' . $members_email . '",
                        "phone" : "' . $members_phone . '"
                    },
                    "shipping" : {
                       "first_name": "' . $members_firstname . '",
                        "last_name" : "' . $members_lastname . '",
                        "address_1" : "' . $members_address . '",
                        "address_2" : "' . $members_address2 . '",
                        "address_3" : "' . $members_address3 . '",
                        "city" : "' . $members_city . '",
                        "state" : "' . $members_state . '",
                        "postcode": "' . $members_zip . '",
                        "country" : "' . $members_country . '"
                    },
                    "line_items": [
                        {
                            "product_id": "' . $product_id . '",
                            "quantity" : "'.$quantity.'"
                        }
                    ]
                }';
            $curl     = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "" . $path . "/wp-json/wc/v3/orders?consumer_key=" . $woocommerce_key . "&consumer_secret=" . $woocommerce_secret . "",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $postdata,
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/json"
                )
            ));
            $response = curl_exec($curl);
            $err      = curl_error($curl);
            curl_close($curl);
            if ($err) {
                //echo "cURL Error #:" . $err;
            } else {
                //echo $response; exit;
            }
        }
        catch (HttpClientException $e) {
        }
        $autoshipresult = json_decode($response);

        return $autoshipresult;
    }
}
?>
