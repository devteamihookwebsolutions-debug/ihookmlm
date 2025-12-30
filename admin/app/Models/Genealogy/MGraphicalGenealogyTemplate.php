<?php
namespace Admin\App\Models\Genealogy;
use Admin\App\Models\Member\SiteSetting;

class MGraphicalGenealogyTemplate
{

public static function setGenealogyTemplate($templateKey, $templateValue)
{
    // dd('finciton reached');
    // Check if record exists
    $setting = SiteSetting::where('sitesettings_name', $templateKey)->first();
    // dd($setting);

    if ($setting) {
        // Update existing
        $setting->update([
            'sitesettings_value' => $templateValue
        ]);
    } else {
        // Insert new
        SiteSetting::create([
            'sitesettings_name' => $templateKey,
            'sitesettings_value' => $templateValue
        ]);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Template updated successfully'
    ]);
}

   
}