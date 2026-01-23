<?php

namespace Model\Shopify;

use Query\Bin_Query;
use Model\Middleware\MSiteDetails;
use Model\Shopify\MCustomerBonus;
use Model\Bonus\MShopBonus;
use Model\Middleware\MMatrixMemberLink;
use MongoDB;

class MConnectMLM
{
    public function verifyWebhook($hmacHeader)
    {
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="shop_name" AND sitesettings_description="shopifyconnection"');
        $shop_name = $sitesettings[0]['sitesettings_value'];
        $shop_name = $shop_name.'.myshopify.com';
        return ($shop_name == $hmacHeader) ? '1' : '0';
    }
    /**
     * This public function is used  to insert connect mlm plugin datas
     *
    */
    public static function syUserInsert()
    {
        // echo'<pre>';print_r($_SERVER);
        // $hmacHeader = $_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN'];

        // $verified = self::verifyWebhook($hmacHeader);
        // if ($verified =='1')
        // {

        $data = file_get_contents('php://input');

        $data_row = json_decode(file_get_contents('php://input'), true);

        $email = $data_row['email'];
        $sqluser = "SELECT * FROM `".$_ENV['STORE_PREFIX']."users` WHERE user_email='".$email."'";
        $queryuser = new Bin_Query();
        $queryuser->executeQuery($sqluser);
        $resultuser = $queryuser->records;
        if (count((array)$resultuser) == '0') { //insert if user not exists*/

            $user_login = $data_row['note'];
            $user_activation_key = $data_row['id'];
            $sql_matrxd = "INSERT INTO `".$_ENV['STORE_PREFIX']."users`(`ID`, `user_login`, `user_email`,`user_registered`,`user_activation_key`,`user_status`) VALUES ('".$user_activation_key."','".$user_login."','".$data_row['email']."',NOW(),'".$user_activation_key."','1')";
            $obj_matrixd = new Bin_Query();
            if ($obj_matrixd->updateQuery($sql_matrxd)) {
                $user_id = $obj_matrixd->insertid;
                foreach ($data_row as $mkey => $mvalue) {
                    if ($mvalue != '') {

                        if ($mkey == 'default_address') {

                            foreach ($data_row['default_address'] as $addrkey => $addrvalue) {
                                $sql_meta = "INSERT INTO `".$_ENV['STORE_PREFIX']."usermeta`(`user_id`, `meta_key`, `meta_value`) VALUES ('".$user_activation_key."','".$addrkey."','".$addrvalue."')";
                                $obj_meta = new Bin_Query();
                                $obj_meta->updateQuery($sql_meta);
                            }
                            /* $addresdetails['country']=$data_row['addresses'][1]['country'];
                             $addresdetails['city']=$data_row['addresses'][1]['city'];
                             $addresdetails['province']=$data_row['addresses'][1]['province'];
                             $addresdetails['zip']=$data_row['addresses'][1]['zip'];
                             $addresdetails['phone']=$data_row['addresses'][1]['phone'];
                             $addresdetails['province_code']=$data_row['addresses'][1]['province_code'];
                             $addresdetails['country_code']=$data_row['addresses'][1]['country_code'];
                             for($a=0;$a<count($addresdetails);$a++){
                                 $sql_meta = "INSERT INTO `".$_ENV['STORE_PREFIX']."usermeta`(`user_id`, `meta_key`, `meta_value`) VALUES ('".$user_id."','".$mkey."','".$addresdetails[$i]."')";
                                 $obj_meta = new Bin_Query();
                                 $obj_meta->updateQuery($sql_meta);
                             }*/
                        }


                    } else {

                        $sql_meta = "INSERT INTO `".$_ENV['STORE_PREFIX']."usermeta`(`user_id`, `meta_key`, `meta_value`) VALUES ('".$user_activation_key."','".$mkey."','".$mvalue."')";
                        $obj_meta = new Bin_Query();
                        $obj_meta->updateQuery($sql_meta);

                    }

                }

            }
        }
    }
    // }


