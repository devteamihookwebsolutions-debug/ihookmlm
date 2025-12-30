<?php
namespace Admin\App\Models\Reports;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Admin\App\Display\Reports\DPackageReports;

class MPackageReports
{
    /**
     * Get package reports with pagination and record count
     */
    public static function getPackagereports(Request $request)
    {
        $perPage = (int) $request->input('perPage', 10);
        $page = (int) $request->input('page', 1);
        $offset = ($page - 1) * $perPage;

        $columnIndex = (int) $request->input('columnIndex');
        $queryValue = $request->input('query');

        // Base query
        $query = DB::table('ihook_matrix_members_link_table as a')
            ->leftJoin('ihook_members_table as b', 'a.members_id', '=', 'b.members_id')
            ->leftJoin('ihook_package_table as c', 'a.members_subscription_plan', '=', 'c.package_id')
            ->select(
                'a.members_id',
                'b.members_username',
                'c.package_name'
            );

        //  Optional: Apply filters if search/queryValue exists
        if (!empty($queryValue)) {
            if ($columnIndex === 1) {
                $query->where('b.members_username', 'LIKE', '%' . trim($queryValue) . '%');
            }

            if ($columnIndex === 2) {
                $query->where('c.package_name', 'LIKE', '%' . trim($queryValue) . '%');
            }
        }

        // Count total records
        $iTotal = $query->count();

        //  Apply pagination manually
        $records = $query
            ->orderBy('a.members_id', 'DESC')
            ->skip($offset)
            ->take($perPage)
            ->get();
        // dd($records);
        //  Calculate total pages
        $totalPages = ceil($iTotal / $perPage);

        //  Pass to display layer (like DRankReports)
        return DPackageReports::getPackagereports($records, $totalPages, $iTotal);
    }
}
