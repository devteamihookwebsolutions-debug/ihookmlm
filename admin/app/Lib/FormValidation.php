<?php

/**
 * This class contains public functions related to FormValidation
 *
 * @package         FormValidation
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

use Admin\App\Models\Middleware\MSiteDetails;
use Lib\Validation\Handler as ExceptionHandler;


class FormValidation extends ExceptionHandler
{
    public $nullmessage;
    public $urlmessage;
    public $emailmessage;
    public $spcharmessage;
    public $imagemessage;
    public $numbermessage;
    public $limitmessage;
    public $duplicatemessage;
    public $formatmessage;
    public $alphamessage;
    public $optionmessage;
    public $uploadmessage;
    public function __construct($form)
    {

        $this->nullmessage    = __('This field is required');
        $this->emailmessage   = __('Invalid Email');


        ($form == 'validatelogin') ? $this->validateLogin() : '';
        ($form == 'forgotpassword') ? $this->validateForgotPassword() : '';
        ($form == 'profilesettings') ? $this->validateProfileSettings() : '';
        ($form == 'changepassword') ? $this->validateChangePassword() : '';
        ($form == 'detect') ? $this->validateDetect() : '';
    }
    public function isValidEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
    public function isValidURL($url)
    {
        return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
    }
    public function checkMaxLength($name, $val, $maxlen)
    {
        if (strlen($val) > $maxlen) {
            return false;
        } else {
            return true;
        }
    }
    public function checkMinLength($name, $val, $minlen)
    {
        if (strlen($val) < $minlen) {
            return false;
        } else {
            return true;
        }
    }
    //validation for Numbers ie., if input is like 12345success it is effective
    public function validateNumber($str)
    {
        $flag      = 0;
        $str_array = str_split($str, 1);
        foreach ($str_array as $value) {
            if (!is_numeric($value)) {
                $flag++;
            }
        }
        if ($flag > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function priceCheck($value)
    {
        $len = strlen($value);
        for ($i = 0; $i < $len; $i++) {
            $a = ord($value[$i]);
            if (!(($a >= 48 and $a <= 57) or ($a == 46))) {
                return 0;
            }
        }
        return 1;
    }
    public function numericCheck($value)
    {
        $len = strlen($value);
        for ($i = 0; $i < $len; $i++) {
            $a = ord($value[$i]);
            if (!($a >= 48 and $a <= 57)) {
                return 0;
            }
        }
        return 1;
    }
    public function validateLoginold()
    {
        $currentDateTime = date('Y-m-d H:i:s');
        $ipAddress       = $_SERVER['REMOTE_ADDR'];
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
            $ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
        }

        if (isset($_POST['remember'])) {
            setcookie("login_user_email", $_POST['admin_name'], time() + (86400 * 30), "/"); // 30 days
            setcookie("login_user_password", $_POST['admin_password'], time() + (86400 * 30), "/"); // 30 days
        } else {
            setcookie("login_user_email", "", time() - 3600, "/"); // Remove cookie if unchecked
            setcookie("login_user_password", "", time() - 3600, "/"); // Remove cookie if unchecked
        }

        $loginattempt = new Bin_Query();
        $attempt_sql  = "select * from " . $_ENV['PROMLM_PREFIX'] . "login_attempts where  attempt_IP = '" . $ipAddress . "'";
        $loginattempt->executeQuery($attempt_sql);
        $attemptrecord   = $loginattempt->records;
        $attemptcount    = $attemptrecord[0]['attemptcount'];
        $attemptdatetime = $attemptrecord[0]['attemptdatetime'];
        if (count((array)$attemptrecord) == 0) {
            // $insert_attempt    = new Bin_Query();
            // $insertattempt_sql = "INSERT INTO `" . $_ENV['PROMLM_PREFIX'] . "login_attempts` (`attempt_IP`,`attemptdatetime`,`attemptcount`)
            //  VALUES ('" . $ipAddress . "','" . $currentDateTime . "','0')";
            // $insert_attempt->updateQuery($insertattempt_sql);
        } else {
            // if ($attemptdatetime != "0000-00-00 00:00:00" && $attemptcount > 4) {
            //     $to_time      = strtotime($currentDateTime);
            //     $from_time    = strtotime($attemptdatetime);
            //     $totalminutes = round(abs($to_time - $from_time) / 60, 2);
            //     if ($totalminutes > 15) {
            //         $sqlUpdate1 = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "login_attempts
            //         SET attemptcount='0', attemptdatetime='" . $currentDateTime . "'
            //         WHERE attempt_IP='" . $ipAddress . "'";
            //         $qryUpdate1 = new Bin_Query();
            //         $qryUpdate1->updateQuery($sqlUpdate1);
            //     } else {
            //         $_SESSION['error_message'] = MText::getWords('YOUR_IP_BLOCKED_TRY_AFTER_15_MINUTES');
            //         header('Location:' . $_ENV['BCPATH'] . '/adminlogin');
            //         exit();
            //     }
            // } else {
            //     $attemptcount_plusone = $attemptcount + 1;
            //     $sqlUpdate1           = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "login_attempts
            //     SET attemptcount=" . $attemptcount_plusone . " WHERE attempt_IP='" . $ipAddress . "'";
            //     $qryUpdate1           = new Bin_Query();
            //     $qryUpdate1->updateQuery($sqlUpdate1);
            // }
        }

        /*validate code ends*/
        $getUser = new Bin_Query();
        $this->Assign("admin_name", trim($_POST["admin_name"]), "noempty", $this->nullmessage);
        $this->Assign("admin_password", trim($_POST["admin_password"]), "noempty", $this->nullmessage);
        if (!empty($_POST["admin_name"]) && !empty($_POST["admin_password"])) {
            $where                 = "WHERE sitesettings_name ='google_captcha_status' ";
            $sitesettings          = MSiteDetails::getSiteSettingsDetails($where);
            $google_captcha_status = $sitesettings[0]['sitesettings_value'];
            $where                 = "WHERE sitesettings_name ='google_secret_key' ";
            $sitesettings          = MSiteDetails::getSiteSettingsDetails($where);
            $secret_key            = $sitesettings[0]['sitesettings_value'];
            if (isset($_POST['g-recaptcha-response'])) {
                if ($secret_key != '') {
                    if ($_POST['g-recaptcha-response'] == '') {
                        $this->Assign("g-recaptcha-response", $_POST['g-recaptcha-response'], "noempty", "Captcha -" . $this->nullmessage);
                    } else {
                        $recaptchaResponse = $_POST['g-recaptcha-response'];
                        $url               = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret_key . "&response=" . $recaptchaResponse . "";
                        $response          = file_get_contents($url);
                        $status            = json_decode($response, true);
                        if ($status['success']) {
                            // echo "working";
                        } else {
                            $this->Assign("errmsg", "", "noempty", __('Enter captha code'));
                        }
                    }
                }
            }


            if (isset($_POST['seccode'])) {
                if (trim($_POST['seccode']) == '') {
                    $this->Assign("seccode", "", "noempty", $this->nullmessage);
                }
                if (trim($_POST['seccode']) != '') {


                    if (trim($_POST['usercapchacode']) != trim($_POST['seccode'])) {
                        $this->Assign("seccode", "", "noempty", __('Enter captha code'));
                    }
                }
            }



            $querycon = new Bin_Query();
            $link     = $querycon->getConnection();
            $getUser = new Bin_Query();
            $sql_user = "SELECT * FROM `" . $_ENV['PROMLM_PREFIX'] . "admin_table` WHERE `admin_username` = '" . mysqli_real_escape_string($link, trim($_POST["admin_name"])) . "'  AND `admin_status`='enable'";
            if (!$getUser->executeQuery($sql_user)) {
                $this->Assign("errmsg", "", "noempty", __('Invalid username and password'));
            } else {
                $adminpassword = trim($getUser->records[0]['admin_password']);
                if (!sodium_crypto_pwhash_str_verify($adminpassword, trim($_POST["admin_password"]))) {
                    $this->Assign("errmsg", "", "noempty", __('Invalid username and password'));
                } else {

                    if (!isset($_SESSION['adminotp'])) {
                        $query = new Bin_Query();
                        $sql = "UPDATE `".$_ENV['PROMLM_PREFIX']."admin_table` SET admin_otp='' WHERE admin_id=".$getUser->records[0]['admin_id']."";
                        $query->updateQuery($sql);
                    }
                    $_SESSION['adminotp'] = array(
                        "id" => $getUser->records[0]['admin_id'],
                        "admin_mail" => $getUser->records[0]['admin_email']
                    );
                    //master admin
                    $_SESSION['master_admin']['status'] = $getUser->records[0]['master_admin'] ;
                    //allowurlend
                    $queadmincont      = "SELECT * FROM  " . $_ENV['PROMLM_PREFIX'] . "admin_table
                    WHERE admin_id='" . $getUser->records[0]['admin_id'] . "'";
                    $qryadmin          = new Bin_Query();
                    $qryadmin->executeQuery($queadmincont);
                    $accesscontrol                = $qryadmin->records;
                    $_SESSION['allaccesscontrol'] = $accesscontrol[0]['allaccess_control'];
                    $querr                        = "SELECT * FROM  " . $_ENV['PROMLM_PREFIX'] . "subadmin_link_table
                    WHERE subadmin_id='" . $_SESSION['adminotp']['id'] . "'";
                    $qrysubval                    = new Bin_Query();
                    $qrysubval->executeQuery($querr);
                    $rownotification = $qrysubval->records[0];
                    $secenable       = $rownotification['accesscontrol_id'];
                    $variable        = explode(',', $secenable);
                    $sriill          = array();
                    for ($i = 0; $i < count($variable); $i++) {
                        if ($variable[$i] > 0) {
                            $subpriill = array();
                            $querche   = "SELECT * FROM  " . $_ENV['PROMLM_PREFIX'] . "subadmintablemenu_table
                        WHERE subadmin_id='" . $variable[$i] . "'";
                            $qrysubche = new Bin_Query();
                            $qrysubche->executeQuery($querche);
                            $row            = $qrysubche->records[0];
                            $rowcheck       = $row['subadmin_doname'];
                            $parent_menu_id = $row['parent_menu_id'];
                            if ($parent_menu_id == '0') {
                                $rowcheckpar = $row['default_menu_name'];
                            } else { //parent
                                $subpriillpar = array();
                                $querchepar   = "SELECT * FROM  " . $_ENV['PROMLM_PREFIX'] . "subadmintablemenu_table
                            WHERE parent_menu_id='" . $parent_menu_id . "'";
                                $qrysubchepar = new Bin_Query();
                                $qrysubchepar->executeQuery($querchepar);
                                $rowpar      = $qrysubchepar->records[0];
                                $rowcheckpar = $rowpar['default_menu_name'];
                            }
                            if ($rowcheck != '') {
                                $subadmin_donames = explode(',', $rowcheck);
                                foreach ($subadmin_donames as $subadmin_doname) {
                                    $sriill[$subadmin_doname] = 1;
                                }
                                $sriill[$rowcheck] = 1;
                            }
                            if ($rowcheckpar != '') {
                                $sriill[$rowcheckpar] = 1;
                            }
                        }
                    }


                    $_SESSION['subadminprivill']  = $sriill;
                    $_SESSION['accesscontrol_id'] = trim($secenable);

                }
            }
        }
        $this->PerformValidation('' .$_ENV['BCPATH']. '/adminlogin');
    }

     function validateLogin()
    {
//         echo '<pre>';
// print_r($_POST);
// print_r($_COOKIE);
// exit;
        $currentDateTime = date('Y-m-d H:i:s');
        //$ipAddress       = $_SERVER['REMOTE_ADDR'];
       if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $forwardedFor = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
    $ipAddress = trim(end($forwardedFor));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['remember'])  && $_POST['remember'] == '1') {
           //  echo '<pre>';print_r($_POST);exit;
            setcookie("login_user_email", trim($_POST['admin_name']), time() + (86400 * 30), "/"); // 30 days
            setcookie("login_user_password", trim($_POST['admin_password']), time() + (86400 * 30), "/"); // 30 days
        } else {

            setcookie("login_user_email", "", time() - 3600, "/"); // Remove cookie if unchecked
            setcookie("login_user_password", "", time() - 3600, "/"); // Remove cookie if unchecked
        }
    }

        $loginattempt = new Bin_Query();
        $attempt_sql  = "select * from " . $_ENV['PROMLM_PREFIX'] . "login_attempts where  attempt_IP = '" . $ipAddress . "'";
        $loginattempt->executeQuery($attempt_sql);
        $attemptrecord   = $loginattempt->records;
        $attemptcount    = $attemptrecord[0]['attemptcount'];
        $attemptdatetime = $attemptrecord[0]['attemptdatetime'];
        if (count((array)$attemptrecord) == 0) {
            // $insert_attempt    = new Bin_Query();
            // $insertattempt_sql = "INSERT INTO `" . $_ENV['PROMLM_PREFIX'] . "login_attempt` (`attempt_IP`,`attemptdatetime`,`attemptcount`)
            //  VALUES ('" . $ipAddress . "','" . $currentDateTime . "','0')";
            // $insert_attempt->updateQuery($insertattempt_sql);
        } else {
            // if ($attemptdatetime != "0000-00-00 00:00:00" && $attemptcount > 4) {
            //     $to_time      = strtotime($currentDateTime);
            //     $from_time    = strtotime($attemptdatetime);
            //     $totalminutes = round(abs($to_time - $from_time) / 60, 2);
            //     if ($totalminutes > 15) {
            //         $sqlUpdate1 = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "login_attempt
            //         SET attemptcount='0', attemptdatetime='" . $currentDateTime . "'
            //         WHERE attempt_IP='" . $ipAddress . "'";
            //         $qryUpdate1 = new Bin_Query();
            //         $qryUpdate1->updateQuery($sqlUpdate1);
            //     } else {
            //         $_SESSION['error_message'] = MText::getWords('YOUR_IP_BLOCKED_TRY_AFTER_15_MINUTES');
            //         header('Location:' . $_ENV['BCPATH'] . '/adminlogin');
            //         exit();
            //     }
            // } else {
            //     $attemptcount_plusone = $attemptcount + 1;
            //     $sqlUpdate1           = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "login_attempt
            //     SET attemptcount=" . $attemptcount_plusone . " WHERE attempt_IP='" . $ipAddress . "'";
            //     $qryUpdate1           = new Bin_Query();
            //     $qryUpdate1->updateQuery($sqlUpdate1);
            // }
        }

        /*validate code ends*/
        $getUser = new Bin_Query();
        $this->Assign("admin_name", trim($_POST["admin_name"]), "noempty", $this->nullmessage);
        $this->Assign("admin_password", trim($_POST["admin_password"]), "noempty", $this->nullmessage);
        if (!empty($_POST["admin_name"]) && !empty($_POST["admin_password"])) {
            $where                 = "WHERE sitesettings_name ='google_captcha_status' ";
            $sitesettings          = MSiteDetails::getSiteSettingsDetails($where);
            $google_captcha_status = $sitesettings[0]['sitesettings_value'];
            $where                 = "WHERE sitesettings_name ='google_secret_key' ";
            $sitesettings          = MSiteDetails::getSiteSettingsDetails($where);
            $secret_key            = $sitesettings[0]['sitesettings_value'];
            if (isset($_POST['g-recaptcha-response'])) {
                if ($secret_key != '') {
                    if ($_POST['g-recaptcha-response'] == '') {
                        $this->Assign("g-recaptcha-response", $_POST['g-recaptcha-response'], "noempty", "Captcha -" . $this->nullmessage);
                    } else {
                        $recaptchaResponse = $_POST['g-recaptcha-response'];
                        $url               = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret_key . "&response=" . $recaptchaResponse . "";
                        $response          = file_get_contents($url);
                        $status            = json_decode($response, true);
                        if ($status['success']) {
                            // echo "working";
                        } else {
                            $this->Assign("errmsg", "", "noempty", __('Enter captha code'));
                        }
                    }
                }
            }


            if (isset($_POST['seccode'])) {
                if (trim($_POST['seccode']) == '') {
                    $this->Assign("seccode", "", "noempty", $this->nullmessage);
                }
                if (trim($_POST['seccode']) != '') {


                    if(trim($_POST['usercapchacode'])!=trim($_POST['seccode'])) {
                        $this->Assign("seccode", "", "noempty", __('Enter captha code'));
                    }
                }
            }



            $querycon = new Bin_Query();
            $link     = $querycon->getConnection();
            $getUser=new Bin_Query();
            $sql_user = "SELECT * FROM `" . $_ENV['PROMLM_PREFIX'] . "admin_table` WHERE `admin_username` = '" . mysqli_real_escape_string($link, trim($_POST["admin_name"])) . "'  AND `admin_status`='enable'";
            if (!$getUser->executeQuery($sql_user)) {
                $this->Assign("errmsg", "", "noempty",__('Invalid username and password'));
            } else {
                 $adminpassword = trim($getUser->records[0]['admin_password']);
                if (!sodium_crypto_pwhash_str_verify($adminpassword, trim($_POST["admin_password"]))) {
                    $this->Assign("errmsg", "", "noempty", __('Invalid username and password'));
                } else {

                    if(!isset($_SESSION['adminotp'])){
                        $query = new Bin_Query();
                        $sql = "UPDATE `".$_ENV['PROMLM_PREFIX']."admin_table` SET admin_otp='' WHERE admin_id=".$getUser->records[0]['admin_id']."";
                        $query->updateQuery($sql);
                    }
                    $_SESSION['adminotp'] = array(
                        "id" => $getUser->records[0]['admin_id'],
                        "admin_mail" => $getUser->records[0]['admin_email']
                    );
                    //master admin
                     $_SESSION['master_admin']['status']= $getUser->records[0]['master_admin'] ;
                    //allowurlend
                    $queadmincont      = "SELECT * FROM  " . $_ENV['PROMLM_PREFIX'] . "admin_table
                    WHERE admin_id='" . $getUser->records[0]['admin_id'] . "'";
                    $qryadmin          = new Bin_Query();
                    $qryadmin->executeQuery($queadmincont);
                    $accesscontrol                = $qryadmin->records;
                    $_SESSION['allaccesscontrol'] = $accesscontrol[0]['allaccess_control'];
                    $querr                        = "SELECT * FROM  " . $_ENV['PROMLM_PREFIX'] . "subadmin_link_table
                    WHERE subadmin_id='" . $_SESSION['adminotp']['id'] . "'";
                    $qrysubval                    = new Bin_Query();
                    $qrysubval->executeQuery($querr);
                    $rownotification = $qrysubval->records[0];
                    $secenable       = $rownotification['accesscontrol_id'];
                    $variable        = explode(',', $secenable);
                    $sriill          = array();
                    for ($i = 0; $i < count($variable); $i++) {
                        if ($variable[$i] > 0) {
                            $subpriill = array();
                              $querche   = "SELECT * FROM  " . $_ENV['PROMLM_PREFIX'] . "subadmintablemenu_table
                        WHERE subadmin_id='" . $variable[$i] . "'";
                            $qrysubche = new Bin_Query();
                            $qrysubche->executeQuery($querche);
                            $row            = $qrysubche->records[0];
                            $rowcheck       = $row['subadmin_doname'];
                            $parent_menu_id = $row['parent_menu_id'];
                            if ($parent_menu_id == '0') {
                                $rowcheckpar = $row['default_menu_name'];
                            } else { //parent
                                $subpriillpar = array();
                                     $querchepar   = "SELECT * FROM  " . $_ENV['PROMLM_PREFIX'] . "subadmintablemenu_table
                            WHERE parent_menu_id='" . $parent_menu_id . "'";
                                $qrysubchepar = new Bin_Query();
                                $qrysubchepar->executeQuery($querchepar);
                                $rowpar      = $qrysubchepar->records[0];
                                $rowcheckpar = $rowpar['default_menu_name'];
                            }
                            if ($rowcheck != '') {
                                $subadmin_donames = explode(',', $rowcheck);
                                foreach ($subadmin_donames as $subadmin_doname) {
                                    $sriill[$subadmin_doname] = 1;
                                }
                                $sriill[$rowcheck] = 1;
                            }
                            if ($rowcheckpar != '') {
                                $sriill[$rowcheckpar] = 1;
                            }
                        }
                    }


                    $_SESSION['subadminprivill']  = $sriill;
                    $_SESSION['accesscontrol_id'] = trim($secenable);

                }
            }
        }
        $this->PerformValidation('' .$_ENV['BCPATH']. '/adminlogin');
    }
    public function validateForgotPassword()
    {
        if ($_POST['admin_email'] != '' && $this->isValidEmail(trim($_POST["admin_email"]))) {
            $query      = new Bin_Query();
            $link       = $query->getConnection();
            $sqlCheck   = "SELECT COUNT(*) AS CHECKNUM FROM " . $_ENV['PROMLM_PREFIX'] . "admin_table
                     WHERE admin_email = '" . mysqli_real_escape_string($link, trim($_POST['admin_email'])) . "'  ";
            $queryCheck = new Bin_Query();
            $queryCheck->executeQuery($sqlCheck);
            $recordscount = $queryCheck->records[0]['CHECKNUM'];
            if ($recordscount == 0) {
                $this->Assign("admin_email", "", "noempty", __('Invalid email'));
            }
        }
        $this->PerformValidation('' .$_ENV['BCPATH']. '/forgotpassword');
    }
    public function validateProfileSettings()
    {
        //otp checking
        $this->Assign("otpvalid", trim($_POST['otpvalid']), "noempty", __('OTP'));
        if (trim($_POST['otpvalid'] != '')) {
            $objotp = new Bin_Query();
            $sqlotp = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "admin_table WHERE  admin_type = '1'";
            $objotp->executeQuery($sqlotp);
            $recordsadmin = $objotp->records;
            $admin_otpcrypt    = $recordsadmin[0]['admin_otp'];
            if (!sodium_crypto_pwhash_str_verify(trim($admin_otpcrypt), trim($_POST['otpvalid']))) {
                $this->Assign("otpvalid", "", "noempty", __('Invalid OTP'));
            }
        }
        $this->PerformValidation('' . $_ENV['BCPATH'] . '/profile_settings');
    }
    public function validateChangePassword()
    {
        $sql = "SELECT * FROM  " . $_ENV['PROMLM_PREFIX'] . "admin_table WHERE admin_id='" . $_SESSION['admin']['id'] . "'";
        $qry = new Bin_Query();
        $qry->executeQuery($sql);
        $admin_username = $qry->records[0]['admin_username'];
        if (strlen($_POST["newpass"]) <= '8') {
            $this->Assign('newpass', "", "noempty", __('Password must be at least 8 characters long.'));
        } elseif (!preg_match("#[0-9]+#", $_POST["newpass"])) {
            $this->Assign('newpass', "", "noempty", __('Password must include at least one number.'));
        } elseif (!preg_match("#[A-Z]+#", $_POST["newpass"])) {
            $this->Assign('newpass', "", "noempty", __('Password must include at least one uppercase letter.'));
        } elseif (!preg_match("#[a-z]+#", $_POST["newpass"])) {
            $this->Assign('newpass', "", "noempty", __('Password must include at least one lowercase letter.'));
        } elseif (!preg_match("/[\W_]/", $_POST["newpass"])) {
            $this->Assign('newpass', "", "noempty", __('Password must include at least one special character.'));
        } elseif (stristr($_POST["newpass"], $admin_username) !== false) {
            $this->Assign('newpass', "", "noempty", __('Password must not contain your username.'));
        }
        $this->PerformValidation('' . $_ENV['BCPATH'] . '/changepassword');
    }
    public function validateDetect()
    {

        if ($_SESSION['site_settings']['dashboard_type'] == '2') {
            $history_wallet_type = trim($_POST['wallet_type']);
            $currency_id = '1';
            $members_id = trim($_POST['user_list'][0]);
            $balance_amount         = MCryptoWalletBalance::getWalletCurrentBalance($members_id, $history_wallet_type, $currency_id);
        } else {
            $history_wallet_type = trim($_POST['wallet_type']);
            $members_id = trim($_POST['user_list'][0]);
            $balance_amount      = MWalletBalance::getWalletCurrentBalance($members_id, $history_wallet_type);
        }

        $this->Assign("user_list", $_POST['user_list'], "noempty", $this->nullmessage);
        if ($balance_amount < trim($_POST['amount']) && $_POST['amount'] != '') {
            $this->Assign("amount", "", "noempty", 'Current balance'.$balance_amount);
        }
        $this->Assign("amount", $_POST['amount'], "nostring", $this->numbermessage);
        $this->Assign("memo", $_POST['memo'], "noempty", $this->nullmessage);
        $this->PerformValidation("" . $_ENV['BCPATH'] . "/detect");
    }
}
