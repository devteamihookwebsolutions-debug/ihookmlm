<?php
/**
 * This class contains public static functions related to shopify user
 *
 * @package         MShopifyUser
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php
namespace Admin\App\Models\Shopify;

use Exception;
class MShopifyUserInsert
{
    public static function insertShopifyuser($members_username, $members_password, $members_email, $members_doj, $members_ip_address, $members_firstname, $members_lastname, $members_state, $members_city, $members_address, $members_address2, $members_address3, $members_phone, $members_zip, $members_country, $members_group_id, $members_alternate_email, $matrix_id, $members_from, $members_image, $members_thumb_image, $members_id_proof, $members_pan_tax_document, $store_url, $access_token, $api_key)
    {

        try {

            if($members_firstname!='' && $members_email!='' && $members_phone!='' && $members_zip!='' && $members_city!='' && $members_lastname!=''){
                $customer_array = array(
                    'customer' => array(
                        'first_name' => $members_firstname,
                        'last_name' => $members_lastname,
                        'email' => $members_email,
                        'phone' => $members_phone,
                        'note' => $members_username,
                        'verified_email' => true,
                        'addresses' => array(
                            0 => array(
                                'address1' => $members_address,
                                'city' => $members_city,
                                'phone' => $members_phone,
                                'zip' => $members_zip,
                                'last_name' => $members_lastname,
                                'first_name' => $members_firstname,
                                'country_code'=>$members_country,
                                'province_code'=>$members_state
                            )
                        ),
                        'send_email_invite' => true
                    )
                );
            }else{

                $customer_array = array(
                    'customer' => array(
                        'first_name' => $members_username,
                        'last_name' => $members_username,
                        'note' => $members_username,
                        'email' => $members_email,
                        'verified_email' => true,
                        'send_email_invite' => true
                    )
                );

            }
            $data           = json_encode($customer_array);
            $url            = "https://" . $api_key . ":" . $access_token . "@" . $store_url . ".myshopify.com/admin/customers.json";
            $ch             = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json'
            ));
            $result    = curl_exec($ch);
            $customer  = json_decode($result, true);
            $error_msg = curl_error($ch);
            $error     = json_decode($error_msg);
            curl_close ($ch);

            if($customer['errors']){
				$err = array_keys($customer['errors'])[0];
				$error = $err.' '.$customer['errors'][$err][0];
            }
            if (count((array)$error) > 0) {

                $_SESSION['error_message'] = $error.' In Shopify Store';
                if(isset($_SESSION['recruit']))
                {
                    header("Location:" .$_ENV['FCPATH']. "/recruituser/recruit");
                    exit;
                }else{
                    header("Location:" .$_ENV['FCPATH']. "/register");
                    exit;
                }

            } else {
                return $customer['customer']['id'];
            }
        }
        catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage() . ' In Shopify Store';
            if(isset($_SESSION['recruit']))
            {
                header("Location:" .$_ENV['FCPATH']. "/recruituser/recruit");
                exit;
            }else{
                header("Location:" .$_ENV['FCPATH']. "/register");
                exit;
            }
        }
    }
}
?>
