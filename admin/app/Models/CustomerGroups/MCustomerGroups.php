<?php
/**
 * This class contains public static functions related to Customers Groups
 *
 * @package         MCustomerGroups
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright        Copyright (c) 2020 - 2021, Sunsofty.
 * @version         Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@alphabettechs.com.
*****************************************************************************/
?>
<?php
namespace Admin\App\Models\CustomerGroups;
class MCustomerGroups {
     /**
     * This public static function is used to show users list.
     * @param int matrix_id
     * @return array data
    */
	 public static function insertCustomerGroups() {
        $created_by =$_SESSION['admin']['id'];
        $members_id=trim($_POST['dismember_id']);
        $customergroups_name=trim($_POST['customergroups_name']);
        $status = $_POST['status'];
        if ($_POST['status'] != '') {
            $status = $_POST['status'];
        } else {
            $status = '2';
        }
        $obj            = new Bin_Query();
        $sql            = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "customergroups(customergroups_name,members_id,status,created_on,created_by)
                VALUES('" . $customergroups_name . "','".$members_id."','".$status."',NOW(),'" . $created_by . "')";
        if($obj->updateQuery($sql)){

            $_SESSION['success_message'] = __('Customer group created successfully');
        } else {
            $_SESSION['error_message'] = __('Customer group not created');
        }

        header('Location:' . $_ENV['BCPATH'] . '/customergroups');
        exit();
     }
     public static function getCustomerGroups(){
		$obj = new Bin_Query();
	     $sql = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "customergroups WHERE customergroups_id>0";
        $obj->executeQuery($sql);
        $records = $obj->records;
        return DCustomerGroups::getCustomerGroups($records);
     }
     public static function getCustomerGroupDetails(){

        $customergroups_id=$_GET['sub1'];
		$obj = new Bin_Query();
	    $sql = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "customergroups WHERE customergroups_id='".$customergroups_id."'";
        $obj->executeQuery($sql);
        $records = $obj->records[0];
        return $records;

     }
     public static function updateCustomerGroups(){

      //  print_r($_GET);exit;

        $updated_by =$_SESSION['admin']['id'];
        $members_id=trim($_POST['members_id']);
        $customergroups_id=trim($_POST['customergroups_id']);
        $customergroups_name=trim($_POST['customergroups_name']);
        $status = $_POST['status'];
        if ($_POST['status'] != '') {
            $status = $_POST['status'];
        } else {
            $status = '2';
        }
        $obj            = new Bin_Query();
        $sql            = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "customergroups
        SET customergroups_name='" . $customergroups_name . "',
        members_id='".$members_id."',
        status='".$status."',
        updated_on=NOW(),
        updated_by='".$members_id."'
        WHERE members_id='".$members_id."' AND customergroups_id='".$customergroups_id."'";
        if($obj->updateQuery($sql)){
            $_SESSION['success_message'] = __('Customer group updated successfully');
        } else {
            $_SESSION['error_message'] = __('Customer group not updated');
        }

        header('Location:' . $_ENV['BCPATH'] . '/customergroups');
        exit();

     }

     public static function deleteCustomerGroups(){

        $customergroups_id=$_GET['sub1'];
        $sql         = "DELETE FROM  " . $_ENV['PROMLM_PREFIX'] . "customergroups WHERE customergroups_id='".$customergroups_id."'";
        $obj         = new Bin_Query();
        if ($obj->updateQuery($sql)) {
            $_SESSION['success_message'] = __('Customer group deleted successfully');
        } else {
            $_SESSION['error_message'] = __('Customer group not deleted');
        }
        header('Location:' . $_ENV['BCPATH'] . '/customergroups');
        exit();
     }

     public static function sendMessageToGroups(){

        $sub=trim($_POST['subject']);
        $message=trim($_POST['message']);
        foreach ($_POST['customergroups_id'] as $val) {
            $sql = "SELECT customers_email AS email FROM " . $_ENV['PROMLM_PREFIX'] . "customergroup_members WHERE customergroups_id='" . $val . "'";
            $obj = new Bin_Query();
            $obj->executeQuery($sql);
            $arr = $obj->records;
                 //$totuni = count((array)array_unique($arr));
                 if (is_array($arr)) {
                    $totuni = count((array)array_unique($arr));
                } else {
                    $totuni = 0; // Set to 0 or another default value if $arr is null
                }
            $createdddate=date('Y-m-d H:i:s');
            $formatdate = MFormatDate::formatingDate($createdddate);
            $query = new Bin_Query();
            $sqlMail = "SELECT * FROM `" . $_ENV['PROMLM_PREFIX'] . "mailtemplates_table`
                WHERE `mail_default_name`='newsletter_notification'
                AND mail_status='1' AND mail_lang='1'";
            $query->executeQuery($sqlMail);
            $recordsmail = $query->records[0];
            $body = $recordsmail['mail_content'];
            $name = str_replace('[name]','User', $body);
            $date = str_replace('[date]',$formatdate, $name);
            $mess = str_replace('[msg]', $message, $date);
            // $totlamemberssplit=array_chunk($arr, 250, true);
            if (is_array($arr)) {
                $totlamemberssplit = array_chunk($arr, 250, true);
            } else {
                $totlamemberssplit = []; // Set a default empty array if $arr is null
            }
            $rountcount       = count((array)$totlamemberssplit);
            //$rountcount       = round($rountcount + 1);
            $recordsmail['mail_subject'] = $sub;
            for($i = 0; $i < (array)$rountcount; $i++){
                 $maillist=$totlamemberssplit[$i];
                if(count((array)$maillist) > 0 ){
                    MSendBulkMail::sendMail($recordsmail, $maillist, $mess, '', '', '');

                }else{
                    break;
                }
            }
        }
        $_SESSION['success_message'] = __('Mail send successfully');
        header('Location:' . $_ENV['BCPATH'] . '/customergroups');
        exit();
     }

}
?>
