<?php

/**
 * This class contains public functions related to GPVReportsController
 *
 * @package         GPVReportsController
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php


namespace Admin\App\Http\Controllers\Reports;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Reports\MGPVReports;
use Illuminate\Http\Request;
use Exception;

class GPVReportsController extends Controller
{

    public static function showGPVReports()
    {
           // Just return the Blade view — no JSON
        return view('reports.gpvreports')
            ->with('success_message', 'Commission reports page loaded.');
        }
        /**
         * This public function is used  to get pv data from db
         * @return JSON data
         */
    public function getGPVReports(Request $request)
{
    try {
        $data = MGPVReports::getGPVReports($request);
        // return response()->json($data);
        return response()->json($data, 200, [], JSON_UNESCAPED_SLASHES);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
    }





