<?php
/**
 * This class contains public static functions related to premier e learning
 *
 * @package         DPremiumCoursePayment
 * @category        Display
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?>
<?php

namespace Admin\App\Display\PremiumLearning;

use Admin\App\Models\Middleware\MFormatDate;
use Admin\App\Models\Middleware\MMemberDetails;
use Admin\App\Models\Middleware\MPaymentGatewayDetails;
use Admin\App\Models\PremiumLearning\MPremiumCourses;


class DPremiumCoursePayment
{

public static function showCoursePayment($records)
{
    $output = '';
    $j = 1; // Serial number starts from 1

    foreach ($records as $record) {
        $course_id = $record->course_id; // Use object notation
        $course_name = MPremiumCourses::getCourses($course_id, 'title');
        $members_id = $record->paymenthistory_member_id;
        $userdetails = MMemberDetails::getUserDetails($members_id);

        // Action buttons based on status
        if ($record->paymenthistory_status == 'paid') {
            $action = '<div class=""><a aria-label="link" title="'.__('Click to cancel').'" onclick="cancelelerningSettings('.$course_id.','.$members_id.');" href="javascript:void(0);" ><svg ...></svg></a></div>';
        } elseif ($record->paymenthistory_status == 'notpaid') {
            $action = '<a aria-label="link" title="' . __('Click to pay') . '" onclick="changeelearningSettings('.$course_id.','.$members_id.');" href="javascript:void(0);"><svg ...></svg></a></div>&nbsp;<div class=""><a aria-label="link" title="'.__('Click to cancel').'" onclick="cancelelerningSettings('.$course_id.','.$members_id.');" href="javascript:void(0);" ><svg ...></svg></a></div>';
        } else {
            $action = ''; // fallback
        }

        $where = 'WHERE paymentsettings_id="' . $record->paymenthistory_mode . '" ';
        $paymentdetails = MPaymentGatewayDetails::getPaymentGatewayDetails($where);
        $payment_mode = $paymentdetails['paymentsettings_name'] ?? 'Unknown';

        $payment_status = ($record->paymenthistory_status == 'notpaid')
            ? '<span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300">notpaid</span>'
            : '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">paid</span>';

        $output .= '<tr>
                      <td>'.$j.'</td>
                      <td>'.$userdetails['members_username'].'</td>
                      <td>'.$course_name.'</td>
                      <td>'.$record->paymenthistory_amount.'</td>
                      <td>'.$payment_mode.'</td>
                      <td>'.$payment_status.'</td>
                      <td>'.MFormatDate::formatingDate($record->paymenthistory_date).'</td>
                      <td class="flex mx-2">'.$action.'</td>
                    </tr>';

        $j++;
    }

    return $output;
}
}
?>
