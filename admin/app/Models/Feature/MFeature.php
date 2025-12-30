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

namespace Admin\App\Models\Feature;
// use Admin\App\Display\Factories\DRegisterSettings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Admin\App\Models\Member\Feature;
use Admin\App\Models\Member\SiteSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class MFeature
{
    public static function getFeaturestatus($Err = null)
{
    // Fetch all feature rows
    $rows = Feature::all();

    $fields = [];

    foreach ($rows as $row) {

        // Special cases
        if ($row->feature_name === 'sendgrid_distributors') {
            $fields['sendgrid_distributors_desc'] = $row->feature_description;
        }

        if ($row->feature_name === 'sendgrid_leadcontacts') {
            $fields['sendgrid_leadcontacts_desc'] = $row->feature_description;
        }

        if ($row->feature_name === 'pv_file_path') {
            $fields['pv_file_path_description'] = $row->feature_description;
        }

        // General feature key
        $key = strtolower(str_replace(' ', '_', $row->feature_name));
        $fields[$key] = $row->feature_status;
    }

    // If $Err object provided and has messages → replace fields
    if ($Err && isset($Err->messages) && count((array)$Err->messages) > 0) {
        $fields = $Err->values;
    }
// dd($fields);
    return $fields;
}
 public static function updateFeature(Request $request)
    {
        // dd('askldjf');
        // 1. Reset all empty descriptions to 0
        DB::table('ihook_feature_table')
            ->where('feature_description', '')
            ->update([
                'feature_status' => 0
            ]);

        // 2. Set countdown days logic
        $countdownDays = ($request->countdowntype != 1)
            ? 30
            : $request->countdowndays;

        // Override in request data
        $request->merge([
            'countdowndays' => $countdownDays
        ]);

        // 3. Update special fields
        if ($request->has('sendgrid_thingid')) {
            Feature::where('feature_name', 'sendgrid_distributors')
                ->update([
                    'feature_description' => $request->sendgrid_thingid,
                    'created_on'          => now()
                ]);
        }

        if ($request->has('pv_file_path')) {
            Feature::where('feature_name', 'pv_file_path')
                ->update([
                    'feature_description' => $request->pv_file_path,
                    'created_on'          => now()
                ]);
        }

        if ($request->has('sendgrid_leadthingid')) {
            Feature::where('feature_name', 'sendgrid_leadcontacts')
                ->update([
                    'feature_description' => $request->sendgrid_leadthingid,
                    'created_on'          => now()
                ]);
        }

        // 4. Update every feature
            $ignore = [
                'do',
                'submit',
                'action',
                '_token',
                '_method',
                'sendgrid_thingid',
                'sendgrid_leadthingid'
            ];

            foreach ($request->except($ignore) as $key => $value) {

                $exists = Feature::where('feature_name', $key)->exists();

                if ($exists) {
                    Feature::where('feature_name', $key)
                        ->update([
                            'feature_status' => (int) $value,
                            'created_on'     => now()
                        ]);
                } else {
                    Feature::create([
                        'feature_name'   => $key,
                        'feature_status' => (int) $value,
                        'created_on'     => now()
                    ]);
                }

                if ($key === 'benefits') {
                    SiteSetting::create([
                        'sitesettings_name'        => 'benefits',
                        'sitesettings_value'       => 1,
                        'sitesettings_description' => 'benefits',
                        'last_updated'             => now()
                    ]);
                }
            }

        // 6. Update mass_payout session
        $enableStatus = Feature::where('feature_name', 'mass_payout')->value('feature_status');

        session(['enable_status' => $enableStatus]);

        // 7. Success message + redirect
        return redirect()
            ->route('enablefeature')
            ->with('success_message', 'Feature Status Updated Successfully');
    }
}