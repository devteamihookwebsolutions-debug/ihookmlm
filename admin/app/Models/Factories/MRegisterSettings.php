<?php

namespace Admin\App\Models\Factories;
use Admin\App\Display\Factories\DRegisterSettings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Admin\App\Models\Member\RegistrationSetting;

use Illuminate\Http\Request;

class MRegisterSettings
{


public static function showRegisterSettings()
{
    $records = RegistrationSetting::whereNotIn('column_name', ['leg_selection', 'id_proof', 'pancard'])
                ->where('id', '<=', 16)
                ->orderBy('id', 'ASC')
                ->get();

                // dd($records);
    return DRegisterSettings::showRegisterSettings($records);
}
//  public static function updateRegSettings(Request $request)
// {
//     // Update 'required' field
//     for ($j = 1; $j <= 16; $j++) {
//         $record = RegistrationSetting::find($j);
//         if ($record) {
//             $record->required = $request->input("chkSub.$j") ? 1 : 0;
//             $record->save();
//         }
//     }

//     // Update 'display' field and special Username logic
//     for ($k = 1; $k <= 16; $k++) {
//         $record = RegistrationSetting::find($k);
//         if ($record) {
//             if ($request->has("chkSub1.$k")) {
//                 // If checkbox is checked, display=1
//                 $record->display = 1;

//                 // For last record (ID 16), reset username fields
//                 if ($k == 16) {
//                     $record->checkuserval = 0;
//                 }

//             } else {
//                 // If checkbox not checked, display=0
//                 $record->display = 0;

//                 // For last record (ID 16), update username fields
//                 if ($k == 16) {
//                     $record->checkuserval = $request->input('chkuserval', 0);
//                     $record->checkuserprefix = $request->input('chkuservalletter', '');
//                 }
//             }
// // dd($record);
//             $record->save();
//         }
//     }

//     // Flash success message
//     Session::flash('success_message', __('Registration settings updated successfully'));
// }

public static function updateRegSettings(Request $request)
{
    // Update 'required' field
    for ($j = 1; $j <= 16; $j++) {
        $record = RegistrationSetting::find($j);
        if ($record) {
            $record->required = $request->input("chkSub.$j") ? 1 : 0;
            $record->save();
        }
    }

    // Update 'display' and username logic
    for ($k = 1; $k <= 16; $k++) {
        $record = RegistrationSetting::find($k);

        if ($record) {
            if ($request->has("chkSub1.$k")) {

                $record->display = 1;

                if ($k == 16) {
                    $record->checkuserval = 0;
                    // SAFE: Prevent NULL
                    $record->checkuserprefix = '';
                }

            } else {

                $record->display = 0;

                if ($k == 16) {
                    $record->checkuserval = $request->chkuserval ?? 0;
                    // SAFE: Prevent NULL
                    $record->checkuserprefix = trim($request->chkuservalletter ?? '');
                }
            }

            $record->save();
        }
    }

    Session::flash('success', __('Registration settings updated successfully'));
}

}
