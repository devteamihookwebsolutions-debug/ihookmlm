<?php
/**
 * This class contains public functions related to connect mlm for wordpress from mlm
 *
 * @package         MInstallConnectMLM
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php
namespace Model\Shopify;
use Query\Bin_Query;
use Model\Middleware\MSiteDetails;
class MUpdateConnectMLM
{

    public function verifyWebhook($data, $hmacHeader)
    {
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="api_secret_key"');
        $api_secret_key = $sitesettings[0]['sitesettings_value'];
        $calculatedHmac = base64_encode(hash_hmac('sha256', $data, $api_secret_key, true));
        error_log('$hmacHeader = ' . $hmacHeader);
        error_log('$calculatedHmac = ' . $calculatedHmac);
        return ($hmacHeader == $calculatedHmac);
    }

    /**
     * This public function is used  to insert connect mlm plugin datas
     *
    */
    public static function syUserUpdate()
    {

        // $hmacHeader = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
        $data_row = json_decode(file_get_contents('php://input'), true);

        $id=$data_row['id'];
        $sqluser = "SELECT COUNT(*) AS total FROM `".$_ENV['STORE_PREFIX']."users` WHERE ID='".$id."'";
        $queryuser = new Bin_Query();
        $queryuser->executeQuery($sqluser);
        $resultuser = $queryuser->records[0]['total'];
        if($resultuser > 0){
            $user_login=$data_row['note'];
            $sql_matrxd = " UPDATE  `".$_ENV['STORE_PREFIX']."users` SET `user_login`='".$user_login."',`user_email`='".$data_row['email']."' WHERE  ID='". $id ."'";
            $obj_matrixd = new Bin_Query();
            if($obj_matrixd->updateQuery($sql_matrxd))
            {
                foreach($data_row as $mkey => $mvalue){
                if($mvalue!=''){

                    if($mkey=='default_address'){

                        foreach($data_row['default_address'] as $addrkey=>$addrvalue){
                            $sql_select_usermeta = "SELECT COUNT(*) AS total FROM `".$_ENV['STORE_PREFIX']."usermeta` WHERE user_id='".$id."' and meta_key='".$addrkey."'";
                            $query_select_user = new Bin_Query();
                            $query_select_user->executeQuery($sql_select_usermeta);
                            $resultusermeta = $query_select_user->records[0]['total'];
                            if($resultusermeta > 0){
                                    $sql_meta = "UPDATE  `".$_ENV['STORE_PREFIX']."usermeta` SET `meta_value`='".$addrvalue."' WHERE  user_id='". $id ."' AND meta_key='".$addrkey."'";
                                    $obj_meta = new Bin_Query();
                                    $obj_meta->updateQuery($sql_meta);

                            }else{
                                $sql_meta = "INSERT INTO `".$_ENV['STORE_PREFIX']."usermeta`(`user_id`, `meta_key`, `meta_value`) VALUES ('".$id."','".$addrkey."','".$addrvalue."')";
                                $obj_meta = new Bin_Query();
                                $obj_meta->updateQuery($sql_meta);
                            }

                        }



                    }else{
                            $sql_select_usermeta = "SELECT COUNT(*) AS total FROM `".$_ENV['STORE_PREFIX']."usermeta` WHERE user_id='".$id."' and meta_key='".$mkey."'";
                            $query_select_user = new Bin_Query();
                            $query_select_user->executeQuery($sql_select_usermeta);
                            $resultusermeta = $query_select_user->records[0]['total'];
                            if($resultusermeta > 0){
                                    $sql_meta = "UPDATE  `".$_ENV['STORE_PREFIX']."usermeta` SET `meta_value`='".$mvalue."' WHERE  user_id='". $id ."' AND meta_key='".$mkey."'";
                                    $obj_meta = new Bin_Query();
                                    $obj_meta->updateQuery($sql_meta);

                            }else{
                                $sql_meta = "INSERT INTO `".$_ENV['STORE_PREFIX']."usermeta`(`user_id`, `meta_key`, `meta_value`) VALUES ('".$id."','".$mkey."','".$mvalue."')";
                                $obj_meta = new Bin_Query();
                                $obj_meta->updateQuery($sql_meta);
                            }

                        }

                    }

                }
            }
        }

    }
    public static function syProductUpdate(){
        // $hmacHeader = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
        $data_row = json_decode(file_get_contents('php://input'), true);
        $id=$data_row['id'];
        $sql = "SELECT * FROM `".$_ENV['STORE_PREFIX']."posts` WHERE post_password='".$id."' AND post_type='product'";
        $query = new Bin_Query();
        $query->executeQuery($sql);
        $totalcount = $query->records;
        $postid = $totalcount[0]['ID'];
        if(count((array)$totalcount) > 0){
            $sql_post = "UPDATE  `".$_ENV['STORE_PREFIX']."posts` SET `post_content`='".$data_row['body_html']."',`post_title`='".$data_row['title']."',`post_name`='".$data_row['title']."',`guid`='".$data_row['admin_graphql_api_id']."' WHERE  post_password='".$id."' AND post_type='product'";
            $obj_post = new Bin_Query();
            $obj_post->updateQuery($sql_post);
            $sql_post_img = "UPDATE  `".$_ENV['STORE_PREFIX']."posts` SET `post_title`='".$data_row['title']."',`guid`='".$data_row['image']['src']."' WHERE  post_password='".$id."' AND post_type='attachment'";
            $obj_post_img = new Bin_Query();
            $obj_post_img->updateQuery($sql_post_img);
            $edit_lock='';
            $regular_price=$data_row['variants'][0]['price'];
            $sale_price=$data_row['variants'][0]['price'];
            $total_sales='0';
            $tax_status='taxable';
            $manage_stock='no';
            $backorders='no';
            $sold_individually='no';
            $virtual='no';
            $downloadable='no';
            $download_limit='-1';
            $download_expiry='-1';
            $stock='';
            $stock_status='instock';
            $wc_average_rating='0';
            $wc_review_count='0';
            $product_version='0';
            $price=$data_row['variants'][0]['price'];
            $pv_point='0';
            $productcategory=$data_row['product_type'];
            $sku=$data_row['variants'][0]['sku'];
            $arrayproductmeta=array('_edit_lock'=>$edit_lock,'_edit_last'=>$edit_last,'_regular_price'=>$regular_price,'_sale_price'=>$sale_price,'total_sales'=>$total_sales,'_tax_status'=>$tax_status,'_tax_class'=>$tax_class,'_tax_class'=>$tax_class,'_manage_stock'=>$manage_stock,'_backorders'=>$backorders,'_sold_individually'=>$sold_individually,'_virtual'=>$virtual,'_downloadable'=>$downloadable,'_download_limit'=>$download_limit,'_download_expiry'=>$download_expiry,'_stock'=>$stock,'_wc_average_rating'=>$wc_average_rating,'_wc_review_count'=>$wc_review_count,'_product_version'=>$product_version,'_price'=>$price,'_pv_point'=>$pv_point,'_sku'=>$sku);

                        foreach($arrayproductmeta as $productmetakey=>$productmetavalue){
                            $sql_postmeta = "UPDATE  `".$_ENV['STORE_PREFIX']."postmeta` SET `meta_value`='".$productmetavalue."' WHERE  user_id='". $id ."' AND meta_key='".$productmetakey."'";
                            $obj_postmeta = new Bin_Query();
                            $obj_postmeta->updateQuery($sql_postmeta);
                        }
        }


    }
    public static function syProductDelete(){
        // $hmacHeader = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
        $data_row = json_decode(file_get_contents('php://input'), true);
        $id=$data_row['id'];
        $sql = "SELECT * FROM `".$_ENV['STORE_PREFIX']."posts` WHERE post_password='".$id."' AND post_type='product'";
        $query = new Bin_Query();
        $query->executeQuery($sql);
        $totalcount = $query->records;
        $postid = $totalcount[0]['ID'];
        $obj1 = new Bin_Query();
        $sql1 = "DELETE FROM " . $_ENV['STORE_PREFIX'] . "posts WHERE  post_password='".$id."'";
        $obj1->updateQuery($sql1);
        $obj_meta = new Bin_Query();
        $sql_meta = "DELETE FROM " . $_ENV['STORE_PREFIX'] . "postmeta WHERE  post_id='".$postid."'";
        $obj_meta->updateQuery($sql_meta);
    }
    public static function syOrderUpdate(){
        // $hmacHeader = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
        $data_row = json_decode(file_get_contents('php://input'), true);
        $id = $data_row['id'];
        $post_author='1';
        $post_content='';
        $post_title='Order'.date("l jS \of F Y h:i:s A");
        $post_excerpt='';
        $comment_status='open';
        $ping_status='closed';
        $post_password='wc_order_'.$data_row['id'];
        $post_name='Order-'.date("l jS \of F Y h:i:s A");
        $to_ping='';
        $pinged='';
        $post_content_filtered='';
        $post_parent='';
        $guid=$data_row['admin_graphql_api_id'];
        $menu_order='';
        $post_type='shop_order';
        $comment_count='1';
        $billing_address=$data_row['billing_address'];
        $shipping_address=$data_row['shipping_address'];
        $email   = $data_row['email'];
        $currency   = $data_row['currency'];
        $total_discounts= $data_row['total_discounts'];
        $total_tax=$data_row['total_tax'];
        $order_total=$data_row['total_price'];
        $shipping_total=$data_row['total_shipping_price_set']['shop_money']['amount'];
        $line_items=$data_row['line_items'];
        $gateway   = $data_row['gateway'];

        $sql = "SELECT * FROM `".$_ENV['STORE_PREFIX']."posts` WHERE post_author='".$id."'";
        $query = new Bin_Query();
        $query->executeQuery($sql);
        $totalcount = $query->records;
        $postid = $totalcount[0]['ID'];
        if(count((array)$totalcount)>0){
            $postmeta=array('_order_currency'=>$currency,'_cart_discount'=>$total_discounts,'_order_tax'=>$total_tax,'_order_total'=>$order_total,'_order_shipping'=>$shipping_total,'_payment_method'=>$payment_method);
            foreach($postmeta as $postmetakey=>$postmetavalue){
                $sql_postmeta = "UPDATE  `".$_ENV['STORE_PREFIX']."postmeta` SET `meta_value`='".$postmetavalue."' WHERE  user_id='". $postid ."' AND meta_key='".$postmetakey."'";
                $obj_postmeta = new Bin_Query();
                $obj_postmeta->updateQuery($sql_postmeta);
            }
             foreach($billing_address as $billing_addresskey=>$billing_addressvalue){
                 if($billing_addresskey=='province'){
                     $billing_addresskey='state';
                 }
                 if($billing_addresskey=='zip'){
                     $billing_addresskey='postcode';
                 }
                 if($billing_addresskey=='address1'){
                     $billing_addresskey='address_1';
                 }
                 $finalbillkey='_billing_'.$billing_addresskey;
                 if($billing_addressvalue!=''){
                     $sql_postmeta1 = "UPDATE  `".$_ENV['STORE_PREFIX']."postmeta` SET `meta_value`='".$billing_addressvalue."' WHERE  user_id='". $postid ."' AND meta_key='".$finalbillkey."'";
                     $obj_postmeta1 = new Bin_Query();
                     $obj_postmeta1->updateQuery($sql_postmeta1);
                 }
             }
            foreach($shipping_address as $shipping_addresskey=>$shipping_addressvalue){
                if($shipping_addresskey=='province'){
                    $shipping_addresskey='state';
                }
                if($shipping_addresskey=='zip'){
                    $shipping_addresskey='postcode';
                }
                if($shipping_addresskey=='address1'){
                    $shipping_addresskey='address_1';
                }
                $finalshipkey='_shipping_'.$shipping_addresskey;
                if($shipping_addressvalue!=''){
                    $sql_postmeta2 = "UPDATE  `".$_ENV['STORE_PREFIX']."postmeta` SET `meta_value`='".$shipping_addressvalue."' WHERE  user_id='". $postid ."' AND meta_key='".$finalshipkey."'";
                    $obj_postmeta2 = new Bin_Query();
                    $obj_postmeta2->updateQuery($sql_postmeta2);
                }
            }
            if(count((array)$line_items)>0){

                        for ($i=0; $i < count((array)$line_items); $i++) {
                            $queryorder1=new Bin_Query();
                             $sqlorder1 = "SELECT * FROM `".$_ENV['STORE_PREFIX']."woocommerce_order_items` WHERE order_id='".$postid."' AND order_item_type='line_item'";
                            $queryorder1->executeQuery($sqlorder1);
                            $resultorder1 = $queryorder1->records;
                            $order_item_id = $resultorder1[0]['order_item_id'];
                            $post_password=$line_items[$i]['product_id'];

                            $quantity=$line_items[$i]['quantity'];
                            $variant_id=$line_items[$i]['variant_id'];
                            $tax_class='';
                            $line_subtotal=$line_items[$i]['price'];
                            $line_total=$line_items[$i]['price'];
                            $line_subtotal_tax='';
                            $line_tax='';
                            $orderitememeta=array('_variation_id'=>$variant_id,'_qty'=>$quantity,'_tax_class'=>$tax_class,'_line_subtotal'=>$line_subtotal,'_line_subtotal_tax'=>$line_subtotal_tax,'_line_tax'=>$line_tax,'_line_total'=>$line_total);
                            foreach($orderitememeta as $orderitemkey=>$orderitemvalue){
                                $sql_postmeta3 = "UPDATE  `".$_ENV['STORE_PREFIX']."woocommerce_order_itemmeta` SET `meta_value`='".$orderitemvalue."' WHERE  order_item_id='". $order_item_id ."' AND meta_key='".$orderitemkey."'";
                                $obj_postmeta3 = new Bin_Query();
                                $obj_postmeta3->updateQuery($sql_postmeta3);
                            }
                            //orderitem tax
                            $method_id='flat_rate';
                            $cost='0';
                            $total_tax='0';
                            $title=$line_items[$i]['title'];
                            $orderitememeta=array('method_id'=>$method_id,'cost'=>$cost,'_qty'=>$quantity,'total_tax'=>$total_tax,'Items'=>$title);
                            foreach($orderitememeta as $orderitemkey=>$orderitemvalue){
                                $sql_postmeta4 = "UPDATE  `".$_ENV['STORE_PREFIX']."woocommerce_order_itemmeta` SET `meta_value`='".$orderitemvalue."' WHERE  order_item_id='". $order_item_id ."' AND meta_key='".$orderitemkey."'";
                                $obj_postmeta4 = new Bin_Query();
                                $obj_postmeta4->updateQuery($sql_postmeta4);
                            }

                        }
                    }

        }


    }
    public static function syOrderCancel(){
            $data_row = json_decode(file_get_contents('php://input'), true);
            $id=$data_row['id'];
            $post_password='wc_order_'.$id;
            $sqlterm="UPDATE `".$_ENV['STORE_PREFIX']."posts` SET post_status='wc-cancelled'
            WHERE post_password='".$post_password."'";
            $objterm = new Bin_Query();
            $objterm->updateQuery($sqlterm);
    }

}
?>


