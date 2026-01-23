<?php
/**
 * This class contains public functions related to purchase history
 *
 * @package         PurchaseHistory
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
?><?php

namespace Admin\App\Http\Controllers\Wordpress;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Wordpress\MWordPressPurchaseHistory;
use Exception;
class WordPressPurchaseHistoryController extends Controller
{

    public static function showPurchaseHistory()
    {
        try {
            $output = [];

            MWordPressPurchaseHistory::updateUnseenOrder();

            return view('wordpress\wordpresspurchasehistory.html', $output);
            unset($_SESSION['success_message']);
            unset($_SESSION['error_message']);
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("location:" . $_ENV['BCPATH'] . "/wordpresspurchasehistory");
            exit();
        }
    }

    public static function getPurchaseHistory()
    {
        try {
            MWordPressPurchaseHistory::getPurchaseHistory();
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("location:" . $_ENV['BCPATH'] . "/wordpresspurchasehistory");
            exit();
        }
    }

    public static function getOrderDetails()
    {
        try {
        MWordPressPurchaseHistory::getOrderDetails();
    }catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("location:" . $_ENV['BCPATH'] . "/wordpresspurchasehistory/orderdetails");
        exit();
    }
}
}

