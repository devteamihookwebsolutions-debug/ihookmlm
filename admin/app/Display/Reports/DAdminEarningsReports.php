<?php
namespace Admin\App\Display\Reports;
use Admin\App\Models\Middleware\MMatrixDetails;
use Admin\App\Models\Middleware\MFormatDate;
use Admin\App\Models\Middleware\MFormatNumber;
use DB;
use Illuminate\Http\JsonResponse;

class DAdminEarningsReports
{
    public static function adminEarnings($records, $iTotal, $iTotalRecords)
{
    $memData = [];

    foreach ($records as $record) {
        if (empty($record->members_id)) {
            continue;
        }

        // Get matrix name
        $matrixDetails = MMatrixDetails::getMatrixDetails($record->history_matrix_id);
        $matrixName = $matrixDetails['matrix_name'] ?? '';

        // === Description ===
        $type = match ($record->history_description) {
            'upgrade' => __('Upgraded as premium member'),
            'purchase' => __('Purchase of product'),
            'subscription' => __('Subscription of package'),
            'ewalletcredits' => __('Paid for e-wallet credit'),
            'generationbonus' => __('Generation Bonus Commission'),
            default => $record->history_description,
        };

        // === Earning Type ===
        $earningType = match ($record->history_type) {
            'withdrawal' => __('Withdraw Commission'),
            'fundtransferred' => __('Fund transfer commission'),
            'ewalletcredits' => __('Paid for e-wallet credit'),
            default => $type ?? __('Other Earnings'),
        };

        if ($record->history_description == 'upgrade') {
            $earningType = __('Purchase of plan') . ' - ' . $matrixName;
        }

        // === Payment Status ===
        $paymentStatus = '';
        if ($record->history_status === 'paid' || (is_numeric($record->history_status) && $record->history_status > 0)) {
            $paymentStatus = '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">' . __('Paid') . '</span>';
        } elseif ($record->history_status === 'notpaid') {
            $paymentStatus = '<span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">' . __('Pending') . '</span>';
        } elseif ($record->history_status == 0 && in_array($record->history_type, ['withdrawal', 'fundtransferred'])) {
            $paymentStatus = '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">' . __('Paid') . '</span>';
        }

        // === Currency Symbol ===
        $currencySymbol = null;
        if (!empty($record->currency_id)) {
            $currency = DB::table($_ENV['IHOOK_PREFIX'] . 'currencysettings_table')
                ->where('currency_id', $record->currency_id)
                ->first();

            $currencySymbol = $currency->currency_symbol ?? $_SESSION['site_settings']['site_currency'] ?? '$';
        } else {
            $currencySymbol = $_SESSION['site_settings']['site_currency'] ?? '$';
        }

        // === Action Button ===
        $action = '<a aria-label="link" class="hover:bg-brand text-brand p-2 rounded-full" href="#" title="View" onclick="viewDetails(' . $record->history_id . ')">
            <svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd"></path>
            </svg>
        </a>';

        // === Date + Amount Formatting ===
        $formatDate = MFormatDate::formatingDate($record->history_datetime);
        $formattedAmount = $currencySymbol . MFormatNumber::formatingNumberCurrency($record->history_amount);

        // $memData[] = [
        //     'Name' => '<a aria-label="link" href="' . $_ENV['BCPATH'] . '/memberarea/show/' . $record->history_member_id . '">' . e($record->members_username) . '</a>',
        //     'earningtype' => $earningType,
        //     'transid' => $record->history_transaction_id,
        //     'date' => $formatDate,
        //     'description' => $type,
        //     'paymentstatus' => $paymentStatus,
        //     'amount' => $formattedAmount,
        //     'action' => $action,
        // ];
        $memData[] = [
    'Name' => e($record->members_username),
    'earningtype' => $earningType,
    'transid' => $record->history_transaction_id,
    'date' => $formatDate,
    'description' => $type,
    'paymentstatus' => $paymentStatus,
    'amount' => $formattedAmount,
    'action' => $action,
];

    }

    // $response = [
    //     'total_pages' => $iTotal,
    //     'records' => $memData,
    //     'total_records' => $iTotalRecords,
    // ];
    // //  dd($response);
    // return response()->json($response);
    // dd($memData);
    return [
        'total_pages' => $iTotal,
        'records' => $memData,
        'total_records' => $iTotalRecords,
    ];

}

public static function adminEarningsDetails($records)
{
    $record = $records->first();

    if (!$record) {
        return response()->json(['error' => 'No record found'], 404);
    }

    $matrix = DB::table('ihook_matrix_table')
        ->where('matrix_id', $record->history_matrix_id)
        ->first();

    $matrixname = $matrix ? $matrix->matrix_name : '';

    switch ($record->history_description) {
        case 'upgrade':
            $earningtype = __('Upgraded as Premium Member') . ' - ' . $matrixname;
            break;
        case 'purchase':
            $earningtype = __('Purchase of Product');
            break;
        case 'subscription':
            $earningtype = __('Subscription Of Package');
            break;
        case 'ewalletcredits':
            $earningtype = __('Paid for ewallet credits');
            break;
        default:
            $earningtype = $record->history_description;
    }

    if ($record->history_type == 'withdrawal') {
        $earningtype = __('Withdrawal commission');
    } elseif ($record->history_type == 'fundtransferred') {
        $earningtype = __('Fundtransfer commission');
    } elseif ($record->history_type == 'ewalletcredits') {
        $earningtype = __('Paid for ewallet credits');
    }

    $formatDate = MFormatDate::formatingDate($record->history_datetime);
$currency = session('site_settings.site_currency', '$');
    $output = '
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5">

        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-black dark:text-white">Username</label>
            <input type="text" value="' . $record->members_username . '" disabled class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
        </div>

        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-black dark:text-white">Earning Type</label>
            <input type="text" value="' . $earningtype . '" disabled class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
        </div>

        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-black dark:text-white">Transaction ID</label>
            <input type="text" value="' . $record->history_transaction_id . '" disabled class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
        </div>

        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-black dark:text-white">Payment Status</label>
            <input type="text" value="' . $record->history_status . '" disabled class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
        </div>

        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-black dark:text-white">Date</label>
            <input type="text" value="' . $formatDate . '" disabled class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
        </div>

        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-black dark:text-white">Amount</label>
            <input type="text" value="' . $currency. ' ' . MFormatNumber::formatingNumberCurrency($record->history_amount) . '" disabled class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
        </div>

    </div>';

    return $output;
}



}
