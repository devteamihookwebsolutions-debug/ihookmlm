<?php

/**
 * This class contains public static functions related to profile
 *
 * @package         MMyProfile
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

namespace Model\Profile;

use Model\Middleware\MAmazonS3;
use Model\Middleware\MCryptoGraphy;
use Model\Middleware\MTwoFactor;
use Query\Bin_Query;
use Display\Profile\DMyProfile;
use DateTimeZone;
use Model\Middleware\MAmazonS3Ext;

class MMyProfile
{
    /**
     * This public static function is used  to updateMyProfile
     */
    public static function getMembersDetail()
    {

        $members_id = $_SESSION['default']['customer_id'];
        $sql             = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "members_table
        WHERE members_id='" . $members_id . "'";
        $obj             = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records[0];
        return $records;
    }

    public static function updateMyProfile($memberDetail)
    {
        $members_id = $_SESSION['default']['customer_id'];
        $members_firstname = trim($_POST['members_firstname']);
        $members_lastname = trim($_POST['members_lastname']);
        $members_company_name = trim($_POST['members_company_name']);
        $members_phonenumber = trim($_POST['members_phone']);

        $members_phonecon = trim($_POST['members_temp_phone_dial']) . trim($_POST['members_phone']);


        $members_phone = trim($members_phonenumber[0] == '+') ? trim($_POST['members_phone']) : $members_phonecon;


        if ($members_phonenumber == '') {
            $members_phone = trim($_POST['errorphonenumber']);
        }

        $members_email = trim($_POST['members_email']);
        $members_subdomain = trim($_POST['members_subdomain']);
        $members_email2 = trim($_POST['members_email2']);


        $obj = new Bin_Query();
        $sql = "UPDATE " . $_ENV['IHOOK_PREFIX'] . "members_table SET
            members_firstname ='" . $members_firstname . "',
            members_lastname  ='" . $members_lastname . "',
            members_company_name     ='" . $members_company_name . "',
            members_phone     ='" . $members_phone . "',
            members_email     ='" . $members_email . "',
            members_subdomain     ='" . $members_subdomain . "',
            members_alternate_email ='" . $members_email2 . "',
            updated_on        =NOW()
            WHERE members_id='" . $members_id . "'";
        if ($obj->updateQuery($sql)) {
            $_SESSION['success_message'] = CUS_PERSONAL_INFO_UPDATED;
            header('Location:' .$_ENV['FCPATH']. '/myprofile');
            exit();
        } else {
            $_SESSION['error_message'] = CUS_PERSONAL_INFO_NOT_UPDATED;
            header('Location:' .$_ENV['FCPATH']. '/myprofile');
            exit();
        }

    }

    public static function updateContactProfile($memberDetail)
    {
        $members_id = $_SESSION['default']['customer_id'];
        $members_address = trim($_POST['members_address']);
        $members_address2 = trim($_POST['members_address2']);
        $members_country = trim($_POST['members_country']);
        $members_city = trim($_POST['members_city']);
        $members_state = trim($_POST['members_state']);
        $members_zip = trim($_POST['members_zip']);
        $obj = new Bin_Query();
        $sql = "UPDATE " . $_ENV['IHOOK_PREFIX'] . "members_table SET
            members_address ='" . $members_address . "',
            members_address2 ='" . $members_address2 . "',
            members_country  ='" . $members_country . "',
            members_city     ='" . $members_city . "',
            members_state     ='" . $members_state . "',
            members_zip='" . $members_zip . "',
            updated_on        =NOW()
            WHERE members_id='" . $members_id . "'";
        if ($obj->updateQuery($sql)) {
            $_SESSION['success_message'] = CUS_PERSONAL_INFO_UPDATED;
            header('Location:' .$_ENV['FCPATH']. '/myprofile');
            exit();
        } else {
            $_SESSION['error_message'] = CUS_PERSONAL_INFO_NOT_UPDATED;
            header('Location:' .$_ENV['FCPATH']. '/myprofile');
            exit();
        }

    }

    public static function updatePasswordDetail($memberDetail)
    {
        $members_id = $_SESSION['default']['customer_id'];
        $newpassword = trim($memberDetail['newpassword']);
        $members_password = MCryptoGraphy::encryptionData($newpassword);
        $obj = new Bin_Query();
        $sql = "UPDATE " . $_ENV['IHOOK_PREFIX'] . "members_table SET
            members_password   ='" . $members_password . "',
            updated_on         =NOW()
            WHERE members_id   ='" . $members_id . "'";
        if ($obj->updateQuery($sql)) {
            $_SESSION['success_message'] = CUS_PASSWORD_UPDATED_SUCCEFULLY;
            header('Location:' . $_ENV['FCPATH'] . '/myprofile');
            exit();
        } else {
            $_SESSION['error_message'] = CUS_PASSWORD_NOT_UPDATED;
            header('Location:' .$_ENV['FCPATH']. '/myprofile');
            exit();
        }
    }

    public static function update2fa()
    {
        $members_id = $_SESSION['default']['customer_id'];
        $val = $_POST['set'];
        if ($val == '2') {
            $verify = '1';
        } else {
            $verify = '0';
        }
        $obj = new Bin_Query();
        $sql = "UPDATE " . $_ENV['IHOOK_PREFIX'] . "members_table SET
            members_two_fact   ='".$val."',members_login_verification='".$verify."',members_password_verification='".$verify."',gauth_codes=0,
            updated_on         =NOW()
            WHERE members_id   ='" . $members_id . "'";
        if ($obj->updateQuery($sql)) {
            $desc = "Email Authentication set Success";
            MTwoFactor::insertSecurityLog($desc, '2');
            echo 1;
        } else {
            $desc = "Email Authentication set failed";
            MTwoFactor::insertSecurityLog($desc, '2');
            echo 2;
        }exit;
    }

    public static function updateAvatarDetails($member_file, $crop_image)
    {
        $members_id = $_SESSION['default']['customer_id'];
        $members_image_name = $member_file['members_image']['name'];
        $members_image_cropped = $crop_image['members_image_cropped'];
        //cropped imaGE UPLOAD
        if ($crop_image['members_image_cropped'] != '') {
            $img = $crop_image['members_image_cropped'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $ranunie = uniqid();
            $file = '../'.$_ENV['CURRENT_UPATH'].'/shift/'.$ranunie . '.png';
            $success = file_put_contents($file, $data);
            /*start:amazonupload*/
            $amaname       = $ranunie.".png";
            $image = 'uploads/members/' . $amaname;
            MAmazonS3Ext::amazonFileCreationExt($file, 'image/png', $image);
            /*end:amazonupload*/

            $obj = new Bin_Query();
            $sql = "UPDATE " . $_ENV['IHOOK_PREFIX'] . "members_table SET
                        members_image         ='" . $image . "',
                        members_thumb_image   ='" . $image . "',
                        updated_on            =NOW()
                        WHERE members_id='" . $members_id . "'";
            if ($obj->updateQuery($sql)) {
                $_SESSION['members_image'] = $image;
                $_SESSION['success_message'] = CUS_AVATAR_UPDATED_SUCCEFFULLY;
            } else {
                $_SESSION['error_message'] = CUS_AVATAR_NOT_UPDATED;
                header('Location:' .$_ENV['FCPATH']. '/myprofile');
                exit();
            }

        } else {

            if ($members_image_name != '') {
                $imgfilename = $member_file['members_image']['name'];
                $ext = strtolower(substr($imgfilename, strripos($imgfilename, '.') + 1));
                $flnm = hash('sha256', $imgfilename) . '.' . $ext;
                $ranunie = uniqid();
                $amaname       = $ranunie.".png";
                $image = 'uploads/members/' . $amaname;
                MAmazonS3Ext::amazonUploadExt($_FILES['members_image']['name'], $_FILES['members_image']['tmp_name'], $_FILES['members_image']['type'], $image);
                $thumb_image = 'uploads/members/thumb/' . $flnm;
                // print_r($thumb_image);exit;
                MAmazonS3Ext::amazonUploadExt($_FILES['members_image']['name'], $_FILES['members_image']['tmp_name'], $_FILES['members_image']['type'], $thumb_image);
                $obj = new Bin_Query();
                $sql = "UPDATE " . $_ENV['IHOOK_PREFIX'] . "members_table SET
                        members_image         ='" . $image . "',
                        members_thumb_image   ='" . $thumb_image . "',
                        updated_on            =NOW()
                        WHERE members_id='" . $members_id . "'";
                if ($obj->updateQuery($sql)) {
                    $_SESSION['members_image'] = $image;

                    $_SESSION['success_message'] = CUS_AVATAR_UPDATED_SUCCEFFULLY;

                } else {
                    $_SESSION['error_message'] = CUS_AVATAR_NOT_UPDATED;
                    header('Location:' .$_ENV['FCPATH']. '/myprofile');
                    exit();
                }
            }

        }

        header('Location:' . $_ENV['FCPATH'] . '/myprofile');
        exit();
    }

    public static function updateTransPassDetail($memberDetail)
    {
        $members_id = $_SESSION['default']['customer_id'];
        $members_transaction_password = trim($memberDetail['transactionpassword']);
        $members_transaction_password = MCryptoGraphy::encryptionData($members_transaction_password);
        $obj = new Bin_Query();
        $sql = "UPDATE " . $_ENV['IHOOK_PREFIX'] . "members_table SET
            members_transaction_password   ='" . $members_transaction_password . "',
            updated_on                     =NOW()
            WHERE members_id               ='" . $members_id . "'";
        if ($obj->updateQuery($sql)) {
            $_SESSION['success_message'] = CUS_TRANSACTION_PASSWORD_UPDATED_SUCESSFULLY;
            header('Location:' . $_ENV['FCPATH'] . '/myprofile');
            exit();
        } else {
            $_SESSION['error_message'] = CUS_TRANSACTION_PASSWORD_NOT_UPDATED;
            header('Location:' .$_ENV['FCPATH']. '/myprofile');
            exit();
        }
    }

    public static function checkCurrentPassword()
    {

        $sql             = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "members_table
        WHERE members_id='" . $_SESSION['default']['customer_id'] . "'";
        $obj             = new Bin_Query();
        $obj->executeQuery($sql);
        $members_password    = $obj->records[0]['members_password'];
        $currentpassword = trim($_POST['currentpassword']);
        if (sodium_crypto_pwhash_str_verify(trim($members_password), $currentpassword)) {
            echo json_encode(array(
                'valid' => true,
            ));
            exit;
        } else {
            echo json_encode(array(
                'valid' => false,
            ));
            exit;
        }
    }

    public static function checkTransactionPassword()
    {
        $currenttransactionpassword = trim($_POST['currenttransactionpassword']);
        $sql                        = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "members_table
        WHERE members_id='" . $_SESSION['default']['customer_id'] . "'";
        $obj                        = new Bin_Query();
        $obj->executeQuery($sql);
        $members_transaction_password    = $obj->records[0]['members_transaction_password'];
        if (sodium_crypto_pwhash_str_verify(trim($members_transaction_password), $currenttransactionpassword)) {
            echo json_encode(array(
                 'valid' => true,
             ));
            exit;
        } else {
            echo json_encode(array(
                'valid' => false,
            ));
            exit;
        }
    }

    public static function getTotalOrder($user_id)
    {
        $sql   = "SELECT * FROM  " . $_ENV['IHOOK_PREFIX'] . "members_table where members_id ='" . $user_id . "'";
        $query = new Bin_Query();
        $query->executeQuery($sql);
        $records         = $query->records;
        $members_shop_id = $records[0]['members_shop_id'];
        $sql1            = "SELECT a.post_type,a.post_date_gmt,b.meta_value,
            b.meta_key,b.post_id,a.post_status FROM `" . $_ENV['STORE_PREFIX'] . "posts` AS a
            LEFT JOIN   `" . $_ENV['STORE_PREFIX'] . "postmeta` AS b
            ON b.post_id=a.ID WHERE a.post_type='shop_order' AND a.post_status='wc-completed' AND  b.meta_key='_customer_user' AND b.meta_value='" . $members_shop_id . "'";
        $obj             = new Bin_Query();
        $obj->executeQuery($sql1);
        $records = count((array)$obj->records);
        return $records;
    }

    public static function showActivityLogs()
    {
        $user_id = $_SESSION['default']['customer_id'];
        $sql     = "SELECT a.*,b.members_firstname,b.members_lastname FROM  " . $_ENV['IHOOK_PREFIX'] . "members_log_table as a  LEFT JOIN promlm_members_table AS b
            ON a.members_log_members_id = b.members_id
        WHERE a.members_log_members_id = " . $user_id . " LIMIT 5";
        $query   = new Bin_Query();
        $query->executeQuery($sql);
        $records = $query->records;
        return DMyProfile::showActivityLogs($records);
    }

    public static function getUserNewNotification()
    {
        $user_id = $_SESSION['default']['customer_id'];
        /* registeration notification */
        $sql     = "SELECT COUNT(a.members_id) AS notifimembercount FROM " . $_ENV['IHOOK_PREFIX'] . "matrix_members_link_table as a  LEFT JOIN promlm_members_table AS b
            ON a.members_id = b.members_id
        WHERE a.direct_id = " . $user_id . " AND b.notification_status='0'";
        $obj     = new Bin_Query();
        $obj->executeQuery($sql);
        $records            = $obj->records;

        $unseenmemberscount = $records[0]['notifimembercount'];
        /*measge notification*/
        $sql  = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "message_center_table
        WHERE message_to_id='" . $user_id . "' AND message_status='0' ORDER BY message_id DESC LIMIT 0,10";
        $obj                = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records;
        return DMyProfile::showUserNewNotification($records);

    }

    public static function getDownlineSales()
    {
        $user_id = $_SESSION['default']['customer_id'];
        $sql   = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "matrix_members_link_table as a  LEFT JOIN promlm_members_table AS b
            ON a.members_id = b.members_id
        WHERE a.direct_id = " . $user_id . " LIMIT 5";
        $query = new Bin_Query();
        $query->executeQuery($sql);
        $records = $query->records;
        return DMyProfile::showDownlineSales($records);
    }

    public static function getLanguage($members_lang)
    {
        $sql = "SELECT * FROM ".$_ENV['IHOOK_PREFIX']."language_table";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records;
        return DMyProfile::getLanguage($records, $members_lang);
    }

    public static function updateAccInfo($records)
    {
        $members_login_verification = ($records['members_login_verification'] == 'on') ? 1 : 0 ;
        $members_password_verification = ($records['members_password_verification'] == 'on') ? 1 : 0;
        $members_password_verification = ($records['members_password_verification'] == 'on') ? 1 : 0;
        $members_password_verification = ($records['members_password_verification'] == 'on') ? 1 : 0;
        $members_id = $_SESSION['default']['customer_id'];
        $members_communication_email = (isset($records['members_communication_email'])) ? 1 : 0;
        $members_communication_sms = (isset($records['members_communication_sms'])) ? 2 : 0;

        //Rey
        $members_two_fact = $records['members_two_fact'];
        //Rey
        $obj = new Bin_Query();
        $sql = "UPDATE " . $_ENV['IHOOK_PREFIX'] . "members_table SET
        members_username ='" . $records['members_username'] . "',
        members_email ='" . $records['members_email'] . "',
        members_lang  ='" . $records['members_lang'] . "',
        members_login_verification='" . $members_login_verification . "',
        members_password_verification='" . $members_password_verification . "',
        members_two_fact='".$members_two_fact."',
        updated_on        =NOW()
        WHERE members_id='" . $members_id . "'";
        if ($obj->updateQuery($sql)) {

            if ($members_communication_email) {
                $communication[]['notify_via'] = 1;
            }

            if ($members_communication_sms) {
                $communication[]['notify_via'] = 2;
            }

            if ($communication) {
                for ($i = 0; $i < count((array)$communication) ; $i++) {
                    $sql_check = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "usernotify_meta WHERE meta_key='notify_via' AND user_id='" . $_SESSION['default']['customer_id'] . "'  AND meta_value='" . trim($communication[$i]['notify_via']) . "'";
                    $obj_check = new Bin_Query();
                    $obj_check->executeQuery($sql_check);
                    $records = $obj_check->records;
                    if (count((array)$records) > 0) {
                        $sql = "UPDATE " . $_ENV['IHOOK_PREFIX'] . "usernotify_meta SET meta_value= '" . $communication[$i]['notify_via'] . "' WHERE meta_key='notify_via' AND user_id='" . $_SESSION['default']['customer_id'] . "'";
                    } else {
                        if (count((array)$communication) == 1) {
                            $sql_up = "UPDATE " . $_ENV['IHOOK_PREFIX'] . "usernotify_meta SET meta_value= '' WHERE meta_key='notify_via' AND user_id='" . $_SESSION['default']['customer_id'] . "'";
                            $obj_up = new Bin_Query();
                            $obj_up->updateQuery($sql_up);

                        }
                        $sql = "INSERT INTO `" . $_ENV['IHOOK_PREFIX'] . "usernotify_meta` ( `meta_key`, `meta_value`,user_id) VALUES ('notify_via', '" . $communication[$i]['notify_via'] . "', '" . $_SESSION['default']['customer_id'] . "');";
                    }
                    $obj_update = new Bin_Query();
                    $obj_update->updateQuery($sql);
                }
            } else {
                $query_delete = new Bin_Query();
                $sql_delete = "DELETE FROM " . $_ENV['IHOOK_PREFIX'] . "usernotify_meta WHERE meta_key='notify_via' AND user_id='" . $_SESSION['default']['customer_id'] . "'";
                $query_delete->executeQuery($sql_delete);
            }
            $_SESSION['success_message'] = CUS_PERSONAL_INFO_UPDATED;
            header('Location:' .$_ENV['FCPATH']. '/myprofile');
            exit();
        } else {
            $_SESSION['success_message'] = CUS_PERSONAL_INFO_NOT_UPDATED;
            header('Location:' .$_ENV['FCPATH']. '/myprofile');
            exit();
        }
    }

    public static function getTimeZone($records, $member_timezone)
    {
        return DMyProfile::getTimeZone($records, $member_timezone);
    }

    public static function saveMailSetting($records)
    {

        if (!isset($_POST['all_notify'])) {
            $_POST['all_notify'] = 0;
        }
        if (!isset($_POST['register_notify'])) {
            $_POST['register_notify'] = 0;
        }
        if (!isset($_POST['order_notify'])) {
            $_POST['order_notify'] = 0;
        }

        if (!isset($_POST['message_notify'])) {
            $_POST['message_notify'] = 0;
        }
        if (!isset($_POST['withdraw_notify'])) {
            $_POST['withdraw_notify'] = 0;
        }

        $_POST['members_email_notification'] = ($_POST['members_email_notification']) ? 1 : 0 ;

        $_POST['members_personalemail_notification'] = ($_POST['members_personalemail_notification']) ? 1 : 0 ;

        foreach ($_POST as $key => $value) {
            if ($key != 'do' && $key != 'submit' && $key != 'action') {
                $sql_check = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "usernotify_meta WHERE meta_key='" . trim($key) . "' AND user_id='" . $_SESSION['default']['customer_id'] . "'";
                $obj_check = new Bin_Query();
                $obj_check->executeQuery($sql_check);
                $records = $obj_check->records;
                if (count((array)$records) > 0) {
                    $sql = "UPDATE " . $_ENV['IHOOK_PREFIX'] . "usernotify_meta SET meta_value= '" . $value . "',user_id='" . $_SESSION['default']['customer_id'] . "' WHERE meta_key='" . $key . "' AND user_id='" . $_SESSION['default']['customer_id'] . "'";
                } else {
                    $sql = "INSERT INTO `" . $_ENV['IHOOK_PREFIX'] . "usernotify_meta` ( `meta_key`, `meta_value`,user_id) VALUES ('" . $key . "', '" . $value . "', '" . $_SESSION['default']['customer_id'] . "');";
                }
                $obj_update = new Bin_Query();
                $obj_update->updateQuery($sql);
            }
        }
        $_SESSION['success_message'] = CUS_PERSONAL_INFO_UPDATED;
        header('Location:' .$_ENV['FCPATH']. '/myprofile');
        exit();

    }

    public static function getNotification()
    {
        $output = array();
        $query = new Bin_Query();
        $sql_site = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "usernotify_meta WHERE user_id='" . $_SESSION['default']['customer_id'] . "'";
        if ($query->executeQuery($sql_site)) {

            for ($i = 0;$i < $query->totrows;$i++) {
                if ($query->records[$i]['meta_key'] != 'notify_via') {
                    $fields[strtolower(str_replace(' ', '_', $query->records[$i]['meta_key'])) ] = $query->records[$i]['meta_value'];
                } else {

                    $fields[$query->records[$i]['meta_value']][strtolower(str_replace(' ', '_', $query->records[$i]['meta_key'])) ] = $query->records[$i]['meta_value'];

                }
            }
            if (count((array)$Err->messages) > 0) {
                $fields = $Err->values;
            }
        }

        return $fields;
    }


    public static function getMemberslinkdetails()
    {

        $members_id = $_SESSION['default']['customer_id'];
        $sql             = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "matrix_members_link_table
        WHERE members_id='" . $members_id . "'";
        $obj             = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records[0];
        return $records;
    }



}
?>
