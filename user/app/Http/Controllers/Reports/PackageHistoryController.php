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
