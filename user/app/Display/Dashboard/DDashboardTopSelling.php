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

use Model\Middleware\MSiteDetails;
use Model\Middleware\MFormatNumber;

class DDashboardTopSelling
{
    /**
     * This public static function is used  to show the dashboard top selling products
     * @param array $product;
     * @return HTML data
     */
    public static function getTopSellingProducts($product)
    {

        if (!empty($product) && count($product) && CART_CONFIGURE_ID == 1) {
            $j = 1;
            for ($i = 0; $i < count((array)$product); $i++) {

                $id = $product[$i]['product_id'];
                $key_where = "WHERE sitesettings_name ='woocommerce_key' ";
                $sitesettings = MSiteDetails::getSiteSettingsDetails($key_where);
                $woocommerce_key = $sitesettings[0]['sitesettings_value'];
                $secret_where = "WHERE sitesettings_name ='woocommerce_secret' ";
                $sitesettings = MSiteDetails::getSiteSettingsDetails($secret_where);
                $woocommerce_secret = $sitesettings[0]['sitesettings_value'];
                $key_where = "WHERE sitesettings_name ='woocommerce_path' ";
                $sitesettings = MSiteDetails::getSiteSettingsDetails($key_where);
                $path = $sitesettings[0]['sitesettings_value'];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $path.'/wp-json/wc/v3/products/'.$id.'?consumer_key='.$woocommerce_key.'&consumer_secret='.$woocommerce_secret);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                $result = curl_exec($ch);
                curl_close($ch);
                $records = json_decode($result);

                if ($i % 4 == 0) {
                    if ($j == 1) {
                        $j++;
                        $output .= '<div class="carousel-item active">
                                <div class="col-md-12  pb-3">
                                <div class="row">';
                    } else {
                        $output .= '<div class="carousel-item">
                                <div class="col-md-12  pb-3">
                                <div class="row">';
                    }
                }

                if ($records->images[0]->src != '') {
                    $productimage = $records->images[0]->src;
                } else {
                    $productimage = $_ENV['UI_ASSET_URL']."/assets/img/empty_product.png";
                }


                $output .= '<div class="col-md-3 border-right">
                                                    <div class="card border-0 b-radius">
                                                        <img src="' . $productimage . '" alt="product" class="product_img1">
                                                        <div class="card-body text-center">
                                                        <h5 class="header-title">' . $records->name . '</h5>
                                                        
                                                        <div class="text-center">
                                                            <div class="price-rate ">
                                                            <span class="m--font-primary">' .$records->price_html . '</span>
                                                            </div>
                                                            <div class="status">
                                                          <!--   <span class="m-badge m-badge--success">In Stock</span> -->
                                                            <span class="fa fa-star checked"></span>
                                                            <span class="fa fa-star checked"></span>
                                                            <span class="fa fa-star checked"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>  
                                                </div>';
                if ($i % 4 == 3) {
                    $output .= '</div></div></div>';
                }
            }
        } else {
            $output .= '<style>
            .product_img {
                width: 150px;
                height: 150px;
                margin: 10px auto 0;
                }
            </style>';
            $output .= '<div class="carousel-inner">';
            $i = 0;
            $j = 1;
            foreach ($product as $key => $value) {
                if ($i % 4 == 0) {
                    if ($j == 1) {
                        $j++;
                        $output .= '<div class="carousel-item active">
                                            <div class="col-md-12  pb-3">
                                            <div class="row">';
                    } else {
                        $output .= '<div class="carousel-item">
                                            <div class="col-md-12  pb-3">
                                            <div class="row">';
                    }
                }
                if ($value['product_image']) {
                    $productimage = $value['product_image'];
                } else {
                    $productimage = $_ENV['UI_ASSET_URL']."/assets/img/empty_product.png";
                }
                $output .= '<div class="col-md-3 ">
                                    <div class="card border-0 b-radius">
                                        <img src="' .$productimage. '" alt="product" class="product_img">
                                    <div class="card-body text-center">
                                            <h5 class="header-title">'.$value['product_name'].'</h5>
                                            <p></p>
                                        <div class="text-center">
                                            <div class="price-rate ">
                                                <span class="m--font-primary">'.$_SESSION['site_settings']['site_currency'].MFormatNumber::formatingNumberCurrency($value['product_price']) .'</span>
                                            </div>
                                            <div class="status">
                                                <!--   <span class="m-badge m-badge--success">In Stock</span> -->
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>';
                if ($i % 4 == 3) {
                    $output .= '</div></div></div>';
                }
                $i++;
            }
            $output .= '
                </div>';
        }
        return $output;
    }
}
?>