<?php

/**
 * This class contains public functions related to MCompressedGenealogy
 *
 * @package         MCompressedGenealogy
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?><?php
namespace Admin\App\Models\Genealogy;
use Query\Bin_Query;
use Model\Middleware\MMembersDetails;
use Model\Middleware\MAmazonS3;

use Model\Middleware\MAmazonCloudFront;
use Model\Middleware\MURLCrypt;
use Display\Factories\DSiteSettings;
class MCompressedGenealogy
{
     /**
     * This public static function is used  to get genealogy data
     * @param int $members_id
     * @param int $matrix_id
     * @return bool
    */
    public static function updateGenealogyDetails($members_id, $matrix_id)
    {
        $output='';
        //getdefault details
        $sqldefault = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table WHERE matrix_id='" . $matrix_id . "' AND members_id='" . $members_id . "'";
        $objdefault = new Bin_Query();
        $objdefault->executeQuery($sqldefault);
        $recordsdefault     = $objdefault->records;
        $default_members_id = $recordsdefault[0]['members_id'];
        $default_members_account_status= $recordsdefault[0]['members_account_status'];

        $sqlmembers = "SELECT SQL_CALC_FOUND_ROWS a.*,b.members_email,b.members_firstname,b.members_lastname,b.members_image,b.members_phone,b.members_username,c.members_username AS sponsorname,d.rank_key,d.rank_value,e.rank_value AS rank_icon_path FROM
            " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table AS a
            LEFT JOIN " . $_ENV['PROMLM_PREFIX'] . "members_table AS b ON a.members_id=b.members_id
            LEFT JOIN " . $_ENV['PROMLM_PREFIX'] . "members_table AS c ON c.members_id=a.direct_id
            LEFT JOIN " . $_ENV['PROMLM_PREFIX'] . "ranksetting AS d ON d.rank_id=a.rankid
            LEFT JOIN " . $_ENV['PROMLM_PREFIX'] . "ranksetting AS e ON (e.rank_id=a.rankid && e.rank_key='rank_icon_path' && e.matrix_id='" . $matrix_id . "')
            WHERE (FIND_IN_SET('" . $members_id . "',`members_parents`) || a.members_id='" . $members_id . "') AND a.members_account_status ='1'  GROUP BY a.link_id  ORDER BY a.position ASC LIMIT 1000";
        $objmembers = new Bin_Query();
        $objmembers->executeQuery($sqlmembers);
        $referralslinkdetails = $objmembers->records;
        if (count((array)$referralslinkdetails) > '0') {
             for ($i = 0; $i < count((array)$referralslinkdetails); $i++) {
                $groupTitleColor          = '#4169e1';
                $itemTitleColor           = '#4169e1';
                $spillover_id             = $referralslinkdetails[$i]['spillover_id'];
                $members_email            = $referralslinkdetails[$i]['members_email'];
                $memberimage              = $referralslinkdetails[$i]['members_image'];
                $memberimage              = $memberimage != '' ?  $memberimage : 'uploads/members/avatar.png';
				$memberimage              = $_ENV['CDNCLOUDEXTURL'].'/'.$memberimage;
                $members_fullname         = $referralslinkdetails[$i]['members_username'];
                $members_phone            = $referralslinkdetails[$i]['members_phone'];
                $linkid                   = $referralslinkdetails[$i]['link_id'];
                $sponsor_name             = $referralslinkdetails[$i]['sponsorname'];
                $rank_value               = $referralslinkdetails[$i]['rank_value'];
                $members_passup_id        = $referralslinkdetails[$i]['members_passup_id'];
                $members_passup_direct_id = $referralslinkdetails[$i]['members_passup_direct_id'];
                if ($members_passup_id > 0) {
                    $members_passup_id;
                    $member_details   = MMembersDetails::getPartMembersDetails('members_username',$members_passup_id);
                    $passupmembername = $member_details['members_username'];
                    $passupdetails    = ', Passup : ' . $passupmembername . '';
                } else {
                    $passupdetails = '';
                }
                $sponsor_name   = $sponsor_name == '' ? 'Nil' : $sponsor_name;
                $rank           = $rank_value == '' ? 'Nil' : $rank_value;
                $rank_icon_path = $referralslinkdetails[$i]['rank_icon_path'];
                $rank_icon_path = $rank_icon_path == '' ? '' :  $rank_icon_path;
				$rank_icon_path = $_ENV['CDNCLOUDEXTURL'].'/'.$rank_icon_path;
                if ($referralslinkdetails[$i]['rank_icon_path'] != '' && $referralslinkdetails[$i]['rankid'] > 0) {
                    $output .= '{ id:  "' . $referralslinkdetails[$i]['members_id'] . '", parent: "' . $spillover_id . '", title: "' . $members_fullname . '", description: "' .__('Sponsor') . ' : ' . $sponsor_name . ' ' . $passupdetails . '", phone: "' . $members_phone . '", email: "' . $members_email . '",rank: "' . __('Rank') . ' : ' . $rank . '", image: "' . $memberimage . '", rankimage: "' . $rank_icon_path . '",  templateName: "contactTemplate", members_id: "' . $referralslinkdetails[$i]['members_id'] . '",groupTitleColor:"' . $groupTitleColor . '",itemTitleColor:"' . $itemTitleColor . '", href: "/genealogy/viewtree/' . $linkid . '"},';
                } else {
                    $output .= '{ id:  "' . $referralslinkdetails[$i]['members_id'] . '", parent: "' . $spillover_id . '", title: "' . $members_fullname . '", description: "' .__('Sponsor') . ' : ' . $sponsor_name . ' ' . $passupdetails . '", phone: "' . $members_phone . '", email: "' . $members_email . '",rank: "' . __('Rank') . ' : ' . $rank . '", image: "' . $memberimage . '",rankimage: "0",  templateName: "contactTemplate1", members_id: "' . $referralslinkdetails[$i]['members_id'] . '",groupTitleColor:"' . $groupTitleColor . '",itemTitleColor:"' . $itemTitleColor . '", href: "/genealogy/viewtree/' . $linkid . '"},';
                }
            }
        }


        $output    = 'var data=[' . $output . ']';
        /*$upladfile = fopen("../".$_ENV['CURRENT_UPATH']."/shift/user" . $members_id . "" . $matrix_id . ".js", "w");
        fwrite($upladfile, $output);
        fclose($upladfile);*/
        /*start:amazonupload*/
        /*$flnm          = '../'.$_ENV['CURRENT_UPATH'].'/shift/user' . $members_id . $matrix_id . ".js";
        $amaname       = 'user' . $members_id . $matrix_id . ".js";
        $genealogyfile = 'uploads/genealogydata/' . $amaname;
        MAmazonS3::amazonFileCreation($flnm, 'text/js', $genealogyfile);*/
        /*end:amazonupload*/
        return $output;
    }

    public static function getCryptData()
    {
        $matrix_id=trim($_POST['matrix_id']);
        $sql = "SELECT a.*,b.matrix_value FROM " . $_ENV['PROMLM_PREFIX'] . "matrix_table AS a
        LEFT JOIN  " . $_ENV['PROMLM_PREFIX'] . "matrix_configuration_table AS b
        ON b.matrix_id=a.matrix_id  WHERE a.matrix_status='1' AND
        b.matrix_key='default_sponsor' AND a.matrix_id='".$matrix_id."' ORDER BY a.matrix_id ASC";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records;
        $crypturl = MURLCrypt::getEncryptURL($records[0]['matrix_id'],$records[0]['matrix_value']);

        $_SESSION['genealogylinkcrypt']=$crypturl;

        return $crypturl;

    }
     /**
     * This public static function is used  to update site active matrixdetails
     * @return HTML data
     */
    public static function getActiveMatrix()
    {

        $decrypturl =  MURLCrypt::getDecryptURL($_GET['sub1']);
        $members_id = $decrypturl[0];
        $matrix_id  = $decrypturl[1];
        $default_matrix=$matrix_id;

        $where          = 'WHERE matrix_status="1"';
        $sql            = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "matrix_table " . $where . "";
        $obj            = new Bin_Query();
        $obj->executeQuery($sql);
        $defaultmatrix = $obj->records;
        return DSitesettings::getActiveMatrix($defaultmatrix, $default_matrix);
    }

}
?>
