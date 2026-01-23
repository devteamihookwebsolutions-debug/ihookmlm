<?php

/**
 * This class contains public functions related to DDownlineLevelSales
 *
 * @package         DDownlineLevelSales
 * @category        Display
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
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
