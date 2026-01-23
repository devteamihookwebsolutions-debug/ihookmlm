<?php
/**
 * This class contains public static functions related to add Customer
 *
 * @package         MCustomerNameValidate
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

class MCustomerNameValidate {
    public static function checkCustomerNameExists($username) {
       $sql = "SELECT * FROM  " . $_ENV['PROMLM_PREFIX'] . "customers where customers_username='" . $username . "'";
        $obj = new Bin_Query();
        if ($obj->executeQuery($sql)) {
            echo '2';
        } else {
            echo '1';
        }
    }
}
?>
