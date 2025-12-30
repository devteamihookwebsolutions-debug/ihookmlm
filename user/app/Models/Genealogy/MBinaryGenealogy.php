<?php
/**
 * This class contains public static functions related to genealogy
 *
 * @package         MGenealogy
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
namespace User\App\Models\Genealogy;
use Admin\App\Models\Middleware\MBinaryMembersPosition;
use Admin\App\Models\Middleware\MMatrixMemberLink;
use Admin\App\Models\Genealogy\MBinaryLinkDetails;
use Admin\App\Models\Middleware\MURLCrypt;

class MBinaryGenealogy
{
     /**
     * This public static function is used  to get genealogy data
     * @param int $members_id
     * @param int $matrix_id
     * @return bool
    */
  public static function getBinaryGenealogyDetails($members_id, $matrix_id)
{
    $finalArray = [];

    // Root user (current member)
    $binaryparentdetails = MBinaryLinkDetails::getBinaryLinkDetails($members_id, $matrix_id);
    $spillover_id        = $binaryparentdetails['spillover_id'] ?? '';
    $members_username    = $binaryparentdetails['membername'] ?? 'Unknown';
    $members_phone       = $binaryparentdetails['members_phone'] ?? '';
    $members_email       = $binaryparentdetails['members_email'] ?? '';
    $memberImagePath = $binaryparentdetails['members_image']? '/'.$binaryparentdetails['members_image']: '/assets/img/avatar/avatar.png';
    $members_image = asset($memberImagePath);
    // dd($members_image);
    // $members_image       = $binaryparentdetails['members_image'] ? $binaryparentdetails['members_image'] : '/assets/img/avatar/avatar.png';
    $sponsor_username    = $binaryparentdetails['direct_id'] > 0 ? $binaryparentdetails['sponsor_username'] : 'Nil';
    $ranktitle           = $binaryparentdetails['ranktitle'] ?? 'Nil';
    $rankid              = $binaryparentdetails['rankid'] ?? 0;

    $count = MBinaryMembersCount::getBinaryMemberscount($members_id, $matrix_id);
    $leftcount = $count['left'] ?? 0;
    $rightcount = $count['right'] ?? 0;

    $template = $rankid > 0 ? 'contactTemplate' : 'contactTemplate1';

    $finalArray[] = [
        'id'               => (string)$members_id,
        'parent'           => $spillover_id ? (string)$spillover_id : "",
        'title'            => $members_username,
        'description'      => "Sponsor : {$sponsor_username}",
        'phone'            => $members_phone,
        'email'            => $members_email,
        'rank'             => "Rank : {$ranktitle}",
        'image'            => $members_image,
        'templateName'     => $template,
        'leftmembercount'  => "Left total members : {$leftcount}",
        'rightmembercount' => "Right total members : {$rightcount}",
        'members_id'       => (string)$members_id,
        'href'             => "/genealogy/viewtree/" . MURLCrypt::encode($members_id, $matrix_id)
    ];

    // Left & Right children
    $leftuser  = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '1');
    $rightuser = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '2');

    $where = [['spillover_id', '=', $members_id], ['matrix_id', '=', $matrix_id]];
    $referrals = MMatrixMemberLink::getMatrixLinkDetails($where);

    if (count((array)$referrals) == 2) {
        if ($leftuser > 0)  $finalArray = array_merge($finalArray, self::getChildNodes($leftuser, $members_id, $matrix_id));
        if ($rightuser > 0) $finalArray = array_merge($finalArray, self::getChildNodes($rightuser, $members_id, $matrix_id));
    }
    elseif (count((array)$referrals) == 1) {
        if ($leftuser > 0) {
            $finalArray = array_merge($finalArray, self::getChildNodes($leftuser, $members_id, $matrix_id));
            $finalArray[] = self::getEmptyNode($members_id, $matrix_id, '2');
        }
        if ($rightuser > 0) {
            $finalArray[] = self::getEmptyNode($members_id, $matrix_id, '1');
            $finalArray = array_merge($finalArray, self::getChildNodes($rightuser, $members_id, $matrix_id));
        }
    }
    else {
        $finalArray[] = self::getEmptyNode($members_id, $matrix_id, '1');
        $finalArray[] = self::getEmptyNode($members_id, $matrix_id, '2');
    }

    // dd($finalArray);
