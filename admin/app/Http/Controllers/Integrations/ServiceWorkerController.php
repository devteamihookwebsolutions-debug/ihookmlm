<?php

/**
 * This class contains public functions related to ServiceWorkerController
 *
 * @package         ServiceWorkerController
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?><?php
namespace Admin\App\Http\Controllers\Integrations;
use Admin\App\Http\Controllers\Controller;
use Admin\Models\Integrations\MServiceWorker;
use Exception;
    class ServiceWorkerController extends Controller
    {
        public static function updateServiceWorker()
        {
            try{
            MServiceWorker::updateServiceWorker();
        }catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("location:" . $_ENV['BCPATH'] . "/serviceworker/update");
                exit();
             }
            }
    }
    ?>
