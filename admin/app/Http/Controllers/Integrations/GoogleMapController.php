<?php

/**
 * This class contains public functions related to social api
 *
 * @package         CSocialLoginApi
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

namespace Admin\Http\Controllers\Integrations;

use Admin\App\Http\Controllers\Controller;
use Admin\Models\Integrations\MGoogleMap;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use App\Models\Integrations\GoogleMap;
use App\Models\Grants\Previllage;
use Exception;

class GoogleMapController extends Controller
{


    /**
     * Update Google Map settings
     *
     * @return RedirectResponse
     */
    public function updateGoogleMap(): RedirectResponse
    {
        try {
            MGoogleMap::updateGoogleMap();

            return redirect('/integration')
                ->with('success_message', 'Google Map updated successfully');
        } catch (Exception $e) {
            return redirect('/googlemap/update')
                ->with('error_message', $e->getMessage());
        }
    }
}
