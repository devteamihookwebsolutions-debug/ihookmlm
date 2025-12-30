<?php

namespace User\App\Display\Reports;

use Admin\App\Models\Middleware\MFormatDate;
use Admin\App\Models\Middleware\MFormatNumber;

class DWithdrawalHistory
{
    public static function withdrawalhistory($records)
    {
        // dd($records);
        $output = "";

        foreach ($records as $row) {
            // dd('fjkasghdf');

            // STATUS BADGE
            if ($row->history_type === 'withdraw_pending') {
                $status = '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">' . __('Pending') . '</span>';
            } else {
                $status = '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">' . __('Completed') . '</span>';
            }

            // DATE FORMAT
            $date = MFormatDate::formatingDate($row->history_datetime);

            // AMOUNT FORMAT
            $currency = session('site_settings.site_currency');
            $rate = session('matrix.currency_conversion_rate', 1);

            $amount = $currency . '&nbsp;' .
                MFormatNumber::formatingNumberCurrency($row->history_amount * $rate);

            // BUILD ROW
            $output .= '
                <tr>
                    <td>' . $date . '</td>
                    <td>' . $row->history_description . '</td>
                    <td>' . $amount . '</td>
                    <td>' . $status . '</td>
                </tr>
            ';
        }
        // dd($output);
        return $output;
    }
}
