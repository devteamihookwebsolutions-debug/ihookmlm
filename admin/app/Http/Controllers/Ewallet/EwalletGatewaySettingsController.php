<?php

/**
 * This class contains public functions related to Total Commission reports
 *
 * @package
 * @category        Controller
 * @author
 * @link
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
 *****************************************************************************/
?>
<?php


namespace Admin\App\Http\Controllers\Ewallet;
use Admin\App\Models\Ewallet\MEwalletGatewaySettings;
use Admin\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class EwalletGatewaySettingsController extends Controller
{

        public static function ewalletGateway()
        {
            // dd('aslkdfh');
            $output['apistatus'] = MEwalletGatewaySettings::getContent('ewallet-gateway_status');

            $output['apiusername'] = MEwalletGatewaySettings::getContent('ewallet-apiusername');

            $output['apipassword'] = MEwalletGatewaySettings::getContent('ewallet-apipassword');
    //  dd($output);
            return view('Ewallet.ewalletsettings',$output);

       }

public function updateEwallet(Request $request)
          {
             MEwalletGatewaySettings::updateSettings($request);

            return redirect()->back();
          }
 public function generateKey()
{
    $key = MEwalletGatewaySettings::generateKey();
    return response($key); // return plain text for JS
}

}
