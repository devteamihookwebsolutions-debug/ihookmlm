<?php
/**
 * This class contains public functions related to woo products
 *
 * @package         WordPressProducts
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
 */
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Http\Controllers\Wordpress;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Lib\ValidateInputs;
use Admin\App\Models\Middleware\MAdminActivityLog;
use Admin\App\Models\Middleware\MSiteDetails;
use Admin\App\Models\Wordpress\MWordPressProducts;
use Exception;
class WordPressProductsController extends Controller
{

    public static function showWordPressProducts()
    {
        try {

        $output['products'] = MWordPressProducts::showWordPressProducts();

        return view('wordpress/wordpressproductslist', $output);
        unset($_SESSION['success_message']);
        unset($_SESSION['error_message']);
    }catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("location:" . $_ENV['BCPATH'] . "/wordpresspurchasehistory/orderdetails");
        exit();
    }
}

    public static function showAddProducts()
    {
        try {

        if (isset($_GET['sub1'])) {
            $result = MWordPressProducts::editProducts($_GET['sub1']);
            $output['post_title'] = $result['post_title'];
            $output['post_name'] = $result['post_name'];
            $output['post_content'] = $result['post_content'];
            $output['regular_price'] = $result['regular_price'];
            $output['sales_price'] = $result['sales_price'];
        }
        $sitesettings_val =MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="woocommerce_secret"');
        $output['woocommerce_secret'] = $sitesettings_val[0]['sitesettings_value'];

        return view('wordpress/worpressaddproducts', $output);
        unset($_SESSION['success_message']);
        unset($_SESSION['error_message']);
    }catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("location:" . $_ENV['BCPATH'] . "/wordpressproducts/eaddproducts");
        exit();
    }
}

    public static function insertProducts()
    {
        try {
        new ValidateInputs('e_product');
        if (isset($_POST['id']) && $_POST['id'] != "")
        {
              //Admin Activity Log
        MAdminActivityLog::getAdminActivity('Wordpress - Update Product');
         //Admin Activity Log
            MWordPressProducts::updateProducts();
        } else {
           MAdminActivityLog::getAdminActivity('Wordpress - Insert Product');
            MWordPressProducts::insertProducts();
        }
        header('Location:' . $_ENV['BCPATH'] . '/wordpressproducts');
        exit();
    }catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("location:" . $_ENV['BCPATH'] . "/wordpressproducts/insert");
        exit();
    }
}

    public static function deleteProducts()
    {
        try {
         //Admin Activity Log
        MAdminActivityLog::getAdminActivity('Wordpress - Delete Product');
         //Admin Activity Log

        MWordPressProducts::deleteProducts();
        header('Location:' . $_ENV['BCPATH'] . '/wordpressproducts');
        exit();
    }catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("location:" . $_ENV['BCPATH'] . "/wordpressproducts/delete");
        exit();
    }
}

    public static function showEditProducts()
    {
        try {


        if (isset($_GET['sub1'])) {
            $result = MWordPressProducts::editProducts($_GET['sub1']);
            $output['post_title'] = $result->name;
            $output['post_name'] = strip_tags($result->short_description);
            $output['post_content'] = strip_tags($result->description);
            $output['regular_price'] = $result->regular_price;
            $output['sales_price'] = $result->sale_price;
            $output['productimage'] = $result->images[0]->src;
        }

        // echo '<pre>';
        // print_r($output['productimage']);exit;


        $sitesettings_val =MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="woocommerce_secret"');
        $output['woocommerce_secret'] = $sitesettings_val[0]['sitesettings_value'];



       return view('wordpress/wordpressediteproducts', $output);
        unset($_SESSION['success_message']);
        unset($_SESSION['error_message']);
    }catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("location:" . $_ENV['BCPATH'] . "/wordpressproducts/edit");
        exit();
    }
}

    public static function getProducts()
    {
        try {
        echo MWordPressProducts::allWordPressProducts();
    }catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("location:" . $_ENV['BCPATH'] . "/wordpressproducts/getrecords");
        exit();
    }
}

    public static function showProductDetails()
    {
        try {
        $records = $_GET['records'] ?? null;
        echo MWordPressProducts::showProductDetails($records);
            exit;
    }catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("location:" . $_ENV['BCPATH'] . "/wordpressproducts/showeproducts");
        exit();
    }
}

    public static function allWordPressProducts()
    {
        try {
        echo MWordPressProducts::allWordPressProducts();
        exit;
    }catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("location:" . $_ENV['BCPATH'] . "/wordpressproducts/alleproducts");
        exit();
    }
}
}
