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
