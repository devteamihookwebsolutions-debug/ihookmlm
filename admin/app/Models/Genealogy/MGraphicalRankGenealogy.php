<?php
/**
 * This class contains public static functions related to graphical genealogy
 *
 * @package         MGraphicalGenealogy
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright      Copyright (c) 2020 - 2023, Sunsofty.
 * @version        Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php
namespace Admin\App\Models\Genealogy;
use Query\Bin_Query;
use Model\Middleware\MMemberDetails;
use Model\Middleware\MAmazonS3;

use Model\Middleware\MAmazonCloudFront;
class MGraphicalRankGenealogy
{


    public static function updateGenealogyDetails($members_id,$matrix_id)
    {
        //getdefault details
        $sqldefault = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table WHERE matrix_id='" . $matrix_id . "' AND members_id='" . $members_id . "'";
        $objdefault = new Bin_Query();
        $objdefault->executeQuery($sqldefault);
        $recordsdefault     = $objdefault->records;
        $default_members_id = $recordsdefault[0]['members_id'];

         $sqlmembers = "SELECT SQL_CALC_FOUND_ROWS a.*,b.members_email,b.members_firstname,b.members_lastname,b.members_image,b.rankgenealogy_name,b.members_phone,b.members_username,c.members_username AS sponsorname,d.rank_key,d.rank_value,e.rank_value AS rank_icon_path,f.rank_value AS rankcolor FROM
            " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table AS a
            LEFT JOIN " . $_ENV['PROMLM_PREFIX'] . "members_table AS b ON a.members_id=b.members_id
            LEFT JOIN " . $_ENV['PROMLM_PREFIX'] . "members_table AS c ON c.members_id=a.direct_id
            LEFT JOIN " . $_ENV['PROMLM_PREFIX'] . "ranksetting AS d ON d.rank_id=a.rankid
            LEFT JOIN " . $_ENV['PROMLM_PREFIX'] . "ranksetting AS e ON (e.rank_id=a.rankid && e.rank_key='rank_icon_path' && e.matrix_id='" . $matrix_id . "')
            LEFT JOIN " . $_ENV['PROMLM_PREFIX'] . "ranksetting AS f ON (f.rank_id=a.rankid AND f.rank_key='rank_color' AND f.matrix_id='" . $matrix_id . "')
            WHERE (FIND_IN_SET('" . $members_id . "',`members_parents`) || a.members_id='" . $members_id . "')
            AND a.matrix_id='" . $matrix_id . "'
            GROUP BY a.link_id ORDER BY a.position ASC LIMIT 1000";
        $objmembers = new Bin_Query();
        $objmembers->executeQuery($sqlmembers);
        $referralslinkdetails = $objmembers->records;


        $sqldefaultSponsor    = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "matrix_configuration_table WHERE matrix_key='default_sponsor' AND matrix_id=" . $matrix_id . " ";
        $objSponsor           = new Bin_Query();
        $objSponsor->executeQuery($sqldefaultSponsor);
        $dfsponsors      = $objSponsor->records;
        $default_sponsor = $dfsponsors[0]['matrix_value'];
        $totalusers      = count((array)$referralslinkdetails);

        if (count((array)$referralslinkdetails) > '0') {
            if ($totalusers > 2000) { //start 2000
                for($i = 0; $i < count((array)$referralslinkdetails); $i++) {
                    if ($i < 43) {
                        $groupTitleColor          = '#4169e1';
                        $itemTitleColor           = '#4169e1';
                        $spillover_id             = $referralslinkdetails[$i]['spillover_id'];
                        $members_email            = $referralslinkdetails[$i]['members_email'];
                        $members_firstname        = $referralslinkdetails[$i]['members_firstname'];
                        $members_lastname         = $referralslinkdetails[$i]['members_lastname'];
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
                            $member_details   = MMemberDetails::getPartMembersDetails('members_username',$members_passup_id);
                            $passupmembername = $member_details['members_username'];
                            $passupdetails    = ', Passup : ' . $passupmembername . '';
                        } else {
                            $passupdetails = '';
                        }
                        $sponsor_name   = $sponsor_name == '' ? 'Nil' : $sponsor_name;
                        $rank           = $rank_value == '' ? 'Nil' : $rank_value;
                        $rank_icon_path = $referralslinkdetails[$i]['rank_icon_path'];
                        $rank_icon_path = $rank_icon_path == '' ? '' : $_ENV['CDNCLOUDEXTURL'].'/'.$rank_icon_path;
                        $rank_color         = $referralslinkdetails[$i]['rankcolor'];
                        $rankgenealogy_name = $referralslinkdetails[$i]['rankgenealogy_name'];
                        if ($default_sponsor != $members_id) {
                            if ($i == 0) {
                                $spillover_id = 0;
                            }
                        } else {
                            $spillover_id = $spillover_id;
                        }
                        $title = $members_firstname . ' ' . $members_lastname;
                        $title = $title == '' ? 'Nil' : $title;
                        if ($referralslinkdetails[$i]['rank_icon_path'] != '' && $referralslinkdetails[$i]['rankid'] > 0) {
                            $output .= '{ id:  "' . $referralslinkdetails[$i]['members_id'] . '", name: "' . $members_fullname . '", pid: ' . $spillover_id . ', title: "' . $title . '", description: "' . __('Sponsor') . ' : ' . $sponsor_name . ' ' . $passupdetails . '", phone: "' . $members_phone . '", email: "' . $members_email . '",rank: "' .  __('Rank') . ' : ' . $rank . '", img: "' . $memberimage . '", rankimage: "' . $rank_icon_path . '", members_id: "' . $referralslinkdetails[$i]['members_id'] . '", matrix_id:  ' . $referralslinkdetails[$i]['matrix_id'] . ', rankgenealogy_name: "' . $rankgenealogy_name . '"},';
                                 $rank_color_css .= '.node.' . $rankgenealogy_name . ' rect {
                                        fill: ' . $rank_color . ';
                                    }';


                        } else {
                            $output .= '{ id:  "' . $referralslinkdetails[$i]['members_id'] . '", name: "' . $members_fullname . '", pid: ' . $spillover_id . ', title: "' . $title . '", description: "' . __('Sponsor') . ' : ' . $sponsor_name . ' ' . $passupdetails . '", phone: "' . $members_phone . '", email: "' . $members_email . '",rank: "' .  __('Rank') . ' : ' . $rank . '", img: "' . $memberimage . '",rankimage: "0", members_id: "' . $referralslinkdetails[$i]['members_id'] . '",matrix_id:  ' . $referralslinkdetails[$i]['matrix_id'] . ', rankgenealogy_name: "' . $rankgenealogy_name . '"},';
                                 $rank_color_css .= '.node.' . $rankgenealogy_name . ' rect {
                                        fill: ' . $rank_color . ';
                                    }';



                        }
                    }
                }
            } //end 2000
            else {

$rescont=count((array)$referralslinkdetails);
for ($i=0; $i < $rescont; $i++) {

                    $groupTitleColor          = "#4169e1";
                    $itemTitleColor           = "#4169e1";
                    $spillover_id             = $referralslinkdetails[$i]['spillover_id'];
                    $members_email            = $referralslinkdetails[$i]['members_email'];
                    $members_firstname        = $referralslinkdetails[$i]['members_firstname'];
                    $members_lastname         = $referralslinkdetails[$i]['members_lastname'];
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
                    $title                    = $members_firstname . ' ' . $members_lastname;
                    $title                    = $title == '' ? 'Nil' : $title;
                    if ($members_passup_id > 0) {
                        $members_passup_id;
                        $member_details   = MMemberDetails::getPartMembersDetails('members_username',$members_passup_id);
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
                    $rank_color         = $referralslinkdetails[$i]['rankcolor'];
                    $rankgenealogy_name = $referralslinkdetails[$i]['rankgenealogy_name'];

                    if ($default_sponsor != $members_id) {
                        if ($i == 0) {
                            $spillover_id = 0;
                        }
                    } else {
                        $spillover_id = $spillover_id;
                    }
                    $title = $members_firstname . ' ' . $members_lastname;
                    $title = $title == '' ? 'Nil' : $title;
                    if ($referralslinkdetails[$i]['rank_icon_path'] != '' && $referralslinkdetails[$i]['rankid'] > 0) {
                        $output .= '{ id:  "' . $referralslinkdetails[$i]['members_id'] . '", name: "' . $members_fullname . '", pid: ' . $spillover_id . ', title: "' . $title . '", description: "' . __('Sponsor') . ' : ' . $sponsor_name . ' ' . $passupdetails . '", phone: "' . $members_phone . '", email: "' . $members_email . '",rank: "' .  __('Rank') . ' : ' . $rank . '", img: "' . $memberimage . '", rankimage: "' . $rank_icon_path . '", members_id: "' . $referralslinkdetails[$i]['members_id'] . '", matrix_id:  ' . $referralslinkdetails[$i]['matrix_id'] . ', rankgenealogy_name: "' . $rankgenealogy_name . '"},';
                                 $rank_color_css .= '.node.' . $rankgenealogy_name . ' rect {
                                        fill: ' . $rank_color . ';
                                    }';


                    } else {
                        $output .= '{ id:  "' . $referralslinkdetails[$i]['members_id'] . '", name: "' . $members_fullname . '", pid: ' . $spillover_id . ', title: "' . $title . '", description: "' . __('Sponsor') . ' : ' . $sponsor_name . ' ' . $passupdetails . '", phone: "' . $members_phone . '", email: "' . $members_email . '",rank: "' .  __('Rank') . ' : ' . $rank . '", img: "' . $memberimage . '",rankimage: "0", members_id: "' . $referralslinkdetails[$i]['members_id'] . '",matrix_id:  ' . $referralslinkdetails[$i]['matrix_id'] . ', rankgenealogy_name: "' . $rankgenealogy_name . '"},';
                           $rank_color_css .= '.node.' . $rankgenealogy_name . ' rect {
                                        fill: ' . $rank_color . ';
                                    }';

                    }
                }
            }
        }
        $output    = 'var data=[' . $output . ']';
        $returnoutput=array();
        $returnoutput[0]=$output;
        $returnoutput[1]=$rank_color_css;
        /* $upladfile = fopen("../".$_ENV['CURRENT_UPATH']."/shift/usergraphical" . $members_id . "" . $matrix_id . ".js", "w");
        fwrite($upladfile, $output);
        fclose($upladfile);

        $flnm          = '../'.$_ENV['CURRENT_UPATH'].'/shift/usergraphical' . $members_id . $matrix_id . ".js";
        $amaname       = 'usergraphical' . $members_id . $matrix_id . ".js";
        $genealogyfile = 'uploads/genealogydata/' . $amaname;
        MAmazonS3::amazonFileCreation($flnm, 'text/js', $genealogyfile);
       end:amazonupload

            $cssfile = fopen("../".$_ENV['CURRENT_UPATH']."/shift/usergraphical" . $members_id . "" . $matrix_id . ".css", "w");
            fwrite($cssfile, $rank_color_css);
            fclose($cssfile);
            $flnm          = '../'.$_ENV['CURRENT_UPATH'].'/shift/usergraphical' . $members_id . $matrix_id . ".css";
            $amaname       = 'usergraphical' . $members_id . $matrix_id . ".css";
            $genealogyfile = 'uploads/genealogydata/' . $amaname;
            MAmazonS3::amazonFileCreation($flnm, 'text/css', $genealogyfile);
            end:amazonupload*/
        return $returnoutput;

    }
}
?>
