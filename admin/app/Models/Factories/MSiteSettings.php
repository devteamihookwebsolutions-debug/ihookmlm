<?php

/**
 * This class contains public functions related to MSiteSettings
 *
 * @package         MSiteSettings
 * @category        Model
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

namespace Admin\App\Models\Factories;

class MSiteSettings
{
    /**
     * This public static function is used  to get site details
     * @param array $Err
     * @return HTML data
     */
    public static function showSiteSettings($Err)
    {
        $output   = [];
        $query    = new Bin_Query();
        $sql_site = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table";
        if ($query->executeQuery($sql_site)) {
            for ($i = 0; $i < $query->totrows; $i++) {
                $fields[strtolower(str_replace(' ', '_', $query->records[$i]['sitesettings_name']))] = $query->records[$i]['sitesettings_value'];
            }
            if (count((array) $Err->messages) > 0) {
                $fields = $Err->values;
            }
        }
        return $fields;
    }
    /**
     * This public static function is used  to update site details
     */
    public static function updateSiteSettings()
    {
        if (trim($_POST['sitedatetimeformat']) == 'm/d/Y') {
            $sitedateres['sitedatetimeformatcal'] = 'mm/dd/yyyy';
        }
        if (trim($_POST['sitedatetimeformat']) == 'd-M-Y') {
            $sitedateres['sitedatetimeformatcal'] = 'dd-M-yyyy';
        }
        if (trim($_POST['sitedatetimeformat']) == 'd-M-Y h:i') {
            $sitedateres['sitedatetimeformatcal'] = 'dd-M-yyyy';
        }
        if (trim($_POST['sitedatetimeformat']) == 'd-M-Y h:i:s') {
            $sitedateres['sitedatetimeformatcal'] = 'dd-M-yyyy';
        }
        // $_POST=array_merge((array)$_POST,$sitedateres);

        if (is_array($sitedateres)) {
            $_POST = array_merge((array) $_POST, $sitedateres);
        }

        //update unread status
        $uploaded_path                = '../' . $_ENV['CURRENT_UPATH'] . '/uploads/site_logo/';
        $image_crop_file_hidd         = $_POST['image_crop_file_hidd'];
        $image_favicon_crop_file_hidd = $_POST['image_favicon_crop_file_hidd'];
        $footer_image_crop_file_hidd  = $_POST['footer_image_crop_file_hidd'];

        if ($_FILES['site_logo']['size'] > 0 && $image_crop_file_hidd == '') {
            $uploadedName    = $_FILES['site_logo']['name'];
            $ext             = strtolower(substr($uploadedName, strripos($uploadedName, '.') + 1));
            $flnm            = hash('sha256', $uploadedName) . '.' . $ext;
            $headerimagepath = 'uploads/site_logo/' . $flnm;
            MAmazonS3Ext::amazonUploadExt($_FILES['site_logo']['name'], $_FILES['site_logo']['tmp_name'], $_FILES['site_logo']['type'], $headerimagepath);

            if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
                $tmpPath = $_FILES['site_logo']['tmp_name'];
                $mimeType = mime_content_type($tmpPath); // e.g., image/png or image/jpeg
                $base64_site_logo = 'data:' . $mimeType . ';base64,' . base64_encode(file_get_contents($tmpPath));
            } else {
                $base64_site_logo = '';
            }

        } else {

            if ($image_crop_file_hidd != '') {
                $img             = $_POST['image_crop_file_hidd'];
                $imagepar        = explode('base64,', $img);
                $imagemimeparse  = explode('data:image/', $imagepar[0]);
                $imagemimeparse2 = explode(';', $imagemimeparse[1]);
                $mimelogotype    = trim($imagemimeparse2[0]);

                $img     = str_replace(' ', '+', $imagepar[1]);
                $data    = base64_decode($img);
                $bytes   = random_bytes(16);
                $ranunie = bin2hex($bytes);
                $file    = '../' . $_ENV['CURRENT_UPATH'] . '/shift/' . $ranunie . '.' . $mimelogotype;
                $success = file_put_contents($file, $data);
                /*start:amazonupload*/
                $amaname         = $ranunie . "." . $mimelogotype;
                $headerimagepath = 'uploads/site_logo/' . $amaname;
                MAmazonS3::amazonFileCreation($file, 'image/' . $mimelogotype, $headerimagepath);
                /*end:amazonupload*/
            } else {
                $headerimagepath = trim($_POST['hidden_site_logo']);
            }

        }


        if ($_FILES['site_logo_dark']['size'] > 0) {
            $uploadedName    = $_FILES['site_logo_dark']['name'];
            $ext             = strtolower(substr($uploadedName, strripos($uploadedName, '.') + 1));
            $flnm            = hash('sha256', $uploadedName) . '.' . $ext;
            $headerimagepathdark = 'uploads/site_logo/' . $flnm;
            MAmazonS3Ext::amazonUploadExt($_FILES['site_logo_dark']['name'], $_FILES['site_logo_dark']['tmp_name'], $_FILES['site_logo_dark']['type'], $headerimagepathdark);
        } else {
            $headerimagepathdark = trim($_POST['hidden_site_logo_dark']);
        }


        if ($_FILES['footer_site_logo']['size'] > 0 && $footer_image_crop_file_hidd == '') {
            $uploadedName    = $_FILES['footer_site_logo']['name'];
            $ext             = strtolower(substr($uploadedName, strripos($uploadedName, '.') + 1));
            $flnm            = hash('sha256', $uploadedName) . '.' . $ext;
            $footerimagepath = 'uploads/site_logo/' . $flnm;
            MAmazonS3Ext::amazonUploadExt($_FILES['footer_site_logo']['name'], $_FILES['footer_site_logo']['tmp_name'], $_FILES['footer_site_logo']['type'], $footerimagepath);
        } else {
            if ($footer_image_crop_file_hidd != '') {
                $img             = $_POST['footer_image_crop_file_hidd'];
                $imagepar        = explode('base64,', $img);
                $imagemimeparse  = explode('data:image/', $imagepar[0]);
                $imagemimeparse2 = explode(';', $imagemimeparse[1]);
                $mimelogotype    = trim($imagemimeparse2[0]);

                $img     = str_replace(' ', '+', $imagepar[1]);
                $data    = base64_decode($img);
                $bytes   = random_bytes(16);
                $ranunie = bin2hex($bytes);
                $file    = '../' . $_ENV['CURRENT_UPATH'] . '/shift/' . $ranunie . '.' . $mimelogotype;
                $success = file_put_contents($file, $data);
                /*start:amazonupload*/
                $amaname         = $ranunie . "." . $mimelogotype;
                $footerimagepath = 'uploads/site_logo/' . $amaname;
                MAmazonS3Ext::amazonFileCreationExt($file, 'image/' . $mimelogotype, $footerimagepath);
                /*end:amazonupload*/
            } else {
                $footerimagepath = trim($_POST['hidden_footer_logo']);
            }

        }

        if ($_FILES['site_favicon']['size'] > 0) {
            $uploadedName     = $_FILES['site_favicon']['name'];
            $ext              = strtolower(substr($uploadedName, strripos($uploadedName, '.') + 1));
            $flnm             = hash('sha256', $uploadedName) . '.' . $ext;
            $headerimagepath2 = 'uploads/site_logo/' . $flnm;
            MAmazonS3Ext::amazonUploadExt($_FILES['site_favicon']['name'], $_FILES['site_favicon']['tmp_name'], $_FILES['site_favicon']['type'], $headerimagepath2);
        } else {

            if ($image_favicon_crop_file_hidd != '') {
                $img     = $_POST['image_favicon_crop_file_hidd'];
                $img     = str_replace('data:image/jpeg;base64,', '', $img);
                $img     = str_replace(' ', '+', $img);
                $data    = base64_decode($img);
                $ranunie = random_bytes(16);
                $file    = '../' . $_ENV['CURRENT_UPATH'] . '/shift/' . $ranunie . '.jpeg';
                $success = file_put_contents($file, $data);
                /*start:amazonupload*/
                $amaname          = $ranunie . ".jpeg";
                $headerimagepath2 = 'uploads/site_logo/' . $amaname;
                MAmazonS3::amazonFileCreation($file, 'image/jpeg', $headerimagepath2);
                /*end:amazonupload*/
            } else {
                $headerimagepath2 = trim($_POST['hidden_site_favicon']);
            }

        }

        if ($_FILES['login_site_logo']['size'] > 0) {
            $login_logo = $_FILES['login_site_logo']['name'];
            $ext        = strtolower(substr($login_logo, strripos($login_logo, '.') + 1));
            $flnm       = hash('sha256', $login_logo) . '.' . $ext;
            $login_logo = 'uploads/site_logo/' . $flnm;
            MAmazonS3Ext::amazonUploadExt($_FILES['login_site_logo']['name'], $_FILES['login_site_logo']['tmp_name'], $_FILES['login_site_logo']['type'], $login_logo);
        } else {
            if ($image_login_crop_file_hidd != '') {
                $img     = $_POST['image_login_crop_file_hidd'];
                $img     = str_replace('data:image/jpeg;base64,', '', $img);
                $img     = str_replace(' ', '+', $img);
                $data    = base64_decode($img);
                $ranunie = random_bytes(16);
                $file    = '../' . $_ENV['CURRENT_UPATH'] . '/shift/' . $ranunie . '.jpeg';
                $success = file_put_contents($file, $data);
                /*start:amazonupload*/
                $amaname    = $ranunie . ".jpeg";
                $login_logo = 'uploads/login_logo/' . $amaname;
                MAmazonS3::amazonFileCreation($file, 'image/jpeg', $login_logo);
                /*end:amazonupload*/
            } else {
                $login_logo = trim($_POST['hidden_login_logo']);
            }
        }

        if ($_FILES['register_logo']['size'] > 0) {
            $register_logo = $_FILES['register_logo']['name'];
            $ext           = strtolower(substr($register_logo, strripos($register_logo, '.') + 1));
            $flnm          = hash('sha256', $register_logo) . '.' . $ext;
            $register_logo = 'uploads/site_logo/' . $flnm;
            MAmazonS3Ext::amazonUploadExt($_FILES['register_logo']['name'], $_FILES['register_logo']['tmp_name'], $_FILES['register_logo']['type'], $register_logo);
        } else {
            if ($image_resgiter_crop_file_hidd != '') {
                $img     = $_POST['image_resgiter_crop_file_hidd'];
                $img     = str_replace('data:image/jpeg;base64,', '', $img);
                $img     = str_replace(' ', '+', $img);
                $data    = base64_decode($img);
                $ranunie = random_bytes(16);
                $file    = '../' . $_ENV['CURRENT_UPATH'] . '/shift/' . $ranunie . '.jpeg';
                $success = file_put_contents($file, $data);
                /*start:amazonupload*/
                $amaname       = $ranunie . ".jpeg";
                $register_logo = 'uploads/register_logo/' . $amaname;
                MAmazonS3::amazonFileCreation($file, 'image/jpeg', $login_logo);
                /*end:amazonupload*/
            } else {
                $register_logo = trim($_POST['hidden_register_logo']);
            }
        }

        if ($_FILES['site_watermark']['size'] > 0) {
            $uploadedName     = $_FILES['site_watermark']['name'];
            $ext              = strtolower(substr($uploadedName, strripos($uploadedName, '.') + 1));
            $flnm             = hash('sha256', $uploadedName) . '.' . $ext;
            $headerimagepath3 = 'uploads/site_logo/' . $flnm;
            MAmazonS3Ext::amazonUploadExt($_FILES['site_watermark']['name'], $_FILES['site_watermark']['tmp_name'], $_FILES['site_watermark']['type'], $headerimagepath3);
        } else {
            $headerimagepath3 = trim($_POST['hidden_site_watermark']);
        }
        $watermark_status = trim($_POST['watermark_status']);
        $obj              = new Bin_Query();
        $link             = $obj->getConnection();
        //update null value
        $updatefields = [
            'show_genealogy_tree',
            'auto_responded',
            'show_uplines_user',
            'show_leaderboards',
            'show_feeds',
            'google_captcha_status',
            'code_captcha_status',
            'withdrawfund_status',
            'fundtransfer_status',
            'epin_spend_status',
            'epin_transfer_status',
            'lock_account_status',
            'email_notification_user',
            'email_notification_admin',
            'login_attempt_lock',
            'uniqueforlogin',
            'subdomain_enble',
            'https_enble',
            'watermark_status',
            'site_watermark',
            'dashboard_type',
            'register_type',
            'currency_format',
            'waitingliststatus',
        ]; //security settings
        foreach ($updatefields as $key => $value) {
            self::updateSiteFields($value);
        }
        //Code Update Default Matrix

        $default_matrix = $_POST['default_matrix'];

        $matrixupdate_allsql = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "matrix_table SET matrix_default=0 ";
        $matrixall_obj       = new Bin_Query();
        $matrixall_obj->updateQuery($matrixupdate_allsql);

        // Ensure $default_matrix is an integer
        $default_matrix = (int) $_POST['default_matrix'];

        // Construct the query with a placeholder
        $matrixupdate_sql = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "matrix_table
                            SET matrix_default = 1
                            WHERE matrix_id = " . $default_matrix;

        $matrix_obj = new Bin_Query();
        $matrix_obj = new Bin_Query();
        $matrix_obj->updateQuery($matrixupdate_sql);

        //Code Update Default Matrix
        foreach ($_POST as $key => $value) {
            if ($key == 'site_name') {
                $site_name = $value;
            }
            if ($key == 'site_meta_themecolor') {
                $site_meta_themecolor = $value;
            }
            if ($key != 'hidden_site_logo' && $key != 'site_logo' && $key != 'do' && $key != 'submit' && $key != 'action') {
                if ($key == 'google_analaytics_code') {
                    $value = mysqli_real_escape_string($link, $value);
                }
                $sql_check = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_name='" . trim($key) . "'";
                $obj_check = new Bin_Query();
                if ($obj_check->executeQuery($sql_check)) {
                    $sql_update = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table SET sitesettings_value= '" . $value . "',last_updated=NOW() WHERE sitesettings_name='" . $key . "'";
                    $obj_update = new Bin_Query();
                    $obj_update->updateQuery($sql_update);
                } else {
                    if ($key == 'dashboard_type') {
                        $sitesettings_description = '1=>Shop,2=>Crypto,3=>MLM';
                    } else {
                        $sitesettings_description = '';
                    }
                    $sql_update = "INSERT INTO `" . $_ENV['PROMLM_PREFIX'] . "sitesettings_table` ( `sitesettings_name`, `sitesettings_value`,`sitesettings_description`,`last_updated`) VALUES ('" . $key . "', '" . $value . "','" . $sitesettings_description . "',NOW());";
                    $obj_update = new Bin_Query();
                    $obj_update->updateQuery($sql_update);
                }

                if ($key == 'admin_mail_id') {
                    $sqladmin = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "admin_table SET admin_email= '" . trim($value) . "'
                                 WHERE admin_type='1' AND admin_login_verified='1' AND allaccess_control='1'";
                    $objadmin = new Bin_Query();
                    $objadmin->updateQuery($sqladmin);
                }
            }
        }


        $sql_logo_check = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_name= 'site_logo_dark'";
        $obj_logo_check = new Bin_Query();
        if ($obj_logo_check->executeQuery($sql_logo_check)) {
            $sql_site_logo = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table SET sitesettings_value= '" . $headerimagepathdark . "',last_updated=NOW()
                           WHERE sitesettings_name='site_logo_dark'";
        } else {
            $sql_site_logo = "INSERT INTO `" . $_ENV['PROMLM_PREFIX'] . "sitesettings_table`(`sitesettings_name`,`sitesettings_value`,`last_updated`) VALUES ('site_logo_dark','" . $headerimagepathdark. "',NOW() )";
        }
        $obj_site_logo = new Bin_Query();
        $obj_site_logo->updateQuery($sql_site_logo);

        $sql_logo_check = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_name= 'site_logo'";
        $obj_logo_check = new Bin_Query();
        if ($obj_logo_check->executeQuery($sql_logo_check)) {
            $sql_site_logo = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table SET sitesettings_value= '" . $headerimagepath . "',last_updated=NOW() WHERE sitesettings_name='site_logo'";
        } else {
            $sql_site_logo = "INSERT INTO `" . $_ENV['PROMLM_PREFIX'] . "sitesettings_table`(`sitesettings_name`,`sitesettings_value`,`last_updated`) VALUES ('site_logo','" . $headerimagepath . "',NOW())";
        }
        $obj_site_logo = new Bin_Query();
        $obj_site_logo->updateQuery($sql_site_logo);


        //sitelogo base64
        if ($base64_site_logo) {
            $sql_logo_check = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_name= 'base64_site_logo'";
            $obj_logo_check = new Bin_Query();
            if ($obj_logo_check->executeQuery($sql_logo_check)) {
                $sql_site_logo = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table SET sitesettings_value= '" . $base64_site_logo . "',last_updated=NOW() WHERE sitesettings_name='base64_site_logo'";
            } else {
                $sql_site_logo = "INSERT INTO `" . $_ENV['PROMLM_PREFIX'] . "sitesettings_table`(`sitesettings_name`,`sitesettings_value`,`last_updated`) VALUES ('base64_site_logo','" . $base64_site_logo . "',NOW())";
            }
            $obj_site_logo = new Bin_Query();
            $obj_site_logo->updateQuery($sql_site_logo);
        }


        $sql_logo_check1 = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_name= 'footer_site_logo'";
        $obj_logo_check1 = new Bin_Query();
        if ($obj_logo_check1->executeQuery($sql_logo_check1)) {
            $sql_site_logo1 = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table SET sitesettings_value= '" . $footerimagepath . "'
                           WHERE sitesettings_name='footer_site_logo'";
        } else {
            $sql_site_logo1 = "INSERT INTO `" . $_ENV['PROMLM_PREFIX'] . "sitesettings_table`(`sitesettings_name`,`sitesettings_value`,`last_updated`) VALUES ('footer_site_logo','" . $footerimagepath . "',NOW() )";
        }
        $obj_site_logo1 = new Bin_Query();
        $obj_site_logo1->updateQuery($sql_site_logo1);

        $sql_logo_check2 = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_name= 'site_favicon'";
        $obj_logo_check2 = new Bin_Query();
        if ($obj_logo_check2->executeQuery($sql_logo_check2)) {
            $sql_site_logo2 = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table SET sitesettings_value= '" . $headerimagepath2 . "',last_updated=NOW()
                           WHERE sitesettings_name='site_favicon'";
        } else {
            $sql_site_logo2 = "INSERT INTO `" . $_ENV['PROMLM_PREFIX'] . "sitesettings_table`(`sitesettings_name`,`sitesettings_value`,`last_updated`) VALUES ('site_favicon','" . $headerimagepath2 . "',NOW() )";
        }
        $obj_site_logo2 = new Bin_Query();
        $obj_site_logo2->updateQuery($sql_site_logo2);

        $sql_logo_check3 = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_name= 'login_logo'";
        $obj_logo_check3 = new Bin_Query();
        if ($obj_logo_check3->executeQuery($sql_logo_check3)) {
            $sql_site_logo3 = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table SET sitesettings_value= '" . $login_logo . "',last_updated=NOW()  WHERE sitesettings_name='login_logo'";
        } else {
            $sql_site_logo3 = "INSERT INTO `" . $_ENV['PROMLM_PREFIX'] . "sitesettings_table`(`sitesettings_name`,`sitesettings_value`,`last_updated`) VALUES ('login_logo','" . $login_logo . "',NOW() )";
        }
        $obj_site_logo3 = new Bin_Query();
        $obj_site_logo3->updateQuery($sql_site_logo3);
        $sql_logo_check4 = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_name= 'register_logo'";
        $obj_logo_check4 = new Bin_Query();
        if ($obj_logo_check4->executeQuery($sql_logo_check4)) {
            $sql_site_logo4 = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table SET sitesettings_value= '" . $register_logo . "',last_updated=NOW()
                           WHERE sitesettings_name='register_logo'";
        } else {
            $sql_site_logo4 = "INSERT INTO `" . $_ENV['PROMLM_PREFIX'] . "sitesettings_table`(`sitesettings_name`,`sitesettings_value`,`last_updated`) VALUES ('register_logo','" . $register_logo . "',NOW() )";
        }
        $obj_site_logo4 = new Bin_Query();
        $obj_site_logo4->updateQuery($sql_site_logo4);

        $sql_logincontent = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_name= 'login_content'";
        $obj_logincontent = new Bin_Query();
        if ($obj_logincontent->executeQuery($sql_logincontent)) {
            $sql_logincontent = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table SET sitesettings_value= '" . $_POST['login_content'] . "',last_updated=NOW() WHERE sitesettings_name='login_content'";
        } else {
            $sql_logincontent = "INSERT INTO `" . $_ENV['PROMLM_PREFIX'] . "sitesettings_table`(`sitesettings_name`,`sitesettings_value`,`last_updated`) VALUES ('login_content','" . $_POST['login_content'] . "',NOW() )";
        }
        $obj_logincontent = new Bin_Query();
        $obj_logincontent->updateQuery($sql_logincontent);

        $sql_loginsubcontent = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_name= 'login_content'";
        $obj_loginsubcontent = new Bin_Query();
        if ($obj_loginsubcontent->executeQuery($sql_loginsubcontent)) {
            $sql_loginsubcontent = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table SET sitesettings_value= '" . $_POST['login_sub_content'] . "',last_updated=NOW() WHERE sitesettings_name='login_sub_content'";
        } else {
            $sql_loginsubcontent = "INSERT INTO `" . $_ENV['PROMLM_PREFIX'] . "sitesettings_table`(`sitesettings_name`,`sitesettings_value`,`last_updated`) VALUES ('login_sub_content','" . $_POST['login_sub_content'] . "',NOW())";
        }
        $obj_loginsubcontent = new Bin_Query();
        $obj_loginsubcontent->updateQuery($sql_loginsubcontent);

        $_SESSION['success_message'] = __('Site settings updated successfully');
    }
    /**
     * This public static function is used  to update site details
     * @param string $sitesettings_name
     * @return HTML data
     */
    public static function updateSiteFields($sitesettings_name)
    {
        $sql = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table SET sitesettings_value= '0'
                           WHERE sitesettings_name='" . $sitesettings_name . "' AND  sitesettings_description!='security'";
        $obj = new Bin_Query();
        $obj->updateQuery($sql);
    }
    /**
     * This public static function is used  to update site active matrixdetails
     * @return HTML data
     */
    public static function getActiveMatrix()
    {
        $where          = "WHERE sitesettings_name ='default_matrix' ";
        $sitesettings   = MSiteDetails::getSiteSettingsDetails($where);
        $default_matrix = $sitesettings[0]['sitesettings_value'];
        $where          = 'WHERE matrix_status="1"';
        $sql            = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "matrix_table " . $where . "";
        $obj            = new Bin_Query();
        $obj->executeQuery($sql);
        $defaultmatrix = $obj->records;
        return DSitesettings::getActiveMatrix($defaultmatrix, $default_matrix);
    }
    /**
     * This public static function is used  to update site autoload
     */
    public static function updateSiteAutoloadContent()
    {

        $recordsdefaultarray = ['site_name', 'site_version', 'dashboard_type', 'site_meta_title', 'company_name', 'company_address', 'site_meta_keyword', 'site_meta_description', 'site_footer_content', 'site_logo', 'site_favicon', 'admin_site_logo', 'google_analaytics_code', 'idle_logout_time', 'site_currency', 'site_currency_code', 'db_prefix', 'idle_timeout_status', 'package_expiry_alert_status', 'package_expiry_alert_time', 'subdomain_enble', 'https_enble', 'mass_payout', 'site_meta_themecolor', 'site_service_worker', 'db_name', 'admin_site_footer_logo', 'woocommerce_path', 'sitestatus', 'admin_site_footer_content', 'appstorestatus', 'playstorestatus', 'admin_site_favicon', 'firebasestatus', 'sitedatetimeformat', 'cart_id', 'product_check', 'orders_check', 'discount_check', 'product_level_check', 'autoship_check', 'wooprefix', 'woodbname', 'sitedatetimeformatcal', 'enabled_tax_status', 'registertype', 'menu_layout_type', 'footer_site_logo', 'admin_site_logo_inver', 'login_logo', 'register_logo', 'waitingliststatus'];

        $sitearrayName = [];
        $sql_check     = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE  (sitesettings_name='site_name' || sitesettings_name='site_version' || sitesettings_name='dashboard_type' || sitesettings_name='site_meta_title' || sitesettings_name='company_name' || sitesettings_name='company_address' || sitesettings_name='site_meta_keyword' || sitesettings_name='site_meta_description' || sitesettings_name='site_footer_content' || sitesettings_name='site_logo' || sitesettings_name='site_favicon' || sitesettings_name='admin_site_logo' || sitesettings_name='google_analaytics_code' || sitesettings_name='idle_logout_time' || sitesettings_name='site_currency' || sitesettings_name='site_currency_code' || sitesettings_name='db_prefix' || sitesettings_name='idle_timeout_status' || sitesettings_name='package_expiry_alert_status' || sitesettings_name='package_expiry_alert_time' || sitesettings_name='subdomain_enble' || sitesettings_name='https_enble' || sitesettings_name='mass_payout' || sitesettings_name='site_meta_themecolor' ||  sitesettings_name='site_service_worker' || sitesettings_name='db_name'|| sitesettings_name='admin_site_footer_logo'|| sitesettings_name='woocommerce_path'|| sitesettings_name='sitestatus' || sitesettings_name='admin_site_footer_content' || sitesettings_name='appstorestatus' || sitesettings_name='playstorestatus' ||  sitesettings_name='admin_site_favicon' || sitesettings_name='firebasestatus' || sitesettings_name='sitedatetimeformat' || sitesettings_name='cart_id' || sitesettings_name='product_check' || sitesettings_name='orders_check' || sitesettings_name='discount_check' || sitesettings_name='product_level_check' || sitesettings_name='autoship_check' || sitesettings_name='wooprefix' || sitesettings_name='woodbname' || sitesettings_name='sitedatetimeformatcal' || sitesettings_name='enabled_tax_status' || sitesettings_name='registertype' || sitesettings_name='menu_layout_type' || sitesettings_name='footer_site_logo' || sitesettings_name='admin_site_logo_inver' || sitesettings_name='login_logo' || sitesettings_name='register_logo' || sitesettings_name='waitingliststatus') GROUP BY sitesettings_name";
        $obj_check     = new Bin_Query();
        if ($obj_check->executeQuery($sql_check)) {
            $recordssiteup = $obj_check->records;
            foreach ($recordsdefaultarray as $keysiteup => $valuesiteup) {
                $sitedefaultkey   = array_search($valuesiteup, array_column($recordssiteup, 'sitesettings_name'));
                $sitedefaultvalue = $sitedefaultkey > 0 ? $recordssiteup[$sitedefaultkey]['sitesettings_value'] : 0;
                if ($valuesiteup == 'cart_id') {
                    $sitearrayName[] = [
                        'cart_configure_id' => $sitedefaultvalue,
                    ];

                } else {
                    $sitearrayName[] = [
                        $valuesiteup => $sitedefaultvalue,
                    ];
                }

            }
        }

    }
    /**
     * This public static function is used to get site language
     * @return HTML
     */
    public static function defaultLang()
    {
        $where          = "WHERE sitesettings_name ='default_language' ";
        $sitesettings   = MSiteDetails::getSiteSettingsDetails($where);
        $default_matrix = $sitesettings[0]['sitesettings_value'];
        $sql            = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "language_table";
        $obj            = new Bin_Query();
        $obj->executeQuery($sql);
        $language = $obj->records;
        return DSiteSettings::defaultLang($language, $default_matrix);
    }
    /**
     * This public static function is used to get site version
     * @return int
     */
    public static function getSiteCurrectVersion()
    {
        $site_version =  '16';
        return $site_version;
    }
    /**
     * This public static function is used to get user dashboard type
     * @return string
     */
    public static function showDashboardType()
    {
        $where          = "WHERE sitesettings_name ='dashboard_type' ";
        $sitesettings   = MSiteDetails::getSiteSettingsDetails($where);
        $default_matrix = $sitesettings[0]['sitesettings_value'];
        return DSiteSettings::showDashboardType($default_matrix);
    }

    public static function showCurrencyFormat()
    {
        $where          = "WHERE sitesettings_name ='currency_format' ";
        $sitesettings   = MSiteDetails::getSiteSettingsDetails($where);
        $default_matrix = $sitesettings[0]['sitesettings_value'];
        return DSiteSettings::showCurrencyFormat($default_matrix);
    }

}
