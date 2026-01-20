<?php

/**
 * This class contains public functions related to MZohoCRMCode
 *
 * @package         MZohoCRMCode
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
class MZohoCRMCode {
    /**
     * This public static function is used to get CRM code in third party integration
     */
    public static function getCRMcode() {
        $response = $_SERVER['REQUEST_URI'];
        $part1 = explode("&", $response);
        $part2 = explode("=", $part1[0]);
        $code = trim($part2[1]);
        $module = "zohocrm";
        $sql = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "thirdpartyintegration WHERE module='" . $module . "'";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records;
        $result = array();
        if (count($records) > 0) {
            for ($i = 0; $i < count($records); $i++) {
                $result[$records[$i]['metakey']] = $records[$i]['metavalue'];
            }
        }
        $zoho_clientid = trim($result['zoho_clientid']);
        $zoho_secretid = trim($result['zoho_secretid']);
        $zohoredirect = $_ENV['BCPATH'] . '/integration/getcrmcode';
        $tokenurl = 'https://accounts.zoho.com/oauth/v2/token?code=' . $code . '&redirect_uri=' . $zohoredirect . '&client_id=' . $zoho_clientid . '&client_secret=' . $zoho_secretid . '&grant_type=authorization_code';
        $resuacce = self::getZohoCurlAccess($tokenurl);
        $pareresult = json_decode($resuacce);
        $refresh_token = $pareresult->refresh_token;
        $sqlcheck = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "thirdpartyintegration WHERE metakey='refresh_token' AND module='zohocrm'";
        $objcheck = new Bin_Query();
        $objcheck->executeQuery($sqlcheck);
        $recordscheck = $objcheck->records;
        if (count($recordscheck) > 0) {
            $sqlUser = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "thirdpartyintegration SET metavalue='" . $refresh_token . "' WHERE metakey='refresh_token' AND module='zohocrm'";
            $objUser = new Bin_Query();
            $objUser->updateQuery($sqlUser);
        } else {
            $sqlUser = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "thirdpartyintegration(module,metakey,metavalue,integration_status)
                        VALUES('zohocrm','refresh_token','" . $refresh_token . "','1')";
            $objUser = new Bin_Query();
            $objUser->updateQuery($sqlUser);
        }

        return true;
    }

    /**
     * This public static function is used to get Zoho Curl Access connect
     */
    public static function getZohoCurlAccess($url) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array("cache-control: no-cache"),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
}
?>
