<?php

/**
 * This class contains public functions related to MGroupSalesTargetAmount
 *
 * @package         MGroupSalesTargetAmount
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

namespace Admin\App\Models\Middleware;
use Illuminate\Support\Facades\DB;
use App\Models\Middleware\MDownlineSales;

class MGroupSalesTargetAmount
{
    /**
     * Get total group sales (self + downline)
     *
     * @param int $member_id
     * @param int $matrix_id
     * @return float|int
     */
    public static function groupSalesTarget($member_id, $matrix_id)
    {
        // Get member's own shop sales
        $shop_sales = DB::table(env('IHOOK_PREFIX') . '_matrix_members_link_table')
            ->where('members_id', $member_id)
            ->where('matrix_id', $matrix_id)
            ->value('total_sales') ?? 0;

        // Get downline MLM sales
        $mlm_sales = MDownlineSales::getDownlineMLMSales($member_id, $matrix_id);

        // Total group sales
        return $shop_sales + $mlm_sales;
    }
}
