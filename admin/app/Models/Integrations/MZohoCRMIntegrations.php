<?php

/**
 * This class contains public functions related to MZohoCRMIntegrations
 *
 * @package         MZohoCRMIntegrations
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace Admin\Models\Integrations;

class MZohoCRMIntegrations {
    /**
     * This public static function is used to setZohocrm template

     */
    public static function setZohoCRMIntegration() {

        $zoho_clientid = trim($_POST['zoho_clientid']);
            $_SESSION['success_message'] = '' . __('ZOHO CRM Configured Successfully') . '';
            $zohoredirect = $_ENV['BCPATH'] . '/integration/getcrmcode';
            /*  header('Location: https://accounts.zoho.com/oauth/v2/auth?scope=ZohoCRM.users.ALL,ZohoCRM.modules.leads.ALL,ZohoCRM.modules.deals.ALL,ZohoCRM.settings.ALL&client_id='.$zoho_clientid.'&response_type=code&access_type=offline&redirect_uri='.$zohoredirect);
            */
            header('Location:https://accounts.zoho.com/oauth/v2/auth?scope=ZohoCRM.users.ALL,ZohoCRM.modules.leads.ALL,ZohoCRM.modules.deals.ALL,ZohoCRM.settings.ALL&client_id=' . $zoho_clientid . '&response_type=code&access_type=offline&redirect_uri=' . $zohoredirect . '&prompt=consent');
            echo "zohocrm";
            exit();
            }
    }
