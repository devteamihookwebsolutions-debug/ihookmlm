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


class MCustomerDefaultGroups {

     public static function getCustomerDefaultGroups(){

		$obj = new Bin_Query();
	    $sql = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "customersdefaultgroups WHERE status='1'";
        $obj->executeQuery($sql);
        $records = $obj->records;
        return DCustomerDefaultGroups::getCustomerDefaultGroups($records);
     }
     public static function getDefaultGroupMembers($status){

		$obj = new Bin_Query();
	    $sql = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "customers WHERE customers_status='".$status."'";
        $obj->executeQuery($sql);
        $recordsmem = $obj->records;

        return $recordsmem;
     }

     public static function sendMessageToDefaultGroups(){

        $sub=trim($_POST['subjectdefault']);
        $message=trim($_POST['messagedefault']);

        foreach ($_POST['customergroupsdefault_id'] as $val) {
            $objmem = new Bin_Query();
            $sqlmem = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "customersdefaultgroups WHERE customersdefaultgroups_id='".$val."'";
            $objmem->executeQuery($sqlmem);
            $recordsmem = $objmem->records;
            if ($recordsmem[0]['customersdefaultgroups_defaultname']=='active') {
                $status='1';  // 1 active
                $sql_user = "SELECT customers_email AS email  FROM " . $_ENV['PROMLM_PREFIX'] . "customers WHERE  customers_status='".$status."'";
            }
            if ($recordsmem[0]['customersdefaultgroups_defaultname']=='inactive') {
                $status='0';  // 0 INactive
                $sql_user = "SELECT customers_email AS email FROM " . $_ENV['PROMLM_PREFIX'] . "customers WHERE  customers_status='".$status."'";
            }
            if ($recordsmem[0]['customersdefaultgroups_defaultname']=='inactivepast30') {
                $sql_user = "SELECT a.customers_email AS email FROM " . $_ENV['PROMLM_PREFIX'] . "customers AS a
                JOIN `" . $_ENV['STORE_PREFIX'] . "posts` AS b ON b.post_author=a.customers_shop_id
                WHERE (b.post_type!='shop_order'OR b.post_type!='product' OR b.post_type!='attachment') AND DATE_FORMAT(post_date, '%Y-%m-%d') BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() GROUP BY a.customers_email";
            }
            if ($recordsmem[0]['customersdefaultgroups_defaultname']=='inactivepast60') {
                $sql_user = "SELECT a.customers_email AS email FROM " . $_ENV['PROMLM_PREFIX'] . "customers AS a
                JOIN `" . $_ENV['STORE_PREFIX'] . "posts` AS b ON b.post_author=a.customers_shop_id
                WHERE (b.post_type!='shop_order'OR b.post_type!='product' OR b.post_type!='attachment') AND DATE_FORMAT(post_date, '%Y-%m-%d') BETWEEN CURDATE() - INTERVAL 60 DAY AND CURDATE() GROUP BY a.customers_email";
            }
            if ($recordsmem[0]['customersdefaultgroups_defaultname']=='inactivepast90') {
                $sql_user = "SELECT a.customers_email AS email FROM " . $_ENV['PROMLM_PREFIX'] . "customers AS a
                JOIN `" . $_ENV['STORE_PREFIX'] . "posts` AS b ON b.post_author=a.customers_shop_id
                WHERE (b.post_type!='shop_order'OR b.post_type!='product' OR b.post_type!='attachment') AND DATE_FORMAT(post_date, '%Y-%m-%d') BETWEEN CURDATE() - INTERVAL 90 DAY AND CURDATE() GROUP BY a.customers_email";
            }
            $obj = new Bin_Query();
            $obj->executeQuery($sql_user);
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
            $name = str_replace('[name]', 'User', $body);
            $date = str_replace('[date]', $formatdate, $name);
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

            for ($i = 0; $i < $rountcount; $i++) {
                $maillist=$totlamemberssplit[$i];
                if (count($maillist) > 0) {
                    MSendBulkMail::sendMail($recordsmail, $maillist, $mess, '', '', '');
                } else {
                    break;
                }
            }

        $_SESSION['success_message'] = __('Mail send successfully');
        header('Location:' . $_ENV['BCPATH'] . '/customergroups');
        exit();
     }

    }
}
?>
