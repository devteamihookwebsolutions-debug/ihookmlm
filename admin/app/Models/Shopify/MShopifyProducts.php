<?php
/**
 * This class contains public static functions related to shopify products.
 *
 * @package         MShopifyProducts
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copyDShopifyProducts of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?>
<?php
namespace Admin\App\Models\Shopify;

use Admin\App\Display\Shopify\DShopifyProducts;
use Admin\App\Models\Middleware\MAmazonCloudFront;
use Admin\App\Models\Middleware\MAmazonS3;
use Admin\App\Models\Middleware\MSiteDetails;
class MShopifyProducts {

    /**
     * This public static function is used  to shopifyProducts
    */
    public static function shopifyProducts() {
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="shop_name" AND sitesettings_description="shopifyconnection"');
        $store_url = $sitesettings[0]['sitesettings_value'];
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="access_token" AND sitesettings_description="shopifyconnection"');
        $access_token = $sitesettings[0]['sitesettings_value'];


        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="api_key" AND sitesettings_description="shopifyconnection"');
        $api_key = $sitesettings[0]['sitesettings_value'];

        $url = "https://" . $api_key . ":" . $access_token . "@" . $store_url . ".myshopify.com/admin/products.json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',));
        $result = curl_exec($ch);
        $records = json_decode($result, 2);
        curl_close ($ch);
        $shop_url = $store_url . '.myshopify.com';
        return DShopifyProducts::shopifyProducts($records['products'], $shop_url);
    }
    /**
     * This public static function is used  to insertProduct
    */
    public static function insertProduct() {
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="shop_name" AND sitesettings_description="shopifyconnection"');
        $store_url = $sitesettings[0]['sitesettings_value'];
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="access_token" AND sitesettings_description="shopifyconnection"');
        $access_token = $sitesettings[0]['sitesettings_value'];
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="api_key" AND sitesettings_description="shopifyconnection"');
        $api_key = $sitesettings[0]['sitesettings_value'];
        $uploaded_path = '../'.$_ENV['CURRENT_UPATH'].'/uploads/shopify/';
        if ($_FILES['fileToUpload']['name'] != '') {
            $uploadedName = $_FILES["fileToUpload"]["name"];
            /*$ext = strtolower(substr($uploadedName, strripos($uploadedName, '.') + 1));
            $flnm = hash('sha256', $uploadedName) . '.' . $ext;
            $headerimage = $uploaded_path . "/" . $flnm;
            move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $headerimage);
            $headerimagepath = 'uploads/shopify/' . $flnm;*/
            $ext = strtolower(substr($uploadedName, strripos($uploadedName, '.') + 1));
            $flnm = hash('sha256', $uploadedName) . '.' . $ext;
            $headerimagepath = 'uploads/shopify/' . $flnm;
            MAmazonS3::amazonUpload($_FILES['fileToUpload']['name'],$_FILES['fileToUpload']['tmp_name'],$_FILES['fileToUpload']['type'],$headerimagepath);
        }
        /**
     * This public static function is used  to checkShopifyInstall
        */
		 $headerimagepath = MAmazonCloudFront::getCloudFrontUrl($headerimagepath);
        $product_pv = $_POST['product_pv'];
        $data = array('product' => array('title' => $_POST['title'], 'body_html' => $_POST['post_content'], "variants" => array(array('price' => $_POST['post_regprice'], 'option1' => '', 'option2' => '', 'option3' => '')), 'images' => array(0 => array('src' => $headerimagepath,),),),);
        $data = json_encode($data);
        $url = "https://" . $api_key . ":" . $access_token . "@" . $store_url . ".myshopify.com/admin/products.json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',));
        $result = curl_exec($ch);
        $products = json_decode($result, 2);
        $error_msg = curl_error($ch);
        $error = json_decode($error_msg);
        curl_close ($ch);
        // Ensure $error is an array before using count()
        if (!empty($error) && is_array($error) && count($error) > 0) {
            $_SESSION['error_message'] = $error;
            header("Location:" . $_ENV['BCPATH'] . "/shopify_products");
            exit;
        }
    }
    /**
     * This public static function is used  to updateProduct
    */
    public static function updateProduct() {
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="shop_name"');
        $store_url = $sitesettings[0]['sitesettings_value'];
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="access_token"');
        $access_token = $sitesettings[0]['sitesettings_value'];
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="api_key"');
        $api_key = $sitesettings[0]['sitesettings_value'];
        $product_pv = $_POST['product_pv'];
        $uploaded_path = '../'.$_ENV['CURRENT_UPATH'].'/uploads/shopify/';
        if ($_FILES['fileToUpload']['name'] != '') {
            $uploadedName = $_FILES["fileToUpload"]["name"];
            /*$ext = strtolower(substr($uploadedName, strripos($uploadedName, '.') + 1));
            $flnm = hash('sha256', $uploadedName) . '.' . $ext;
            $headerimage = $uploaded_path . "/" . $flnm;
            move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $headerimage);
            $headerimagepath = 'uploads/shopify/' . $flnm;*/
            $ext = strtolower(substr($uploadedName, strripos($uploadedName, '.') + 1));
            $flnm = hash('sha256', $uploadedName) . '.' . $ext;
            $headerimagepath = 'uploads/shopify/' . $flnm;
            MAmazonS3::amazonUpload($_FILES['fileToUpload']['name'],$_FILES['fileToUpload']['tmp_name'],$_FILES['fileToUpload']['type'],$headerimagepath);
			 $headerimagepath = MAmazonCloudFront::getCloudFrontUrl($headerimagepath);
            $data = array("product" => array("id" => $_POST['id'], "title" => $_POST['title'], "body_html" => $_POST['post_content'], "variants" => array(array('price' => $_POST['post_regprice'],"inventory_policy" => "continue", 'option1' => '', 'option2' => '', 'option3' => '')), "images" => array(array('src' =>  $headerimagepath,)) ));
        } else {
            $data = array("product" => array("id" => $_POST['id'], "title" => $_POST['title'], "body_html" => $_POST['post_content'], "variants" => array(array('price' => $_POST['post_regprice'],"inventory_policy" => "continue", 'option1' => '', 'option2' => '', 'option3' => ''))));
        }
        $data = json_encode($data);
        $url = "https://" . $api_key . ":" . $access_token . "@" . $store_url . ".myshopify.com/admin/products/" . $_POST['id'] . ".json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',));
        $result = curl_exec($ch);
        $customer = json_decode($result, 2);
        $error_msg = curl_error($ch);
        $error = json_decode($error_msg);
        curl_close ($ch);
        if (count((array)$error) > 0) {
            $_SESSION['error_message'] = $error;
            header("Location:" . $_ENV['BCPATH'] . "/shopify_products");
            exit;
        }
    }
    /**
     * This public static function is used  to getProducts
     * @param array $id
    */
    public static function getProducts($id) {
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="shop_name"');
        $store_url = $sitesettings[0]['sitesettings_value'];
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="access_token"');
        $access_token = $sitesettings[0]['sitesettings_value'];
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="api_key"');
        $api_key = $sitesettings[0]['sitesettings_value'];
        $url = "https://" . $api_key . ":" . $access_token . "@" . $store_url . ".myshopify.com/admin/products/" . $id . ".json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',));
        $result = curl_exec($ch);
        $products = json_decode($result, 2);
        curl_close ($ch);
        return $products;
    }
    /**
     * This public static function is used  to deleteProduct
     * @param array $id
    */
    public static function deleteProduct($id) {
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="shop_name"');
        $store_url = $sitesettings[0]['sitesettings_value'];
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="access_token"');
        $access_token = $sitesettings[0]['sitesettings_value'];
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="api_key"');
        $api_key = $sitesettings[0]['sitesettings_value'];
        $url = "https://" . $api_key . ":" . $access_token . "@" . $store_url . ".myshopify.com/admin/products/" . $id . ".json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',));
        $result = curl_exec($ch);
        $products = json_decode($result, 2);
        curl_close ($ch);
        $sql_mat = "DELETE FROM " . $_ENV['PROMLM_PREFIX'] . "shopify_products WHERE product_shopify_id='" . $id . "'";
        $obj_mat = new Bin_Query();
        $obj_mat->updateQuery($sql_mat);
        $_SESSION['success_message'] = __('Product deleted successfully');
        return true;
    }
    /**
     * This public static function is used  to getProductsPV
     * @param array $id
    */
    public static function getProductsPV($id) {
        $sql_site = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "shopify_products WHERE
        product_shopify_id=" . $id . "";
        $obj_site = new Bin_Query();
        $obj_site->executeQuery($sql_site);
        $recordsSite = $obj_site->records[0];
        return $recordsSite;
    }
}
?>
