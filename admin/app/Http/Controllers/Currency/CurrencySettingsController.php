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
