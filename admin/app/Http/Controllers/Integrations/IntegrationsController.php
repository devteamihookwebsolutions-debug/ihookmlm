<?php

/**
 * This class contains public functions related to third party integration
 *
 * @package         CIntegrations
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
use Admin\App\Models\Integrations\MIntegrations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class IntegrationsController extends Controller
{
    public function showIntegration(Request $request, $category = 'all')
    {
        $output['integrationslist'] = MIntegrations::getIntegrationList($category);

        Session::forget(['success_message', 'error_message']);

        return view('integrations.integration', $output);
    }
}
