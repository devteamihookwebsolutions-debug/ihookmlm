<?php
namespace Admin\App\Display\Ewallet;

use Illuminate\Http\JsonResponse;
use Admin\App\Models\Middleware\MFormatDate;
use Admin\App\Models\Middleware\MSiteDetails;
use Illuminate\Support\Facades\DB;
class DEwalletPayments   
{
    
// public static function showEwalletManagement($records, $iTotal)
// {
//     // dd($records);
//     $data = [];

//     if (count((array) $records) > 0) {


//         //Get site currency only once
//         $where = 'WHERE sitesettings_name="site_currency"';
//         $site_currency_data = MSiteDetails::getSiteSettingsDetails($where);
//         $site_currency = is_array($site_currency_data) && isset($site_currency_data[0]['sitesettings_value'])
//             ? $site_currency_data[0]['sitesettings_value']
//             : '';

//         foreach ($records as $record) {

//             $currency = DB::table('ihook_currencysettings_table')
//                 ->where('currency_id', $record->payment_user_request_currency_id)
//                 ->first();

//             $user = DB::table('ihook_members_table')
//                 ->where('members_id', $record->paymenthistory_member_id)
//                 ->first();

//             $payment = DB::table('ihook_paymentsettings_table')
//                 ->where('paymentsettings_id', $record->paymenthistory_mode)
//                 ->first();

//             $formattedDate = MFormatDate::formatingDate($record->paymenthistory_date);
//             $currencySymbol = $currency->currency_symbol ?? '';
//             // dd($currency);
//             // Build payment status (HTML ready)
//             $paymentStatus = $record->paymenthistory_status === 'notpaid'
//                 ? '<a href="javascript:void(0);" onclick="activateEwalletPayment(' . $record->paymenthistory_id . ')">
//                     <span class="bg-neutral-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded border border-blue-400">Activate</span>
//                    </a>'
//                 : '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-400">Paid</span>';

//             //Push into data array
//             $data[] = [
//                 'username'       => $user->members_username ?? '-',
//                 'amount'         => $currencySymbol . ($record->paymenthistory_amount ?? '0'),
//                 'payment_mode'   => $payment->paymentsettings_name ?? '-',
//                 'transaction_id' => $record->paymenthistory_trans_id ?? '-',
//                 'date'           => $formattedDate,
//                 'type'           => ucfirst($record->paymenthistory_type ?? '-'),
//                 'status'         => $paymentStatus,
//             ];
//         }
//     }
//     return [
//         'total' => $iTotal,
//             'data'  => $data,
//     ];

// }

public static function showEwalletManagement($records, $iTotal)
{
    // dd('function reached');
    $output = '';

    if (count((array) $records) > 0) {

        //  Get site currency once
        // $where = 'WHERE sitesettings_name="site_currency"';
        // $site_currency_data = MSiteDetails::getSiteSettingsDetails($where);
        // $site_currency = is_array($site_currency_data) && isset($site_currency_data[0]['sitesettings_value'])
        //     ? $site_currency_data[0]['sitesettings_value']
        //     : '';
$where = ['sitesettings_name' => 'site_currency'];
$site_currency = MSiteDetails::getSiteSettingsDetails($where)->first();
        foreach ($records as $record) {

            //  Get related currency details
            $currency = DB::table('ihook_currencysettings_table')
                ->where('currency_id', $record->payment_user_request_currency_id)
                ->first();

            //  Get user details
            $user = DB::table('ihook_members_table')
                ->where('members_id', $record->paymenthistory_member_id)
                ->first();

            //  Get payment settings
            $payment = DB::table('ihook_paymentsettings_table')
                ->where('paymentsettings_id', $record->paymenthistory_mode)
                ->first();

            //  Format date
            $formattedDate = MFormatDate::formatingDate($record->paymenthistory_date);

            // urrency symbol
            $currencySymbol = $currency->currency_symbol ?? '';

            // Payment status button / label
            if ($record->paymenthistory_status === 'notpaid') {
                $paymentStatus = '<a aria-label="link" href="javascript:void(0);" onclick="activateEwalletPayment(' . $record->paymenthistory_id . ')" id="awaiting">
                    <span class="bg-neutral-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 dark:text-blue-400 border border-blue-400">
                        ' . __('Activate') . '
                    </span>
                </a>';
            } else {
                $paymentStatus = '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 dark:text-green-400 border border-green-400">
                    ' . __('Paid') . '
                </span>';
            }

            // Build HTML row
            $output .= '<tr>
                <td>' . ($user->members_username ?? '-') . '</td>
                <td>' . $currencySymbol . ($record->paymenthistory_amount ?? '0') . '</td>
                <td>' . ($payment->paymentsettings_name ?? '-') . '</td>
                <td>' . ($record->paymenthistory_trans_id ?? '-') . '</td>
                <td>' . $formattedDate . '</td>
                <td>' . ucfirst($record->paymenthistory_type ?? '-') . '</td>
                <td>' . $paymentStatus . '</td>
            </tr>';
        }
    }

    // Return final HTML table rows
    // dd($output);
    return $output;
}


}




