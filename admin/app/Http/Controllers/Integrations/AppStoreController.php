<?php

/**
 * This class contains public functions related to CAppStore
 * @package         CAppStore
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

namespace Admin\App\Http\Controllers\Admin\Integration;

use Admin\App\Http\Controllers\Controller;
use Admin\Models\Integrations\MAppStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Integrations\AppStore;

class AppStoreController extends Controller
{

    public function updateAppStoreSettings(Request $request)
    {
        try {
            // You can pass $request if your model method needs form data
            MAppStore::updateAppStoreSettings();

            // Success message (Laravel way)
            return redirect()
                ->route('admin.integration.appstore.update') // or wherever you want to go back
                ->with('success', 'App Store settings updated successfully!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}
