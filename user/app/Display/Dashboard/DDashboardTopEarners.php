<?php
/**
 * This class contains public static functions related to dashboard top selling
 *
 * @package         DDashBoard
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

namespace Display\Dashboard;

use Query\Bin_Query;
use Model\Middleware\MAmazonCloudFront;
use Model\Middleware\MFormatNumber;

class DDashboardTopEarners
{
    /**
     * This public static function is used  to show the dashboard top selling products
     * @param array $records;
     * @return HTML data
     */
    public static function getTopEarners($records)
    {


        if (count((array)$records) > 0) {

            for ($t = 0; $t < count((array)$records); $t++) {

                $imgemenm = $_ENV['CDNCLOUDEXTURL'].$records[$t]['members_image'];

                $output .= '<div class="earn-top">
                                            <div class="earner">  
                                                <img src="' . $imgemenm . '" width="100px" class="top-earner">                                   
                                                <div class="earner-name">
                                                       <span>' .__('Name') . '</span>
                                                        <h5 class="pt-3">' .$records[$t]['members_username'] . '</h5>
                                                </div>
                                                <div class="earner-price">
                                                      <span>' .__('Price') . '</span>
                                                    <h5 class="pt-3">' .MFormatNumber::formatingNumberCurrency($records[$t]['totalprice']). '</h5>
                                                </div>
                                            </div>                                  
                                        </div>';
            }

        } else {
            $output .= '
            <div class="earn-top">
                                            <div class="earner">  
                                                <img src="' .$_ENV['UI_ASSET_URL']. "/assets/img/Avatar.png" . '" width="100px" class="top-earner">                                   
                                                <div class="earner-name">
                                                       <span>' .__('Name') . '</span>
                                                        <h5 class="pt-3">maxwin</h5>
                                                </div>
                                                <div class="earner-price">
                                                      <span>' .__('Price') . '</span>
                                                    <h5 class="pt-3">' .$_SESSION['site_settings']['site_currency']. '1960.00</h5>
                                                </div>
                                        </div>
                                      </div>
                                      <div class="earn-top">
                                            <div class="earner">  
                                                <img src="' .$_ENV['UI_ASSET_URL']. "/assets/img/Avatar.png" . '" width="100px" class="top-earner">                                   
                                                <div class="earner-name">
                                                       <span>' .__('Name') . '</span>
                                                        <h5 class="pt-3">maxwin5</h5>
                                                </div>
                                                <div class="earner-price">
                                                      <span>' .__('Price') . '</span>
                                                    <h5 class="pt-3">' .$_SESSION['site_settings']['site_currency']. '1710.00</h5>
                                                </div>
                                        </div>
                                      </div>
                                      <div class="earn-top">
                                            <div class="earner">  
                                                <img src="' .$_ENV['UI_ASSET_URL']. "/assets/img/Avatar.png" . '" width="100px" class="top-earner">                                   
                                                <div class="earner-name">
                                                       <span>' .__('Name') . '</span>
                                                        <h5 class="pt-3">maxwin5</h5>
                                                </div>
                                                <div class="earner-price">
                                                      <span>' .__('Price') . '</span>
                                                    <h5 class="pt-3">' .$_SESSION['site_settings']['site_currency']. '1200.00</h5>
                                                </div>
                                        </div>
                                      </div>
                                      <div class="earn-top">
                                            <div class="earner">  
                                                <img src="' .$_ENV['UI_ASSET_URL']. "/assets/img/Avatar.png" . '" width="100px" class="top-earner">                                   
                                                <div class="earner-name">
                                                       <span>' .__('Name') . '</span>
                                                        <h5 class="pt-3">maxwin5</h5>
                                                </div>
                                                <div class="earner-price">
                                                      <span>' .__('Price') . '</span>
                                                    <h5 class="pt-3">' .$_SESSION['site_settings']['site_currency']. '1000.00</h5>
                                                </div>
                                        </div>
                                      </div>
                                      <div class="earn-top">
                                            <div class="earner">  
                                                <img src="' .$_ENV['UI_ASSET_URL']. "/assets/img/Avatar.png" . '" width="100px" class="top-earner">                                   
                                                <div class="earner-name">
                                                       <span>' .__('Name') . '</span>
                                                        <h5 class="pt-3">maxwin5</h5>
                                                </div>
                                                <div class="earner-price">
                                                      <span>' .__('Price') . '</span>
                                                    <h5 class="pt-3">' .$_SESSION['site_settings']['site_currency']. '800.00</h5>
                                                </div>
                                        </div>
                                      </div>
                                      ';
        }
        echo json_encode($output);
        exit;
    }
}
?>