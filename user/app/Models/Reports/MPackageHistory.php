<?php

namespace User\App\Models\Reports;
use User\App\Display\Reports\DPackageHistory;
use Admin\App\Models\Middleware\MMembersDetails;
use Admin\App\Models\Middleware\MPackageDetails;
use User\App\Models\PaymentHistory;
use User\App\Models\Package;
use User\App\Models\Matrix;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MPackageHistory
{
 


public static function packageHistory(Request $request)
{
    $members_id = Auth::user()->members_id;

    // Direct table names – no prefix
    $payment = 'ihook_paymenthistory_table';
    $matrix  = 'ihook_matrix_table';
    $package = 'ihook_package_table';
    $links   = 'ihook_matrix_members_link_table';

    // BASE QUERY
    $query = DB::table($payment . ' as a')
        ->select(
            'a.*',
            'b.matrix_name as planname',
            'c.package_name'
        )
        ->join($matrix . ' as b', 'b.matrix_id', '=', 'a.matrix_id')
        ->join($package . ' as c', 'c.package_id', '=', 'a.paymenthistory_plan_id')
        ->where('a.paymenthistory_plan_id', '>', 0);
        

    // ALL PACKAGE HISTORY
    if ($request->query('do') == 'allpackagehistory') {

        // dd('fucntion reached');
        $downlines = DB::table($links)
            ->whereRaw("FIND_IN_SET(?, members_parents)", [$members_id])
            ->pluck('members_id')
            ->toArray();

        $memberIds = empty($downlines) ? [$members_id] : array_merge($downlines, [$members_id]);

        $query->whereIn('a.paymenthistory_member_id', $memberIds);

    } else {
        // ONLY SELF
        $query->where('a.paymenthistory_member_id', $members_id);
    }

    // DATE RANGE
    if ($request->filled('start-date') && $request->filled('end-date')) {
        $query->whereDate('a.paymenthistory_date', '>=', $request->input('start-date'))
              ->whereDate('a.paymenthistory_date', '<=', $request->input('end-date'));
    }

    // PACKAGE FILTER
    if ($request->filled('package_id')) {
        $query->where('c.package_id', $request->package_id);
    }

    // STATUS FILTER
    if ($request->filled('status')) {
        $query->where('a.paymenthistory_status', $request->status);
    }

    // MATRIX FILTER
    if ($request->filled('matrix_id')) {
        $query->where('b.matrix_id', $request->matrix_id);
    }

    // EXECUTE QUERY
    $records = $query
        ->orderBy('a.paymenthistory_id', 'DESC')
       ->paginate(10);

    // dd($records->toArray());

    return DPackageHistory::PackageHistory($records);
}


public static function showPackageList($where, $select, $name)
{

    $records = Package::whereRaw($where)->get();
    // dd($records);
    return DPackageHistory::showPackageList($records, $select, $name);
}


public static function showMatrixList($where, $select, $name)
{
    // Eloquent query
   $records = Matrix::where('matrix_status', 1);

if(!empty($where)){
    $records = $records->whereRaw($where);
}

$records = $records->get();
    //  dd($records);
    return DPackageHistory::showMatrixList($records, $select, $name);
}


// public static function viewpackageinvoice($id)
// {
//     $userId = Auth::user()->members_id;

//     // 1. User details
//     $user = MMembersDetails::getUserDetails($userId);

//     // 2. Invoice record
//     $invoice = DB::table('ihook_paymenthistory_table')
//         ->where('paymenthistory_id', $id)
//         ->first();

//     if (!$invoice) {
//         return back()->with('error_message', 'Invoice not found');
//     }

//     // 3. Payment history details
//     $history = DB::table('ihook_history_table')
//         ->where('history_member_id', $userId)
//         ->first();

//     // 4. Package details
//     $package = MPackageDetails::getPackageDetails($invoice->paymenthistory_plan_id);

//     // 5. Determine payment method
//     $payment_method = ($history->history_wallet_type ?? 0) == 1 
//         ? "E-Wallet" 
//         : "C-Wallet";

//     // 6. Prepare data for blade
//     $data = [
//         'username'          => $user['members_username'],
//         'fullname'          => $user['members_firstname'] . ' ' . $user['members_lastname'],
//         'email'             => $user['members_email'],
//         'phone'             => $user['members_phone'],
//         'address'           => $user['members_address'],
//         'city'              => $user['members_city'],
//         'zip'               => $user['members_zip'],
//         'company_name'      => $user['members_company_name'],

//         'invoice'           => $invoice,
//         'history'           => $history,
//         'payment_method'    => $payment_method,
//         'packagename'       => $package['package_name'],
//     ];
//     // dd($data);
//     return view('reports.packageinvoice', $data);
// }
public static function viewpackageinvoice($id)
{
    $userId = Auth::user()->members_id;

    // 1. Get user details
    $user = MMembersDetails::getUserDetails($userId);

    // 2. Get invoice row
    $invoice = DB::table('ihook_paymenthistory_table')
        ->where('paymenthistory_id', $id)
        ->first();

    if (!$invoice) {
        return "<tr><td colspan='5'>Invoice not found</td></tr>";
    }

    // 3. Get history row
    $history = DB::table('ihook_history_table')
        ->where('history_member_id',  $userId)
        ->first();

    // 4. Get package details
    $package = MPackageDetails::getPackageDetails($invoice->paymenthistory_plan_id);

    // 5. Payment method
    $payment_method = ($invoice->history_wallet_type ?? 0) == 1
        ? "E-Wallet"
        : "C-Wallet";

    // 6. Prepare variables equivalent to your old code
    $username = $user['members_username'];
    $fullname = $user['members_firstname'] . ' ' . $user['members_lastname'];

    $paymenthistory_date = $invoice->paymenthistory_date;
    $history_description = $history->history_description ?? "";
    $payment_amount      = $invoice->paymenthistory_amount;

    // 7. Build the same HTML <tr> output
    $output = "
        <tr>
            <td>{$username}</td>
            <td>{$fullname}</td>
            <td>{$paymenthistory_date}</td>
            <td>{$history_description}</td>
            <td style='text-align:center;'>$$payment_amount</td>
        </tr>
    ";

    // dd($output);
    return $output;
}


}