<?php

namespace Admin\App\Display\Reports;


use Admin\App\Models\Middleware\MFormatDate;
use Admin\App\Models\Middleware\MFormatNumber;
use Illuminate\Http\JsonResponse;
use Admin\App\Models\Middleware\MSiteDetails;
use Admin\App\Models\Member\SiteDetails;
class DUserCommisisonReports
{

public static function getUserCommissionReports($records, $totalPages, $totalCount)
{
   // Get site currency safely
        //  $site_currency = $_SESSION['site_settings']['site_currency'];
                  $site_currency = SiteDetails::where('sitesettings_name', 'site_currency')
                            ->value('sitesettings_value');

        $formattedRecords = [];

        if (!empty($records)) {
            foreach ($records as $index => $record) {
                $sno = $index + 1; // serial number

                $totalCommission = $record->total_commission ?? 0;
                $username = $record->members_username ?? '';

                $formattedRecords[] = [
                    'sno' => $sno,
                    'username' => '<a aria-label="link" href="' . env('BCPATH') . '/memberarea/show/' . $record->members_id . '">' . e($username) . '</a>',
                    'amount' => $site_currency . ' ' . MFormatNumber::formatingNumberCurrency($totalCommission),
                ];
            }

            $response = [
                'total_pages' => $totalPages,
                'records' => $formattedRecords,
                'total_records' => $totalCount,
            ];
        } else {
            $response = [
                'total_pages' => 0,
                'records' => [],
                'total_records' => 0,
            ];
        }
        return [
                'total_pages' => $totalPages,
                'records' => $formattedRecords,
                'total_records' => $totalCount,
            ];
// dd($response);
        // return response()->json($response);
    }


}