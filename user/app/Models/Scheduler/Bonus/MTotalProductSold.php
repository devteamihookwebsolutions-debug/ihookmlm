<?php
/**
 * This class contains public static functions related to Bonus .
 *
 * @package         MTotalProductSold
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://promlmsoftware.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement: 
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?><?php
namespace Model\Scheduler\Bonus;
use Query\Bin_Query;
class MTotalProductSold{
    /**
     * This public static function is used  to check total product sold
     * @param int $User
     * @param int $productsoldcnt
     * @param int $matrix_id
     * @param string $condition
     * @return Boolean data
    */
     public static function totalProductSold($User, $matrix_id, $productsoldcnt, $condition)
    {
        $qty             = 0;
        $sql = "SELECT members_shop_id FROM  " . $_ENV['PROMLM_PREFIX'] . "members_table where members_id='" . $User . "'";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records;
        $members_shop_id = $records[0]['members_shop_id'];
        $sql_user        = "SELECT post_id from " . $_ENV['STORE_PREFIX'] . "postmeta where meta_key='_customer_user' and meta_value='" . $members_shop_id . "'";
        $obj_user        = new Bin_Query();
        $obj_user->executeQuery($sql_user);
        $records_user = $obj_user->records;
        for ($i = 0; $i < count((array)$records_user); $i++) {
            $sql_meta = "SELECT count(*) as total from " . $_ENV['STORE_PREFIX'] . "posts  where post_type='shop_order' and post_status='wc-completed' and ID='" . $records_user[$i]['post_id'] . "'";
            $obj_meta = new Bin_Query();
            $obj_meta->executeQuery($sql_meta);
            if ($obj_meta->records[0]['total'] > 0) {
                $sql_ur = "SELECT cart_woocommerce_order_itemmeta.meta_value  from " . $_ENV['STORE_PREFIX'] . "woocommerce_order_items  AS orderitem
                    LEFT JOIN cart_woocommerce_order_itemmeta ON cart_woocommerce_order_itemmeta.order_item_id = orderitem.order_item_id         
                    WHERE  orderitem.order_id='" . $records_user[$i]['post_id'] . "' AND cart_woocommerce_order_itemmeta.meta_key='_qty'";
                $obj_ur = new Bin_Query();
                $obj_ur->executeQuery($sql_ur);
                $records_ur = $obj_ur->records;
                $qty        = $qty + $records_ur[0]['meta_value'];
            }
        }
        if ($condition == "<") {
            if ($qty < $productsoldcnt) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == "<=") {
            if ($qty <= $productsoldcnt) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == ">") {
            if ($qty > $productsoldcnt) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == ">=") {
            if ($qty >= $productsoldcnt) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == "==") {
            if ($qty == $productsoldcnt) {
                return true;
            } else {
                return false;
            }
        } else if ($condition == "!=") {
            if ($qty != $productsoldcnt) {
                return true;
            } else {
                return false;
            }
        }
    }
}
?>    