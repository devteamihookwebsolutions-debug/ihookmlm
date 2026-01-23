<?php

/**
 * This class contains public functions related to DPVReports
 *
 * @package         DPVReports
 * @category        Display
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