return json_encode($finalArray, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}
private static function getChildNodes($child_id, $parent_id, $matrix_id)
{
    $nodes = [];
    $details = MBinaryLinkDetails::getBinaryLinkDetails($child_id, $matrix_id);

    if (!$details || !is_array($details)) {
        $details = ['membername' => 'Unknown', 'members_phone' => '', 'members_email' => '',
                    'members_image' => '/assets/img/avatar/avatar.png', 'sponsor_username' => 'Nil',
                    'ranktitle' => 'Nil', 'rankid' => 0];
    }

    $count = MBinaryMembersCount::getBinaryMemberscount($child_id, $matrix_id);
    $template = ($details['rankid'] ?? 0) > 0 ? 'contactTemplate' : 'contactTemplate1';
    $image = $details['members_image'] ? $details['members_image'] : '/assets/img/avatar/avatar.png';
// dd($image);
    $nodes[] = [
        'id'               => (string)$child_id,
        'parent'           => (string)$parent_id,
        'title'            => $details['membername'] ?? 'Unknown',
        'description'      => "Sponsor : " . ($details['direct_id'] > 0 ? $details['sponsor_username'] : 'Nil'),
        'phone'            => $details['members_phone'] ?? '',
        'email'            => $details['members_email'] ?? '',
        'rank'             => "Rank : " . ($details['ranktitle'] ?? 'Nil'),
        'image'            => $image,
        'templateName'     => $template,
        'leftmembercount'  => "Left total members : " . ($count['left'] ?? 0),
        'rightmembercount' => "Right total members : " . ($count['right'] ?? 0),
        'members_id'       => (string)$child_id,
        'href'             => "/genealogy/viewtree/" . MURLCrypt::encode($child_id, $matrix_id)
    ];

    // Recursive depth
    $left  = MBinaryMembersPosition::getBinaryMembersPosition($child_id, $matrix_id, '1');
    $right = MBinaryMembersPosition::getBinaryMembersPosition($child_id, $matrix_id, '2');

    if ($left > 0)  $nodes = array_merge($nodes, self::getChildNodes($left, $child_id, $matrix_id));
    if ($right > 0) $nodes = array_merge($nodes, self::getChildNodes($right, $child_id, $matrix_id));

    return $nodes;
}

