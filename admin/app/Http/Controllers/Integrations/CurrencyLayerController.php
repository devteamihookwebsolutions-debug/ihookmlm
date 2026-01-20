<?php

/**
 * This class contains public functions related to CurrencyLayerController
 *
 * @package         CurrencyLayerController
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

namespace Admin\App\Http\Controllers\Integrations;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Integrations\MCurrencyLayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Exception;

class CurrencyLayerController extends Controller
{

    /**
     * Update CurrencyLayer settings
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCurrencyLayer()
    {
        try {
            MCurrencyLayer::updateCurrencyLayer();

            return redirect('/integration')
                ->with('success_message', 'Currency Layer updated successfully');
        } catch (Exception $e) {
            return redirect('/currencylayer/update')
                ->with('error_message', $e->getMessage());
        }
    }
}
