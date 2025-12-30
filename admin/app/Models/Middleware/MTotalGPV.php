<?php
/**
 * This class contains public static functions related to payment gateway details.
 *
 * @package         MPaymentGatewayDetails
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://promlmsoftware.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement: 
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?><?php
namespace Admin\App\Models\Middleware;
use Admin\App\Models\Member\Reports;
class MTotalGPV{

     public static function getTotalGPV($members_id, $matrix_id)
    {
        // dd($matrix_id);
       $total = Reports::from('ihook_history_table as a')
    ->leftJoin('ihook_matrix_members_link_table as b', 'b.members_id', '=', 'a.history_member_id')
    ->whereRaw("FIND_IN_SET(?, b.members_parents)", [$members_id])
    ->where('a.history_type', 'pv')
    ->where('a.history_matrix_id', $matrix_id)
    ->sum('a.history_amount');

    //    dd($total);
        return $total ;
    }
}