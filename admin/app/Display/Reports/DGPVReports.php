<?php

/**
 * This class contains public functions related to DGPVReports
 *
 * @package         DGPVReports
 * @category        Display
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?><?php

namespace Admin\App\Display\Reports;

use Admin\App\Models\Middleware\MTotalGPV;
use Illuminate\Http\JsonResponse;

class DGPVReports
{
    /**
     * Get GPV Reports (Display Layer)
     *
     * @param array $records
     * @param int $iTotal
     * @param int $iTotalRecords
     * @return JsonResponse
     */
    public static function getGPVReports($records, $iTotal, $iTotalRecords)
    {
        // $mem_data = [];

        if (!empty($records)) {
            foreach ($records as $i => $record) {
                $members_id = $record['members_id'];
                $matrix_id = $record['matrix_id'];
                $amount = MTotalGPV::getTotalGPV($members_id, $matrix_id);
                // dd($amount);
               $mem_data[] = [
            'sno'      => $i + 1,
            'username' => $record['members_username'], // no link here
            'amount'   => round($amount ?? 0),
            'date'      =>$record['history_datetime']
        ];
            }
        }

        // $res_array = [
        //     'total_pages'   => $iTotal,
        //     'records'       => $mem_data,
        //     'total_records' => $iTotalRecords,
        // ];
        // // dd($res_array);

        // return response()->json($res_array);
        return [
            'total_pages'   => $iTotal,
            'records'       => $mem_data,
            'total_records' => $iTotalRecords
            ];
    }
}
