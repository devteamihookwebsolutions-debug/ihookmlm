<?php
/**
 * This class contains public static functions related to user network
 *
 * @package         DActiveNetwork
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

namespace User\App\Display\Network;

use Admin\App\Models\Middleware\MMemberDetails;
use Admin\App\Models\Middleware\MURLCrypt;
use Display\Network\DSocialShare;

use Query\Bin_Query;

class DActiveNetwork
{

    public static function getActiveNetworkDetails($records)
    {

        $user_id           = $_SESSION['default']['customer_id'];
        $members_subdomain = MMemberDetails::getPartMembersDetails('members_subdomain', $user_id);
        $members_subdomain = $members_subdomain['members_subdomain'];
        $sql               = "SELECT * FROM  " . $_ENV['IHOOK_PREFIX'] . "sitesettings_table WHERE sitesettings_name ='site_url'";
        $obj               = new Bin_Query();
        $obj->executeQuery($sql);
        $site_settings = $obj->records[0]['sitesettings_value'];
        $pageurl       = $site_settings;
        if (count((array) $records) > 0) {
            for ($i = 0; $i < count((array) $records); $i++) {
                $status                      = '';
                $matrix_id                   = $records[$i]['matrix_id'];
                $members_id                  = $records[$i]['members_id'];
                $members_account_status      = $records[$i]['members_account_status'];
                $members_subscription_plan   = $records[$i]['members_subscription_plan'];
                $current_package_id          = $records[$i]['members_subscription_plan'];
                $members_subscription_status = $records[$i]['members_subscription_status'];
                $default_sponsor             = $records[$i]['default_sponsor'];
                $stripe_cusid                = $records[$i]['stripe_cusid'];
                $stripe_subid                = $records[$i]['stripe_subid'];
                $chargebee_subid             = $records[$i]['chargebee_subid'];
                $link_id                     = $records[$i]['link_id'];
                $authorize_subid             = $records[$i]['authorize_subid'];
                $authorize_cusid             = $records[$i]['authorize_cusid'];

                $where = 'WHERE paymenthistory_member_id="' . $members_id . '" AND
                      (paymenthistory_type="upgrade" OR paymenthistory_type="subscription")
                       AND matrix_id="' . $matrix_id . '" ORDER BY paymenthistory_id DESC';
                $paymentdetails        = MUserDetailsPlan::getPaymentHistoryDetails($where);
                $paymenthistory_id     = $paymentdetails['paymenthistory_id'];
                $paymenthistory_mode   = $paymentdetails['paymenthistory_mode'];
                $paymenthistory_status = $paymentdetails['paymenthistory_status'];
                $cancelled_sub_id      = "";
                if (count((array) $paymentdetails) > 0) {
                    if ($paymenthistory_status == '0' || $paymenthistory_status == '') {
                        $status = '<span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300">' . __('Free') . '</span>';
                    }
                    if ($paymenthistory_status == 'notpaid') {
                        $status = '
                       <span class="bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-yellow-900 dark:text-yellow-300">' . __('Awaiting for admin approval') . '</span>';
                    }
                    if ($paymenthistory_status == 'paid') {
                        $status = '<span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">' . __('Paid') . '</span>';
                    }
                } else {
                    if ($default_sponsor > 0) {
                        $status = '<span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">' . __('Paid') . '</span>';
                    } else {
                        $status = '<span class="bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-yellow-900 dark:text-yellow-300">' . __('New') . '</span>';
                    }
                }
                $matrix_config = MMatrixConfiguration::getMatrixConfigurationDetails($matrix_id, 'members_account_type');
                if ($matrix_config[0]['matrix_value'] == '1') {
                    $membership_type = __('Free');
                } elseif ($matrix_config[0]['matrix_value'] == '2') {
                    $matrix_config = MMatrixConfiguration::getMatrixConfigurationDetails($matrix_id, 'members_paid_account_type');
                    if ($matrix_config[0]['matrix_value'] == '1') {
                        $membership_type = '' . __('Subscription') . '';
                    } else {
                        $membership_type = '' . __('One time registration') . '';
                    }
                } elseif ($matrix_config[0]['matrix_value'] == '3') {
                    $membership_type = '' . __('Free and upgrade') . '';
                }
                if ($members_subscription_plan > 0) {
                    $members_subscription_plan_details = MPackageDetails::getPackageDetails($members_subscription_plan);

                    $members_subscription_plan_name    = $members_subscription_plan_details['package_name'];
                    $package_price                     = $members_subscription_plan_details['package_price'];
                } else {
                    $members_subscription_plan_name = '-';
                }
                $doj             = MFormatDate::formatingDate($records[$i]['matrix_doj']);
                $sponsor         = MMemberDetails::getPartMembersDetails('members_username', $records[$i]['direct_id']);
                $matrixdetails   = MMatrixDetails::getMatrixDetails($matrix_id);
                $matrix_type_id  = $matrixdetails['matrix_type_id'];
                $matrix_name     = $matrixdetails['matrix_name'];
                $where           = 'WHERE matrix_type_id="' . $matrix_type_id . '" ';
                $sql_matrix_type = "SELECT matrix_type_name FROM  " . $_ENV['IHOOK_PREFIX'] . "matrix_type_table " . $where . "";
                $obj_matrix_type = new Bin_Query();
                $obj_matrix_type->executeQuery($sql_matrix_type);
                $matrix_type_name            = $obj_matrix_type->records[0]['matrix_type_name'];
                $matrix_description          = substr($records[$i]['matrix_description'], 0, 100);
                $parentid                    = $records[$i]['spillover_id'];
                $parentname                  = MMemberDetails::getPartMembersDetails('members_username', $parentid);
                $parentname                  = $parentname['members_username'];
                $parentname                  = $parentname == '' ? '-' : $parentname;
                $sponsor['members_username'] = $sponsor['members_username'] == '' ? '-' : $sponsor['members_username'];
                $where                       = 'members_passup_direct_id="' . $members_id . '" AND matrix_id="' . $matrix_id . '" AND members_account_status!="-1" AND root>0';
                $sql                         = "SELECT count(*) as total FROM " . $_ENV['IHOOK_PREFIX'] . "matrix_members_link_table WHERE " . $where . " ";
                $obj                         = new Bin_Query();
                $obj->executeQuery($sql);
                $referralscount = $obj->records[0]['total'];
                //for unilevel
                //get rank
                $where    = 'WHERE rank_id="' . $records[$i]['rankid'] . '"';
                $rankname = MRankDetails::getRankDetails($where);
                if (count((array) $rankname) > 0) {
                    $rankname = $rankname[0]['rank_value'];
                } else {
                    $rankname = '' . __('NA') . '';
                }
                $firebasestatus = $_SESSION['site_settings']['firebasestatus'];
                if ($firebasestatus == '1') {
                    $dynamicurl = $records[$i]['dynamic_url'];
                }
                //check matrix registration is alowed for user
                $matrixuserallow = MMatrixConfiguration::getMatrixConfigurationDetails($matrix_id, 'registration');
                $matrixuserallow = $matrixuserallow[0]['matrix_value'];

                $cus_id = $stripe_cusid;
                $sub_id = $stripe_subid;


                if ($_SESSION['site_settings']['subdomain_enble'] != '1') {
                    $siteurlparsed      = $pageurl . '/';
                    $refelinkencode     = 'ref' . $members_id . '-' . $matrix_id;
                    $refelinkencode     = urlencode(base64_encode($refelinkencode));
                    $socialsharelink    = $siteurlparsed . '' . $refelinkencode;
                    $description_strip  = html_entity_decode($socialsharelink);
                    $encode_description = urlencode($description_strip);
                    $socailurl          = urlencode($_SERVER['SERVER_NAME']);
                    $socialdynamicshare = DSocialShare::getSocialShare($encode_description, $socailurl);

                } elseif ($_SESSION['site_settings']['subdomain_enble'] == '1') {
                    $refelinkencode     = 'ref' . $members_id . '-' . $matrix_id;
                    $refelinkencode     = urlencode(base64_encode($refelinkencode));
                    $socialsharelink    = $members_subdomain . '/' . $refelinkencode;
                    $description_strip  = html_entity_decode($socialsharelink);
                    $encode_description = urlencode($description_strip);
                    $socailurl          = urlencode($_SERVER['SERVER_NAME']);
                    $socialdynamicshare = DSocialShare::getSocialShare($encode_description, $socailurl);

                }

                $output .= ' <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 p-6 rounded-lg" bis_skin_checked="1"
                style="">
                <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-6" bis_skin_checked="1">
                    <div bis_skin_checked="1" class="mt-4">
                        <img src="'.$_ENV['UI_ASSET_URL'].'/public/assets/img/plan.png"
                            alt="Plan Image" class="w-full">
                    </div>
                    <div class="col-span-2" bis_skin_checked="1">
                        <div class="datatable-wrapper datatable-loading no-footer sortable fixed-columns shadow-xl"
                            bis_skin_checked="1">
                            <div class="datatable-top" bis_skin_checked="1"></div>
                            <div class="datatable-container" bis_skin_checked="1">
                                <table id="default-table" class="datatable-table border">
                                    <tbody>
                                        <tr class="border-b dark:border-neutral-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-black dark:text-white">
                                               ' . __('Plan') . '</th>
                                            <td class="px-6 py-4 dark:text-neutral-100">' . $matrix_type_name . '

                                            </td>
                                        </tr>
                                        <tr class="border-b dark:border-neutral-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-black dark:text-white">
                                                ' . __('Membership') . '' . __('Type') . '
                                            </th>
                                            <td class="px-6 py-4 dark:text-neutral-100">' . $membership_type . '</td>
                                        </tr>
                                        <tr class="border-b dark:border-neutral-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-black dark:text-white">
                                              ' . __('Membership') . '' . __('Status') . '</th>
                                            <td class="px-6 py-4 dark:text-neutral-100">
                                                <span
                                                    class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">' . $status . '</span>
                                            </td>

                                        </tr>';

                if ($members_subscription_plan > 0) {

                    $output .= ' <tr class="border-b dark:border-neutral-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-black dark:text-white">
                                                ' . __('Package') . '</th>
                                            <td class="px-6 py-4 dark:text-neutral-100">' . $members_subscription_plan_name . ' ' . $cancelsubscription . '</td>
                                            </tr>
                                            <tr class="border-b dark:border-neutral-700">
                                                <th scope="row" class="px-6 py-4 font-medium text-black dark:text-white">
                                                    ' . __('Expired Date') . '</th>
                                                <td class="px-6 py-4 dark:text-neutral-100">' . MFormatDate::formatingDate($records[$i]['members_subscription_expirydate']) . '</td>
                                            </tr>' . $stripe_extra_display;

                }
                // $output.=' <tr class="border-b dark:border-neutral-700">
                //     <th scope="row" class="px-6 py-4 font-medium text-black dark:text-white">
                //         Members Account
                //         login status</th>
                //     <td class="px-6 py-4 dark:text-neutral-100">
                //         <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300
                //                     ">Waiting list</span>
                //     </td>
                // </tr>';

                $output .= ' <tr class="border-b dark:border-neutral-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-black dark:text-white">
                                                ' . __('Sponsor') . '</th>
                                            <td class="px-6 py-4 dark:text-neutral-100">' . $sponsor['members_username'] . '</td>
                                        </tr>
                                        <tr class="border-b dark:border-neutral-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-black dark:text-white">
                                                ' . __('Enroller') . '</th>
                                            <td class="px-6 py-4 dark:text-neutral-100">' . $parentname . '</td>
                                        </tr>
                                        <tr class="border-b dark:border-neutral-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-black dark:text-white">
                                               ' . __('Direct') . '' . __('Referrals') . '
                                            </th>
                                            <td class="px-6 py-4 dark:text-neutral-100"><a aria-label="link" href="' . 'admin' . '/network/level/' . $matrix_id . '/1">' . $referralscount . '</a></td>
                                        </tr>
                                        <tr class="border-b dark:border-neutral-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-black dark:text-white">
                                               ' . __('Date of Join') . '
                                            </th>
                                            <td class="px-6 py-4 dark:text-neutral-100">' . $doj . '</td>
                                        </tr>
                                        <tr class="border-b dark:border-neutral-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-black dark:text-white">
                                               ' . __('Current') . '' . __('Rank') . '
                                            </th>
                                            <td class="px-6 py-4 dark:text-neutral-100"> ' . $rankname . '</td>
                                        </tr>
                                        ' . $showunilevels . '

                                    </tbody>

                                </table>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="border border-yellow-500 rounded-2xl p-6 shadow-2xl text-center lg:col-span-1 mt-4"
                    bis_skin_checked="1">
                    <div class="mt-3 gap-2 border p-5 border-neutral-600 rounded-md" bis_skin_checked="1">
                        <p class="text-sm text-black dark:text-white">Referral Link :</p>
                        <div class="overflow-hidden text-ellipsis w-48 mx-auto" bis_skin_checked="1">
                            <a aria-label="link" href="' . $siteurlparsed . '' . $refelinkencode . '"
                                target="_blank" rel="noopener" class="text-sm text-blue-800 block break-all">
                                ' . $siteurlparsed . '' . $refelinkencode . '
                            </a>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-4" bis_skin_checked="1">
                        <button onclick="showMatrixMoreInformation(' . $records[$i]['matrix_id'] . ');"
                            class="text-white bg-neutral-800 bg-neutral-900 hover:bg-neutral-900 focus:outline-none focus:ring-4 focus:ring-neutral-300 font-medium rounded-lg text-sm px-5 py-2.5">
                           ' . __('More Info') . '
                        </button>
                    </div>
                    <div class="border-b border-neutral-300 my-5" bis_skin_checked="1"></div><div class="text-center col-span-3 mt-10" bis_skin_checked="1">';

                // <img src="'.$_ENV['UI_ASSET_URL'].'/public/assets/img/upgrade.png" alt="Upgrade" class="mx-auto w-60 mb-3">

                $sqlpack = 'SELECT count(*) as total FROM ' . $_ENV['IHOOK_PREFIX'] . 'package_table WHERE matrix_id="' . $matrix_id . '"';
                $objpack = new Bin_Query();
                $objpack->executeQuery($sqlpack);
                $recordsusedpackage = $objpack->records[0]['total'];
                if ($cus_id != "" && $sub_id != "") {

                    $output .= '<button onclick="subscriptionreminder(1)"
                            class="text-white brand-color font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            ' . __('Upgrade') . '
                        </button>';
                } elseif ($chargebee_subid != "") {

                    $output .= '<button onclick="subscriptionreminder(2)"
                        class="text-white brand-color font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        ' . __('Upgrade') . '
                    </button>';

                } elseif ($authorize_subid != "" && $authorize_cusid != "") {

                    $output .= '<button onclick="subscriptionreminder(3,' . $matrix_id . ',' . $current_package_id . ')"
                        class="text-white brand-color font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        ' . __('Upgrade') . ' </button>';
                } else {
                    if ($recordsusedpackage > 0) {

                        $output .= '<button onclick="upgardeMatrixSubcription(' . $matrix_id . ',' . $members_subscription_status . ',' . $current_package_id . ')"
                        class="text-white brand-color font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        ' . __('Upgrade') . ' </button>';
                    } elseif ($members_subscription_plan != '' && $members_subscription_status == '2') {

                        $output .= '<button onclick="upgardeMatrixSubcription(' . $matrix_id . ',' . $members_subscription_status . ',' . $current_package_id . ')"
                        class="text-white brand-color font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        ' . __('Upgrade') . ' </button>';
                    }
                }

                $output .= '</div></div>
            </div>';

            }
        }

        return $output;
    }


    public static function getAllGenealogyList($members_id, $matrix_id)
    {
        $encrypted = MURLCrypt::encode($members_id, $matrix_id);

        $output = '<button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
                    class="inline-flex items-center text-white bg-neutral-800 hover:bg-neutral-900 focus:outline-none focus:ring-4 focus:ring-neutral-300 font-medium rounded-lg text-sm px-5 py-2.5 me-3 dark:bg-neutral-900 dark:hover:bg-neutral-700 dark:focus:ring-neutral-700 dark:border-neutral-700" type="button">
                    Genealogy Tree
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>

                <div id="dropdown" class="z-10 hidden bg-white divide-y divide-neutral-100 rounded-lg shadow w-44 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">
                    <ul class="py-2 text-sm text-black dark:text-neutral-200" aria-labelledby="dropdownDefaultButton">
                        <li><a href="' . route('user.genealogy.viewtree', ['encrypted' => $encrypted]) . '" class="block px-4 py-2 hover:bg-neutral-100 dark:hover:bg-neutral-600">Genealogy Tree</a></li>
                        <li><a href="' . route('user.genealogy.tabularview', ['encrypted' => $encrypted]) . '" class="block px-4 py-2 hover:bg-neutral-100 dark:hover:bg-neutral-600">Tabular Genealogy</a></li>
                        <li><a href="' . route('user.grpgenealogy.viewtree', ['encrypted' => $encrypted]) . '" class="block px-4 py-2 hover:bg-neutral-100 dark:hover:bg-neutral-600">Graphical Genealogy</a></li>
                        <li><a href="' . route('user.countgenealogy.viewtree', ['encrypted' => $encrypted]) . '" class="block px-4 py-2 hover:bg-neutral-100 dark:hover:bg-neutral-600">Downline Count Genealogy</a></li>
                        <li><a href="' . route('user.rankgenealogy.viewtree', ['encrypted' => $encrypted]) . '" class="block px-4 py-2 hover:bg-neutral-100 dark:hover:bg-neutral-600">Rank Genealogy</a></li>
                        <li><a href="' . route('user.collapsegenealogy.viewtree', ['encrypted' => $encrypted]) . '" class="block px-4 py-2 hover:bg-neutral-100 dark:hover:bg-neutral-600">Collapse Genealogy</a></li>
                    </ul>
                </div>';

        return $output;
    }

    public static function getAllGenealogy($members_id, $matrix_id)
    {
        $encrypted = MURLCrypt::encode($members_id, $matrix_id);

        $output = '
            <li><a href="' . route('user.genealogy.viewtree', ['encrypted' => $encrypted]) . '" class="block px-4 py-2 hover:bg-neutral-100 dark:hover:bg-neutral-600">Genealogy Tree</a></li>
            <li><a href="' . route('user.genealogy.tabularview', ['encrypted' => $encrypted]) . '" class="block px-4 py-2 hover:bg-neutral-100 dark:hover:bg-neutral-600">Tabular Genealogy</a></li>
            <li><a href="' . route('user.grpgenealogy.viewtree', ['encrypted' => $encrypted]) . '" class="block px-4 py-2 hover:bg-neutral-100 dark:hover:bg-neutral-600">Graphical Genealogy</a></li>
            <li><a href="' . route('user.countgenealogy.viewtree', ['encrypted' => $encrypted]) . '" class="block px-4 py-2 hover:bg-neutral-100 dark:hover:bg-neutral-600">Downline Count Genealogy</a></li>
            <li><a href="' . route('user.rankgenealogy.viewtree', ['encrypted' => $encrypted]) . '" class="block px-4 py-2 hover:bg-neutral-100 dark:hover:bg-neutral-600">Rank Genealogy</a></li>
            <li><a href="' . route('user.collapsegenealogy.viewtree', ['encrypted' => $encrypted]) . '" class="block px-4 py-2 hover:bg-neutral-100 dark:hover:bg-neutral-600">Collapse Genealogy</a></li>
        ';

        return $output;
    }

 public static function getActiveNetworkList($records)
{
    if (!is_array($records) || empty($records)) {
        return '';
    }

    $currentMatrixId = request('sub1');
    $isReferralView  = request('do') === 'referrallinks';

    $output = '';

    foreach ($records as $record) {
        if (!is_array($record) || empty($record['matrix_id'])) {
            continue;
        }

        $matrix_id  = trim($record['matrix_id']);
        $members_id = trim($record['members_id'] ?? '');
        $matrix_name = $record['matrix_name'] ?? 'Unknown Matrix';

        $selected = ($currentMatrixId == $matrix_id && $isReferralView) ? 'selected' : '';

        $output .= '<option value="' . $matrix_id . '" ' . $selected . '>'
                 . htmlspecialchars($matrix_name, ENT_QUOTES, 'UTF-8')
                 . '</option>';
    }

    return $output;
}
}
