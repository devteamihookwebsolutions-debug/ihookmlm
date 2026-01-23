<?php

/**
 * This class contains public functions related to MTwilioSettings
 *
 * @package         MTwilioSettings
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
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


class MTwilioSettings {

    public static function getTwilioSettings(){

        $output   = array();
        $query    = new Bin_Query();
        $sql_site = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_description='twilio'";
        if ($query->executeQuery($sql_site)) {
            if (count((array)$records) > 0) {
                $cnt=count((array)$records);
                for ($i=0; $i <$cnt ; $i++) {
                $fields[strtolower(str_replace(' ', '_', $query->records[$i]['sitesettings_name']))] = $query->records[$i]['sitesettings_value'];
            }

        }
        return $fields;
    }
}
    /**
     * This public static function is used to twiliosettings
     * @return html
     */
    public static function updateTwilioSettings() {


        MSiteFields::updateSiteFields('whatsapp_status');
        MSiteFields::updateSiteFields('sms_blaststatus');

        $mode = trim($_POST['gateway_mode']);
        $token = trim($_POST['auth_token']);
        $accountid = trim($_POST['account_id']);
        $phone = trim($_POST['phone_no']);
        $blast = trim($_POST['sms_blaststatus']);
        foreach ($_POST as $key => $value)
        {
            $sql_check = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_name='" . trim($key)."' AND sitesettings_description='twilio'";
            $obj_check = new Bin_Query();
            if ($obj_check->executeQuery($sql_check)) {
                $sql = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table SET sitesettings_value= '" . $value . "' WHERE sitesettings_name='" . $key . "' AND sitesettings_description='twilio'";
            }
            else
            {
                $sql = "INSERT INTO `" . $_ENV['PROMLM_PREFIX'] . "sitesettings_table` ( `sitesettings_name`, `sitesettings_value`,`sitesettings_description`) VALUES ('" . $key . "', '" . $value . "','twilio');";
            }
            $obj_update = new Bin_Query();
            $obj_update->updateQuery($sql);
        }
         $_SESSION['success_message'] = ' ' . __('Integrations updated successfully') . '';

    }


}
?>
