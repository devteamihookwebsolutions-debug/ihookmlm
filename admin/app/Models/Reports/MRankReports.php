<?php
namespace Admin\App\Models\Reports;

use Illuminate\Http\Request;
use Admin\App\Models\Member\Reports;
use Admin\App\Models\Member\Member;
use Admin\App\Display\Reports\DRankReports;

class MRankReports
{
    /**
     * Show rank bonus report (Eloquent version)
     */
    public static function rankbonus(Request $request, $value)
    {
        $perPage = (int) $request->input('perPage', 10);
        $page = (int) $request->input('page', 1);
        $offset = ($page - 1) * $perPage;

        $columnIndex = (int) $request->input('columnIndex');
        $queryValue = $request->input('query');

        // Base query
        $query =Reports::from('ihook_history_table as a')
            ->leftJoin('ihook_members_table as b', 'a.history_member_id', '=', 'b.members_id')
            ->where('a.history_type', '=', $value)
            ->select(
                'a.history_member_id',
                'b.members_username',
                'a.history_amount',
                'a.history_wallet_type',
                'a.history_datetime'
            );

        // Apply filters
        if (!empty($queryValue)) {
            if ($columnIndex === 1) {
                $query->where('b.members_username', trim($queryValue));
            }

            if ($columnIndex === 3) {
                $query->where('a.history_wallet_type', trim($queryValue));
            }

            if ($columnIndex === 4) {
                $dateArray = explode('|', $queryValue);
                if (count($dateArray) === 2) {
                    $startDate = date('Y-m-d', strtotime($dateArray[0]));
                    $endDate = date('Y-m-d', strtotime($dateArray[1]));
                    $query->whereBetween(Reports::raw('DATE(a.history_datetime)'), [$startDate, $endDate]);
                }
            }
        }

        // Count and paginate
        $iTotal = $query->count();
        $records = $query
            ->orderBy('a.history_id', 'DESC')
            ->skip($offset)
            ->take($perPage)
            ->get();

        $totalPages = ceil($iTotal / $perPage);
        // dd($records);
        // Pass to display layer
        return DRankReports::rankbonus($records, $totalPages, $iTotal);
    }
}
