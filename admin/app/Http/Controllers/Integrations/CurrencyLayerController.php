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
