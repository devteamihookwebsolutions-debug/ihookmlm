<?php
/**
 * This class contains public static functions related to user card details
 *
 * @package         DCardDetails
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

namespace Display\Network;

use Query\Bin_Query;
use Model\Packages\MPackageIcon;
use Model\Middleware\MFormatNumber;
use Model\Middleware\MAmazonCloudFront;

class DCardDetails
{
    /**
     * This public static function is used to show  network details of member
     * @param array  $records
     *
     * @return HTML data
     */
    public static function showActiveSubscription($records)
    {
        $matrix_id = $_GET['sub1'];
        $user_id   = $_SESSION['default']['customer_id'];
        if (count((array)$records) > 0) {
            $output .= ' <div class="m-pricing-table-1__items row" id="showpackageviewww">';
            for ($i = 0; $i < count((array)$records); $i++) {
                $net_amount = $records[$i]['package_price'] * $_SESSION['matrix']['currency_conversion_rate'];
                $net_amount = MFormatNumber::formatingNumberCurrency($net_amount);

                $package_image = trim($records[$i]['package_icon']);

                if ($package_image != '') {
                    $package_image = MAmazonCloudFront::getCloudFrontUrl($package_image);
                } else {
                    $package_image = $_ENV['UI_ASSET_URL'].'/assets/img/'.$site_loader_logo;
                }

                $output .= '<div class="m-pricing-table-1__item col-lg-4 col-md-6">
                <div class="m-pricing-table-1__visual">
                    <span class="m-pricing-table-1__icon m--font-brand">
                        <img src="' . $package_image . '" alt="" class="w-2/3 mx-auto">
                    </span>
                </div>
                <span class="m-pricing-table-1__price text-lg font-semibold text-black">' . $records[$i]['package_name'] . '</span>
                <h2 class="m-pricing-table-1__subtitle text-xl font-bold text-black dark:text-white">
                    ' . $_SESSION['matrix']['temp_site_currency'] . ' ' . $net_amount . '
                </h2>
                <h4 class="mt-2"></h4>
                <div class="m-pricing-table-1__btn mt-4">
                    <button aria-label="button" class="btn btn-outline-primary bg-neutral-500 text-white hover:bg-neutral-600 border border-blue-500 py-2 px-4 rounded-md" type="button"
                        onclick="purchasePackage(' . $records[$i]['package_id'] . ');">Cancel Subscription
                    </button>
                </div>
            </div>';

            }
        }
        return $output;
    }
    public static function showAllCards($records)
    {
        $allcards[0] = $records;
        $output = "";
        if (count((array)$records) > 0) {
            for ($i = 0; $i < count((array)$allcards); $i++) {
                $output .= "<tr>
					<td>" . ++$i . "</td>
					<td>" .$allcards[0]['last4']. "</td>
					<td>" .$allcards[0]['brand']. "</td>
					<td>" .$allcards[0]['exp_month']. "</td>
					<td>" .$allcards[0]['exp_year']. "</td>
					<td>" .$allcards[0]['fingerprint']. "</td>
					<td><a href='addstripecard/add'  data-cardid='".$allcards[0]['card']."'><svg class='w-6 h-6 text-black dark:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' viewBox='0 0 24 24'>
                    <path fill-rule='evenodd' d='M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z' clip-rule='evenodd'/>
                    <path fill-rule='evenodd' d='M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z' clip-rule='evenodd'/>
                    </svg>
                    <svg class='w-6 h-6 text-black dark:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' viewBox='0 0 24 24'>
                    <path fill-rule='evenodd' d='M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z' clip-rule='evenodd'/>
                    </svg></a></td>
					</tr>";
            }
        } else {
            $output .= "";
        }

        return $output;
    }
}
?>