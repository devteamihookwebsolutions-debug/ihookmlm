<?php
/**
 * This class contains public static functions related to network page
 *
 * @package         MTaxDetails
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
?>
<?php
namespace Model\Profile;
use Model\Middleware\MAmazonS3;
use Query\Bin_Query;

class MTaxDetails {
  
    
    public static function saveTaxInfo(){

        $members_ssn_number = $_POST['members_ssn_number'];
        $members_ein_number = $_POST['members_ein_number'];

        $members_tax_form_chk = $_POST['members_tax_form'];
        $members_w8_form_chk = $_POST['members_w8_form'];

        $members_id = $_SESSION['default']['customer_id'];
        $members_tax_form = $_FILES['members_tax_form']['name'];
        $members_w8_form = $_FILES['members_w8_form']['name'];
		
         if($_FILES['customFiletax']['size'] > 0){

            $uploadedName     = $_FILES['customFiletax']['name'];
            $ext              = strtolower(substr($uploadedName, strripos($uploadedName, '.') + 1));
            $flnm             = hash('sha256', $uploadedName) . '.' . $ext;
            $members_tax_form = 'uploads/members/tax/' . $flnm;
            MAmazonS3::amazonUpload($_FILES['customFiletax']['name'], $_FILES['customFiletax']['tmp_name'], $_FILES['customFiletax']['type'], $members_tax_form);
            $obj1 = new Bin_Query();
            $sql1 = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "members_table SET
            members_tax_form     ='" . $members_tax_form . "'
            WHERE members_id='" . $members_id . "'";
            $obj1->updateQuery($sql1);
         }else{
            $members_tax_form = $_POST['customFiletaxhidden'];             
            $obj2 = new Bin_Query();
            $sql2 = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "members_table SET
            members_tax_form     ='" . $members_tax_form . "'
            WHERE members_id='" . $members_id . "'";
            $obj2->updateQuery($sql2);
         }
         if($_FILES['w8form']['size'] > 0){

            $uploadedName     = $_FILES['w8form']['name'];
            $ext              = strtolower(substr($uploadedName, strripos($uploadedName, '.') + 1));
            $flnm             = hash('sha256', $uploadedName) . '.' . $ext;
            $members_w8_form = 'uploads/members/tax/' . $flnm;
            MAmazonS3::amazonUpload($_FILES['w8form']['name'], $_FILES['w8form']['tmp_name'], $_FILES['w8form']['type'], $members_w8_form);

                $obj2 = new Bin_Query();
                $sql2 = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "members_table SET
                members_w8_form     ='" . $members_w8_form . "'
                WHERE members_id='" . $members_id . "'";
                $obj2->updateQuery($sql2);
         }else{
            $members_w8_form = $_POST['customFileW8formhidden'];             
            $obj2 = new Bin_Query();
            $sql2 = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "members_table SET
            members_w8_form     ='" . $members_w8_form . "'
            WHERE members_id='" . $members_id . "'";
            $obj2->updateQuery($sql2);
         }
            
         /*end:amazonupload*/
         $obj = new Bin_Query();
         $sql = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "members_table SET
            members_ssn_number ='" . $members_ssn_number . "',
            members_ein_number  ='" . $members_ein_number . "',
            updated_on        =NOW()
            WHERE members_id='" . $members_id . "'";
            if ($obj->updateQuery($sql)) {
                $_SESSION['success_message'] = '' . __('Tax Information updated successfully') . '';
                header('Location:' .$_ENV['FCPATH']. '/myprofile');
                exit();
            } else {
               $_SESSION['error_message'] = '' . __('Tax Information not updated') . '';
                header('Location:' .$_ENV['FCPATH']. '/myprofile');
                exit();
            }
    }
    
    
    
}
?>