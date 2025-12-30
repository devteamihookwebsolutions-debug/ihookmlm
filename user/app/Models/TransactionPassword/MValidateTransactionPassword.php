<?php
/**
 * This class contains public static functions related to fund transfer
 *
 * @package         CFundTransfer
 * @category        Controller
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
namespace Model\TransactionPassword;
use Query\Bin_Query;

class MValidateTransactionPassword
{
   /**
     * This public static function is used  to validateepinpass
     */
    public static function validateTransactionPassword()
    {
        if (trim($_POST['transaction_password']) != '') {
            $query                      = new Bin_Query();
            $link                       = $query->getConnection();
            $members_transpassword_post = mysqli_real_escape_string($link, trim($_POST["transaction_password"]));
            $obj                        = new Bin_Query();
            $sql                        = "SELECT members_transaction_password FROM " . $_ENV['PROMLM_PREFIX'] . "members_table WHERE members_id='" . $_SESSION['default']['customer_id'] . "'";
            $obj->executeQuery($sql);
            $members_transaction_password = $obj->records[0]['members_transaction_password'];
            if(sodium_crypto_pwhash_str_verify(trim($members_transaction_password),trim($members_transpassword_post))) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }
}
?>