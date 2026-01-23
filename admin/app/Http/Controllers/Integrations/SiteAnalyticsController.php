<?php

/**
 * This class contains public functions related to SiteAnalyticsController
 *
 * @package         SiteAnalyticsController
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
    class Controller_Integrations_CSiteAnalytics
    {
        var $output = array();
        /**
         * This public function is used  to constructor of this class
         */
        public function __construct()
        {

            $output = array();
            if (empty($_SESSION['admin']['id'])) {
                header('Location:' . $_ENV['BCPATH'] . '/adminlogin');
                exit();
            }
            Model\Grants\MPrevillage::getPrevillage();
        }
        /**
         * This publicstatic  function is used  to show third party integration  page
         * @return HTML data
         */
        public static function showSiteAnalytics()
        {
            try{

            $token_auth = Model\Integrations\MSiteAnalytics::getMatomaUserToken();
            $output['matomopanel'] = $_ENV['BASEPATH'] . '/matomo/index.php?date=today&module=CoreHome&action=index&page=0&idSite=1&token_auth=' . $token_auth . '&period=day#?idSite=1&period=day&date=today&category=Dashboard_Dashboard&subcategory=1';




            Bin_Template::createTemplate('integrations/siteanalytics.html', $output);
            unset($_SESSION['success_message']);
            unset($_SESSION['error_message']);
        }catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("location:" . $_ENV['BCPATH'] . "/siteanalytics");
                exit();
             }
            }
    }
    ?>
