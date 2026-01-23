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

use Query\Bin_Query;

class MReferralHeaderBanner
{
    public static function getReferralHeader()
    {
        $referral_no = $_POST['username'];

        $filterdata = $_ENV['CARTBASEPATH'].'/'.$referral_no;

        $queryuser  = new Bin_Query();
        $sqluser = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "members_table WHERE members_subdomain = '" . $filterdata . "'";
        $queryuser->executeQuery($sqluser);
        $resultuser = $queryuser->records;

        if (count((array) $resultuser) > 0) {
            $row = $resultuser[0];

            $members_username  = $row['members_username'];
            $members_firstname = $row['members_firstname'];
            $members_lastname  = $row['members_lastname'];
            $members_phone     = $row['members_phone'];
            $members_email     = $row['members_email'];
            $members_image     = $row['members_image'];
            $members_subdomain = $row['members_subdomain'];
            $members_id        = $row['members_id'];

            $matrix_id = 1;
            $refelinkencode = 'ref' . $members_id . '-' . $matrix_id;
            $refelinkencode = urlencode(base64_encode($refelinkencode));
            $referral_link = $_ENV['BASEPATH'] . '/' . $refelinkencode;

            $memberimage = $members_image == 'uploads/members/avatar.png'
            ? $_ENV['UI_ASSET_URL'] . '/tailassets/img/register-package/avatar.png'
            : $_ENV['CDNCLOUDEXTURL'] . '/' . $members_image;


            $name = $members_username . " - " . $members_firstname . " " . $members_lastname;
            $user_profile_icon = substr(strtoupper($members_username), 0, 1);
            // Return JSON response
            return json_encode([
                'status' => 200,
                'message' => 'Referral Header Banner',
                'data' => [
                    'username' => $members_username,
                    'fullname' => $members_firstname . ' ' . $members_lastname,
                    'email' => $members_email,
                    'phone' => $members_phone,
                    'image' => $memberimage,
                    'referral_link' => $referral_link,
                    'user_profile_icon' => $user_profile_icon,
                    'referral_name_display' => $name,
                    'site_link' => $_ENV['BASEPATH']
                ]
            ]);
        } else {
            return json_encode([
                'status' => 404,
                'message' => 'No referral found',
                'data' => []
            ]);
        }
    }


}
