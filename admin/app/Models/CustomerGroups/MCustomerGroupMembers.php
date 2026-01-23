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

class MCustomerGroupMembers {

     public static function getCustomerGroupMembers(){

        $customergroups_id=trim($_GET['sub1']);
        $customers_sponsor_id=$_GET['sub2'];
		$obj = new Bin_Query();
        $sql = "SELECT a.customers_username,a.customers_email,b.customers_id AS selcusid,a.customers_id AS cusid FROM " . $_ENV['PROMLM_PREFIX'] . "customers AS a
        LEFT JOIN " . $_ENV['PROMLM_PREFIX'] . "customergroup_members AS b ON b.customers_id=a.customers_id AND b.customergroups_id='".$customergroups_id."' WHERE a.customers_sponsor_id='".$customers_sponsor_id."' ";
        $obj->executeQuery($sql);
        $records = $obj->records;
        return DCustomerGroupMembers::getCustomerGroupMembers($records);
    }
     public static function updateCustomerGroupMembers(){

        $members_id =$_GET['sub2'];
        $customergroups_id=$_GET['sub1'];
        $sql         = "DELETE FROM  " . $_ENV['PROMLM_PREFIX'] . "customergroup_members WHERE customergroups_id='".$customergroups_id."'";
        $obj         = new Bin_Query();
        $obj->updateQuery($sql);

        $custlist=$_POST['id'];
        if (count((array)$custlist) > 0) {
            for($i=0;$i<count((array)$custlist);$i++) {
                $customers_id=$custlist[$i];
                $objc = new Bin_Query();
                $sqlc = "SELECT customers_email FROM " . $_ENV['PROMLM_PREFIX'] . "customers WHERE customers_id='".$customers_id."'";
                $objc->executeQuery($sqlc);
                $customer_email = $objc->records[0]['customers_email'];
                if ($customer_email!='') {
                    $obj            = new Bin_Query();
               $sql            = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "customergroup_members(customergroups_id,customers_id,customers_email,created_on,created_by)
                            VALUES('" . $customergroups_id . "','".$customers_id."','".$customer_email."',NOW(),'" . $members_id . "')";
                    $obj->updateQuery($sql);
                }
            }

        }


        $_SESSION['success_message'] = 'Recipient add group successfully';

    }


}
?>
