<?php

namespace Admin\App\Display\Reports;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Admin\App\Models\Middleware\MSiteDetails;
use Admin\App\Models\Middleware\MFormatDate;
use Admin\App\Models\Middleware\MMemberDetails;
use Admin\App\Models\Middleware\MFormatNumber;
use Illuminate\Http\JsonResponse;
use Admin\App\Models\Member\SiteDetails;

class DCommissionReports
{

public static function getCommissionReports($records, $totalPages, $totalRecords)
    {
        //Get site currency
           $site_currency = SiteDetails::where('sitesettings_name', 'site_currency')
                            ->value('sitesettings_value');

        $data = [];

        if (!empty($records) && count((array)$records) > 0) {
            foreach ($records as $index => $record) {
                // $formattedDate = MFormatDate::formatingDate($record['history_datetime']);
                      $formattedDate = MFormatDate::formatingDate($record->history_datetime);
                    //   dd($formattedDate);
                $memberId = $record->history_member_id;

                $type = self::getHistoryType($record->history_type);

                $data[] = [
                    'sno' => $index + 1,
                    'username' => sprintf(
                        '<a aria-label="link" href="%s/memberarea/show/%d">%s</a>',
                        env('BCPATH'),
                        $memberId,
                        $record->members_username
                    ),
                    'amount' => $site_currency . ' ' . MFormatNumber::formatingNumberCurrency($record->history_amount),
                    'type' => $type,
                    'date' => $formattedDate,
                ];
            }
        }
        // dd($data);
        // return response()->json([
        //     'total_pages' => $totalPages,
        //     'records' => $data,
        //     'total_records' => $totalRecords,
        // ]);
        return [
    'total_pages' => $totalPages,
    'records' => $data,
    'total_records' => $totalRecords,
];

    }



    public static function getHistoryType($historyType)
{
    $historyTypes = [
        'levelcommission' => 'CUS_LEVEL_COMMISSION',
        'directcommission' => 'CUS_DIRECT_COMMISSION',
        'xupcommission' => 'CUS_XUP_COMMISSION',
        'withdraw_pending' => 'CUS_WITHDRAW_PENDING',
        'withdrawal' => 'CUS_WITHDRAWAL',
        'binarycommission' => 'CUS_BINARY_COMMISSION',
        'cyclecommission' => 'CUS_CYCLE_COMMISSION',
        'productlevelcommission' => 'CUS_PRODUCT_LEVEL_COMMISSION',
        'ewalletdeducts' => 'CUS_EWALLET_DEDUCTS',
        'ewalletcredits' => 'CUS_EWALLET_CREDITS',
        'adminbonus' => 'CUS_ADMIN_BONUS',
        'admindeduct' => 'CUS_ADMIN_DEDUCT',
        'pv' => 'CUS_PV',
        'epinpurchasededuct' => 'CUS_EPIN_PURCHASE_DEDUCT',
        'fundtransferred' => 'CUS_FUND_TRANSFERRED',
        'fundreceived' => 'CUS_FUND_RECEIVED',
        'rankbonus' => 'CUS_RANK_BONUS',
        'joiningcommission' => 'CUS_JOINING_COMMISSION',
        'entrybonus' => 'CUS_ENTRY_BONUS',
        'exitbonus' => 'CUS_EXIT_BONUS',
        'custombonus' => 'CUS_CUSTOM_BONUS',
        'stairwellcommission' => 'CUS_STAIRWELL_COMMISSION',
        'qualificationbonus' => 'CUS_QUALIFICATION_BONUS',
        'directbonus' => 'CUS_DIRECT_BONUS',
        'networkbonus' => 'CUS_NETWORK_BONUS',
        'matchingbonus' => 'CUS_MATCHING_BONUS',
        'withdrawcompleted' => 'CUS_WITHDRAW_COMPLETED',
        'dailybinarycommision' => 'CUS_DAILY_BINARY_COMMISSION',
        'weeklybinarycommision' => 'CUS_WEEKLY_BINARY_COMMISSION',
        'monthlybinarycommision' => 'CUS_MONTHLY_BINARY_COMMISSION',
        'stairstep' => 'CUS_STAIRSTEP',
        'generationbonus' => 'CUS_GENERATION_BONUS',
        'customer_acquisition_bonus' => 'CUS_CUSTOMER_ACQUISITION_BONUS',
        'customer_retail_commission' => 'CUS_CUSTOMER_RETAIL_COMMISSION',
        'membershipcommission' => 'CUS_MEMBERSHIP_COMMISSION',
        'split_commission' => 'CUS_SPLIT_COMMISSION',
        'pool' => 'CUS_POOL'
    ];

    // Get the mapped key (CUS_* code)
    $languageKey = $historyTypes[$historyType] ?? null;

    if (!$languageKey) {
        return ucfirst(str_replace('_', ' ', $historyType));
    }

    // Get current site language (fallback to English)
    $language = session('sitelang', 'en');

    // Fetch translation from terminology table
   $record = DB::table('ihook_terminology_settings_table')
    ->where('language_key', $languageKey)
    ->where('language', $language)
    ->value('language_value');

    // If no translation found, fallback to key itself
    return $record ?? ucfirst(str_replace('_', ' ', $historyType));
}

}
