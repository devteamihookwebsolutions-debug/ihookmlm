<?php

/**
 * This class contains public functions related to EwalletPaymentsController
 *
 * @package         EwalletPaymentsController
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php


namespace Admin\App\Http\Controllers\Ewallet;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Ewallet\MEwalletPayments;
use Illuminate\Http\Request;
use Exception;

class EwalletPaymentsController extends Controller
{

    public  function showEwallet()
    {
        $ewalletmanagement = MEwalletPayments::showEwalletManagement();

           // Just return the Blade view — no JSON
    return view('Ewallet.ewalletmanagement', compact('ewalletmanagement'));
    }

    /**
     * This public function is used  to get pv data from db
     * @return JSON data
     */
   public function activateEwalletPayment(Request $request)
    {
        // Call your model’s static function
        // dd($request);
        return MEwalletPayments::activateEwalletPayment($request);
    }
    }





