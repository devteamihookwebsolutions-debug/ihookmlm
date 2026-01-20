<?php

/**
 * This class contains public functions related to MSalesForceIntegrations
 *
 * @package         MSalesForceIntegrations
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
class MSalesForceIntegrations {
    /**
     * This public static function is used to setSalesForceIntegration template
     */
    public static function setSalesForceIntegration() {
         $salesforce_clientid = trim($_POST['salesforce_clientid']);
            $salesforce_secretid = trim($_POST['salesforce_secretid']);
            $salesforce_redirect_url = trim($_POST['salesforce_redirect_url']);
            $salesforce_login_base_url = trim($_POST['salesforce_login_base_url']);
            $salesforce_status = $_POST['salesforce_status'];
            $_SESSION['salesforce_client_id'] = $salesforce_clientid;
            $_SESSION['salesforce_client_secret'] = $salesforce_secretid;
            $_SESSION['salesforce_redirect_url'] = $salesforce_redirect_url;
            $_SESSION['salesforce_loginbase_url'] = $salesforce_login_base_url;
            $salesforceredirect = $salesforce_redirect_url;
            header('Location: ' . $salesforce_login_base_url . '/services/oauth2/authorize?client_id=' . $salesforce_clientid . '&response_type=code&redirect_uri=' . $salesforce_redirect_url . '');
            exit();
        }
    }
