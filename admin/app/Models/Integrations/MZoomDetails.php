<?php

/**
 * This class contains public functions related to MZoomDetails
 *
 * @package         MZoomDetails
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
namespace Admin\Models\Integrations;



class MZoomDetails {


    public static function updateIntegration() {
        foreach ($_POST as $key => $value)
        {
            if ($key != 'do' && $key != 'submit' && $key != 'action') {
                $sql_check = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_name='" . trim($key)."' AND sitesettings_description='zoom'";
                $obj_check = new Bin_Query();
                if ($obj_check->executeQuery($sql_check)) {
                    $sql = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table SET sitesettings_value= '" . $value . "' WHERE sitesettings_name='" . $key . "' AND sitesettings_description='zoom'";
                }
                else
                {
                    $sql = "INSERT INTO `" . $_ENV['PROMLM_PREFIX'] . "sitesettings_table` ( `sitesettings_name`, `sitesettings_value`,`sitesettings_description`) VALUES ('" . $key . "', '" . $value . "','zoom');";
                }
                $obj_update = new Bin_Query();
                $obj_update->updateQuery($sql);
            }
        }
         $_SESSION['success_message'] = ' ' . __('Integrations updated successfully') . '';
        $client_id = trim($_POST['clientid']);
        $callback = trim($_POST['callbackurl']);
        header("Location:https://zoom.us/oauth/authorize?response_type=code&client_id=".$client_id."&redirect_uri=".$callback);
        exit();

    }
    public static function getZoomDetails(){
        $output   = array();
        $query    = new Bin_Query();
        $sql_site = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_description='zoom'";
        if ($query->executeQuery($sql_site)) {
            $records = $query->records;
            if (count((array)$records) > 0) {
                $cnt=count((array)$records);
                for ($i=0; $i < $cnt; $i++) {
                $fields[strtolower(str_replace(' ', '_', $query->records[$i]['sitesettings_name']))] = $query->records[$i]['sitesettings_value'];
            }

        }
        return $fields;
        }
    }


}
?>
