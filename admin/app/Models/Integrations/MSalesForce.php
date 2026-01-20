<?php

/**
 * This class contains public functions related to MSalesForce
 *
 * @package         MSalesForce
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace Admin\App\Models\Integrations;

class MSalesForce {
    public static function getAccessToken() {
        $actual_link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $actual_link = explode('code=', $actual_link);
        $code = $actual_link[1];
        $_SESSION['salesforce_code'] = $code;
        header('Location:' . $_ENV['BCPATH'] . '/salesforce/updateaccesstoken');
        exit;
    }
    public static function updateAccessToken() {
        $client_id = $_SESSION['salesforce_client_id'];
        $client_secret = $_SESSION['salesforce_client_secret'];
        $salesforce_redirect_url = $_SESSION['salesforce_redirect_url'];
        $salesforce_loginbase_url = $_SESSION['salesforce_loginbase_url'];
        $code = $_SESSION['salesforce_code'];
        $curl = curl_init();
        curl_setopt_array($curl, array(CURLOPT_URL => $salesforce_loginbase_url . "/services/oauth2/token?grant_type=authorization_code&code=" . $code . "&client_id=" . $client_id . "&client_secret=" . $client_secret . "&redirect_uri=" . $salesforce_redirect_url . "", CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 30, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "POST", CURLOPT_HTTPHEADER => array("cache-control: no-cache",),));
        $response = curl_exec($curl);
        //$err = curl_error($curl);
        curl_close($curl);
        $pareresult = json_decode($response);
        $salesforce_access_token = $pareresult->access_token;
        $sqlcheck = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "thirdpartyintegration WHERE metakey='salesforce_access_token' AND module='salesforce'";
        $objcheck = new Bin_Query();
        $objcheck->executeQuery($sqlcheck);
        $records = $objcheck->records;
        if (count($records) > 0) {
            $sqlinte = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "thirdpartyintegration SET metavalue='" . trim($salesforce_access_token) . "',integration_status='1' WHERE metakey='salesforce_access_token' AND module='salesforce'";
            $objinte = new Bin_Query();
            $objinte->updateQuery($sqlinte);
        } else {
            $sqlUser = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "thirdpartyintegration(module,metakey,metavalue,integration_status)
                  VALUES('salesforce','salesforce_access_token','" . trim($salesforce_access_token) . "','1')";
            $objUser = new Bin_Query();
            $objUser->updateQuery($sqlUser);
        }
        $_SESSION['success_message'] = '' . __('Integrations updated successfully') . '';
        header('Location: ' . $_ENV['BCPATH'] . '/integration');
        exit();
    }
}
?>
