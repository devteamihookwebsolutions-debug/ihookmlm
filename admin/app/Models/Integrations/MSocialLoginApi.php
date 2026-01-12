<?php
/**
 * This class contains public static functions related to social login api.
 *
 * @package         MSocialLoginApi
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
namespace Admin\Models\Integrations;
class MSocialLoginApi {
    /**
     * This public static function is used  to updateSocialLoginApi Twitter
    */
    public static function updateSocialLoginApi() {
        if($_POST['configure']=='googlelogin'){
            MSiteFields::updateSiteFields('googleloginstatus');
        }
        if($_POST['configure']=='facebook'){
            MSiteFields::updateSiteFields('facebookstatus');
        }
        if($_POST['configure']=='twitter'){
            MSiteFields::updateSiteFields('twitterloginstatus');
        }
        if($_POST['configure']=='instagram'){
            MSiteFields::updateSiteFields('instaloginstatus');
        }
        if($_POST['configure']=='linkedin'){
            MSiteFields::updateSiteFields('linkedinloginstatus');
        }
        foreach ($_POST as $key => $value) {
            if ($key != 'do' && $key != 'submit' && $key != 'action') {
                $query = new Bin_Query();
                $sql_site = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table
                WHERE sitesettings_description='socialloginapi'
                AND sitesettings_name='" . $key . "'";
                if ($query->executeQuery($sql_site)) {
                    $sql = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table
                        SET sitesettings_value='" . $value . "'
                        WHERE sitesettings_name='" . $key . "' AND
                        sitesettings_description='socialloginapi'";
                    $obj = new Bin_Query();
                    $obj->updateQuery($sql);
                } else {
                    foreach ($_POST as $key => $value) {
                        $sql = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table
                            (sitesettings_value,sitesettings_name,sitesettings_description)
                            VALUES('" . $value . "','" . $key . "','socialloginapi')";
                        $obj = new Bin_Query();
                        $obj->updateQuery($sql);
                    }
                }
            }
        }
        $_SESSION['success_message'] = __('Integrations updated successfully');
    }
     /**
     * This public static function is used  to showSocialLoginApi
    */
    public static function showSocialLoginApi($Err) {
        $output = array();
        $query = new Bin_Query();
        $sql_site = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_description='socialloginapi'";
        if ($query->executeQuery($sql_site)) {
            $cnt=count((array)$records);
            for ($i=0; $i < $cnt; $i++) {
                $fields[$query->records[$i]['sitesettings_name']] = $query->records[$i]['sitesettings_value'];
            }
            if (count((array)$Err->messages) > 0) {
                $fields = $Err->values;
            }
        }
        return $fields;
    }
}
?>
