<?php

/**
 * This class contains public functions related to database
 *
 * @package         WordPressDiscountGroup
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
use Admin\App\Models\Middleware\MAdminActivityLog;
use Admin\App\Models\Wordpress\MWordPressDiscountGroup;
use Exception;
use Admin\App\Lib\ValidateInputs;

class WordPressDiscountGroupController extends Controller
{

        public static function discountGroup()
        {
            try {

            $output['usergroup'] = MWordPressDiscountGroup::showGroup();

            //Bin_Template::createTemplate('wordpress\wordpressdiscountgroup.html', $output);
           return view('wordpress/wordpressdiscountgroup', $output);
            unset($_SESSION['success_message']);
            unset($_SESSION['error_message']);
            unset($_SESSION['grpid']);
            unset($_SESSION['groupid']);
        }catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("location:" . $_ENV['BCPATH'] . "/wordpressdiscountgroup");
        }
    }

        public static function addGroup()
        {
            try {
            $output = [];

            //Admin Activity Log
           MAdminActivityLog::getAdminActivity('Wordpress - Add Group');
            //Admin Activity Log

            // Bin_Template::createTemplate('wordpress\wordpressdiscountgroupaddgroup.html', $output);
            return view('wordpress/wordpressdiscountgroupaddgroup', $output);
            unset($_SESSION['success_message']);
            unset($_SESSION['error_message']);
        }catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("location:" . $_ENV['BCPATH'] . "/wordpressdiscountgroup/addgroup");
        }
    }

        public static function updateGroup()
        {
            try {


              //Admin Activity Log
             MAdminActivityLog::getAdminActivity('Wordpress - Update Group');
              //Admin Activity Log

           MWordPressDiscountGroup::updateGroup();
            header("Location:" . $_ENV['BCPATH'] . "/wordpressdiscountgroup");
            exit();
        }catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("location:" . $_ENV['BCPATH'] . "/wordpressdiscountgroup/updategroup");
        }
    }

        public static function editGroup()
        {
            try {

            $id = $_GET['sub1'];
             //Admin Activity Log
            MAdminActivityLog::getAdminActivity('Wordpress - Edit Group');
             //Admin Activity Log
            $output['errval'] = MWordPressDiscountGroup::editGroup();
            $output['group_id'] = $id;

            // Bin_Template::createTemplate('wordpress\wordpressdiscountgroupeditgroup.html', $output);
            return view('wordpress/wordpressdiscountgroupeditgroup', $output);
            unset($_SESSION['success_message']);
            unset($_SESSION['error_message']);
        }catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("location:" . $_ENV['BCPATH'] . "/wordpressdiscountgroup/edit");
        }
    }

        public static function editUpdateGroup()
        {
            try {

            // new Lib\ValidateInputs('editgroup');
             //Admin Activity Log
            MAdminActivityLog::getAdminActivity('Wordpress - UpdateEdit Group');
             //Admin Activity Log
           MWordPressDiscountGroup::editUpdateGroup();
            header("Location:" . $_ENV['BCPATH'] . "/wordpressdiscountgroup");
            exit();
        }catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("location:" . $_ENV['BCPATH'] . "/wordpressdiscountgroup/editupdategroup");
        }
    }

        public static function deleteGroup()
        {
            try {

           MAdminActivityLog::getAdminActivity('Wordpress - Delete Group');
            MWordPressDiscountGroup::deleteGroup();
            header("Location:" . $_ENV['BCPATH'] . "/wordpressdiscountgroup");
            exit();
        }catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("location:" . $_ENV['BCPATH'] . "/wordpressdiscountgroup/deletegroup");
        }
    }

        public static function viewUsers()
        {
            try {

            $output['id'] = $_GET['sub1'];
            $output['user_manage'] = MWordPressDiscountGroup::showGroupUsers();

            // Bin_Template::createTemplate('wordpress\wordpressdiscountgroupusersgroup.html', $output);
            return view('wordpress/wordpressdiscountgroupusersgroup', $output);
            unset($_SESSION['success_message']);
            unset($_SESSION['error_message']);
        }catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("location:" . $_ENV['BCPATH'] . "/wordpressdiscountgroup/view");
        }
    }

        public static function showUsers()
        {
            try {

            $output['user_manage'] = MWordPressDiscountGroup::showUsers();

            // Bin_Template::createTemplate('wordpress\wordpressdiscountgroupusers.html', $output);
            return view('wordpress/wordpressdiscountgroupusers', $output);
            unset($_SESSION['success_message']);
            unset($_SESSION['error_message']);
        }catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("location:" . $_ENV['BCPATH'] . "/wordpressdiscountgroup/showusers");
        }
    }

        public static function usersAddGroup()
        {
            try {
           $output = [];

            $a = '';
            if (isset($_POST)) {
                foreach ($_POST['groupid'] as $key => $val) {
                    $a .= $val;
                    $a .= ',';
                }
                $_SESSION['grpid'] = $a;
            }
            if (isset($_SESSION['groupid'])) {
                header("Location:" . $_ENV['BCPATH'] . "/wordpressdiscountgroup/usersupdategroup");
                exit();
            } else {

 //Admin Activity Log
MAdminActivityLog::getAdminActivity('DiscountGroup - Add usersAddGroup');
 //Admin Activity Log


                return view('wordpress\usersaddgroup.html', $output);
            }
            unset($_SESSION['success_message']);
            unset($_SESSION['error_message']);
        }catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("location:" . $_ENV['BCPATH'] . "/wordpressdiscountgroup/usersaddgroup");
        }
    }

        public static function usersUpdateGroup()
        {
            try {

            if (!isset($_SESSION['groupid'])) {
                new ValidateInputs('usersaddgroup');
            }
            MWordPressDiscountGroup::usersUpdateGroup();
            header("Location:" . $_ENV['BCPATH'] . "/wordpressdiscountgroup");
            exit();
        }catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("location:" . $_ENV['BCPATH'] . "/wordpressdiscountgroup/usersupdategroup");
        }
    }

        public static function addUsers()
        {
            try {
            $id = $_GET['sub1'];
            $_SESSION['groupid'] = $id;
            header("Location:" . $_ENV['BCPATH'] . "/wordpressdiscountgroup/showusers");
            exit();
        }catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("location:" . $_ENV['BCPATH'] . "/wordpressdiscountgroup/addusers");
        }
    }

        public static function checkGroupName()
        {
            try {
           MWordPressDiscountGroup::checkGroupName();
        }catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("location:" . $_ENV['BCPATH'] . "/wordpressdiscountgroup/checkgroupname");
        }
    }
    }
    ?>
