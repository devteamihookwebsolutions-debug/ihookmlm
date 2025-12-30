<?php

/**
 * This class contains public static functions related to profile
 *
 * @package         MMySite
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2008 - 2019, Sunsofty.
 * @version         Version 10.4
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php
namespace Model\Profile;

use Display\Profile\DMySite;
use Query\Bin_Query;

class MMySite
{
    /**
     * This public static function is used  to show member site details
     */
    public static function getMembersSiteDetail()
    {

        $members_id = $_SESSION['default']['customer_id'];
        $sql        = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "members_meta_table
        WHERE members_id='" . $members_id . "' AND meta_key = 'website_bio'";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records;
        return DMySite::getMembersSiteDetail($records);
    }

    /**
     * This public static function is used  to get user my website details
     * @return HTML
     */
    public static function getWebsiteDetails($user_id)
    {
        $sql = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "members_meta_table where meta_key='website_bio' AND members_id =$user_id";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records;
        return count((array) $records);
    }
    /**
     * This public static function is used  to update user my website details
     * @return HTML
     */
    public static function updateWebsiteDetails($meta_key)
    {
        $id      = $_SESSION['default']['customer_id'];
        $mobile  = $_POST['mobile'];
        $message = $_POST['message'];
        if ($meta_key == '') {
            $meta_data = json_encode(['mobile' => $mobile, 'message' => $message]);
            $obj1      = new Bin_Query();
            $sql1      = "INSERT INTO " . $_ENV['IHOOK_PREFIX'] . "members_meta_table(members_id,members_email,sec_code,meta_key,meta_data,created_on,created_by,updated_on,updated_by) VALUES('$id','','','website_bio','$meta_data',NOW(),'',NOW(),'')";
            if ($obj1->executeQuery($sql1)) {
                $_SESSION['success_message'] = "" . __('User has   been updated sucessfully') . "";
            } else {
                $_SESSION['success_message'] = "" . __('User has not been updated sucessfully') . "";
            }
        } else {
            $meta_data = json_encode(['mobile' => $mobile, 'message' => $message]);
            $obj1      = new Bin_Query();
            $sql1      = "UPDATE " . $_ENV['IHOOK_PREFIX'] . "members_meta_table SET meta_data = '$meta_data', updated_on = NOW()  WHERE members_id='$id' AND meta_key='website_bio'";
            if ($obj1->executeQuery($sql1)) {
                $_SESSION['success_message'] = "" . __('User has been updated sucessfully') . "";
            } else {
                $_SESSION['success_message'] = "" . __('User has not been updated sucessfully') . "";
            }

        }
        header('Location:' . $_ENV['FCPATH'] . '/myprofile');exit;
    }

}
