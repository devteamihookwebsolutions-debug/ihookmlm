<?php

/**
 * This class contains public static functions related to profile
 *
 * @package         MMembersAddress
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

use Query\Bin_Query;
 class MMembersAddress
{

     public static function updateAddressDetails(){


            $members_id = $_SESSION['default']['customer_id'];
            $obj = new Bin_Query();
            $sql = "UPDATE " . $_ENV['IHOOK_PREFIX'] . "members_table SET
            members_firstname ='" . trim($_POST['members_firstname']) . "',
            members_lastname ='" . trim($_POST['members_lastname']) . "',
            members_address  ='" . trim($_POST['members_address']) . "',
            members_address2     ='" . trim($_POST['members_address2']) . "',
            members_city     ='" . trim($_POST['members_city']) . "',
            members_state     ='" . trim($_POST['members_state']) . "',
			members_country     ='" . trim($_POST['members_country']) . "',
            members_zip     ='" . trim($_POST['members_zip']) . "',
            members_phone     ='" . trim($_POST['members_phone']) . "',
            updated_on        =NOW()
            WHERE members_id='" . $members_id . "'";
            if ($obj->updateQuery($sql)) {
                $_SESSION['success_message'] = '' . __('Address updated successfully') . '';
                header('Location:' .$_ENV['FCPATH']. '/myprofile');
                exit();
            } else {
               $_SESSION['success_message'] = '' . __('Address not updated') . '';
                header('Location:' .$_ENV['FCPATH']. '/myprofile');
                exit();
            }

     }




}
?>
