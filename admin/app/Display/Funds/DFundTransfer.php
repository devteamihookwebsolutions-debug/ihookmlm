<?php
namespace Admin\App\Display\Funds;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Admin\App\Models\Middleware\MSiteDetails;
use Admin\App\Models\Middleware\MFormatDate;
use Admin\App\Models\Middleware\MMemberDetails;
use Admin\App\Models\Middleware\MWalletDetails;

class DFundTransfer
{
    public static function showFundTransfers($records, $iTotal)
    {
        $data = [];

        if ($records->count() > 0) {
            // Get site currency once
            $where = 'WHERE sitesettings_name="site_currency"';
            $site_details = MSiteDetails::getSiteSettingsDetails($where);
            $site_currency = $site_details[0]['sitesettings_value'] ?? '';

            // Loop through each record
            foreach ($records as $record) {
                $members_id = $record->history_member_id;
                $to_members_id = $record->history_fund_transfer_from_to_id;

                // Fetch user details
                $userdetails = MMemberDetails::getUserDetails($members_id);
                $touserdetails = MMemberDetails::getUserDetails($to_members_id);

                // Get wallet name
                $wallet_records = MWalletDetails::getWalletDetails($record->history_wallet_type);
                $wallet_type = $wallet_records[0]['wallet_name'] ?? '-';

                // Format date
                $formattedDate = MFormatDate::formatingDate($record->history_datetime);

                // Push into data array
                $data[] = [
                    'from_user'  => $userdetails['members_username'] ?? '-',
                    'to_user'    => $touserdetails['members_username'] ?? '-',
                    'amount'     => $site_currency . ($record->history_amount ?? '0'),
                    'wallet'     => $wallet_type,
                    'date'       => $formattedDate,
                ];
            }
        }

        return [
      'total' => $iTotal,
        'data'  => $data,
        ];
        //Always return a valid JSON response
        // return response()->json([
        //     'total' => $iTotal,
        //     'data'  => $data,
        // ]);
    }
}
