<?php

namespace Admin\App\Http\Controllers\SystemModule;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\SystemModule\MSystemManagement;
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
