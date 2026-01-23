<?php
/**
 * This class contains public functions related to banner
 *
 * @package         MBanner
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php
namespace Model\Banner;
use Model\Middleware\MAmazonCloudFront;
use Query\Bin_Query;

class MBanner
{

    public function getBannerPath(){

        $banner_id                     = $_POST['banner_id'];
        $referlink_membersid           = $_POST['referlink_membersid'];
        $browserdetails                = $_POST['browserdetails'];
        $version                       = $_POST['version'];
        $platform                      = $_POST['platform'];
        $device                        = $_POST['device'];
        $useragent                     = $_POST['useragent'];
        $country                       = $_POST['country'];
        $ip                            = $_POST['ip'];
        $actual_link                   = $_POST['actual_link'];

        $sql    = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "affiliatedbanner_table WHERE banner_id='".$banner_id."'";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records;
        $bannerpath=$records[0]['banner_image'];

        //start : referral tracking
        $sqlre    = "INSERT INTO ".$_ENV['PROMLM_PREFIX']."referral_impressions_list(members_id,banner,ip,created_on,referer_url,country,browserdetails,version,platform,useragent,device) VALUES ('".$referlink_membersid."','".$bannerpath."','".$ip."',NOW(),'".$actual_link."','".$country."','".$browserdetails."','".$version."','".$platform."','".$useragent."','".$device."')";
        $objre = new Bin_Query();
        $objre->updateQuery($sqlre);
        //end: referral tracking


        $cryptlink=MAmazonCloudFront::getCloudFrontUrl($bannerpath);

        return $cryptlink;

    }

}
?>
