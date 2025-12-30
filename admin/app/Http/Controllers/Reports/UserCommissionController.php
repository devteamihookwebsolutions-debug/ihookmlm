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

namespace Admin\App\Http\Controllers\Reports;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Reports\MUserCommissionReports;
use Illuminate\Http\Request;
use Exception;

class UserCommissionController extends Controller
{
public function userCommissionReports()
    {
        return view('reports.usercommissionreports')
            ->with('success_message', 'Commission reports page loaded.');
    }
public function getUserCommissionReports(Request $request)
{
    // dd('function reached');
    try {
        $data = MUserCommissionReports::getUserCommissionReports($request);
        // dd($data);
           return response()->json($data, 200, [], JSON_UNESCAPED_SLASHES);
    } catch (Exception $e) {
        session()->flash('error_message', $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}