private static function getEmptyNode($parent_id, $matrix_id, $position)
{
    $random = mt_rand(10000000, 99999999);
    return [
        'id'           => (string)$random,
        'parent'       => (string)$parent_id,
        'position'     => $position,
        'title'        => "",
        'image'        => asset('assets/img/no-avatar.png'),
        'templateName' => "contactTemplate2",
        'href'         => "/genealogy/viewtree/" . MURLCrypt::encode($parent_id, $matrix_id)
    ];
}
public static function getDepthBinaryGenealogy($members_id, $matrix_id, $targetroot)
    {
        $output = '';
        if ($members_id > 0) {
            $groupTitleColor       = '#4169e1';
            $itemTitleColor        = '#B800E6';
            $binaryparentdetails   = MBinaryLinkDetails::getBinaryLinkDetails($members_id, $matrix_id, $targetroot);
            $direct_id             = $binaryparentdetails['direct_id'];
            $matrix_doj            = $binaryparentdetails['matrix_doj'];
            $members_username      = $binaryparentdetails['membername'];
            $members_email         = $binaryparentdetails['members_email'];
            $members_image         = $binaryparentdetails['members_image'];
            $childroot             = $binaryparentdetails['root'];
            $sponsor_username      = $binaryparentdetails['sponsor_username'];
            $sponsor_username      = $direct_id > '0' ? $sponsor_username : 'Nil';
            $rankid                = $binaryparentdetails['rankid'];
            $rank_icon_path        = $binaryparentdetails['rank_icon_path'];


            $leftuser=MBinaryMembersPosition::getBinaryMembersPosition($members_id,$matrix_id,'1');
            $rightuser=MBinaryMembersPosition::getBinaryMembersPosition($members_id,$matrix_id,'2');

            $rank_icon_path        = $rankid == '' ? '0' : $rank_icon_path;
        $where = [
            ['spillover_id', '=', $members_id],
            ['matrix_id', '=', $matrix_id]
        ];
        $referralslinkdetails = MMatrixMemberLink::getMatrixLinkDetails($where);
            if ($childroot <= $targetroot) {
                if (count((array)$referralslinkdetails) == '2') { //for both side  is filled
                    //showleftdetails
                    $binaryleftdetails    = MBinaryLinkDetails::getBinaryLinkDetails($leftuser, $matrix_id, $targetroot);
                   if (!$binaryleftdetails || !is_array($binaryleftdetails)) {
        $binaryleftdetails = [
            'direct_id' => 0, 'membername' => 'Unknown', 'matrix_doj'=>'', 'members_phone' => '', 'members_email' => '',
            'ranktitle' => '', 'members_image' => '', 'sponsor_username' => 'Nil', 'rankid' => 0
        ];
    }
                    $leftdirect_id        = $binaryleftdetails['direct_id'];
                    $leftmatrix_doj       = $binaryleftdetails['matrix_doj'];
                    $leftmembers_username = $binaryleftdetails['membername'];
                    $leftmembers_email    = $binaryleftdetails['members_email'];
                    $leftranktitle        = $binaryleftdetails['ranktitle'];
                    $leftmembers_phone    = $binaryleftdetails['members_phone'];
                    $leftmembers_image    = $binaryleftdetails['members_image'];
                    $leftsponsor_username = $binaryleftdetails['sponsor_username'];
                    $leftsponsor_username = $leftdirect_id > '0' ? $leftsponsor_username : 'Nil';
                    $leftrankid           = $binaryleftdetails['rankid'];
                    // $leftrank_icon_path   = $binaryleftdetails['rank_value'];
                    $leftmembers_image    = $leftmembers_image != '' ?   $leftmembers_image : '/assets/img/avatar/avatar.png';
                    // $leftrank_icon_path   = $leftrank_icon_path == '' ? '' :  $leftrank_icon_path;


                    $leftcontacttemplate  = $leftrankid > '0' ? 'contactTemplate' : 'contactTemplate1';
                    $count                = MBinaryMembersCount::getBinaryMemberscount($leftuser, $matrix_id);
                    $leftcount            = $count['left'];
                    $rightcount           = $count['right'];
                    $lefttotalmember      = $leftcount;
                    $righttotalmember     = $rightcount;
                    $leftranktitle        = $leftranktitle == '' ? 'Nil' : $leftranktitle;
                    $output .= '{ id:  "' . $leftuser . '", parent: "' . $members_id . '", title: "' . $leftmembers_username . '", description: "Sponsor : ' . $leftsponsor_username . '", phone: "' . $leftmembers_phone . '", email: "' . $leftmembers_email . '",rank: "Rank : ' . $leftranktitle . '", image: "' . $leftmembers_image . '", leftmembercount:"Left total members : ' . $lefttotalmember . '",rightmembercount:"Right total members : ' . $righttotalmember . '",  templateName: "' . $leftcontacttemplate . '", members_id: "' . $leftuser . '",href: "/genealogy/viewtree/' . $leftuser . '"},';
                    //showrightdetails
                    $binaryrightdetails    = MBinaryLinkDetails::getBinaryLinkDetails($rightuser, $matrix_id, $targetroot);
                   if (!$binaryrightdetails || !is_array($binaryrightdetails)) {
        $binaryrightdetails = [
            'direct_id' => 0, 'membername' => 'Unknown','matrix_doj'=>'', 'members_phone' => '', 'members_email' => '',
            'ranktitle' => '', 'members_image' => '', 'sponsor_username' => 'Nil', 'rankid' => 0
        ];
    }
                    $rightdirect_id        = $binaryrightdetails['direct_id'];
                    $rightmatrix_doj       = $binaryrightdetails['matrix_doj'];
                    $rightmembers_username = $binaryrightdetails['membername'];
                    $rightmembers_phone    = $binaryrightdetails['members_phone'];
                    $rightranktitle        = $binaryrightdetails['ranktitle'];
                    $rightmembers_email    = $binaryrightdetails['members_email'];
                    $rightmembers_image    = $binaryrightdetails['members_image'];
                    $rightsponsor_username = $binaryrightdetails['sponsor_username'];
                    $rightsponsor_username = $rightdirect_id > '0' ? $rightsponsor_username : 'Nil';
                    $rightrankid           = $binaryrightdetails['rankid'];
                    // $rightrank_icon_path   = $binaryrightdetails['rank_value'];
                    $rightmembers_image    = $rightmembers_image != '' ?  $rightmembers_image : '/assets/img/avatar/avatar.png';
                    // $rightrank_icon_path   = $rightrank_icon_path == '' ? '' :  $rightrank_icon_path;


                    $rightcontacttemplate  = $rightrankid > '0' ? 'contactTemplate' : 'contactTemplate1';
                    $count                 = MBinaryMembersCount::getBinaryMemberscount($rightuser, $matrix_id);
                    $leftcount             = $count['left'];
                    $rightcount            = $count['right'];
                    $lefttotalmember       = $leftcount;
                    $righttotalmember      = $rightcount;
                    $rightranktitle        = $rightranktitle == '' ? 'Nil' : $rightranktitle;
                    $output .= '{ id:  "' . $rightuser . '", parent: "' . $members_id . '", title: "' . $rightmembers_username . '", description: "Sponsor : ' . $rightsponsor_username . '", phone: "' . $rightmembers_phone . '", email: "' . $rightmembers_email . '",rank: "Rank : ' . $rightranktitle . '", image: "' . $rightmembers_image . '",leftmembercount:"Left total members : ' . $lefttotalmember . '",rightmembercount:"Right total members : ' . $righttotalmember . '",  templateName: "' . $rightcontacttemplate . '", members_id: "' . $members_id . '", href: "/genealogy/viewtree/' . $rightuser . '"},';
                    ;
                    $output .= self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
                    $output .= self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
                }elseif (count((array)$referralslinkdetails) == '1') { //for one side  is filled
                    if ($leftuser > 0) {
                        //showleftdetails
                        $binaryleftdetails         = MBinaryLinkDetails::getBinaryLinkDetails($leftuser, $matrix_id, $targetroot);
                        $leftdirect_id             = $binaryleftdetails['direct_id'];
                        $leftmatrix_doj            = $binaryleftdetails['matrix_doj'];
                        $leftmembers_username      = $binaryleftdetails['membername'];
                        $leftmembers_email         = $binaryleftdetails['members_email'];
                        $leftmembers_members_phone = $binaryleftdetails['members_phone'];
                        $leftranktitle             = $binaryleftdetails['ranktitle'];
                        $leftmembers_image         = $binaryleftdetails['members_image'];
                        $leftsponsor_username      = $binaryleftdetails['sponsor_username'];
                        $leftsponsor_username      = $leftdirect_id > '0' ? $leftsponsor_username : 'Nil';
                        $leftrankid                = $binaryleftdetails['rankid'];
                        // $leftrank_icon_path        = $binaryleftdetails['rank_value'];
                        $leftmembers_image         = $leftmembers_image != '' ?  $leftmembers_image : '/assets/img/avatar/avatar.png';
                        // $leftrank_icon_path        = $leftrank_icon_path == '' ? '' :  $leftrank_icon_path;


                        $leftcontacttemplate       = $leftrankid > '0' ? 'contactTemplate' : 'contactTemplate1';
                        $count                     = MBinaryMembersCount::getBinaryMemberscount($leftuser, $matrix_id);
                        $leftcount                 = $count['left'];
                        $rightcount                = $count['right'];
                        $lefttotalmember           = $leftcount;
                        $righttotalmember          = $rightcount;
                        $leftranktitle             = $leftranktitle == '' ? 'Nil' : $leftranktitle;
                        $output .= '{ id:  "' . $leftuser . '", parent: "' . $members_id . '", title: "' . $leftmembers_username . '", description: "Sponsor : ' . $leftsponsor_username . '", phone: "' . $leftmembers_members_phone . '", email: "' . $leftmembers_email . '",rank: "Rank : ' . $leftranktitle . '", image: "' . $leftmembers_image . '", leftmembercount:"Left total members : ' . $lefttotalmember . '",rightmembercount:"Right total members : ' . $righttotalmember . '", templateName: "' . $leftcontacttemplate . '", members_id: "' . $members_id . '",href: "/genealogy/viewtree/' . $leftuser . '"},';
                        $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '2');
                        $output .= self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
                    }
                    if ($rightuser > 0) {
                        $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '1');
                        $binaryrightdetails    = MBinaryLinkDetails::getBinaryLinkDetails($rightuser, $matrix_id, $targetroot);
                        $rightdirect_id        = $binaryrightdetails['direct_id'];
                        $rightmatrix_doj       = $binaryrightdetails['matrix_doj'];
                        $rightmembers_username = $binaryrightdetails['membername'];
                        $rightmembers_phone    = $binaryrightdetails['members_phone'];
                        $rightmembers_email    = $binaryrightdetails['members_email'];
                        $rightranktitle        = $binaryrightdetails['ranktitle'];
                        $rightmembers_image    = $binaryrightdetails['members_image'];
                        $rightsponsor_username = $binaryrightdetails['sponsor_username'];
                        $rightsponsor_username = $rightdirect_id > '0' ? $rightsponsor_username : 'Nil';
                        $rightrankid           = $binaryrightdetails['rankid'];
                        // $rightrank_icon_path   = $binaryrightdetails['rank_value'];
                        $rightmembers_image    = $rightmembers_image != '' ?  $rightmembers_image : '/assets/img/avatar/avatar.png';
                        // $rightrank_icon_path   = $rightrank_icon_path == '' ? '' :  $rightrank_icon_path;




                        $rightcontacttemplate  = $rightrankid > '0' ? 'contactTemplate' : 'contactTemplate1';
                        $count                 = MBinaryMembersCount::getBinaryMemberscount($rightuser, $matrix_id);
                        $leftcount             = $count['left'];
                        $rightcount            = $count['right'];
                        $lefttotalmember       = $leftcount;
                        $righttotalmember      = $rightcount;
                        $rightranktitle        = $rightranktitle == '' ? 'Nil' : $rightranktitle;
                        $output .= '{ id:  "' . $rightuser . '", parent: "' . $members_id . '", title: "' . $rightmembers_username . '", description: "Sponsor : ' . $rightsponsor_username . '", phone: "' . $rightmembers_phone . '", email: "' . $rightmembers_email . '",rank: "Rank : ' . $rightranktitle . '", image: "' . $rightmembers_image . '",leftmembercount:"Left total members : ' . $lefttotalmember . '",rightmembercount:"Right total members : ' . $righttotalmember . '", templateName: "' . $rightcontacttemplate . '", members_id: "' . $members_id . '", href: "/genealogy/viewtree/' . $rightuser . '"},';
                        $output .= self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
                    }
                }elseif (count((array)$referralslinkdetails) == '0' && $childroot < $targetroot) { //for both side  is empty
                    $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '1');
                    $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '2');
                }
            }
        }
        return $output;
    }
    public static function getEmptyBianryGenealogyDetails($members_id, $matrix_id, $position)
    {
        $output         = '';
		$emtpyimagepath = $_ENV['UI_ASSET_URL'].'/public/assets/img/no-avatar.png';
        $randommember   = mt_rand(10000000, 99999999);
        $output .= '{ id:  "' . $randommember . '", parent: "' . $members_id . '",position:"' . $position . '", title: "",image: "' . $emtpyimagepath . '",templateName: "contactTemplate2", href: "/genealogy/viewtree/' . $members_id . '"},';



        return $output;
    }
}
?>
