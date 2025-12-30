<?php

namespace Admin\App\Display\Factories;

use App\Models\Member\RegistrationSetting;

class DRegisterSettings
{
    public static function showRegisterSettings($records)
{
    // Count required fields
    $countRequired = $records->where('required', '1')->count();
    $checkedRequired = ($countRequired == 16) ? 'checked' : '';

    // Count display fields
    $countDisplay = $records->where('display', '1')->count();
    $checkedDisplay = ($countDisplay == 16) ? 'checked' : '';

    $output = ' 
    <table class="w-full text-sm text-left rtl:text-right text-black dark:text-white">
        <tbody>
            <tr class="bg-white border-b dark:bg-neutral-900 dark:border-neutral-700 dark:hover:bg-neutral-600">
                <th scope="col" class="px-6 py-3 text-black dark:text-white">Field Name</th>
                <th scope="col" class="p-4">
                    <div class="flex items-center text-black dark:text-white">
                        <input type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-100 dark:bg-gray-800 dark:border-gray-700 mr-3" name="selectall1" id="selectall1" value="1" '.$checkedDisplay.'>
                        <label for="selectall1" class="sr-only pr-4">checkbox</label>Enable/Disable Field
                    </div>
                </th>
                <th scope="col" class="p-4">
                    <div class="flex items-center text-black dark:text-white">
                        <input type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-100 dark:bg-gray-800 dark:border-gray-700 mr-3" name="selectall" id="selectall" value="1" '.$checkedRequired.'>
                        <label for="selectall" class="sr-only pr-4">checkbox</label>Required Field
                    </div>
                </th>
            </tr>';

    foreach ($records as $record) {
        $checkedReq = ($record->required == '1') ? 'checked' : '';
        $checkedDisp = ($record->display == '1') ? 'checked' : '';

        $output .= '<tr class="bg-white dark:bg-neutral-900 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-600">
                        <td scope="row" class="w-4 p-4 px-6 py-4 text-black whitespace-nowrap dark:text-white">'. $record->{'Category Name'} .'</td>
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-100 dark:bg-gray-800 dark:border-gray-700 checkallc" name="chkSub1['. $record->id .']" value="1" '.$checkedDisp.' id="chkSub'. $record->id .'">
                                <label for="chkSub'. $record->id .'" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-100 dark:bg-gray-800 dark:border-gray-700 case" name="chkSub['. $record->id .']" value="1" '.$checkedReq.' id="chkSub['. $record->id .']">
                                <label for="chkSub['. $record->id .']" class="sr-only">checkbox</label>
                            </div>
                        </td>
                    </tr>';
    }

    // Handle special "Username" block
    $usernameRecord = $records->firstWhere('Category Name', 'Username');
    if ($usernameRecord) {
        $chec1 = $usernameRecord->checkuserval == 1 ? 'checked' : '';
        $chec2 = $usernameRecord->checkuserval == 2 ? 'checked' : '';
        $chec3 = $usernameRecord->checkuserval == 3 ? 'checked' : '';
        $checked2 = $usernameRecord->checkuserval == 0 ? '' : '';

        $output .= '<table class="w-full border border-neutral-200 table-auto rounded-lg flex justify-between mt-4 p-2" id="blockusername">
                        <tbody>
                            <tr>
                                <td class="p-4">
                                    <label class="flex items-center space-x-2 text-black">
                                        <input type="radio" name="chkuserval" value="1" '.$chec1.' id="chkusername" class="form-radio text-blue-600">
                                        <p class="text-black dark:text-white">User name Automatic for Number or Alpha Numeric</p>
                                    </label>
                                </td>
                                <td class="p-4"></td>
                            </tr>
                            <tr>
                                <td class="p-4">
                                    <label class="flex items-center space-x-2 text-black">
                                        <input type="radio" name="chkuserval" value="2" '.$chec2.' id="chkusername1" class="form-radio text-blue-600">
                                        <p class="text-black dark:text-white">User name Automatic for Number of Digit</p>
                                    </label>
                                </td>
                                <td class="p-4"></td>
                            </tr>
                            <tr>
                                <td class="p-4">
                                    <label class="flex items-center space-x-2 text-black">
                                        <input type="radio" name="chkuserval" value="3" '.$chec3.' id="chkusername2" class="form-radio text-blue-600">
                                        <p class="text-black dark:text-white">User name Automatic Prefix like (C1-Eric)</p>
                                    </label>
                                </td>
                                <td class="p-4">
                                    <input type="text" name="chkuservalletter" value="'. $usernameRecord->checkuserprefix .'"  id="chkSubx" class="form-input w-full px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </td>
                            </tr>
                        </tbody>
                    </table>';
    }

    $output .= '</tbody></table>';
    // dd($output);
    return $output;
}
}