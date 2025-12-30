<?php

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
