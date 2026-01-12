<?php
/**
 * This class contains public static functions related to GoogleMap
 *
 * @package         MGoogleMap
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

class MGoogleMap {
    /**
     * This public static function is used  to updateGoogleMap
    */
    public static function updateGoogleMap() {

        if($_POST['google_map_api_key']!=''){
            MSiteFields::updateSiteFields('google_map_api_key');
        }
        foreach ($_POST as $key => $value) {
            $query = new Bin_Query();
            $sql_site = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table
                WHERE sitesettings_description='googlemap'
                AND sitesettings_name='" . $key . "'";
            if ($query->executeQuery($sql_site)) {
                $sql = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table
                        SET sitesettings_value='" . $value . "'
                        WHERE sitesettings_name='" . $key . "' AND
                        sitesettings_description='googlemap'";
                $obj = new Bin_Query();
                $obj->updateQuery($sql);
            } else {
                foreach ($_POST as $key => $value) {
                    $sql = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table
                            (sitesettings_value,sitesettings_name,sitesettings_description)
                            VALUES('" . $value . "','" . $key . "','googlemap')";
                    $obj = new Bin_Query();
                    $obj->updateQuery($sql);
                }
            }
        }
        $_SESSION['success_message'] = __('Integrations updated successfully');
    }
}
?>
