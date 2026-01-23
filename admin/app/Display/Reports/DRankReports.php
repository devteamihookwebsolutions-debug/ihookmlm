<?php

/**
 * This class contains public functions related to DRankReports
 *
 * @package         DRankReports
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

use Admin\App\Models\Middleware\MWalletDetails;
use Admin\App\Models\Middleware\MFormatDate;
use Admin\App\Models\Middleware\MFormatNumber;
use Illuminate\Http\JsonResponse;

class DRankReports
{
    /**
     * Format Rank Bonus report data and return JSON
     */
    public static function rankbonus($records, $totalPages, $totalRecords): JsonResponse
    {
        $memData = [];

        if ($records->isNotEmpty()) {
            foreach ($records as $index => $record) {
                $walletType = $record->history_wallet_type;
                $walletInfo = MWalletDetails::getWalletDetails($walletType);
                $formattedDate = MFormatDate::formatingDate($record->history_datetime);
                // dd($formattedDate);
                $formattedDate =($record['history_datetime']);
                $walletName = $walletInfo[0]['wallet_name'] ?? 'N/A';


                $memData[] = [
                    'No' => $index + 1,
                    'name' => $record->members_username, //  removed <a href> for cleaner API output
                    'amount' => config('app.currency', '$') . ' ' . MFormatNumber::formatingNumberCurrency($record->history_amount),
                    //  'amount'=>round($record['history_amount']),
                    'wallet' => $walletName,
                    'date' => $formattedDate,
                ];
            }
        }

        $response = [
            'total_pages' => $totalPages,
            'records' => $memData,
            'total_records' => $totalRecords,
        ];
        //  dd($response);
        return response()->json($response);
    }
}
