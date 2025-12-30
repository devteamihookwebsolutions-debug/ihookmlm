<?php

/**
 * This class contains public static functions related to profile
 *
 * @package         MSocialMedia
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

use Display\Profile\DSocialMedia;
use Query\Bin_Query;

class MSocialMedia
{
    /**
     * This public static function is used  to show member social media details
     */
    public static function getMembersSocialDetail()
    {

        $members_id = $_SESSION['default']['customer_id'];
        $sql        = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "members_meta_table
        WHERE members_id='" . $members_id . "' AND meta_key = 'social_media'";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records;
        return DSocialMedia::getMembersSocialDetail($records);
    }

    /**
     * This public static function is used  to get user social media details
     * @return HTML
     */
    public static function getSocialMediaDetails($user_id)
    {
        $sql = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "members_meta_table where meta_key='social_media' AND members_id =$user_id";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records;
        return count((array) $records);
    }
    /**
     * This public static function is used  to update user social media details
     * @return HTML
     */
    public static function updateSocialMediaDetails($meta_key)
    {
        $id        = $_SESSION['default']['customer_id'];
        $facebook  = $_POST['facebook'];
        $twitter   = $_POST['twitter'];
        $youtube   = $_POST['youtube'];
        $linkedin  = $_POST['linkedin'];
        $google    = $_POST['google'];
        $skype     = $_POST['skype'];
        $pinterest = $_POST['pinterest'];
        $tumblr    = $_POST['tumblr'];

        if ($meta_key == '') {
            $meta_data = json_encode(['facebook' => $facebook, 'twitter' => $twitter, 'youtube' => $youtube, 'linkedin' => $linkedin, 'google' => $google, 'skype' => $skype, 'pinterest' => $pinterest, 'tumblr' => $tumblr]);
            $obj1      = new Bin_Query();
            $sql1      = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "members_meta_table(members_id,members_email,sec_code,meta_key,meta_data,created_on,created_by,updated_on,updated_by) VALUES('$id','','','social_media','$meta_data',NOW(),'',NOW(),'')";
            if ($obj1->executeQuery($sql1)) {
                $_SESSION['success_message'] = "" . __('User has been updated sucessfully') . "";
            } else {
                $_SESSION['error_message'] = "" . __('User has not been updated sucessfully') . "";
            }
        } else {
            $meta_data = json_encode(['facebook' => $facebook, 'twitter' => $twitter, 'youtube' => $youtube, 'linkedin' => $linkedin, 'google' => $google, 'skype' => $skype, 'pinterest' => $pinterest, 'tumblr' => $tumblr]);
            $obj1      = new Bin_Query();
            $sql1      = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "members_meta_table SET meta_data = '$meta_data', updated_on = NOW()  WHERE members_id='$id' AND meta_key='social_media'";
            if ($obj1->executeQuery($sql1)) {
                $_SESSION['success_message'] = "" . __('User has been updated sucessfully') . "";
            } else {
                $_SESSION['error_message'] = "" . __('User has not been updated sucessfully') . "";
            }

        }
        header('Location:' . $_ENV['FCPATH'] . '/myprofile');exit;
    }

}