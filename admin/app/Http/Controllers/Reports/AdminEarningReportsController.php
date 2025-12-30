<?php

namespace Admin\App\Http\Controllers\Reports;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Reports\MAdminEarningReports;
use Illuminate\Http\Request;
use Exception;

class  AdminEarningReportsController extends Controller
{

       public static function adminEarnings()
    {

         // Just return the Blade view — no JSON
        return view('reports.adminearnings')
            ->with('success_message', 'adminearnings reports page loaded.');

            MAdminEarningReports::adminTotalEarnings();



    }
    /**
     * This public function is used  to get admin earnings records from db
     * @return JSON data
     */
    public static function adminEarningsRecords(Request $request)
    {


        $data = MAdminEarningReports::adminEarnings($request);
              return response()->json($data, 200, [], JSON_UNESCAPED_SLASHES);
        // return response()->json($data);


    }


    /**
     * This public function is used  to show admin earnings details
     * @return HTML data
     */
// public function adminEarningsDetails($id)
// {
//     $record = MAdminEarningReports::adminEarningsDetails($id);

//     // Return only the grid HTML (no layout)
//     return response('
//     <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">

//         <div class="mb-5">
//             <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
//             <input type="text" value="'.($record->username ?? 'N/A').'" disabled
//                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-3 dark:bg-gray-700">
//         </div>

//         <div class="mb-5">
//             <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Earning Type</label>
//             <input type="text" value="'.($record->earning_type ?? 'N/A').'" disabled
//                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-3 dark:bg-gray-700">
//         </div>

//         <div class="mb-5">
//             <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Transaction ID</label>
//             <input type="text" value="'.($record->transaction_id ?? 'N/A').'" disabled
//                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-3 dark:bg-gray-700">
//         </div>

//         <div class="mb-5">
//             <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Payment Status</label>
//             <input type="text" value="'.($record->status ?? 'N/A').'" disabled
//                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-3 dark:bg-gray-700">
//         </div>

//         <div class="mb-5">
//             <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date</label>
//             <input type="text" value="'.($record->created_at?->format('d/m/Y') ?? 'N/A').'" disabled
//                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-3 dark:bg-gray-700">
//         </div>

//         <div class="mb-5">
//             <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Amount</label>
//             <input type="text" value="₹ '.number_format($record->amount ?? 0, 2).'" disabled
//                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-3 dark:bg-gray-700">
//         </div>

//     </div>');
// }




public function adminEarningsDetails($id)
{

    $html = MAdminEarningReports::adminEarningsDetails($id);


    return response($html);
}
}
