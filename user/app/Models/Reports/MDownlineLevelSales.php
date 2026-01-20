<?php

/**
 * This class contains public functions related to MDownlineLevelSales
 *
 * @package         MDownlineLevelSales
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace User\App\Models\Reports;
use User\App\Display\Reports\DDownlineLevelSales;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class MDownlineLevelSales
{
    //   public static function getdownlinedetailsnew($members_id){
    //     // dd($members_id);
    //   }
public static function getDownlineDetailsNew($memberId)
{
    $memberId = Auth::user()->members_id;
    // dd($memberId);

    // Date filters
    $start = request('start_date');
    $end   = request('end_date');

    $filter = function ($query) use ($start, $end) {
        if ($start && $end) {
            $query->whereBetween(DB::raw('DATE(paymenthistory_date)'), [
                date('Y-m-d', strtotime($start)),
                date('Y-m-d', strtotime($end))
            ]);
        }
    };

    // Main query
    $records = DB::table('ihook_members_table as a')
        ->leftJoin('ihook_matrix_members_link_table as b', 'a.members_id', '=', 'b.members_id')
        ->whereRaw("FIND_IN_SET(?, b.members_parents)", [$memberId])
        ->select([
            'a.members_username as userName',
            'a.members_id',

            // Sponsor
            DB::raw("(SELECT members_username
                      FROM ihook_members_table
                      WHERE members_id = b.spillover_id) as sponsor"),

            // Rank
            DB::raw("(SELECT rank_value
                      FROM ihook_ranksetting
                      WHERE rank_key='rank_title'
                      AND rank_id=b.rankid
                      LIMIT 1) as ranks"),

            // Sales Amount
            DB::raw("(SELECT SUM(paymenthistory_amount)
                      FROM ihook_paymenthistory_table
                      WHERE paymenthistory_member_id = a.members_id) as salesAmount")
        ])
        ->get();

        // dd($records);
    return DDownlineLevelSales::getdownlinedetailsnew($records);
}

}
