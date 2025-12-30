<?php
/**
 * This class contains public static functions related to get  site details.
 *
 * @package         MAvatarGallery
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://promlmsoftware.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?><?php

namespace Model\Profile;

use Query\Bin_Query;
use Display\Profile\DAvatarGallery;

class MAvatarGallery
{
    /**
     * This public static function is used  to setAvatarGallery
     * @param   int $id
     * @param   int $members_id
     * @return HTML data
    */
    public static function setAvatarGallery($id, $members_id)
    {
        $sql = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "avatar_gallery where avatar_gallery_status='1' AND avatar_gallery_id='" . $id . "'";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records;
        $avatar_gallery_path = $records[0]['avatar_gallery_path'];
        $members_image_name = $records[0]['avatar_gallery_name'];
        if ($members_image_name != '') {
            $extpath = explode('.', $avatar_gallery_path);
            $imgfilename = $extpath[0];
            $ext = $extpath[1];
            $imagefilename = hash('sha256', $imgfilename) . '.' . $ext;
            $filetype = 'image/' . $ext;
            $image = $avatar_gallery_path;
            $updated_on = date('Y-m-d H:i:s');
            $obj = new Bin_Query();
            $sql = "UPDATE " . $_ENV['IHOOK_PREFIX'] . "members_table SET
                    members_image         ='" . $image . "',
                    members_thumb_image   ='" . $image . "',
                    updated_on            =NOW()
                    WHERE members_id='" . $members_id . "'";
            if ($obj->updateQuery($sql)) {
                $_SESSION['members_image'] = $image;
            }
        }
        $_SESSION['success_message'] = '' . __('Avatar has been updated successfully') . '';
    }
    public static function getAvatarGallery()
    {
        $sql = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "avatar_gallery WHERE avatar_gallery_status='1' AND avatar_gallery_rank='0'";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records;
        return DAvatarGallery::getAvatarGallery($records);
    }
}

?>
