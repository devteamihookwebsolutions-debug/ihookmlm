<?php

/**
 * This class contains public functions related to PackageHistoryController
 *
 * @package         PackageHistoryController
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
namespace User\App\Http\Controllers\Reports;

use User\App\Http\Controllers\Controller;
use User\App\Models\Reports\MPackageHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageHistoryController extends Controller
{
public function showPackageHistory(Request $request)
{
    // try {
        $packageId = $request->input('package_id', '');
        $matrixId  = $request->input('matrix_id', '');
        $startDate = $request->input('start-date', '');
        $endDate   = $request->input('end-date', '');
        $status    = $request->input('status', '');

        $output['package'] = MPackageHistory::showPackageList('package_status = "1"', $packageId, "");
        $output['matrix']  = MPackageHistory::showMatrixList("", $matrixId, "matrix_id", "");

        $output['startdate'] = $startDate;
        $output['enddate']   = $endDate;
        $output['status']    = $status;

        $output['packagehistory'] = MPackageHistory::packageHistory($request);

        return view('user::reports.packagehistory', $output);

    // } catch (\Exception $e) {
    //     session()->flash('error_message', $e->getMessage());
    //     return redirect()->route('user.dashboard');
    // }
}

public function viewPackageInvoice($id)
{
    // dd('fucntion reached');
    // dd($id);
    try {
        // Fetch the invoice details
        // $invoice = MPackageHistory::viewPackageInvoice($id);
          $output['invoice'] = MPackageHistory::viewpackageinvoice($id);
        // dd($output);
        // Check if record exists


        return view('user::reports.packageinvoice',$output);

    } catch (\Exception $e) {

        return redirect()->route('user.dashboard')
                         ->with('error_message', $e->getMessage());
    }
}


}
