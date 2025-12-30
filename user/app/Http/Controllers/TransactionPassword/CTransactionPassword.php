<?php
/**
 * This class contains public static functions related to transaction password
 *
 * @package         CTransactionPassword
 * @category        Controller
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2023, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement: 
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php
use Controller\BaseController;

class Controller_TransactionPassword_CTransactionPassword extends BaseController
{
    /**
     * This public static function is used  to constructor of this class
     *
     */
    public function __construct()
    {
        $output = [];
       if (empty($_SESSION['default']['customer_id'])) {
            header("Location:" . $_ENV['FCPATH'] . "/login");
            exit();
        }
        parent::getSiteDetails();
    }
    /**
     * This public static function is used  to showTransationPassword
     * @return HTML data
     */
    public static function showTransactionPassword()
    {
        try {

            $today   = date('Y-m-d');
            $user_id = $_SESSION['default']['customer_id'];
            Model\TransactionPassword\MTransactionPassword::sendMailOTP();
            $output['totalorders'] = Model\MyProfile\MMyProfile::getTotalOrder($user_id);
            $output['errval']      = count($Err->messages) ? $Err->values : Model\Middleware\MMembersDetails::getUserDetails($user_id);

            Bin_Template::createTemplate('transactionpassword/otpsend.html', $output);
            unset($_SESSION['success_message']);
            unset($_SESSION['error_message']);
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/dashboard");exit();
        }
    }
    /**
     * This public static function is used  to checkTransationOTP
     */
    public static function checkTransactionOTP()
    {
        try {

            Model\TransactionPassword\MTransactionPassword::checkTransactionOTP();
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/dashboard");exit();
        }
    }
    /**
     * This public static function is used  to setTransationPassword
     */
    public static function setTransactionPassword()
    {
        try {

            Model\TransactionPassword\MTransactionPassword::setTransactionPassword();
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/dashboard");exit();
        }
    }
    /**
     * This public static function is used  to changeTransationPassword
     * @return HTML data
     */
    public static function changeTransactionPassword()
    {
        try {

            $today                 = date('Y-m-d');
            $user_id               = $_SESSION['default']['customer_id'];
            $output['totalorders'] = Model\MyProfile\MMyProfile::getTotalOrder($user_id);
            $output['errval']      = count($Err->messages) ? $Err->values : Model\Middleware\MMembersDetails::getUserDetails($user_id);

            Bin_Template::createTemplate('transactionpassword/changetransationpassword.html', $output);
            unset($_SESSION['success_message']);
            unset($_SESSION['error_message']);
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/dashboard");exit();
        }
    }
    /**
     * This public static function is used  to setNewTransationPassword
     */
    public static function setNewTransationPassword()
    {
        try {

            Model\TransactionPassword\MTransactionPassword::setNewTransationPassword();
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/dashboard");exit();
        }
    }
    /**
     * This public static function is used  to setResendOTP
     * @return HTML data
     */
    public static function setResendOTP()
    {
        try {

            $today   = date('Y-m-d');
            $user_id = $_SESSION['default']['customer_id'];
            Model\TransactionPassword\MTransactionPassword::sendMailOTP();
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/dashboard");exit();
        }
    }
    public static function setNewTransactionPassword()
    {
        try {

            Model\TransactionPassword\MTransactionPassword::setNewTransactionPassword();
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/dashboard");exit();
        }
    }
}