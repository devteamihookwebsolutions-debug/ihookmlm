<?php

/**
 * This class contains public functions related to MIntegrationsDetails
 *
 * @package         MIntegrationsDetails
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


class MIntegrationsDetails {
        public static function integrationsDetails() {
        $module = $_GET['sub1'];
          $sql = "SELECT * FROM  " . $_ENV['PROMLM_PREFIX'] . "thirdpartyintegration WHERE module='" . $module . "'";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records;
         $cnt=count((array)$records);
         $result = array();
         if($cnt>0){
            for ($i=0; $i < $cnt; $i++) {
                $result[$records[$i]['metakey']]=$records[$i]['metavalue'];
            }
               $result['integration_status'] = $records[0]['integration_status'];
         }else{
             $result['integration_status']='0';
         }
        return $result;

    }
    public static function updateIntegration() {
        $module = $_POST['configure'];
        if (isset($_POST)) {
            $integration_status = trim($_POST['integration_status']);
            $thirdpartyintegration_modules_default_name = trim($_POST['configure']);
            foreach ($_POST as $key => $value) {
                if ($key != 'do' && $key != 'submit' && $key != 'action') {
                    $objlink = new Bin_Query();
                    $link = $objlink->getConnection();
                    $value = mysqli_real_escape_string($link, trim($value));
                    if (trim($key) != 'integration_status' && trim($key) != 'configure' && trim($key)!='submit' && trim($value)!='') {
                        $sqlcheck = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "thirdpartyintegration WHERE metakey='" . trim($key) . "' AND module='" . $module . "'";
                        $objcheck = new Bin_Query();
                        $objcheck->executeQuery($sqlcheck);
                        $records = $objcheck->records;
                        $integrtionid=$records[0]['integration_id'];
                        if (count((array)$records) > 0) {
                            if ($module=='quickbooks') {
                                $libimport='0';
                            }
                             $sqlinte = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "thirdpartyintegration SET metavalue='" . $value . "',integration_status='" . $integration_status . "' WHERE integration_id='" . $integrtionid . "'";
                            $objinte = new Bin_Query();
                            $objinte->updateQuery($sqlinte);
                        } else {
                            if ($module=='quickbooks') {
                                $libimport='1';
                            }
                             $sqlUser = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "thirdpartyintegration(module,metakey,metavalue,integration_status)
                        VALUES('" . $module . "','" . trim($key) . "','" . $value . "','" . $integration_status . "')";
                            $objUser = new Bin_Query();
                            $objUser->updateQuery($sqlUser);
                        }
                    }
                }
            }

            $sqlUser = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "thirdpartyintegration_modules SET thirdpartyintegration_modules_status='" . $integration_status . "' WHERE thirdpartyintegration_modules_default_name='" . $thirdpartyintegration_modules_default_name . "'";
            $objUser = new Bin_Query();
            $objUser->updateQuery($sqlUser);
             if($thirdpartyintegration_modules_default_name=='livechat' && $_POST['livechat']!=''){
                MLiveChatIntegrations::setLiveChatIntegration();
            }
             if($thirdpartyintegration_modules_default_name=='googletagmanager' && $_POST['google_tag_manager_code']!=''){
                MGoogleTagManager::setGoogleTagManager();
            }
            if($thirdpartyintegration_modules_default_name=='matomoanalytics' && $_POST['matomo_analytics_code']!=''){
                MMatomoAnalytics::setMatomoAnalytics();
        }
        if ($thirdpartyintegration_modules_default_name == 'zohocrm') {
            MZohoCRMIntegrations::setZohoCRMIntegration();
        }
        if ($thirdpartyintegration_modules_default_name == 'mailchimp') {
            MMailChimpIntegrations::setMailChimpIntegration();
        }
        if ($thirdpartyintegration_modules_default_name == 'salesforce') {
            MSalesForceIntegrations::setSalesForceIntegration();
        }
        if ($thirdpartyintegration_modules_default_name == 'quickbooks' && $libimport=='1') {
            MQuickBooksIntegrations::setQuickBooksIntegration();
        }
        else {
            $_SESSION['success_message'] = '' . __('Integrations updated successfully') . '';
            header('Location: ' . $_ENV['BCPATH'] . '/integration');
            exit();
        }
    }
}
}
?>
