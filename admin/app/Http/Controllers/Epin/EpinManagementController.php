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


namespace Admin\App\Http\Controllers\Epin;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Epin\MEpinManagement;
use Illuminate\Http\Request;

use Exception;

class EpinManagementController extends Controller
{
    public static function showEpinManagement()
    {
        // dd('funcion reached');
        return view('epin.epinhistory')
            ->with('success', 'Epin');
        }
public function getEpinManagementRecords(Request $request)
{
    try {
        // Pass $request to your model method
        return MEpinManagement::showEpinManagement($request);
    } catch (\Exception $e) {
        \Log::error("EPIN fetch failed: " . $e->getMessage());
        return response()->json(['error' => 'Could not fetch records'], 500);
    }
}
}
