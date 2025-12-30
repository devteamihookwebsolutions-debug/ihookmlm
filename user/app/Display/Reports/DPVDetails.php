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