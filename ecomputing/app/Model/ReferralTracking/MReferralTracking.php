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
namespace Model\ReferralTracking;
use Query\Bin_Query;
class MReferralTracking
{

    public function getReferralTracking(){

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


        $sqlmem = "SELECT members_image FROM  " . $_ENV['PROMLM_PREFIX'] . "members_table WHERE members_id='" . $referlink_membersid . "'";
        $objmem = new Bin_Query();
        $objmem->executeQuery($sqlmem);
        $recordsmem = $objmem->records[0];
        $membersimage=$recordsmem['members_image'];


        //start : referral tracking
        $sqlre    = "INSERT INTO ".$_ENV['PROMLM_PREFIX']."referral_clicks_list(members_id,banner,ip,created_on,referer_url,country,browserdetails,version,platform,useragent,device) VALUES ('".$referlink_membersid."','".$bannerpath."','".$ip."',NOW(),'".$actual_link."','".$country."','".$browserdetails."','".$version."','".$platform."','".$useragent."','".$device."')";
        $objre = new Bin_Query();
        $objre->updateQuery($sqlre);
        //end: referral tracking
        if ($membersimage=='uploads/members/avatar.png') {
            $sqlsite = "SELECT * FROM  " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_name='user_profile_icon_based'";
            $objsite = new Bin_Query();
            $objsite->executeQuery($sqlsite);
            $user_profile_icon_based = $objsite->records[0]['sitesettings_value'];
            if ($user_profile_icon_based=='1') { //firstandlast
				$user_profile_icon=strtoupper($recordsmem['members_firstname'][0]).strtoupper($recordsmem['members_lastname'][0]);
			} elseif ($user_profile_icon_based=='2') {
				$user_profile_icon=strtoupper($recordsmem['members_username'][0]);
			} elseif ($user_profile_icon_based=='3') {
				$user_profile_icon=strtoupper($recordsmem['members_email'][0]);
            }

            $resultimg='<div class="profile-pic-string" style="
            background: #fff;
            padding: 7px 12px;
            border-radius: 100%;
            font-size: 14px;">'.$user_profile_icon.'</div>';

        }else{
            $userimage=$_ENV['CDNCLOUDEXTURL'].'/'.$membersimage;
            $resultimg='<img style="width: 54px;padding: 12px 12px 10px;vertical-align: middle;" src="'.$userimage.'">';
        }

        return $resultimg;


    }

}
?>
