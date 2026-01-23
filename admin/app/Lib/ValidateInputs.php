<?php

/**
 * This class contains public functions related to ValidateInputs
 *
 * @package         ValidateInputs
 * @category        Lib
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace Admin\App\Lib;

class ValidateInputs {
    function __construct($module) {
        ($module == 'validatelogin') ? $this->validateLogin() : '';
        ($module == 'forgotpassword') ? $this->validateForgotPassword() : '';
        ($module == 'profilesettings') ? $this->validateProfileSettings() : "";
        ($module == 'changepassword') ? $this->validateChangePassword() : '';
        ($module == 'detect') ? $this->validateDetect() : '';
    }
    public static function validateLogin() {

        if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
            if ($_POST['admin_name'] != '' or $_POST['admin_password'] != '' or $_POST['admin_name'] == '' or $_POST['admin_password'] == '') {
                $obj = new FormValidation('validatelogin');
            } else {
                header("Location:" .$_ENV['BCPATH']. "/index");
                exit();
            }
        }
    }
   public static function validateForgotPassword() {

        if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
            $obj = new FormValidation('forgotpassword');
        } else {
            header("Location:" . $_ENV['BCPATH'] . "/forgotpassword");
            exit();
        }
    }
   public static function validateProfileSettings() {

        if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
            if (isset($_POST)) {
                $obj = new FormValidation('profilesettings');
            } else {
                header("Location:" . $_ENV['BCPATH'] . "/profile_settings");
                exit();
            }
        }
    }
   public static function validateChangePassword() {

        if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
            if (isset($_POST['oldpass']) and isset($_POST['newpass']) and isset($_POST['confirmpass'])) {
                $obj = new FormValidation('changepassword');
            }
        } else {
            header("location:" . $_ENV['BCPATH'] . "/changepassword");
            exit();
        }
    }
   public static function validateDetect() {

        if (strtolower($_SERVER['REQUEST_METHOD']) == "post") {
            if (isset($_POST)) {
                $obj = new FormValidation('detect');
            } else {
                header("location:" . $_ENV['BCPATH'] . "/detect");
                exit();
            }
        }
    }
}
?>