    public static function syOrderInsert()
    {

        // $hmacHeader = $_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN'];
        // $verified = self::verifyWebhook($hmacHeader);
        // if ($verified =='1')
        // {
        // $data_row = file_get_contents('php://input');
        // $sqlcattaxre="INSERT INTO promlm_shopify_test
        // (`shopify_test_data`)
        // VALUES ('".$data_row."');";
        // $objcattaxre = new Bin_Query();
        // $objcattaxre->updateQuery($sqlcattaxre);

        $data_row = json_decode(file_get_contents('php://input'), true);
        $post_author = '1';
        $post_content = '';
        $post_title = 'Order'.date("l jS \of F Y h:i:s A");
        $post_excerpt = '';
        $post_status = 'wc-processing';
        $comment_status = 'open';
        $ping_status = 'closed';
        $post_password = 'wc_order_'.$data_row['id'];
        $post_name = 'Order-'.date("l jS \of F Y h:i:s A");
        $to_ping = '';
        $pinged = '';
        $post_content_filtered = '';
        $post_parent = '';
        $guid = $data_row['admin_graphql_api_id'];
        $menu_order = '';
        $post_type = 'shop_order';
        $comment_count = '1';
        $order_number = $data_row['order_number'];
        $billing_address = $data_row['billing_address'];
        $shipping_address = $data_row['shipping_address'];
        $email   = $data_row['email'];
        $currency   = $data_row['currency'];
        $total_discounts = $data_row['total_discounts'];
        $total_tax = $data_row['total_tax'];
        $order_total = $data_row['total_price'];
        $shipping_total = $data_row['total_shipping_price_set']['shop_money']['amount'];
        $line_items = $data_row['line_items'];
        $gateway   = $data_row['gateway'];
        $queryuser = new Bin_Query();
        $sqluser = "SELECT * FROM `".$_ENV['STORE_PREFIX']."users` WHERE user_email='".$email."'";
        $queryuser->executeQuery($sqluser);
        $resultuser = $queryuser->records;
        $customer_user = $data_row['customer']['id'];

        $note_attributes = $data_row['note_attributes'];
        for ($note = 0;$note < count((array)$note_attributes);$note++) {
            $namekey = $note_attributes[$note]['name'];
            if ($namekey == 'referral_id') {
                $referral_no = $note_attributes[$note]['value'];
            }
            if ($namekey == 'org_referral_id') {
                $org_referral_no = $note_attributes[$note]['value'];
            }
        }

        $customer_order_flag = '0';
        if ($referral_no != "") {
            $queryuser = new Bin_Query();
            $filterdata = '%/'.$referral_no.'.%';
            $sqluser = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "members_table WHERE members_subdomain LIKE '".$filterdata."'";
            $queryuser->executeQuery($sqluser);
            $resultuser = $queryuser->records;
            $customer_user = $resultuser[0]['members_shopify_id'];
            $members_id = $resultuser[0]['members_id'];
        } else {
            $queryuser = new Bin_Query();
            $sqluser = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "members_table WHERE members_email='".$email."'";
            if ($queryuser->executeQuery($sqluser)) {
                $resultuser = $queryuser->records;
                $customer_user = $resultuser[0]['members_shopify_id'];
                $members_id = $resultuser[0]['members_id'];
            } else {
                $querycus           = new Bin_Query();
                $sqlcus             = "SELECT * FROM `" . $_ENV['PROMLM_PREFIX'] . "customers` WHERE `customers_email` ='" . $email . "'";
                if ($querycus->executeQuery($sqlcus)) {
                    $customers_id         = $querycus->records[0]['customers_id'];
                    $customer_user   = $querycus->records[0]['customers_shop_id'];
                    $customer_order_flag = '1';  //1 means customers order flag
                }
            }

        }
        $membersorg = $customer_user;
        if ($org_referral_no != '') {
            $queryuserorg = new Bin_Query();
            $filterdataorg = '%/'.$org_referral_no.'.%';
            $sqluserorg = "SELECT members_shopify_id FROM " . $_ENV['PROMLM_PREFIX'] . "members_table WHERE (members_subdomain LIKE '".$filterdataorg."' || members_username='".$org_referral_no."')";
            $queryuserorg->executeQuery($sqluserorg);
            $resultuserorg = $queryuserorg->records;
            if (count((array)$resultuserorg) > 0) {
                $membersorg = $resultuserorg[0]['members_shopify_id'];
            }
        }
        $sql_check = "SELECT * FROM  `".$_ENV['STORE_PREFIX']."posts`  WHERE post_password='".$post_password."'";
        $obj_check = new Bin_Query();
        $obj_check->executeQuery($sql_check);
        $ordercheckcnt = count((array)$obj_check->records);
        if ($ordercheckcnt == '0') {
            $sqlinsert = "INSERT INTO `".$_ENV['STORE_PREFIX']."posts` 
                    (`post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`)
                    VALUES ('".$customer_user."',NOW(),NOW(),'".$post_content."','".$post_title."','".$post_excerpt."','".$post_status."','".$comment_status."','".$ping_status."','".$post_password."','".$post_name."','".$to_ping."','".$pinged."',NOW(),NOW(),'".$post_content_filtered."','".$order_number."','".$guid."','".$menu_order."','".$post_type."','".$post_mime_type."','".$comment_count."');";
            $obj = new Bin_Query();
            if ($obj->updateQuery($sqlinsert)) {
                //insert post meta
                //$post_id = $order_number;
                $post_id = $obj->insertid;

                if ($gateway == null) {
                    $payment_method = 'Manual';
                } else {
                    $payment_method = $gateway;
                }
                $paiddate = date('Y-m-d H:i:s');
                $completed_date = date('Y-m-d H:i:s');

                $postmeta = array('_customer_user' => $customer_user,'_order_currency' => $currency,'_cart_discount' => $total_discounts,'_order_tax' => $total_tax,'_order_total' => $order_total,'_order_shipping' => $shipping_total,'_payment_method' => $payment_method,'_original_customer_user' => $membersorg,'customer_order_flag' => $customer_order_flag,'order_number' => $order_number,'_paid_date' => $paiddate,'_completed_date' => $completed_date);
                foreach ($postmeta as $postmetakey => $postmetavalue) {

                    if ($postmetakey != 'notification_status') {
                        $sqli = "INSERT INTO `".$_ENV['STORE_PREFIX']."postmeta` (`post_id`, `meta_key`, `meta_value`) VALUES
                            ('".$post_id."', '".$postmetakey."', '".$postmetavalue."');";
                        $objin = new Bin_Query();
                        $objin->updateQuery($sqli);
                    }
                }

                //insert billing address
                $sqli = "INSERT INTO `".$_ENV['STORE_PREFIX']."postmeta` (`post_id`, `meta_key`, `meta_value`) VALUES
                        ('".$post_id."', '_billing_email', '".$email."');";
                $objin = new Bin_Query();
                $objin->updateQuery($sqli);

                foreach ($billing_address as $billing_addresskey => $billing_addressvalue) {
                    if ($billing_addresskey == 'province') {
                        $billing_addresskey = 'state';
                    }
                    if ($billing_addresskey == 'zip') {
                        $billing_addresskey = 'postcode';
                    }
                    if ($billing_addresskey == 'address1') {
                        $billing_addresskey = 'address_1';
                    }
                    $finalbillkey = '_billing_'.$billing_addresskey;

                    if ($billing_addressvalue != '' && $finalbillkey != 'notification_status') {

                        if ($finalbillkey != 'notification_status') {
                            $sqli = "INSERT INTO `".$_ENV['STORE_PREFIX']."postmeta` (`post_id`, `meta_key`, `meta_value`) VALUES
                                ('".$post_id."', '".$finalbillkey."', '".$billing_addressvalue."');";
                            $objin = new Bin_Query();
                            $objin->updateQuery($sqli);
                        }
                    }
                }
                //insert shipping address
                foreach ($shipping_address as $shipping_addresskey => $shipping_addressvalue) {
                    if ($shipping_addresskey == 'province') {
                        $shipping_addresskey = 'state';
                    }
                    if ($shipping_addresskey == 'zip') {
                        $shipping_addresskey = 'postcode';
                    }
                    if ($shipping_addresskey == 'address1') {
                        $shipping_addresskey = 'address_1';
                    }
                    $finalshipkey = '_shipping_'.$shipping_addresskey;
                    if ($shipping_addressvalue != '' && $finalshipkey != 'notification_status') {
                        $sqli = "INSERT INTO `".$_ENV['STORE_PREFIX']."postmeta` (`post_id`, `meta_key`, `meta_value`) VALUES
                                ('".$post_id."', '".$finalshipkey."', '".$shipping_addressvalue."');";
                        $objin = new Bin_Query();
                        $objin->updateQuery($sqli);
                    }
                }
                //insert order item
                if (count((array)$line_items) > 0) {
                    for ($i = 0; $i < count((array)$line_items); $i++) {
                        $obj = new Bin_Query();
                        $sqltrm = "INSERT INTO `".$_ENV['STORE_PREFIX']."woocommerce_order_items` (`order_item_name`, `order_item_type`, `order_id`) VALUES ( '".$line_items[$i]['title']."', 'line_item', '".$post_id."');";
                        $obj->updateQuery($sqltrm);
                        $order_item_id = $obj->insertid;

                        $obj_meta = new Bin_Query();
                        $sqltrm = "INSERT INTO `".$_ENV['STORE_PREFIX']."woocommerce_order_items` (`order_item_name`, `order_item_type`, `order_id`) VALUES ( 'Flat rate', 'shipping', '".$post_id."');";
                        $obj_meta->updateQuery($sqltrm);
                        $order_item_idtax = $obj_meta->insertid;

                        //insert order itemsmeta
                        $post_password = $line_items[$i]['product_id'];
                        $queryorder = new Bin_Query();
                        $sqlorder = "SELECT * FROM `".$_ENV['STORE_PREFIX']."posts` WHERE post_password='".$post_password."'";
                        $queryorder->executeQuery($sqlorder);
                        $resultorder = $queryorder->records;
                        $product_id = $resultorder[0]['ID'];
                        $quantity = $line_items[$i]['quantity'];
                        $variant_id = $line_items[$i]['variant_id'];
                        $tax_class = '';
                        $line_subtotal = $quantity * $line_items[$i]['price'];
                        $line_total = $quantity * $line_items[$i]['price'];
                        $line_subtotal_tax = '';
                        $line_tax = '';

                        $orderitememeta = array('_product_id' => $post_password,'_variation_id' => $variant_id,'_qty' => $quantity,'_tax_class' => $tax_class,'_line_subtotal' => $line_subtotal,'_line_subtotal_tax' => $line_subtotal_tax,'_line_tax' => $line_tax,'_line_total' => $line_total);

                        foreach ($orderitememeta as $orderitemkey => $orderitemvalue) {
                            $sqli = "INSERT INTO `".$_ENV['STORE_PREFIX']."woocommerce_order_itemmeta` (`order_item_id`, `meta_key`, `meta_value`) VALUES
                                    ('".$order_item_id."', '".$orderitemkey."', '".$orderitemvalue."');";
                            $objin = new Bin_Query();
                            $objin->updateQuery($sqli);
                        }

                        //orderitem tax
                        $method_id = 'flat_rate';
                        $cost = '0';
                        $total_tax = '0';
                        $title = $line_items[$i]['title'];
                        $orderitememeta = array('method_id' => $method_id,'cost' => $cost,'_qty' => $quantity,'total_tax' => $total_tax,'Items' => $title);
                        foreach ($orderitememeta as $orderitemkey => $orderitemvalue) {
                            $sqli = "INSERT INTO `".$_ENV['STORE_PREFIX']."woocommerce_order_itemmeta` ( `order_item_id`, `meta_key`, `meta_value`) VALUES
                                    ('".$order_item_id."', '".$orderitemkey."', '".$orderitemvalue."');";
                            $objin = new Bin_Query();
                            $objin->updateQuery($sqli);
                        }
                    }
                }


            }
        }
        // }



    }
    /**
     * This public function is used  to insert connect mlm plugin product datas
     *
    */
    public static function syProductInsert()
    {

        // $hmacHeader = $_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN'];
        // $verified = self::verifyWebhook($hmacHeader);
        // if ($verified =='1')
        // {
        //     $data_row = file_get_contents('php://input');
        // $sqlcattaxre="INSERT INTO promlm_shopify_test
        // (`shopify_test_data`)
        // VALUES ('".$data_row."');";
        // $objcattaxre = new Bin_Query();
        // $objcattaxre->updateQuery($sqlcattaxre);

        $data_row = json_decode(file_get_contents('php://input'), true);
        $post_author = '1';
        $post_content = $data_row['body_html'];
        $post_title = $data_row['title'];
        $post_excerpt = '';
        $post_status = 'publish';
        $comment_status = 'open';
        $ping_status = 'closed';
        $post_password = $data_row['id'];
        $post_name = $data_row['title'];
        $to_ping = '';
        $pinged = '';
        $post_content_filtered = '';
        $post_parent = '';
        $guid = $data_row['admin_graphql_api_id'];
        $menu_order = '';
        $post_type = 'product';
        $comment_count = '0';

        $sqlinsert = "INSERT INTO `".$_ENV['STORE_PREFIX']."posts` 
                (`post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`)
                VALUES ('".$post_author."',NOW(),NOW(),'".$post_content."','".$post_title."','".$post_excerpt."','".$post_status."','".$comment_status."','".$ping_status."','".$post_password."','".$post_name."','".$to_ping."','".$pinged."',NOW(),NOW(),'".$post_content_filtered."','".$post_parent."','".$guid."','".$menu_order."','".$post_type."','".$post_mime_type."','".$comment_count."');";
        $obj = new Bin_Query();

        if ($obj->updateQuery($sqlinsert)) {

            $post_id = $obj->insertid;
            $post_author = '1';
            $post_content = '';
            $post_title = $data_row['title'];
            $post_excerpt = '';
            $post_status = 'inherit';
            $comment_status = 'open';
            $ping_status = 'closed';
            $post_password = $data_row['id'];
            $post_name = $data_row['images'][0]['id'];
            $to_ping = '';
            $pinged = '';
            $post_content_filtered = '';
            $post_parent = $post_id;
            $guid = $data_row['images'][0]['src'];
            $menu_order = '';
            $post_type = 'attachment';
            $comment_count = '0';

            //insert images
            $sqlinsert = "INSERT INTO `".$_ENV['STORE_PREFIX']."posts` 
                    (`post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`)
                    VALUES ('".$post_date_gmt."',NOW(),NOW(),'".$post_content."','".$post_title."','".$post_excerpt."','".$post_status."','".$comment_status."','".$ping_status."','".$post_password."','".$post_name."','".$to_ping."','".$pinged."',NOW(),NOW(),'".$post_content_filtered."','".$post_parent."','".$guid."','".$menu_order."','".$post_type."','".$post_mime_type."','".$comment_count."');";
            $obj = new Bin_Query();
            $obj->updateQuery($sqlinsert);
            $edit_lock = '';
            $regular_price = $data_row['variants'][0]['price'];
            $sale_price = $data_row['variants'][0]['price'];
            $total_sales = '0';
            $tax_status = $data_row['variants'][0]['taxable'];
            $manage_stock = 'no';
            $backorders = 'no';
            $sold_individually = 'no';
            $virtual = 'no';
            $downloadable = 'no';
            $download_limit = '-1';
            $download_expiry = '-1';
            $stock = $data_row['variants'][0]['inventory_quantity'];
            $stock_status = 'instock';
            $wc_average_rating = '0';
            $wc_review_count = '0';
            $product_version = '0';
            $price = $data_row['variants'][0]['price'];
            $pv_point = '0';
            $productcategory = $data_row['product_type'];
            $sku = $data_row['variants'][0]['sku'];
            $arrayproductmeta = array('_edit_lock' => $edit_lock,'_edit_last' => $edit_last,'_regular_price' => $regular_price,'_sale_price' => $sale_price,'total_sales' => $total_sales,'_tax_status' => $tax_status,'_tax_class' => $tax_class,'_tax_class' => $tax_class,'_manage_stock' => $manage_stock,'_backorders' => $backorders,'_sold_individually' => $sold_individually,'_virtual' => $virtual,'_downloadable' => $downloadable,'_download_limit' => $download_limit,'_download_expiry' => $download_expiry,'_stock' => $stock,'_stock_status' => $stock_status,'_wc_average_rating' => $wc_average_rating,'_wc_review_count' => $wc_review_count,'_product_version' => $product_version,'_price' => $price,'_pv_point' => $pv_point,'_sku' => $sku);

            foreach ($arrayproductmeta as $productmetakey => $productmetavalue) {

                if ($productmetakey != 'notification_status') {
                    $sql_img_meta = "INSERT INTO `".$_ENV['STORE_PREFIX']."postmeta`(`post_id`, `meta_key`, `meta_value`) VALUES ('".$post_id."','".$productmetakey."','".$productmetavalue."')";
                    $obj_img_meta = new Bin_Query();
                    $obj_img_meta->updateQuery($sql_img_meta);
                }

            }

            //insert product category here we take Product type as category

            $querycattest = new Bin_Query();
            $sqlcattest = "SELECT * FROM `".$_ENV['STORE_PREFIX']."terms` WHERE name='".$productcategory."'";
            $querycattest->executeQuery($sqlcattest);
            $resultcnt = $querycattest->records;
            $term_id = $resultcnt[0]['term_id'];
            if (count((array)$resultcnt) > 0) {

                $sqlterm = "UPDATE `".$_ENV['STORE_PREFIX']."termmeta` SET meta_value=meta_value+1
                            WHERE term_id='".$term_id."'";
                $objterm = new Bin_Query();
                $objterm->updateQuery($sqlterm);

                $sqltermtax = "UPDATE `".$_ENV['STORE_PREFIX']."term_taxonomy` SET count=count+1
                            WHERE term_id='".$term_id."'";
                $objtermtax = new Bin_Query();
                $objtermtax->updateQuery($sqltermtax);

                $querycattestmet = new Bin_Query();
                $sqlcattestmet = "SELECT * FROM `".$_ENV['STORE_PREFIX']."term_taxonomy` WHERE term_id='".$term_id."'";
                $querycattestmet->executeQuery($sqlcattestmet);
                $resultcntmet = $querycattestmet->records;
                $term_taxonomy_id = $resultcntmet[0]['term_taxonomy_id'];

                $sqlcattaxre = "INSERT INTO `".$_ENV['STORE_PREFIX']."term_relationships` 
                            (`object_id`, `term_taxonomy_id`, `term_order`)
                            VALUES ('".$post_id."','".$term_taxonomy_id."','0');";
                $objcattaxre = new Bin_Query();
                $objcattaxre->updateQuery($sqlcattaxre);


            } else {

                $sqlcat = "INSERT INTO `".$_ENV['STORE_PREFIX']."terms` 
                            (`name`, `slug`, `term_group`)
                            VALUES ('".$productcategory."','".$productcategory."','0');";
                $objcat = new Bin_Query();
                $objcat->updateQuery($sqlcat);
                $term_id = $objcat->insertid;

                $sqlcatme = "INSERT INTO `".$_ENV['STORE_PREFIX']."termmeta` 
                            (`term_id`, `meta_key`, `meta_value`)
                            VALUES ('".$term_id."','product_count_product_cat','1');";
                $objcatme = new Bin_Query();
                $objcatme->updateQuery($sqlcatme);

                $sqlcattax = "INSERT INTO `".$_ENV['STORE_PREFIX']."term_taxonomy` 
                            (`term_id`, `taxonomy`, `parent`,`count`)
                            VALUES ('".$term_id."','product_cat','0','1');";
                $objcattax = new Bin_Query();
                $objcattax->updateQuery($sqlcattax);
                $term_taxonomy_id = $objcattax->insertid;

                $sqlcattaxre = "INSERT INTO `".$_ENV['STORE_PREFIX']."term_relationships` 
                            (`object_id`, `term_taxonomy_id`, `term_order`)
                            VALUES ('".$post_id."','".$term_taxonomy_id."','0');";
                $objcattaxre = new Bin_Query();
                $objcattaxre->updateQuery($sqlcattaxre);

            }

        }


        // }

    }
    public static function syOrderFulfillment()
    {

        // $hmacHeader = $_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN'];
        // $verified = self::verifyWebhook($hmacHeader);
        // $verified='1';
        // if ($verified =='1')
        // {

        $post_password = '';
        $data_row = json_decode(file_get_contents('php://input'), true);
        $id = $data_row['id'];
        $line_items = $data_row['line_items'];
        $post_password = 'wc_order_'.$id;

        $sqlterm = "UPDATE `".$_ENV['STORE_PREFIX']."posts` SET post_status='wc-completed'
            WHERE post_password='".$post_password."'";
        $objterm = new Bin_Query();
        $objterm->updateQuery($sqlterm);
        $sql = "SELECT ID FROM `".$_ENV['STORE_PREFIX']."posts` WHERE post_password='".$post_password."'";
        $query = new Bin_Query();
        $query->executeQuery($sql);
        $order_id = $query->records[0]['ID'];
        $sql_meta = "SELECT (SELECT meta_value FROM `".$_ENV['STORE_PREFIX']."postmeta` WHERE meta_key='_customer_user' AND post_id='".$order_id."') as shopid,
                (SELECT meta_value FROM `".$_ENV['STORE_PREFIX']."postmeta` WHERE meta_key='_order_total' AND post_id='".$order_id."') as totalprice,
                (SELECT meta_value FROM `".$_ENV['STORE_PREFIX']."postmeta` WHERE meta_key='_original_customer_user' AND post_id='".$order_id."') as original_member_sponsor";
        $query_meta = new Bin_Query();
        $query_meta->executeQuery($sql_meta);
        $metavalues = $query_meta->records;
        $shopid = $metavalues[0]['shopid'];
        $totalprice = $metavalues[0]['totalprice'];
        $original_member_sponsor = $metavalues[0]['original_member_sponsor'];

        $querymemde           = new Bin_Query();
        $sqlmemde             = "SELECT members_id,members_username FROM `" . $_ENV['PROMLM_PREFIX'] . "members_table` WHERE `members_shop_id` ='" . $shopid . "'";
        $querymemde->executeQuery($sqlmemde);
        $members_id       = $querymemde->records[0]['members_id'];

        /*for direct sales*/
        $matrix_link_where = 'members_id="' . $members_id . '"';
        $sqllinkmem = "SELECT direct_id,members_parents FROM " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table
                 WHERE " . $matrix_link_where . " ";
        $objlinkmem = new Bin_Query();
        $objlinkmem->executeQuery($sqllinkmem);
        $recordslinkmem = $objlinkmem->records;
        $sponsor_id = $recordslinkmem[0]['direct_id'];
        $members_parents = $recordslinkmem[0]['members_parents'];
        if ($members_id > '0' || $members_id > 0) {
            $update_direct = new Bin_Query();
            $total = $totalprice;
            $amount = $total;
            $update_direct_query = "UPDATE ".$_ENV['PROMLM_PREFIX']."matrix_members_link_table 
                     SET personal_sales= personal_sales + " . $total . " WHERE members_id='" . $members_id . "'";
            $update_direct->updateQuery($update_direct_query);

            /* start Mongo Update GPV */
            $collectionname = 'members';
            $bulk = new MongoDB\Driver\BulkWrite();
            $bulk->update(
                ['members_id' => (int)$members_id],
                ['$inc' => ['Personal Order Value' => (float)$amount]],
                ['multi' => true, 'upsert' => true]
            );
            $manager = new MongoDB\Driver\Manager($_ENV['MONGO_DRIVE']);
            $manager->executeBulkWrite($_ENV['MONGO_DBNAME'].$collectionname, $bulk);
        }
        /*for direct sales update in MongoDB */
        if ($sponsor_id > '0' || $sponsor_id > 0) {
            $update = new Bin_Query();

            $update_direct = "UPDATE ".$_ENV['PROMLM_PREFIX']."matrix_members_link_table 
                     SET direct_sales= direct_sales + " . $totalprice . " WHERE members_id='" . $sponsor_id . "'";
            $update->updateQuery($update_direct);

            /* start Mongo Update GPV */
            $collectionname = 'members';
            $bulk_direct = new MongoDB\Driver\BulkWrite();
            $bulk_direct->update(
                ['members_id' => (int)$sponsor_id],
                ['$inc' => ['Direct Distributors Order Volume' => (float)$amount]],
                ['multi' => true, 'upsert' => true]
            );
            $manager = new MongoDB\Driver\Manager($_ENV['MONGO_DRIVE']);
            $manager->executeBulkWrite($_ENV['MONGO_DBNAME'].$collectionname, $bulk_direct);
        }
        /*for total downline sales update in MongoDB */
        if ($members_parents != '') {
            $update_total = new Bin_Query();
            $amount = $totalprice;
            $members_parents_array = array_map('intval', explode(',', $members_parents));
            $update_total_query = "UPDATE ".$_ENV['PROMLM_PREFIX']."matrix_members_link_table 
                     SET total_sales= total_sales + ".$amount." WHERE members_id IN (" . $members_parents . ")";
            $update_total->updateQuery($update_total_query);

            /* start Mongo Update GPV */
            $collectionname = 'members';
            $bulk_total = new MongoDB\Driver\BulkWrite();
            $bulk_total->update(
                ['members_id' => ['$in' => $members_parents_array]],
                ['$inc' => ['Total Downline Order Volume' => (float)$amount]],
                ['multi' => true, 'upsert' => true]
            );
            $manager = new MongoDB\Driver\Manager($_ENV['MONGO_DRIVE']);
            $manager->executeBulkWrite($_ENV['MONGO_DBNAME'].$collectionname, $bulk_total);
        }

        self::sendProductLevelCommission($shopid, $order_id, $totalprice);

        /*start code for product pv*/

        //split commission bonus starts
        if ($shopid != $original_member_sponsor) {
            MShopBonus::sendSplitCommission($shopid, $original_member_sponsor, $order_id, $totalprice);
        }

    }
    public function sendProductLevelCommission($members_shop_id, $order_id, $amount)
    {
        $query           = new Bin_Query();
        $sql             = "SELECT members_id,members_username FROM `" . $_ENV['PROMLM_PREFIX'] . "members_table` WHERE `members_shop_id` ='" . $members_shop_id . "'";
        $query->executeQuery($sql);
        $members_id       = $query->records[0]['members_id'];
        $members_username = $query->records[0]['members_username'];
        $queryobj         = new Bin_Query();
        $sqllink          = "SELECT members_id,matrix_id FROM `" . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table` WHERE `members_id` ='" . $members_id . "'";
        $queryobj->executeQuery($sqllink);
        $linkplan          = $queryobj->records;
        $largermembercount = '0';
        $largermatrix_id   = '0';
        for ($i = 0; $i < count((array)$linkplan); $i++) {
            $matrix_id  = $linkplan[$i]['matrix_id'];
            $sqlmembers = "SELECT COUNT(*) AS downlinecount,matrix_id FROM 
                " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table WHERE 
                FIND_IN_SET('" . $members_id . "',`members_parents`)
                AND matrix_id='" . $matrix_id . "'
                ORDER BY members_id ASC";
            $objmembers = new Bin_Query();
            $objmembers->executeQuery($sqlmembers);
            $downlinecount = $objmembers->records[0]['downlinecount'];
            if ($downlinecount > $largermembercount) {
                $largermatrix_id   = $objmembers->records[0]['matrix_id'];
                $largermembercount = $downlinecount;
            }
        }
        if ($largermatrix_id > 0) {
            $largermatrix_id = $largermatrix_id;
        } else {
            $largermatrix_id = $matrix_id;
        }


        self::insertProductLevelCommission($largermatrix_id, $members_id, '1', $amount, $members_username);
        return true;
    }
    public static function insertProductLevelCommission($matrix_id, $members_id, $level, $amount, $members_username)
    {
        $objspill = new Bin_Query();
        $sqlspill = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table 
        WHERE members_id='" . $members_id . "' AND matrix_id='" . $matrix_id . "' AND members_account_status='1'";
        if ($objspill->executeQuery($sqlspill)) {
            $spillover_id                = $objspill->records[0]['spillover_id'];
            $sqlproduct                  = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "productlevelcommission_table 
            WHERE  matrix_id='" . $matrix_id . "' AND productlevelcommission_line_no='" . $level . "' 
            AND product_levelcommission_status='1'";
            $objproduct                  = new Bin_Query();
            $recordss                    = $objproduct->executeQuery($sqlproduct);
            $countproductlevelcommission = count((array)$objproduct->executeQuery($sqlproduct));
            if ($countproductlevelcommission > 0) {
                $productlevelcommission_amount      = $objproduct->records[0]['productlevelcommission_amount'];
                $productlevelcommission_method      = $objproduct->records[0]['productlevelcommission_method'];
                $productlevelcommission_wallet_type = $objproduct->records[0]['productlevelcommission_wallet_type'];
                $currency_id = $objproduct->records[0]['currency_id'];
                if ($productlevelcommission_method == '%') {
                    $commission_amt = ($amount * $productlevelcommission_amount) / 100;
                } else {
                    $commission_amt = $productlevelcommission_amount;
                }
                $description = "Product Level" . ($level) . " commission has been earned from " . $members_username;
                //insert history table
                if ($spillover_id > 0 && $commission_amt > 0) {

                    $sql = "SELECT crypto_default_name FROM " . $_ENV['PROMLM_PREFIX'] . "crypto_currency_and_token where crypto_currency_id='" . $currency_id . "'";
                    $obj = new Bin_Query();
                    $obj->executeQuery($sql);
                    $cryptocurrency = $obj->records[0]['crypto_default_name'];
                    if ($cryptocurrency != '') {
                        $where          = "WHERE sitesettings_name ='site_currency_code' ";
                        $sitesettings   = MSiteDetails::getSiteSettingsDetails($where);
                        $currencycode = $sitesettings[0]['sitesettings_value'];
                        define("SITE_CURRENCY_CODE", $currencycode);
                        $btc_crypto_balance = MCryptoConverter::cryptoConverter($cryptocurrency);
                        $cryptovalue = str_replace(',', '', $btc_crypto_balance);
                        //  $crypto_qty = $commission_amt / $cryptovalue;
                        if ($cryptovalue != '0') {
                            $crypto_qty = $commission_amt / $cryptovalue;
                        } else {
                            $crypto_qty = $cryptovalue;
                        }
                        $crypto_qty = number_format($crypto_qty, 6);
                        $crypto_qty = str_replace(',', '', $crypto_qty);
                    }
                    $objlevel  = new Bin_Query();
                    $sql_level = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "history_table (history_member_id,history_amount, history_type,history_description,history_datetime,history_payment,history_wallet_type,history_transaction_id,crypto_qty,currency_id)
                    VALUES (" . $spillover_id . "," . $commission_amt . ",'productlevelcommission','" . $description . "',NOW(),0,'" . $productlevelcommission_wallet_type . "','#" . substr(number_format(time() * rand(), 0, '', ''), 0, 9) . "','".$crypto_qty."','".$currency_id."')";
                    $objlevel->updateQuery($sql_level);
                }
            }
            $level += 1;
            if ($spillover_id > 0) {
                self::insertProductLevelCommission($matrix_id, $spillover_id, $level, $amount, $members_username);
            }
        }
        return true;
    }
    public function sentPV($shopid, $order_id, $pv_value)
    {
        if ($pv_value > 0) {
            $query           = new Bin_Query();
            $sql             = "SELECT members_id,members_username FROM `" . $_ENV['PROMLM_PREFIX'] . "members_table` WHERE `members_shop_id` ='" . $shopid . "'";
            $query->executeQuery($sql);
            $members_id       = $query->records[0]['members_id'];
            $dec = 'PV has been earned from order id # '.$order_id;
            $updateQuery = new Bin_Query();
            $sql_direct  = "INSERT into " . $_ENV['PROMLM_PREFIX'] . "history_table (history_member_id,history_amount, history_type,history_description,history_datetime,history_payment,history_transaction_id,history_plan_id,history_matrix_id) values (" . $members_id . "," . $pv_value . ",'pv','" . $dec . "',NOW(),0,'#" . substr(number_format(time() * rand(), 0, '', ''), 0, 9) . "','0','" . $matrix_id . "')";
            $updateQuery->updateQuery($sql_direct);
            //start update Mongo DB
            $collectionname = 'members';
            $members_id = (int)$members_id;
            $mng = new MongoDB\Driver\Manager($_ENV['MONGO_DRIVE']);
            if ($querycondition == "") {
                $query = new MongoDB\Driver\Query([]);
            } else {
                $query = new MongoDB\Driver\Query($querycondition);
            }
            $rows = $mng->executeQuery($_ENV['MONGO_DBNAME'].$collectionname, $query);
            $dataarray = iterator_to_array($rows);
            $selectdata = json_encode($dataarray);
            $jsondata = $selectdata;
            $data = json_decode($jsondata);
            $total_value = $data[0]->PV + $pv_value;
            $where = ['members_id' => $members_id];
            $update = ['PV' => $total_value];
            $bulk = new MongoDB\Driver\BulkWrite();
            $bulk->update(
                $where,
                ['$set' => $update],
                ['multi' => false, 'upsert' => false]
            );
            $manager = new MongoDB\Driver\Manager($_ENV['MONGO_DRIVE']);
            $manager->executeBulkWrite($_ENV['MONGO_DBNAME'].$collectionname, $bulk);
            //gpv start
            $pv = $pv_value;
            $matrix_link_where = 'members_id="' . $members_id . '" ';
            $matrix_link_details = MMatrixMemberLink::getPartMatrixLinkDetails('members_parents', $matrix_link_where);
            $members_parents = $matrix_link_details[0]['members_parents'];
            if ($members_parents != '') {
                $members_parents_array = array_map('intval', explode(',', $members_parents));
                $update_gpv = new Bin_Query();
                $update_gpv_query = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table
                SET gpv= gpv + " . $pv . " WHERE members_id IN (" . $members_parents . ")";
                $update_gpv->updateQuery($update_gpv_query);
                /* start Mongo Update GPV */
                $collectionname = 'members';
                $bulk = new MongoDB\Driver\BulkWrite();
                $bulk->update(
                    ['members_id' => ['$in' => $members_parents_array]],
                    ['$inc' => ['GPV' => (int)$pv]],
                    ['multi' => true, 'upsert' => true]
                );
                $manager = new MongoDB\Driver\Manager($_ENV['MONGO_DRIVE']);
                $manager->executeBulkWrite($_ENV['MONGO_DBNAME'].$collectionname, $bulk);
                /* end Mongo Update GPV */
            }
            return true;
        }
    }

}
