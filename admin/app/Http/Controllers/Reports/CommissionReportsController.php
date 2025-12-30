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
use Admin\App\Models\Reports\MCommissionReports;
use Illuminate\Http\Request;
use Exception;

class CommissionReportsController extends Controller
{

    public function index()
    {
        // Just return the Blade view — no JSON
        return view('reports.commissionreports')
            ->with('success_message', 'Commission reports page loaded.');
    }

//    public function getCommissionData()
// {
//     // dd('function rached');
//     try {
//         $commissionReport = new MCommissionReports();
//         $data = $commissionReport->getCommissionReports(10);
//         // dd($data);
//         return response()->json($data);
//     } catch (Exception $e) {
//         return response()->json(['error' => $e->getMessage()], 500);
//     }
// }

// public function getCommissionData(Request $request)
// {
//     $perPage = $request->get('perPage', 10); // items per page

//     $data = MCommissionReports::getCommissionReports($perPage);
//     // dd($data);
//     return response()->json($data);
// }
public function getCommissionData(Request $request)
{
 
    try {
        $data = MCommissionReports::getCommissionReports($request);
        // dd($data);
        // return response()->json($data);
        return response()->json($data, 200, [], JSON_UNESCAPED_SLASHES);

    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}