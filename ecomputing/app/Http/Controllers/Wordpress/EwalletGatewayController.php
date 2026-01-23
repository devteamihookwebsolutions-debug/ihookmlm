<?php

/**
 * This class contains public functions related to EwalletGatewayController
 *
 * @package         EwalletGatewayController
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
namespace Ecomputing\App\Http\Controllers\Wordpress;

use Ecomputing\App\Http\Controllers\Controller;
use Ecomputing\App\Model\Wordpress\MEwalletGateway;
use Illuminate\Support\Facades\Log;

class EwalletGatewayController extends Controller
{

    public function checkWalletBalance()
    {
        Log::info('Laravel: E-Wallet checkWalletBalance ENDPOINT HIT from WooCommerce');
        $walletGateway = new MEwalletGateway();
        $walletGateway->checkWalletBalance();
    }


}
