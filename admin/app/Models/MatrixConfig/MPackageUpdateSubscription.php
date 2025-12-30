<?php
/**
 * This class contains public static functions related to Banner .
 *
 * @package         MPackageUpdateSubscription
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://promlmsoftware.com
 * @copyright      Copyright (c) 2020 - 2023, Sunsofty.
 * @version        Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?>
<?php

namespace Model\MatrixConfig;

use Query\Bin_Query;
use Model\Middleware\MPackageDetails;
use Model\Middleware\MPaymentGatewayDetails;
use Model\Middleware\MCryptoGraphy;

class MPackageUpdateSubscription
{
    /**
       * This public static function is used  to update sub package
       * @return Void data
       */
    public static function updateSubPackagePay()
    {
        $package_id = $_POST['subscription_package_id'];
        $packageobject = MPackageDetails::getPackageDetails($package_id);
        $pack_payment = $packageobject['pack_payment'];
        $pack_payment_arr = unserialize($pack_payment);
        $pack_payment_fields = unserialize($packageobject['pack_payment_fields']);
        $plan_id_unser = unserialize($packageobject['plan_id']);
        $package_name = $packageobject['package_name'];
        $package_price = $packageobject['package_price'];
        $site_currency_code = $_SESSION['site_settings']['site_currency_code'];
        foreach ($pack_payment_arr as $key => $value) {
            if ($value == "stripe") {
                if (!isset($pack_payment_fields['stripe'])) {
                    $where = 'WHERE paymentsettings_default_name="stripe"';
                    $stripedetails = MPaymentGatewayDetails::getPaymentGatewayDetails($where);
                    $secretkey = $stripedetails['paymentsettings_accnum'];


                    $secretkey = MCryptoGraphy::decryptionData($secretkey);
                    $plan_id = str_replace(' ', '_', $package_name);
                    $stripe_amt = floatval($package_price) * 100;
                    if ($stripedetails['paymentsettings_mode'] == 'sandbox') {
                        $paymenturl = $stripedetails['payment_testurl'];
                    } else {
                        $paymenturl = $stripedetails['payment_liveurl'];
                    }
                    // Generated plan/

               
                }
            }
            if ($value == "chargebee") {
                if (!isset($pack_payment_fields['chargebee'])) {
                    $where = 'WHERE paymentsettings_default_name="chargebee"';
                    $chargebeedetails = MPaymentGatewayDetails::getPaymentGatewayDetails($where);
                    $apikey = trim($chargebeedetails['paymentsettings_accname']);
                    $sitename = trim($chargebeedetails['paymentsettings_accnum']);
                    $apikeyuser = $apikey."::";
                    $apikeyval = base64_encode($apikeyuser);
                    $plan_id = str_replace(' ', '_', $package_name);
                    $chargebee_amt =  floatval($package_price) * 100;
                    if ($chargebeedetails['paymentsettings_mode'] == 'sandbox') {
                        $sitename = trim($sitename.$chargebeedetails['payment_testurl']);
                    } else {
                        $sitename = trim($sitename.$chargebeedetails['payment_liveurl']);
                    }
                    $package_nameid = str_replace(' ', '', $package_name);
                    try {
                       
                    } catch (ChargeBee_PaymentException $e) {
                        echo "0";
                    }
                    $pack_payment_fields_arr['chargebee'] = array('interval_selector' => $_POST['interval_selector_chargebee'],'trial_period_days' => $_POST['trial_period_days_chargebee']);
                    $pack_id_arr['chargebee'] = $plan_id;
                }
            }
            if ($value == "paypal") {
                if (!isset($pack_payment_fields['paypal'])) {
                    if ($_POST['paymenttype_paypal'] == "sandbox") {
                        $billingplanurl = "https://api.sandbox.paypal.com/v1/payments/billing-plans/";
                        $tokenurl = "https://api.sandbox.paypal.com/v1/oauth2/token?grant_type=client_credentials";
                    } else {
                        $billingplanurl = "https://api.paypal.com/v1/payments/billing-plans/";
                        $tokenurl = "https://api.paypal.com/v1/oauth2/token?grant_type=client_credentials";
                    }
                    //Access Token Generate
                    $accesstoken_data = '{ "grant_type": "client_credentials" }';
                    $str = $_POST['clientid_paypal'] . ':' . $_POST['secretid_paypal'];
                    $paypal_auth = "Basic " . base64_encode($str);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $tokenurl);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $accesstoken_data); //Post Fields
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $headers = ['Authorization: ' . $paypal_auth, 'Accept: application/json', 'Content-Type: application/x-www-form-urlencoded', 'Accept-Language: en_US', 'Cache-Control: no-cache'];
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $token_output = curl_exec($ch);
                    $token_response = json_decode($token_output);
                    $access_token = $token_response->access_token;
                    curl_close($ch);
                    //Access Token Generate End
                    //Billing Plan Create - Start
                    $plan_id = str_replace(' ', '_', $package_name);
                    $paypal_amt = floatval($package_price) * 100;
                    $paypal_token = 'Bearer ' . $access_token;
                    $paypal_amt = $paypal_amt / 100;
                    $billingplan_data = '{ "name": "' . $plan_id . '", "description": "' . $plan_id . '", "type": "FIXED",  "payment_definitions": [ { "name": "' . $plan_id . '", "type": "REGULAR", "frequency": "' . $_POST['interval_selector_paypal'] . '", "frequency_interval": "1", "amount": { "value": "' . $paypal_amt . '", "currency": "' . $site_currency_code . '" }, "cycles": "12" } ], "merchant_preferences": { "setup_fee": { "value": "1", "currency": "' . $site_currency_code . '" }, "return_url": "https://example.com", "cancel_url": "https://example.com/cancel", "auto_bill_amount": "YES", "initial_fail_amount_action": "CONTINUE", "max_fail_attempts": "0" } }';
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $billingplanurl);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $billingplan_data); //Post Fields
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $headers = ['Authorization: ' . $paypal_token, 'Content-Type: application/json'];
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $plan_output = curl_exec($ch);
                    $plan_response = json_decode($plan_output);
                    $plan_id = $plan_response->id;
                    curl_close($plan_response);
                    //Create Billing Plans -end
                    //Update Billing Plan Status
                    $updateplan_url = $billingplanurl . $plan_id;
                    $updateplan_data = '[{"op": "replace","path": "/","value": {"state": "ACTIVE"}}]';
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $updateplan_url);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $updateplan_data); //Post Fields
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $headers = ['Authorization: ' . $paypal_token, 'Content-Type: application/json'];
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $planupdate_output = curl_exec($ch);
                    curl_close($planupdate_output);
                    //Update Billing Plan End
                    $pack_payment_fields_arr['paypal'] = array('interval_selector' => $_POST['interval_selector_paypal'], 'clientid_paypal' => $_POST['clientid_paypal'], 'secretid_paypal' => $_POST['secretid_paypal'], 'paymenttype_paypal' => $_POST['paymenttype_paypal']);
                    $pack_id_arr['paypal'] = $plan_id;
                }
            }
        }



        if ($packageobject['pack_payment_fields'] == "") {
            $ser_pack_payment_fields_arr = serialize($pack_payment_fields_arr);
        } else {
            // Ensure $pack_payment_fields and $pack_payment_fields_arr are arrays
            $pack_payment_fields = is_array($pack_payment_fields) ? $pack_payment_fields : [];
            $pack_payment_fields_arr = is_array($pack_payment_fields_arr) ? $pack_payment_fields_arr : [];
            $field_merge = array_merge($pack_payment_fields, $pack_payment_fields_arr);
            $ser_pack_payment_fields_arr = serialize($field_merge);
        }

        if ($packageobject['plan_id'] == "") {
            $ser_pack_id_arr = serialize($pack_id_arr);
        } else {
            // Ensure $plan_id_unser and $pack_id_arr are arrays
            $plan_id_unser = is_array($plan_id_unser) ? $plan_id_unser : [];
            $pack_id_arr = is_array($pack_id_arr) ? $pack_id_arr : [];
            $pack_merge = array_merge($plan_id_unser, $pack_id_arr);
            $ser_pack_id_arr = serialize($pack_merge);
        }

      Package::where('package_id', $package_id)
        ->update([
            'pack_payment_fields' => $ser_pack_payment_fields_arr,
            'plan_id'             => $ser_pack_id_arr,
            'stripe_planid'       => $plan_id,
        ]);
    }
}
?>