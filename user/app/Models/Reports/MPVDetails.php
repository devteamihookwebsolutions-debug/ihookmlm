<?php 
namespace User\App\Models\Reports;
use User\App\Display\Reports\DPVDetails;
use User\App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MPVDetails
{
public static function getPVAndGPVHistory($user_id, $startdate = null, $enddate = null)
{
    $query = History::where('history_member_id', $user_id)
                    ->whereIn('history_type', ['pv', 'gpv']); // fetch both PV and GPV

    // Apply date range filter if provided
    if (!empty($startdate) && !empty($enddate)) {
        $query->whereBetween(
            DB::raw("DATE(history_datetime)"),
            [$startdate, $enddate]
        );
    }

    // Paginate results
    $records = $query->orderBy('history_datetime', 'desc')->paginate(10);
// dd($records);
    return DPVDetails::showPVHistory($records);
}

// public static function getGPVHistory(Request $request)
// {
//     // dd('functionreach');
//     $user_id = Auth::user()->members_id;

//     $columns = ['history_datetime', 'history_description', 'history_amount'];

//     $query = History::where('history_member_id', $user_id)
//                     ->where('history_type', 'gpv');

//     // Filters
//     if ($request->filled('columns.0.search.value')) {
//         $dates = explode('|', $request->input('columns.0.search.value'));
//         $startDate = $dates[0];
//         $endDate = $dates[1];
//         $query->whereBetween(DB::raw('DATE(history_datetime)'), [$startDate, $endDate]);
//     }

//     if ($request->filled('columns.1.search.value')) {
//         $query->where('history_description', 'like', '%' . $request->input('columns.1.search.value') . '%');
//     }

//     if ($request->filled('columns.2.search.value')) {
//         $query->where('history_amount', $request->input('columns.2.search.value'));
//     }

//     // Total records before pagination
//     $total = (clone $query)->count();

//     // Ordering
//     $orderColumnIndex = $request->input('order.0.column', 0);
//     $orderDir = $request->input('order.0.dir', 'asc');
//     $query->orderBy($columns[$orderColumnIndex], $orderDir);

//     // Pagination
//     $start = $request->input('start', 0);
//     $length = $request->input('length', 10);
//     $records = $query->skip($start)->take($length)->get();
//     // dd($records);
//     return DPVDetails::showPVHistory($records, $total);
// }


}