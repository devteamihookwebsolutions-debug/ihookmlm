<?php
/**
 * This class contains public static functions related to shopify installation.
 *
 * @package         Model_MShopifyInstallation
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?>
<?php
namespace Model\Shopify;
use Query\Bin_Query;

use Model\Factories\MSiteSettings;

class MShopifyInstallation {
    /**
     * This public static function is used  to showShopifyInstall
     */
    public static function showShopifyInstall() {
        $output = array();
        $query = new Bin_Query();
        $sql_site = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_description='shopifyconnection'";
        if ($query->executeQuery($sql_site)) {
            $records = $query->records;
            if (count((array)$records) > 0) {
                for ($i = 0;$i < count((array)$records);$i++) {
                    $fields[$query->records[$i]['sitesettings_name']] = $query->records[$i]['sitesettings_value'];
                }
            }

        }
        return $fields;
    }
     /**
     * This public static function is used  to updateAccessToken
     */
    public static function updateAccessToken($token) {
        $del_sql = "DELETE FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_name='access_token'
        AND sitesettings_description='shopifyconnection'";
        $obj = new Bin_Query();
        $obj->updateQuery($del_sql);
        $sql = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table
        (sitesettings_value,sitesettings_name,sitesettings_description)
        VALUES('" . $token . "','access_token','shopifyconnection')";
        $obj = new Bin_Query();
        $obj->updateQuery($sql);
        $del_sql = "DELETE FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_name='installation'
        AND sitesettings_description='shopifyconnection'";
        $obj = new Bin_Query();
        $obj->updateQuery($del_sql);
        $sql = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table
        (sitesettings_value,sitesettings_name,sitesettings_description)
        VALUES('success','installation','shopifyconnection')";
        $obj = new Bin_Query();
        $obj->updateQuery($sql);
        MSiteSettings::updateSiteAutoloadContent();
        $_SESSION['success_message']=''. __('Shopify connection details updated successfully') .'';
    }
     /**
     * This public static function is used  to updateScope
     */
    public static function updateScope($scope) {
    $output = '<table>
                    <tr>
                       <th>'. __('API access scopes') .'</th>
                       <th>'.__('Read').'</th>
                       <th>'.__('Write').'</th>
                    </tr>';
        foreach ($scope as $key => $value) {
            $output.= '<tr>
              <td>' . ucfirst($key) . '</td>';
            foreach ($value as $val) {
                $output.= '<td><input aria-label="label" type="checkbox" name="scopes[' . $key . '][]" value="' . $val . '" checked></td>';
            }
            $output.= '</tr>';
        }
        $output.= '</table>';
        $del_sql = "DELETE FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_name='scopes'
        AND sitesettings_description='shopifyconnection'";
        $obj = new Bin_Query();
        $obj->updateQuery($del_sql);


        $sql = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table
        (sitesettings_value,sitesettings_name,sitesettings_description)
        VALUES('" . $output . "','scopes','shopifyconnection')";
        $obj = new Bin_Query();
        $obj->updateQuery($sql);

        $query    = new Bin_Query();
        $sql_site = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table
        WHERE sitesettings_description='shopifyconnection'
        AND sitesettings_name='api_secret_key'";
        $query->executeQuery($sql_site);
        $api_secret_key= $query->records[0]['sitesettings_value'];


        $access_token=trim($api_secret_key);
        //access token and  install success update '
        $sql = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table
        (sitesettings_name,sitesettings_value,sitesettings_description)
        VALUES('access_token','" . $access_token . "','shopifyconnection')";
        $obj = new Bin_Query();
        $obj->updateQuery($sql);

        $sql = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table
        (sitesettings_name,sitesettings_value,sitesettings_description)
        VALUES('installation','success','shopifyconnection')";
        $obj = new Bin_Query();
        $obj->updateQuery($sql);
    }
}
?>
