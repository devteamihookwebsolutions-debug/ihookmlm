<?php

/**
 * This class contains public functions related to SystemManagementController
 *
 * @package         SystemManagementController
 * @category        Controller
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

namespace Admin\App\Http\Controllers\SystemModule;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\SystemModule\MSystemManagement;
use Admin\App\Models\SystemModule\MSystemManagementExt;
use Illuminate\Http\Request;

class SystemManagementController extends Controller
{
    public   function showSystemModules(Request $request)
    {
        // dd('fhjkjhkjhk');
        $menuname = $request->query('dname', '');
        $licensename = $request->query('license', '');

        $output['checkpartyplanactive'] = MSystemManagement::checkSystemModuleActive('partyplan');
        $output['checksalesfunnelactive'] = MSystemManagement::checkSystemModuleActive('salesfunnel');
        $output['checksocialmediaengineactive'] = MSystemManagement::checkSystemModuleActive('socialmediaengine');
        $output['checkshopreplicatedactive'] = MSystemManagement::checkSystemModuleActive('shopreplicated');
        $output['checkepinactive'] = MSystemManagement::checkSystemModuleActive('epin');
        $output['checksmsactive'] = MSystemManagement::checkSystemModuleActive('sms');
        $output['checkelearningactive'] = MSystemManagement::checkSystemModuleActive('elearning');
        $output['checkshopifyactive'] = MSystemManagement::checkSystemModuleActive('shopify');
        $output['checkpremium_elearningactive'] = MSystemManagement::checkSystemModuleActive('premiumelearning');
        $output['checkmessagecenter'] = MSystemManagement::checkSystemModuleActive('messagecenter');
        $output['checkticketcenter'] = MSystemManagement::checkSystemModuleActive('ticketcenter');
        $output['matomo_analytics'] = MSystemManagement::checkSystemModuleActive('matomoanalytics');
        $output['dynamiccompression'] = MSystemManagement::checkSystemModuleActive('dynamiccompression');
//  dd($output);
        return view('systemmodule.menulicense', [
    'checkpartyplanactive'          => $output['checkpartyplanactive'],
    'checksalesfunnelactive'        => $output['checksalesfunnelactive'],
    'checksocialmediaengineactive'  => $output['checksocialmediaengineactive'],
    'checkshopreplicatedactive'     => $output['checkshopreplicatedactive'],
    'checkepinactive'               => $output['checkepinactive'],
    'checksmsactive'                => $output['checksmsactive'],
    'checkelearningactive'          => $output['checkelearningactive'],
    'checkshopifyactive'            => $output['checkshopifyactive'],
    'checkpremium_elearningactive'  => $output['checkpremium_elearningactive'],
    'checkmessagecenter'            => $output['checkmessagecenter'],
    'checkticketcenter'             => $output['checkticketcenter'],
    'matomo_analytics'              => $output['matomo_analytics'],
    'dynamiccompression'            => $output['dynamiccompression'],
]);

    }

        public static function updateLicenseMenu()
    {
        MSystemManagementExt::updateLicenseMenu($smsdo, $licensedo);
    }
}
