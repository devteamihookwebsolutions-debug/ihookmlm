<?php

/**
 * This class contains public functions related to third party integration
 *
 * @package         CIntegrationsDetails
 * @category        Controller
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
 *****************************************************************************/
?><?php

namespace Admin\App\Http\Controllers\Integrations;
use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Factories\MSiteSettings;
use Admin\App\Models\Middleware\MAmazonCloudFront;
use Admin\App\Models\Middleware\MText;
use Admin\Models\Integrations\MAppStore;
use Admin\Models\Integrations\MIntegrationsDetails;
use Admin\Models\Integrations\MSocialLoginApi;
use Admin\Models\Integrations\MTaxSettings;
use Admin\Models\Integrations\MTwilioSettings;
use Admin\Models\Integrations\MZoomDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use Exception;

class IntegrationsDetailsController extends Controller
{

    /**
     * Show integration details page for a given subtype
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function integrationsDetails(Request $request)
    {
        try {
            $subtype = $request->query('sub1'); // GET parameter 'sub1'

            $output = [];
            $output['language'] = MText::getLanguage();
            $output['updatedrecord'] = MIntegrationsDetails::integrationsDetails();

            // Conditional settings
            switch ($subtype) {
                case 'google':
                case 'currencylayer':
                case 'webapp':
                case 'pwa':
                    $output['show_sitesettings'] = MSiteSettings::showSiteSettings();
                    break;

                case 'avalara':
                    $output['tax_settings'] = MTaxSettings::getTaxSettings();
                    break;

                case 'facebook':
                case 'twitter':
                case 'instagram':
                case 'googlelogin':
                case 'linkedin':
                case 'livechat':
                    $output['show_sitesettings'] = MSocialLoginApi::showSocialLoginApi();
                    break;

                case 'appstore':
                case 'playstore':
                case 'firebase':
                    $output['show_sitesettings'] = MAppStore::showAppIntegration();
                    break;

                case 'twilio':
                    $output['show_sitesettings'] = MTwilioSettings::getTwilioSettings();
                    break;

                case 'zoom':
                    $output['zoom'] = MZoomDetails::getZoomDetails();
                    break;
            }

            // PWA special handling
            if ($subtype === 'pwa' && isset($output['show_sitesettings']['site_manfest'])) {
                $output['site_manfest'] = MAmazonCloudFront::getCloudFrontUrl($output['show_sitesettings']['site_manfest']);
            }

            // Clear old session messages
            Session::forget(['success_message', 'error_message']);

            // Render blade view
            return view('integrations.' . $subtype . 'thirdparty', $output);
        } catch (Exception $e) {
            return redirect('/integration/configure')
                ->with('error_message', $e->getMessage());
        }
    }

    /**
     * Update third party integration
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateIntegration(Request $request)
    {
        try {
            MIntegrationsDetails::updateIntegration();
            return redirect('/integration')
                ->with('success_message', 'Integration updated successfully');
        } catch (Exception $e) {
            return redirect('/integration/update')
                ->with('error_message', $e->getMessage());
        }
    }
}
