<?php

/**
 * This class contains public functions related to MDownlineSales
 *
 * @package         MDownlineSales
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace App\Models\Middleware;

use Illuminate\Support\Facades\DB;

class MDownlineSales
{
    /**
     * Get total downline MLM sales
     *
     * @param int $members_id
     * @param int $matrix_id
     * @return float|int
     */
    public static function getDownlineMLMSales($members_id, $matrix_id)
    {
       $prefix = config('services.ihook.prefix');
        return DB::table($prefix . '_matrix_members_link_table as a')
            ->leftJoin(
                $prefix . '_paymenthistory_table as b',
                'b.paymenthistory_member_id',
                '=',
                'a.members_id'
            )
            ->whereRaw('FIND_IN_SET(?, a.members_parents)', [$members_id])
            ->where('a.matrix_id', $matrix_id)
            ->where('b.paymenthistory_status', 'paid')
            ->whereIn('b.paymenthistory_type', ['upgrade', 'subscription'])
            ->sum('b.paymenthistory_amount');
    }
}
