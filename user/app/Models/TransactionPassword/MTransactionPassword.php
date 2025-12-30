<?php
/**
 * This class contains public static functions related to transaction password
 * @package         MTransactionPassword
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php
namespace Model\TransactionPassword;
use Query\Bin_Query;

use Model\Middleware\MSendMail;
use Model\Middleware\MCryptoGraphy;
use Model\Middleware\MMemberDetails;
use Model\Middleware\MURLCrypt;
class MTransactionPassword
{
     /**
     * This public static function is used  to sendMailOTP
     */
    public static function sendMailOTP()
    {
        $user_id                                          = $_SESSION['default']['customer_id'];
        $members_details                                  =  MMemberDetails::getUserDetails($user_id);
        $members_email                                    = $members_details['members_email'];
        $otpnumber                                        = rand(1, 1000000);
        $useroptcry = MCryptoGraphy::encryptionData($otpnumber);
        $sqlupdate  = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "members_table SET user_otp='".$useroptcry."' WHERE members_id='". $user_id ."'";
        $objupdate  = new Bin_Query();
        $objupdate->updateQuery($sqlupdate);
        /*send email*/
        $mail_lang                                        = trim($_SESSION['sitelang_id']);
        $query                                            = new Bin_Query();
        $sqlMail                                          = "SELECT * FROM `" . $_ENV['PROMLM_PREFIX'] . "mailtemplates_table`
                WHERE `mail_default_name`='mail_send_otp'
                AND mail_status='1' AND mail_lang='" . $mail_lang . "'";
        $query->executeQuery($sqlMail);
        $recordsmail = $query->records[0];
        if (count((array)$records) < 0) {
            $query   = new Bin_Query();
            $sqlMail = "SELECT * FROM `" . $_ENV['PROMLM_PREFIX'] . "mailtemplates_table`
                    WHERE `mail_default_name`='mail_send_otp'
                    AND mail_status='1' AND mail_lang='1'";
            $query->executeQuery($sqlMail);
            $recordsmail = $query->records[0];
        }
        $body    = $recordsmail['mail_content'];
        $message = str_replace('[otp]', $otpnumber, $body);
        $mailval = MSendMail::sendMail($recordsmail, $members_email, $message, '', '', '');
        /*end send email*/
        echo true;exit;
    }
     /**
     * This public static function is used  to checkTransactionOTP
     */
    public static function checkTransactionOTP()
    {

        $user_id   = $_SESSION['default']['customer_id'];
        $sql = "SELECT user_otp FROM " . $_ENV['PROMLM_PREFIX'] . "members_table WHERE members_id='". $members_id ."'";
            $qry = new Bin_Query();
            $qry->executeQuery($sql);
            $user_otp = $qry->records[0]['user_otp'];
            $loginkey  = trim($_POST['otp']);
        if (sodium_crypto_pwhash_str_verify(trim($user_otp), $loginkey)) {
            echo '1';
        } else {
            echo '0';
        }
    }
     /**
     * This public static function is used  to setTransactionPassword
     */
    public static function setTransactionPassword()
    {
        $members_id   = $_SESSION['default']['customer_id'];
        $sql = "SELECT user_otp FROM " . $_ENV['PROMLM_PREFIX'] . "members_table WHERE members_id='". $members_id ."'";
            $qry = new Bin_Query();
            $qry->executeQuery($sql);
            $user_otp = $qry->records[0]['user_otp'];
           $loginkey  = trim($_POST['otp']);
        if (sodium_crypto_pwhash_str_verify(trim($user_otp), $loginkey)) {
            echo '1';
        } else {
            echo '0';
        }
    }
     /**
     * This public static function is used  to setNewTransactionPassword
     */
    public static function setNewTransactionPassword()
    {
        $members_id                   = $_SESSION['default']['customer_id'];
        $members_transaction_password = trim($_POST['transactionvalue']);
        $members_transaction_password = MCryptoGraphy::encryptionData($members_transaction_password);
        $obj                          = new Bin_Query();
        $sql                          = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "members_table SET
            members_transaction_password   ='" . $members_transaction_password . "',
            updated_on                     =NOW()
            WHERE members_id               ='" . $members_id . "'";
        if ($obj->updateQuery($sql)) {
            UNSET($_SESSION['error_message']);
            $_SESSION['success_message'] = '' . __('Transaction Password has been updated successfully') . '';
            header('Location:' .$_ENV['FCPATH'] . '/myprofile');
            exit();
        } else {
            throw new Exception("" . __('Transaction Password has not been updated') . "");
        }
    }
}
?>
