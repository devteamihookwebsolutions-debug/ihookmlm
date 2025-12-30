<?php
namespace User\App\Display\Reports;
use Admin\App\Models\Middleware\MFormatDate;
use Admin\App\Models\Middleware\MFormatNumber;
use Illuminate\Support\Facades\DB;
class DEwalletHistory  
{  public static function ewalletHistory($records)
    {
        $output = "";

        // Loop through each record
        foreach ($records as $record) {
            // Check if history_datetime exists and is formatted correctly
            $history_datetime = MFormatDate::formatingDate($record['history_datetime'] ?? ''); // Using array access if $record is an array
            if (empty($history_datetime)) {
                $history_datetime = 'N/A'; // Placeholder for missing datetime
            }

            // Get currency symbol from Laravel session
            $currency = session('site_settings.site_currency', '$');

            // Check history_description, use a default if null
            $description = $record['history_description'] ?? 'No description available';

            // Handle history_amount
            $amount = MFormatNumber::formatingNumberCurrency($record['history_amount'] ?? 0);
            if ($amount == 0) {
                $amount = '0.00'; // Ensure formatting to two decimal places
            }

            // Build table row
            $output .= '<tr>
                <td data-date="'. $history_datetime .'">'. $history_datetime .'</td>
                <td>'. $description .'</td>
                <td>'. $currency . $amount .'</td>
            </tr>';
        }
        // dd($output);
        return $output;
    }
}