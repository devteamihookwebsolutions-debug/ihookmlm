<?php
/**
 * This class contains public static functions related to show autoship
 *
 * @package         MAutoShipCron
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://promlmsoftware.com
 * @copyright        Copyright (c) 2017 - 2020, Sunsofty.
 * @version         Version 10.4
 */
/****************************************************************************
* Licence Agreement: 
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?><?php
namespace Model\Scheduler\AutoShip;
use Query\Bin_Query;
use Model\Middleware\MSiteDetails;
class MAutoShipCron{

	public static function runCronAutoShip()
	{
        $today = date("Y-m-d");        
        $sitesettings     = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="shop_name"');
        $store_url        = $sitesettings[0]['sitesettings_value'];
        $sitesettings     = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="access_token"');
        $access_token     = $sitesettings[0]['sitesettings_value'];
        $sitesettings     = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="api_key"');
        $api_key          = $sitesettings[0]['sitesettings_value'];

        $key_where          = "WHERE sitesettings_name ='woocommerce_key' ";
        $sitesettings       = MSiteDetails::getSiteSettingsDetails($key_where);
        $woocommerce_key    = $sitesettings[0]['sitesettings_value'];
        $secret_where       = "WHERE sitesettings_name ='woocommerce_secret' ";
        $sitesettings       = MSiteDetails::getSiteSettingsDetails($secret_where);
        $woocommerce_secret = $sitesettings[0]['sitesettings_value'];
        $key_where          = "WHERE sitesettings_name ='woocommerce_path' ";
        $sitesettings       = MSiteDetails::getSiteSettingsDetails($key_where);
        $path               = $sitesettings[0]['sitesettings_value'];
		
        $sql = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "autoship_product as a LEFT JOIN " . $_ENV['PROMLM_PREFIX'] . "members_table as b on b.members_id=a.autoship_members_id WHERE a.status='2' AND next_autoship='$today'";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records;
        for($i=0;$i<count((array)$records);$i++)
        {
            $date = $records[$i]['shipping_date'];
            $month = $records[$i]['shipping_month'];
            $year = $records[$i]['shipping_year'];
            $type = $records[$i]['subscription_id'];
			$dt = strtotime($today);	
			$quantity = $records[$i]['product_quantity'];
            $next_autoship = date("Y-m-d", strtotime("+1 ".$type."", $dt));
			$members_id = $records[$i]['autoship_members_id'];
            $product_id = $records[$i]['product_id'];
			$sub1 = $records[$i]['autoship_product_id'];
			$members_address = $records[$i]['address1'];
			$members_address2 = $records[$i]['address2'];				
			$members_city = $records[$i]['city'];				
			$members_state = $records[$i]['state'];  
			$members_zip = $records[$i]['zip'];  
			$members_country = $records[$i]['country']; 
			$sql1 = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "members_table WHERE members_id='$members_id'";
			$obj1 = new Bin_Query();
			$obj1->executeQuery($sql1);
			$records1 = $obj1->records;
			$customer_id = $records1[0]['members_shopify_id'];
			$username = $records1[0]['members_username'];
			$email = $records1[0]['members_email'];
			$billing_members_firstname = $records1[0]['members_firstname'];
			$billing_members_lastname = $records1[0]['members_lastname'];		
			$billing_members_address = $records1[0]['members_address'];
			$billing_members_address2 = $records1[0]['members_address2'];	
			$billing_members_address3 = $records1[0]['members_address3'];	
			$billing_members_city	= $records1[0]['members_city'];	
			$billing_members_state = $records1[0]['members_state'];		
			$billing_members_zip = $records1[0]['members_zip'];
			$billing_country = $records1[0]['members_country'];
			$billing_members_email	= $records1[0]['members_email'];
			$billing_members_phone = $records1[0]['members_phone'];				
			if($_SESSION['site_settings']['cart_id']['cart_configure_id'] == 1)
			{
            $postdata = '{
                    "payment_method" : "' . $payment . '",
                    "payment_method_title" : "' . $payment . '",
                    "set_paid" : true,
                    "billing" : {
                       "first_name": "' . $billing_members_firstname . '",
                        "last_name" : "' . $billing_members_lastname . '",
                        "address_1" : "' . $billing_members_address . '",
                        "address_2" : "' . $billing_members_address2 . '",
                        "address_3" : "' . $billing_members_address3 . '",
                        "city": "' . $billing_members_city . '",
                        "state" : "' . $billing_members_state . '",
                        "postcode" : "' . $billing_members_zip . '",
                        "country" : "' . $billing_country . '",
                        "email" : "' . $billing_members_email . '",
                        "phone" : "' . $billing_members_phone . '"
                    },
                    "shipping" : {
                       "first_name": "' . $billing_members_firstname . '",
                        "last_name" : "' . $billing_members_lastname . '",
                        "address_1" : "' . $members_address . '",
                        "address_2" : "' . $members_address2 . '",
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
            $details = json_decode($response,true);            
            $order_id = $details['order_key'];	
			if($order_id != '')
			{
                                    $updateQuery           = new Bin_Query();         			
                                    $sql_level = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "autoship_product SET previous_autoship='".$today."',next_autoship='".$next_autoship."' WHERE autoship_product_id='" . $sub1 . "'";
                                    $updateQuery->executeQuery($sql_level);		 												
			}				
			}
			if($_SESSION['site_settings']['cart_id']['cart_configure_id'] == 2)
			{			
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
						'name'=>$username,
						'email'=>$email
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
	        $result    = json_decode($result, 2);	
			$order_id = $result['order']['id'];
			if($order_id != '')
			{
                                    $updateQuery           = new Bin_Query();         			
                                    $sql_level = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "autoship_product SET previous_autoship='".$today."',next_autoship='".$next_autoship."' WHERE autoship_product_id='" . $sub1 . "'";
                                    $updateQuery->executeQuery($sql_level);		 												
			}
		}
 	}		
} 
}
?>