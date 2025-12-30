<?php
/**
 * This class contains public static functions related to e-pin
 *
 * @package         DEpinHistory
 * @category        Display
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2023, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php

namespace User\App\Display\Epin;

use Admin\App\Helpers\CurrencyHelper;
use Admin\App\Models\Middleware\MFormatDate;
use Admin\App\Models\Middleware\MMatrixDetails;
use Admin\App\Models\Middleware\MMemberDetails;
use DB;

class DEpinHistory
{

    public static function epinRecordsUnused($epinrecords, $iTotal)
    {
        $output = "";
        $prefix = env('IHOOK_PREFIX');
        $serialNo = 1;

        foreach ($epinrecords as $row) {

            $package_name = 'Unknown Package';

            if ($row->epin_package == '0' || $row->epin_package == null) {
                // Matrix registration
                $matrixdetails = MMatrixDetails::getMatrixDetails($row->epin_matrix_id);

                if ($matrixdetails && isset($matrixdetails['matrix_name'])) {
                    $package_name = $matrixdetails['matrix_name'] . ' Registration';
                } else {
                    $package_name = 'Matrix Registration (Invalid Matrix)';
                }
            }
            elseif ($row->epin_package == '100000000000001') {
                $package_name = 'E-Wallet Topup';
            }
            else {
                // Package-based epin
                $pkg = DB::table("{$prefix}_package_table")
                        ->where('package_id', $row->epin_package)
                        ->first();

                if ($pkg && $pkg->package_name) {
                    $package_name = $pkg->package_name;
                }
                // else keep 'Unknown Package'
            }

            $formatdate = MFormatDate::formatingDate($row->epin_date);

            $output .= "<tr>
                <td>{$serialNo}</td>
                <td>{$row->epin_code}</td>
                <td>" . CurrencyHelper::format($row->epin_amount) . "</td>
                <td>{$package_name}</td>
                <td data-date='{$formatdate}'>{$formatdate}</td>
            </tr>";

            $serialNo++;
        }

        return $output;
    }

public static function epinRecordsUsed($epinrecords, $iTotal)
{
    $output = "";
    $prefix = env('IHOOK_PREFIX');
    $serialNo = 1;

    foreach ($epinrecords as $row) {

        $package_name = 'Unknown Package';

        // Handle matrix registration type
        if ($row->epin_package == '0' || $row->epin_package == null) {
            $matrixdetails = MMatrixDetails::getMatrixDetails($row->epin_matrix_id);

            if ($matrixdetails && isset($matrixdetails['matrix_name'])) {
                $package_name = $matrixdetails['matrix_name'] . ' Registration';
            } else {
                $package_name = 'Matrix Registration (Invalid Matrix)';
            }
        }
        // Handle E-Wallet topup
        elseif ($row->epin_package == '100000000000001') {
            $package_name = 'E-Wallet Topup';
        }
        // Handle normal package
        else {
            $pkg = DB::table("{$prefix}_package_table")
                    ->where('package_id', $row->epin_package)
                    ->first();

            if ($pkg && !empty($pkg->package_name)) {
                $package_name = $pkg->package_name;
            }
        }

        // Safely get user details
        $userdetails = MMemberDetails::getUserDetails($row->epin_user_id);
        $used_by_username = 'Unknown User';

        if ($userdetails && is_array($userdetails) && isset($userdetails['members_username'])) {
            $used_by_username = $userdetails['members_username'];
        } elseif ($userdetails && is_object($userdetails) && !empty($userdetails->members_username)) {
            $used_by_username = $userdetails->members_username;
        }

        // Format dates safely
        $formatdate  = MFormatDate::formatingDate($row->epin_date);
        $formatudate = $row->epin_used_date
            ? MFormatDate::formatingDate($row->epin_used_date)
            : 'Not Available';

        $output .= "<tr>
            <td>{$serialNo}</td>
            <td>{$row->epin_code}</td>
            <td>" . CurrencyHelper::format($row->epin_amount) . "</td>
            <td>{$package_name}</td>
            <td>{$used_by_username}</td>
            <td data-date='{$formatdate}'>{$formatdate}</td>
            <td data-date='{$formatudate}'>{$formatudate}</td>
        </tr>";

        $serialNo++;
    }

    return $output;
}

}
