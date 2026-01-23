<?php

/**
 * This class contains public functions related to CurrencySettingsController
 *
 * @package         CurrencySettingsController
 * @category        Controller
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
namespace Admin\App\Http\Controllers\Currency;

use Admin\App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Admin\App\Models\Currency\MCurrencySettings;
use Exception;

class CurrencySettingsController extends Controller
{


    public function index()
    {
        try {
            // Get currency settings from model
            $currencySettings = MCurrencySettings::showCurrencySettings();

            // Return Blade view with data
            return view('currency.currencysettings', [
                'currency_settings' => $currencySettings,
                'success' => session('success'),
                'error_message' => session('error_message'),
            ]);

        } catch (Exception $e) {
            // Store error message in session and redirect
            return redirect()->route('currency.settings') // define a named route
                             ->with('error_message', $e->getMessage());
        }
    }
}
