<?php
namespace User\App\Display\Reports;
use Admin\App\Models\Middleware\MFormatDate;
use Admin\App\Models\Middleware\MFormatNumber;
use Admin\App\Models\Middleware\MMembersDetails;
use Illuminate\Support\Facades\DB;
class DDownlineLevelSales  
{  
public static function getDownlineDetailsNew($records)
{
    if ($records->isEmpty()) return '';

    $siteCurrency = session('site_settings.site_currency', '$');
    $conversionRate = session('matrix.currency_conversion_rate', 1);
    // dd($conversionRate);

    $output = '';

    foreach ($records as $record) {
        $ranks = $record->ranks ?: '-';
        $salesAmount = $record->salesAmount * $conversionRate;

        $output .= "<tr>
            <td>{$record->members_id}</td>
            <td>{$record->userName}</td>
            <td>{$ranks}</td>
            <td>{$record->sponsor}</td>
            <td>{$siteCurrency}" . number_format($salesAmount, 2) . "</td>
        </tr>";
    }

    // dd($output);
    return $output;
}



}