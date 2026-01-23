<?php
/**
 * This class contains public static functions related to insert customer
 *
 * @package         MInsertCustomers
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright      Copyright (c) 2020 - 2021, Sunsofty.
 * @version         Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact Plan@alphabettechs.com.
*****************************************************************************/
?>
<?php
namespace Admin\App\Models\CustomerManager;

use Admin\App\Models\Middleware\MCryptoGraphy;
use Admin\App\Models\Middleware\MMemberDetails;
use Admin\App\Models\Middleware\MSiteDetails;
use Admin\App\Models\Middleware\MUserNotifyStatus;

class MInsertCustomers {
        //start: get user post variable
    public static function insertCustomers() {

            $customers_username = $_POST['txtusername'];
            $customers_password = $_POST['txtpassword'];
            $customers_password_crypt = MCryptoGraphy::encryptionData(trim($_POST['txtpassword']));
            $repassword = $_POST['txtrepassword'];
            $customers_email = $_POST['members_email'];
            $customers_firstname = $_POST['txtfirstname'];
            $customers_lastname = $_POST['txtlastname'];
            $customers_address = $_POST['txtaddress'];
            $customers_country = $_POST['members_country'];
            $customers_zip = $_POST['txtzipcode'];
            $customers_phone=trim($_POST['members_temp_phone_dial']).trim($_POST['phone']);
            $customers_state = $_POST['members_state'];
            $customers_city = $_POST['members_city'];
            $customers_ip_address = $_SERVER['REMOTE_ADDR'];
            $sponsor_username = trim($_POST['sponsor_id']);
            $customers_alternate_email = $_POST['alternate_email'];
            $customers_address3 = $_POST['members_address3'];
            $customers_address2 = $_POST['members_address2'];
            $shipname = $_POST['shipname'];
            $shipaddress = $_POST['shipaddress'];
            $shipaddress2 = $_POST['shipaddress2'];
            $shipaddress3 = $_POST['shipaddress3'];
            $shipstate = $_POST['shipstate'];
            $shipcity = $_POST['shipcity'];
            $shipzipcode = $_POST['shipzipcode'];
            $ship =$_POST['ship'];
            if($_POST['shipcountry']==''){
                $shipcountry=$customers_country;
                $shipphone=$customers_phone;
            }else{
               $shipcountry = $_POST['shipcountry'];
                $shipphone=trim($_POST['ship_members_temp_phone_dial']).trim($_POST['shipphone']);
            }
        //end: get user post variable


       //start: sponsor
          $where = 'WHERE members_id="' . $sponsor_username . '"';
          $sponsor_details = MMemberDetails::getWhereMemberDetails($where);
          $position_direct_id = $sponsor_details[0]['members_id'];
          $sponsor_id = $sponsor_details[0]['members_id'];
          $sponsor_username = $sponsor_details[0]['members_username'];
       //end: sponsor

        //start: insert in userdetails
        $customers_password_crypt = MCryptoGraphy::encryptionData($customers_password);
        $customers_id = MInsertCustomerDetails::insertCustomerDetails($customers_username, $customers_password_crypt, $customers_email,$customers_ip_address, $customers_firstname, $customers_lastname, $customers_state, $customers_city, $customers_address, $customers_address2, $customers_address3, $customers_phone, $customers_zip, $customers_country,  $customers_alternate_email, $customers_password,$sponsor_id,$shipname,$shipaddress,$shipaddress2,$shipaddress3,$shipcountry,$shipstate,$shipcity,$shipzipcode,$shipphone);

         //end: insert in userdetails



                 //start :user notification
                    $where = "WHERE sitesettings_name ='email_notification_user' ";
                    $sitesettings = MSiteDetails::getSiteSettingsDetails($where);
                    $email_notification_user = $sitesettings[0]['sitesettings_value'];
                    $where                   = "WHERE sitesettings_name ='push_notification_admin' ";
                    $sitesettings            = MSiteDetails::getSiteSettingsDetails($where);
                    $push_notification_admin = $sitesettings[0]['sitesettings_value'];
                    $where                   = "WHERE sitesettings_name ='push_notification_user' ";
                    $sitesettings            = MSiteDetails::getSiteSettingsDetails($where);
                    $push_notification_user = $sitesettings[0]['sitesettings_value'];
                    $usermailstatus            = MUserNotifyStatus::usermailStatus($sponsor_id);//check status
                    $usersmsstatus            = MUserNotifyStatus::usersmsStatus($sponsor_id);//check status
                    $userpushstatus            = MUserNotifyStatus::userpushStatus($sponsor_id);//check status
                    if($usermailstatus==0){
                            $sql_check = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "usernotify_meta WHERE user_id= '".$sponsor_id."' AND meta_key IN('notify_via','all_notify','register_notify')";
                            $obj_check = new Bin_Query();
                            $obj_check->executeQuery($sql_check);
                            $records = $obj_check->records;
                            $notify_via= $records[0]['meta_value'];
                            $all_notify= $records[1]['meta_value'];
                            $register_notify =$records[2]['meta_value'];
                            if(($all_notify==1 || $register_notify == 1) && ($notify_via==1 || $notify_via == 4)){
                                $usermailstatus=1;
                            }
                    }
                    if($usersmsstatus==0){
                            $sql_check = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "usernotify_meta WHERE user_id= '".$sponsor_id."' AND meta_key IN('notify_via','all_notify','register_notify')";
                            $obj_check = new Bin_Query();
                            $obj_check->executeQuery($sql_check);
                            $records = $obj_check->records;
                            $notify_via= $records[0]['meta_value'];
                            $all_notify= $records[1]['meta_value'];
                            $register_notify =$records[2]['meta_value'];
                            if(($all_notify==1 || $register_notify == 1) && ($notify_via==2 || $notify_via == 4)){
                                $usersmsstatus=1;
                            }
                    }
                    if($userpushstatus==0){
                            $sql_check = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "usernotify_meta WHERE user_id= '".$sponsor_id."' AND meta_key IN('notify_via','all_notify','register_notify')";
                            $obj_check = new Bin_Query();
                            $obj_check->executeQuery($sql_check);
                            $records = $obj_check->records;
                            $notify_via= $records[0]['meta_value'];
                            $all_notify= $records[1]['meta_value'];
                            $register_notify =$records[2]['meta_value'];
                            if(($all_notify==1 || $register_notify == 1) && ($notify_via==3 || $notify_via == 4)){
                                $userpushstatus=1;
                            }
                    }
                //end :user notification
                //start :Sponsor notification
                    $sponsorname=$sponsor_details['members_username'];
                    $sponsormail=$sponsor_details['members_email'];
                    $sponsor_push=$sponsor_details['push_token'];
                    $sponsor_phone=$sponsor_details['members_phone'];
                    if ($email_notification_user == '1' && $usermailstatus=='1') {
                        $mail_lang  = MUserNotifyStatus::usermailLang($sponsor_id);//check lang

                        $query     = new Bin_Query();
                        $sqlMail   = "SELECT * FROM `" . $_ENV['PROMLM_PREFIX'] . "mailtemplates_table`
                        WHERE `mail_default_name`='downlinenotification_for_new_user'
                        AND mail_status='1' AND mail_lang='" . $mail_lang . "'";
                        $query->executeQuery($sqlMail);
                        $records = $query->records[0];
                        if (count((array)$records) < 0) {
                            $query   = new Bin_Query();
                            $sqlMail = "SELECT * FROM `" . $_ENV['PROMLM_PREFIX'] . "mailtemplates_table`
                            WHERE `mail_default_name`='downlinenotification_for_new_user'
                            AND mail_status='1' AND mail_lang='1'";
                            $query->executeQuery($sqlMail);
                            $records = $query->records[0];
                        }
                        $body     = $records['mail_content'];
                        $admin    = str_replace('[name]', $sponsorname, $body);
                        $username = str_replace('[username]', $customers_username, $admin);
                        $message  = str_replace('[members_email]', $customers_email, $username);
                        MSendMail::sendMail($records, $sponsormail, $message, '', '', $customers_username);

                    }
                    if (strpos(file_get_contents(MAmazonCloudFront::getCloudFrontUrl('uploads/allowmenu.txt')), 'sms') === true && $usersmsstatus=='1') {
                       if ($sponsor_phone != '') {
                            $query = new Bin_Query();
                            $sql1  = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sms_notificaton
                            WHERE notification_defaultname='downline_notification_for_new_user' AND status='1'";
                            $obj1  = new Bin_Query;
                            $obj1->executeQuery($sql1);
                            $notification_message = $obj1->records[0]['notification_message'];
                            $smsmessage = str_replace('[name]', $sponsorname, $notification_message);
                            MSendSms::sendSms($customers_phone, $smsmessage);
                        }
                }
                if ($push_notification_user == '1' && $userpushstatus=='1') {
                        if ($sponsor_push != '') {
                            $query = new Bin_Query();
                            $sql1  = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "push_notificaton
                            WHERE notification_defaultname='downline_notification_for_new_user' AND status='1'";
                            $obj1  = new Bin_Query;
                            $obj1->executeQuery($sql1);
                            $notification_message = $obj1->records[0]['notification_message'];
                            $title = $obj1->records[0]['notification_name'];
                            $smsmessage = str_replace('[name]', $sponsorname, $notification_message);
                            MSendPush::sendPush($sponsor_push,$smsmessage,$title);
                        }

                }
            //end :Sponsor notification


        //for admin adduser
        $url= $_SERVER['REQUEST_URI'];
        if(strpos($url, 'admin')){
            $_SESSION['success_message'] = 'A new customer has been registered successfully.';
            header('Location:' . $_ENV['BCPATH'] . '/customermanager');exit();
        }else if(strpos($url, 'user')){
            $_SESSION['success_message'] = 'A new customer has been registered successfully.';
            header('Location:' . $_ENV['FCPATH'] . '/customers');exit();
        }

    }
}
?>
