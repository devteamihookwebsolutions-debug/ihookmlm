<?php

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
