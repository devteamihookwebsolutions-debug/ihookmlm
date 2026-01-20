<?php

/**
 * This class contains public functions related to MAppStore
 *
 * @package         MAppStore
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

use Admin\App\Models\Factories\MSiteSettings;
class MAppStore {
    /**
     * This public static function is used  to update app settings third party integration
    */
    public static function updateAppStoreSettings()
    {
        if(isset($_POST['submitplaystore'])){
            MSiteSettings::updateSiteFields('playstorestatus');
        }
        if(isset($_POST['submitappatore'])){
            MSiteSettings::updateSiteFields('appstorestatus');
        }
         if(isset($_POST['submitfirebase'])){
            MSiteSettings::updateSiteFields('firebasestatus');
        }
         foreach ($_POST as $key => $value) {
            if ($key != 'do' && $key != 'submit' && $key != 'action') {
                if ($key!='submitplaystore' || $key!='submitappatore' || $key!='submitfirebase') {
                    $query = new Bin_Query();
                    $sql_site = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table
                    WHERE sitesettings_description='appintegration'
                    AND sitesettings_name='" . $key . "'";
                    if ($query->executeQuery($sql_site)) {
                        $sql = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table
                            SET sitesettings_value='" . $value . "'
                            WHERE sitesettings_name='" . $key . "' AND
                            sitesettings_description='appintegration'";
                        $obj = new Bin_Query();
                        $obj->updateQuery($sql);
                    } else {
                        foreach ($_POST as $key => $value) {
                            $sql = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table
                                (sitesettings_value,sitesettings_name,sitesettings_description)
                                VALUES('" . $value . "','" . $key . "','appintegration')";
                            $obj = new Bin_Query();
                            $obj->updateQuery($sql);
                        }
                    }
                }
            }
        }
        MSiteSettings::updateSiteAutoloadContent();
        $_SESSION['success_message'] = '' . __('Integrations updated successfully') . '';
            header('Location: ' . $_ENV['BCPATH'] . '/integration');
            exit();
    }
    /**
     * This public static function is used to showappIntegration template
     */
    public static function showAppIntegration($err)
    {
        $output = array();
        $query = new Bin_Query();
        $sql_site = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_description='appintegration'";
        if ($query->executeQuery($sql_site)) {
            if (count((array)$records) > 0) {
                $cnt=count((array)$records);

                for ($i=0; $i <$cnt ; $i++) {

                $fields[$query->records[$i]['sitesettings_name']] = $query->records[$i]['sitesettings_value'];
            }
            if (count((array)$Err->messages) > 0) {
                $fields = $Err->values;
            }
        }
        return $fields;
        }

    }
}
?>
