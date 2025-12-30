<?php

namespace User\App\Display\Reports;
use Illuminate\Support\Facades\DB;
use Admin\App\Models\Middleware\MFormatDate;
use Admin\App\Models\Middleware\MFormatNumber;

class DTransactionHistory
{
    public static function TransactionHistory($records)
{
    // dd($records);
    $output = "";

    foreach ($records as $row) {

        // DATE FORMAT
        $date = MFormatDate::formatingDate($row->history_datetime);

        // STATUS BADGE
        if ($row->history_type === 'withdraw_pending') {
            $payment_status = '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">'
                                . __('Pending') .
                              '</span>';
        } else {
            $payment_status = '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">'
                                . __('Completed') .
                              '</span>';
        }

        // HISTORY TYPE
        $history_type = self::gethistorytype($row->history_type);

   
        if (trim($row->history_type) === 'pv') {
            $site_currency  = '';
            $history_amount = round($row->history_amount);
        } else {
            $site_currency  = session('site_settings.site_currency');
            $rate           = session('matrix.currency_conversion_rate', 1);

            $history_amount = MFormatNumber::formatingNumberCurrency(
                $row->history_amount * $rate
            );
        }

        // VIEW LINK
        $view = '<a aria-label="link" href="' . env('FCPATH') . '/transactionhistory/invoice/' . $row->history_id . '">view</a>';

        // BUILD ROW
        $output .= '
            <tr>
                <td>' . $date . '</td>
                <td>' . $row->history_description . '</td>
                <td>' . $history_type . '</td>
                <td>' . $site_currency . $history_amount . '</td>
                <td>' . $view . '</td>
                <td>' . $payment_status . '</td>
            </tr>
        ';
    }
    //  dd($output);
    return $output;
}





 public static function showTransactionType($records)
{
    // dd($records);
    $output = '';

    if ($records->count() > 0) {
        foreach ($records as $row) {

            $history_type_name = $row->history_type_name;
            $formattedName     = $row->history_name;

            // SELECTED
            $isSelected = (isset($_POST['type']) && $_POST['type'] == $history_type_name)
                        ? 'selected'
                        : '';

            if (!empty($formattedName)) {
                $output .= '<option value="' . $history_type_name . '" ' . $isSelected . '>'
                           . $formattedName .
                           '</option>';
            }
        }
    }
    // dd($output);
    return $output;
}
public static function getHistoryType($historytype)
{
    $historytypes = [
        'levelcommission'          => 'CUS_LEVEL_COMMISSION',
        'directcommission'         => 'CUS_DIRECT_COMMISSION',
        'xupcommission'            => 'CUS_XUP_COMMISSION',
        'withdraw_pending'         => 'CUS_WITHDRAW_PENDING',
        'withdrawal'               => 'CUS_WITHDRAWAL',
        'binarycommission'         => 'CUS_BINARY_COMMISSION',
        'cyclecommission'          => 'CUS_CYCLE_COMMISSION',
        'productlevelcommission'   => 'CUS_PRODUCT_LEVEL_COMMISSION',
        'ewalletdeducts'           => 'CUS_EWALLET_DEDUCTS',
        'ewalletcredits'           => 'CUS_EWALLET_CREDITS',
        'adminbonus'               => 'CUS_ADMIN_BONUS',
        'admindeduct'              => 'CUS_ADMIN_DEDUCT',
        'pv'                       => 'CUS_PV',
        'epinpurchasededuct'       => 'CUS_EPIN_PURCHASE_DEDUCT',
        'fundtransferred'          => 'CUS_FUND_TRANSFERRED',
        'fundreceived'             => 'CUS_FUND_RECEIVED',
        'rankbonus'                => 'CUS_RANK_BONUS',
        'joiningcommission'        => 'CUS_JOINING_COMMISSION',
        'entrybonus'               => 'CUS_ENTRY_BONUS',
        'exitbonus'                => 'CUS_EXIT_BONUS',
        'custombonus'              => 'CUS_CUSTOM_BONUS',
        'stairwellcommission'      => 'CUS_STAIRWELL_COMMISSION',
        'qualificationbonus'       => 'CUS_QUALIFICATION_BONUS',
        'directbonus'              => 'CUS_DIRECT_BONUS',
        'networkbonus'             => 'CUS_NETWORK_BONUS',
        'matchingbonus'            => 'CUS_MATCHING_BONUS',
        'withdrawcompleted'        => 'CUS_WITHDRAW_COMPLETED',
        'dailybinarycommision'     => 'CUS_DAILY_BINARY_COMMISSION',
        'weeklybinarycommision'    => 'CUS_WEEKLY_BINARY_COMMISSION',
        'monthlybinarycommision'   => 'CUS_MONTHLY_BINARY_COMMISSION',
        'stairstep'                => 'CUS_STAIRSTEP',
        'generationbonus'          => 'CUS_GENERATION_BONUS',
        'customer_acquisition_bonus' => 'CUS_CUSTOMER_ACQUISITION_BONUS',
        'customer_retail_commission' => 'CUS_CUSTOMER_RETAIL_COMMISSION',
        'membershipcommission'     => 'CUS_MEMBERSHIP_COMMISSION',
        'split_commission'         => 'CUS_SPLIT_COMMISSION',
        'pool'                     => 'CUS_POOL'
    ];

    // If key not found → return empty
    if (!array_key_exists($historytype, $historytypes)) {
        return '';
    }

    // Get matching language_key
    $languageKey = $historytypes[$historytype];

    // Current language (session)
    $lang = session('sitelang', 'en');

    // Query using DB::table()
    $record = DB::table('ihook_terminology_settings_table')
                ->where('language_key', $languageKey)
                ->where('language', $lang)
                ->value('language_value');

    // dd($record);

    return $record ?? '';
}
}
