<?php

/**
 * This class contains public functions related to DLogManagement
 *
 * @package         DLogManagement
 * @category        Display
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace Admin\App\Display\Logs;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Admin\App\Models\Middleware\MSiteDetails;
use Admin\App\Models\Middleware\MFormatDate;


class DLogManagement
{
public static function showUserLogs($userrecords, $iTotal = null)
{
    $output = '';

    // Get the items from the paginator (Collection)
    $records = $userrecords instanceof \Illuminate\Pagination\LengthAwarePaginator
        ? $userrecords->items()
        : (is_array($userrecords) ? $userrecords : $userrecords->all());

    // Optional: total count
    $totalCount = $iTotal ?? count($records);

    // Loop through records
    foreach ($records as $record) {
        $createdDate = $record->created_at ?? '0000-00-00';
        $formatDate = MFormatDate::formatingDate($createdDate);

        $output .= '<tr>
            <td>' . htmlspecialchars($record->members_log_id ?? '') . '</td>
            <td>' . htmlspecialchars($record->log ?? '') . '</td>
            <td>' . htmlspecialchars($record->members_log_ip_used ?? '') . '</td>
            <td>' . $formatDate . '</td>
        </tr>';
    }

    // You can include total count somewhere if needed
    // e.g., a hidden input or summary row
    $output .= '<tr><td colspan="4"><strong>Total Records: ' . $totalCount . '</strong></td></tr>';
// dd($output);
    return $output;
}



public static function showAdminLogs($logrecords)
{
    $output = '';

    // If using Eloquent or pagination, convert to collection or array
    $records = is_array($logrecords) ? collect($logrecords) : $logrecords;

    if ($records->isNotEmpty()) {
        foreach ($records as $record) {

            // Access properties safely (works for arrays or objects)
            $createdDate = isset($record->created_at) ? $record->created_at : '0000-00-00';

            // Format date
            $formatDate = MFormatDate::formatingDate($createdDate);

            $output .= '<tr>
                <td>' . ($record->admin_log_id ?? '') . '</td>
                <td>' . ($record->admin_log ?? '') . '</td>
                <td>' . ($record->admin_log_ip_used ?? '') . '</td>
                <td>' . ($record->admin_username ?? '') . '</td>
                <td>' . $formatDate . '</td>
            </tr>';
        }
    }
    // dd($output);
    return $output;
}
}
