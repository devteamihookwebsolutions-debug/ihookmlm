<?php

/**
 * This class contains public functions related to SalesForceController
 *
 * @package         SalesForceController
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace Admin\App\Http\Controllers\Integrations;
use Admin\App\Http\Controllers\Controller;
use Admin\Models\Integrations\MSalesForce;
use Exception;
class SalesForceController extends Controller
{

    public static function showSalesForceRedirect() {
        try{
       MSalesForce::getaccesstoken();
    }
    catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("location:" . $_ENV['BCPATH'] . "/salesforceredirect");
            exit();
         }
        }

    public static function updateAccessToken() {
        try{
       MSalesForce::updateAccessToken();
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("location:" . $_ENV['BCPATH'] . "/salesforce/updateaccesstoken");
            exit();
         }
        }
}
?>
