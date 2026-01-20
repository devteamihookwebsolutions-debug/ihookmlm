<?php

/**
 * This class contains public functions related to MMailChimpIntegrations
 *
 * @package         MMailChimpIntegrations
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace Admin\App\Models\Integrations;

class MMailChimpIntegrations {
    /**
     * This public static function is used to setgoogleTagManager template
     * @return html
     */
    public static function setMailChimpIntegration() {
        $mailchimp_apikey = trim($_POST['mailchimp_apikey']);
            $mailchimp_apiurl = trim($_POST['mailchimp_apiurl']);
            $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="site_name"');
            $site_name = $sitesettings[0]['sitesettings_value'];
            $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="admin_mail_id"');
            $admin_mail_id = $sitesettings[0]['sitesettings_value'];
            $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="company_address"');
            $company_address = $sitesettings[0]['sitesettings_value'];
            $urlaccess = 'lists';
            $json_data = '{"name":"' . $site_name . '","contact":{"company":"' . $site_name . '","address1":"' . $company_address . '","address2":"' . $company_address . '","city":"","state":"","zip":"","country":"","phone":""},"permission_reminder":"' . $site_name . '","campaign_defaults":{"from_name":"' . $site_name . '","from_email":"' . $admin_mail_id . '","subject":"","language":"en"},"email_type_option":true}';
            $response = self::mailchimpaccess($mailchimp_apikey, $mailchimp_apiurl, $urlaccess, $json_data);
            $mailchimp_list_id = $response->id;
            if($mailchimp_list_id==''){
               $mailchimp_list_id = $response->lists[0]->id;
            }
             $sqlcheck = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "thirdpartyintegration WHERE metakey='mailchimp_listid' AND module='mailchimp'";
                    $objcheck = new Bin_Query();
                    $objcheck->executeQuery($sqlcheck);
                    $records = $objcheck->records;
                    if (count($records) > 0) {
                         $sqlinte = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "thirdpartyintegration SET metavalue='" . trim($mailchimp_list_id). "',integration_status='1' WHERE metakey='mailchimp_listid' AND module='mailchimp'";
                        $objinte = new Bin_Query();
                        $objinte->updateQuery($sqlinte);
                    } else {
                         $sqlUser = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "thirdpartyintegration(module,metakey,metavalue,integration_status)
                    VALUES('mailchimp','mailchimp_listid','" . trim($mailchimp_list_id) . "','1')";
                        $objUser = new Bin_Query();
                        $objUser->updateQuery($sqlUser);
                    }

    }
    public static function mailchimpaccess($api_key, $url, $urlaccess, $json_data) {

        $curlopt_url = $url.$urlaccess;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $curlopt_url);
        curl_setopt($ch, CURLOPT_USERPWD, "user:" . $api_key);
        curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/3.0');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        $reponse = curl_exec($ch);
        $result=json_decode($reponse);
        $title=$result->title;
        $status=$result->status;
       if(trim($status)=='403'){
            // Query String Perameters are here
            // for more reference please vizit http://developer.mailchimp.com/documentation/mailchimp/reference/lists/
            $data = array(
                'fields' => 'lists', // total_items, _links
                //'email' => 'misha@rudrastyh.com',
                'count' => 5, // the number of lists to return, default - all
            );
            $url = 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/';
            $result = json_decode( self::rudr_mailchimp_curl_connect( $url, 'GET', $api_key, $data) );
       }
       return $result;
    }
}
