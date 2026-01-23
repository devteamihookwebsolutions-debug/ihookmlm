<?php
/**
 * This class contains public static functions related to E-SHOP .
 *
 * @package         MShopifyOrders
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

use Admin\App\Models\Middleware\MSiteDetails;
class MShopifyOrders {

    public static function insertShopifyOrders($members_firstname, $members_lastname, $members_address, $members_address2, $members_address3, $members_city, $members_state, $members_zip, $members_country, $members_email, $members_phone,$product_id,$quantity,$autoship_details,$customer_id )
    {
        $members_phone = preg_replace('/[^0-9]/', '', $members_phone); // Remove non-numeric characters
$members_phone = '+1' . $members_phone; // Add country code (change +1 based on your country)
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
        if ($autoship_details == '5') {
            $data = array(
                'order' => array(
                    'line_items' => array(
                        0 => array(
                            'variant_id' => $variants_id,
                            'quantity' => $quantity
                        )
                    ),
                    'customer' => array(
                        'id' => $customer_id,
                        'first_name' => $members_firstname, // Ensure first name is provided
                        'last_name'  => $members_lastname,  // Ensure last name is provided
                        'email'      => $members_email,     // Ensure email is provided
                        'phone'      => $members_phone      // Ensure phone number is provided
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
            $result                      = curl_exec($ch);
            curl_close ($ch);
            $response = json_decode($result);
           // Check for errors in response
            if (isset($response->errors)) {
                $error_messages = [];

                // Loop through error messages
                foreach ($response->errors as $key => $messages) {
                    if (is_array($messages)) {
                        foreach ($messages as $msg) {
                            $error_messages[] = ucfirst($key) . ': ' . $msg;
                        }
                    } else {
                        $error_messages[] = ucfirst($key) . ': ' . $messages;
                    }
                }

                // Store error message in session
                $_SESSION['error_message'] = implode(", ", $error_messages);

                // Redirect to Shopify products page
                header("Location: " . $_ENV['FCPATH'] . "/shopify_products");
                exit;
            }
            return $result;
        }
    }

}
?>
