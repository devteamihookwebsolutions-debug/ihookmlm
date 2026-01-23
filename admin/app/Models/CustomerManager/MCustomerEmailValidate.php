<?php
/**
 * This class contains public static functions related to  customer email validate
 *
 * @package         MCustomerEmailValidate
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright        Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact Plan@alphabettechs.com.
*****************************************************************************/
?>
<?php
namespace Admin\App\Models\CustomerManager;
class MCustomerEmailValidate {
	/**
     * This public static function is used to get matrix type  details
     * @param string  $members_email
     * @return HTML data
     */
  public static function checkCustomerEmailexists($customers_email) {
        $sql = "SELECT customers_email FROM  " . $_ENV['PROMLM_PREFIX'] . "customers where customers_email='" . $customers_email . "'";
        $obj = new Bin_Query();
        if ($obj->executeQuery($sql)) {
           echo json_encode(array(
				'valid' => false,
			));
        } else {
           echo json_encode(array(
				'valid' => true,
			));
        }

	  exit;
    }
}
?>
