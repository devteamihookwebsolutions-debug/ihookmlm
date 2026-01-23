<?php

/**
 * This class contains public functions related to DPVDetails
 *
 * @package         DPVDetails
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

class DPVDetails
{

public static function showPVHistory($pvrecords)
{
    // dd($pvrecords);
    // dd('funciron reached');
    $output = '';

    foreach ($pvrecords as $record) {

        $history_datetime = MFormatDate::formatingDate($record->history_datetime);

        $output .= '
            <tr>
                <td data-date="'.$history_datetime.'">'.$history_datetime.'</td>
                <td>'.$record->history_description.'</td>
                <td>'.round($record->history_amount).'</td>
            </tr>
        ';
    }

    // dd($output);
    return $output;
}


}
