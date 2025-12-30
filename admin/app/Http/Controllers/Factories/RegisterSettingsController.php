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
namespace Admin\App\Http\Controllers\Factories;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Factories\MRegisterSettings;
use Illuminate\Http\Request;
use Admin\App\Models\Member\Banner;
use Exception;

class RegisterSettingsController extends Controller
{
        public static function showRegisterSettings()
    {
        // dd('ashfdak');
        
            $output['category'] = MRegisterSettings::showRegisterSettings();
            return view('factories/registersettings',$output);
        }
        public static function updateregSettings(Request $request)
{
    $output['regsetting'] = MRegisterSettings::updateRegSettings($request);
    return redirect()->back()->with('success', 'Registration settings updated successfully');
}

}
