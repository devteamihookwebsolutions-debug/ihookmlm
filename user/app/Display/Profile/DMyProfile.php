<?php
/**
 * This class contains public static functions related to myaccount
 *
 * @package         DMyProfile
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

namespace Display\Profile;

use Model\Middleware\MFormatNumber;
use Model\Middleware\MSiteDetails;
use Query\Bin_Query;

class DMyProfile
{/**
 * This public static function is used to showHeaderMessageNotification
 * @param array  $unseenmemberscount
 * @param array  $records
 * @return HTML data
 */
    public static function showActivityLogs($records)
    {
        if (count((array) $records) > 0) {
            $output = '';
            foreach ($records as $key => $value) {

                $outout .= '<tr>
                    <td class="px-6 py-4 dark:text-neutral-100">
                       <div class="flex items-center">
                       <div class="flex items-center justify-center w-10 h-10 rounded-full bg-green-500 text-white font-bold text-lg">
                            '.$value['members_firstname'][0].' '.$value['members_lastname'][0].'
                        </div>                        
                    </div>
                    </td>
                    <td class="px-6 py-4 dark:text-neutral-100">
                        <a href="#" class="font-weight-bolder text-hover-primary mb-1 table_section_title">' . $value['log'] . '</a>
                        <div>
                            <span class="font-weight-bolder"></span>
                            <a class="text-muted font-weight-bold text-hover-primary" href="#"></a>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="text-sm font-bold dark:text-white">' . $value['members_log_ip_used'] . '</span><br>
                        <span class="text-muted text-xs">IP Address</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="px-3 py-1 text-xs font-medium text-white bg-yellow-500 rounded-full">' . ucwords($value['doname']) . '</span>

                    </td>

                </tr>';
            }

        }

        return $outout;
    }


    public static function showUserNewNotification($records)
    {

        if (count((array) $records) > 0) {
            $output = '';
            foreach ($records as $key => $value) {
                $subject   = $value['subject'];
                $content   = $value['content'];
                $mesg_from = ($value['message_from_id'] == 0) ? __('Admin Message') : __('User Message');
                $output .= '<div class="m-widget5__item">
                        <div class="m-widget5__content">

                            <div class="m-widget5__section">
                                <h4 class="m-widget5__title">
                                  ' . $subject . '
                                </h4>
                                <span class="m-widget5__desc">
                                     ' . $content . '
                                </span>
                            </div>
                        </div>
                        <div class="m-widget5__content">
                            <div class="m-widget5__stats1">
                               <span class="label label-lg label-light-primary label-inline">' . $mesg_from . '</span>
                            </div>
                        </div>
                    </div>';
            }

        } else {

            $output = '<div class="font-semibold dark:text-white text-base">
                ' . __('No New Notifications') . '
              </div>';

        }
        return $output;
    }

    public static function showDownlineSales($records)
    {
        if (count((array) $records) > 0) {
            $output = '';

            $whereul                 = "WHERE sitesettings_name='user_profile_icon_based' ";
            $sitesettingsul          = MSiteDetails::getSiteSettingsDetails($whereul);
            $user_profile_icon_based = $sitesettingsul[0]['sitesettings_value'];

            foreach ($records as $key => $value) {
                $member_id = $value['members_id'];
                $matrix_id = $value['matrix_id'];

                $sql   = "SELECT sum(paymenthistory_amount) as total FROM " . $_ENV['PROMLM_PREFIX'] . "paymenthistory_table where paymenthistory_member_id='" . $member_id . "'";
                $query = new Bin_Query();
                $query->executeQuery($sql);
                $total         = $query->records[0]['total'];
                $members_image = $_ENV['CDNCLOUDEXTURL'] . '/' . $value['members_image'];
                if ($value['members_image'] == 'uploads/members/avatar.png') {
                    if ($user_profile_icon_based == '1') { // First and Last Name
                        $imagespro = strtoupper($value['members_firstname'][0]) . strtoupper($value['members_lastname'][0]);
                    } elseif ($user_profile_icon_based == '2') { // Username
                        $imagespro = strtoupper($value['members_username'][0]);
                    } elseif ($user_profile_icon_based == '3') { // Email
                        $imagespro = strtoupper($value['members_email'][0]);
                    }

                    $images = '
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-green-500 text-white font-bold text-lg">
                        ' . $imagespro . '
                    </div>';
                } else {
                    $members_image = $_ENV['CDNCLOUDEXTURL'] . '/' . $value['members_image'];
                    $images        = '<img class="w-10 h-10 rounded-full shadow-md" src="' . $members_image . '" alt="Profile Image">';
                }

                $output .= ' <div class="flex justify-between align-center border-b pb-2 pt-2">
    <div class="left-content flex items-center">
        <div class="w-10 h-10 rounded-full mr-3">
           ' . $images . '
        </div>
        <div class="member-info">
            <h4 class="text-base font-semibold leading-none text-black dark:text-white">
              ' . $value['members_username'] . '
            </h4>
            <span class="mb-3 text-sm font-normal dark:text-white">
                 ' . $value['members_email'] . '
            </span>
        </div>
    </div>
    <div class="right-content">
        <div class="member-details text-right">
            <span class="font-semibold text-base dark:text-white">' . $_SESSION['site_settings']['site_currency'] . ' ' . MFormatNumber::formatingNumberCurrency($total) . '</span><br>
            <span class="font-normal text-xs dark:text-white">' . __('Sales') . '</span>
        </div>
    </div>
</div>';
            }
        } else {

            $output = '<div class="m-widget5__item">' . __('No Downlines') . '</div>';
        }
        return $output;
    }

    public static function getLanguage($records, $members_lang)
    {
        if (count((array) $records) > 0) {
            $output .= '<select class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light" aria-label="label" id="members_lang" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500" name="members_lang" required>';

            for ($i = 0; $i < count((array) $records); $i++) {
                if ($members_lang == $records[$i]['lang_id']) {
                    $selected = 'selected=selected';
                } else {
                    $selected = '';
                }
                $output .= '<option value="' . $records[$i]['lang_id'] . '" ' . $selected . '>' . $records[$i]['lang_name'] . '</option>';
            }
            $output .= '</select>';
        }
        return $output;
    }

    public static function getTimezone($records, $members_timezone)
    {

        $output = '<select class="form-control m-input m-input--solid" name="members_timezone">';
        $output .= ' <option value="">Select</option>';
        foreach ($records as $key => $value) {

            if ($members_timezone == $key) {
                $selected = 'selected=selected';
            } else {
                $selected = '';
            }

            $output .= ' <option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
        }

        $output .= '</select>';
        return $output;
    }

}
