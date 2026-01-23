<?php

/**
 * This class contains public functions related to TerminologyController
 *
 * @package         TerminologyController
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
?><?php

namespace Admin\App\Http\Controllers\Terminology;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Terminology\MTerminology;
use Illuminate\Http\Request;

class TerminologyController extends Controller
{

public function showTerminologySettings(Request $request, $lang)
{
    // Pass $lang to model functions
    $output['selected_lang'] = $lang;

    $output['language']     = MTerminology::showLanguage($lang);
    $output['menus']        = MTerminology::getTerminology($lang, 0);
    $output['commissions']  = MTerminology::getTerminology($lang, 1);
    $output['messages']     = MTerminology::showTerminologySettingsNew($lang, 2);
// dd($output);
    return view('terminology/terminologysettings', $output);
}
public function updateTerminologySettings(Request $request, $lang)
{
  // dd('ajsdf');
    // $lang is available here
    MTerminology::updateTerminologySettings($request, $lang);
    return redirect()->back()->with('success', 'Terminology updated successfully.');
}


}
