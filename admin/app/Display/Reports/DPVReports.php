<?php

namespace Admin\App\Display\Reports;

use Admin\App\Models\Middleware\MFormatDate;
use Illuminate\Http\JsonResponse;

class DPVReports
{
    /**
     * Get GPV Reports (Display Layer)
     *
     * @param array $records
     * @param int $iTotal
     * @param int $iTotalRecords
     * @return JsonResponse
     */

    public static function getPVReports($records, $totalPages, $totalRecords)
    {
        $memData = [];

        if (!empty($records) && count((array)$records) > 0) {
            foreach ($records as $index => $record) {
                $no = $index + 1;
                $formattedDate =($record['history_datetime']);

                $memData[] = [
                    'No' => $no,
                    'name' => $record['members_username'], // Removed <a href> link as requested earlier
                    'amount' => round($record['history_amount']),
                    'formatdate' => $formattedDate
                ];
            }
        }

        // Build response structure
        // $response = [
        //     'total_pages' => $totalPages ?? 0,
        //     'records' => $memData,
        //     'total_records' => $totalRecords ?? 0,
        // ];
        return [
                'total_pages' => $totalPages,
                'records' => $memData,
                'total_records' => $totalRecords,
            ];
        //  dd($response);
        // return response()->json($response);
    }
}



