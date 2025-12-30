<?php
/**
 * This class contains functions related to genealogy
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
namespace Admin\App\Models\Genealogy;


use Admin\App\Models\Genealogy\MBinaryLinkDetails;
use Admin\App\Models\Middleware\MBinaryMembersPosition;
use Admin\App\Models\Middleware\MMatrixMemberLink;
use Admin\App\Models\Member\MemberLinks;
use Admin\App\Models\Middleware\MAmazonCloudFront;
class MBinaryCollapseGenealogy
{
     /**
     * This function is used  to get genealogy data
     * @param int $members_id
     * @param int $matrix_id
     * @return bool
    **/
    // public static function getBinaryGenealogyDetails($members_id, $matrix_id)
    // {

    //     // LOAD MAIN MEMBER DETAILS

    //     $binaryparentdetails = MBinaryLinkDetails::getBinaryLinkDetails($members_id, $matrix_id);

    //     $direct_id        = $binaryparentdetails['direct_id'];
    //     $matrix_doj       = $binaryparentdetails['matrix_doj'];
    //     $spillover_id     = $binaryparentdetails['spillover_id'];
    //     $members_username = $binaryparentdetails['membername'];
    //     $members_phone    = $binaryparentdetails['members_phone'];
    //     $members_email    = $binaryparentdetails['members_email'];

    //     $memberImagePath = $binaryparentdetails['members_image'] ?: 'uploads/members/avatar.png';
    //     $members_image   = asset($memberImagePath);

    //     $parentroot       = $binaryparentdetails['root'];
    //     $ranktitle        = $binaryparentdetails['ranktitle'];
    //     $sponsor_username = $direct_id > 0 ? $binaryparentdetails['sponsor_username'] : 'Nil';
    //     $rankid           = $binaryparentdetails['rankid'];
    //     $rank_icon_path   = $binaryparentdetails['rank_icon_path'];

    //     $leftuser  = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '1');
    //     $rightuser = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '2');

    //     $rank_icon_path = $rankid == '' ? '' : $rank_icon_path;
    //     $targetroot     = $parentroot + 3;


    //     // GET MEMBER COUNT

    //     $count = MBinaryMembersCount::getBinaryMemberscount($members_id, $matrix_id);
    //     $lefttotalmember  = $count['left'];
    //     $righttotalmember = $count['right'];

    //     $rank = $ranktitle != '' ? $ranktitle : 'Nil';
    //     // GET REFERRAL / LINK DETAILS USING LARAVEL ELOQUENT

    //     $referralslinkdetails = MemberLinks::where('spillover_id', $members_id)
    //         ->where('matrix_id', $matrix_id)
    //         ->where('position', '>', 0)
    //         ->orderBy('link_id', 'ASC')
    //         ->get();
    //         // dd($referralslinkdetails);
    //     // BUILD OUTPUT JSON VIEW
    //     if ($referralslinkdetails->count() == 0) {
    //         // dd('fucnhaksdf');
    //         $output = '{ "name" : "' . $members_username . '","link" :"' . env('BCPATH') . '/userdetails/show/' . $members_id . '",';
    //     } else {
    //         $output = '{ "name" : "' . $members_username . '","link" :"' . env('BCPATH'). '/userdetails/show/' . $members_id . '","children":[';
    //     }

    //     // CASE 1: BOTH LEFT + RIGHT AVAILABLE
    //     if ($referralslinkdetails->count() == 2) {

    //         // ---------------- LEFT ----------------
    //         if ($leftuser > 0) {
    //             $binaryleftdetails = MBinaryLinkDetails::getBinaryLinkDetails($leftuser, $matrix_id, $targetroot);

    //             $leftusername   = $binaryleftdetails['membername'];
    //             $leftimage      = $binaryleftdetails['members_image'] ?: 'uploads/avatar/emptyavatar.png';
    //             // $leftimage      = MAmazonCloudFront::getCloudFrontUrl($leftimage);

    //             $output .= '{"name" : "' . $leftusername . '","link" :"' . env('BCPATH') . '/userdetails/show/' . $leftuser . '",';
    //             $output .= self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
    //             $output .= '},';
    //         }

    //         // ---------------- RIGHT ----------------
    //         if ($rightuser > 0) {
    //             $binaryrightdetails = MBinaryLinkDetails::getBinaryLinkDetails($rightuser, $matrix_id, $targetroot);

    //             $rightusername = $binaryrightdetails['membername'];
    //             $rightimage    = $binaryrightdetails['members_image'] ?: 'uploads/avatar/emptyavatar.png';
    //             // $rightimage    = MAmazonCloudFront::getCloudFrontUrl($rightimage);

    //             $output .= '{"name" : "' . $rightusername . '","link" :"' . env('BCPATH'). '/userdetails/show/' . $rightuser . '",';
    //             $output .= self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
    //             $output .= '}';
    //         }

    //         $output .= ']};';
    //     }

    //     // CASE 2: ONLY ONE SIDE AVAILABLE
    //     elseif ($referralslinkdetails->count() == 1) {

    //         // LEFT side available
    //         if ($leftuser > 0) {
    //             $binaryleftdetails = MBinaryLinkDetails::getBinaryLinkDetails($leftuser, $matrix_id, $targetroot);

    //             $leftusername = $binaryleftdetails['membername'];
    //             $leftimage    = $binaryleftdetails['members_image'] ?: 'uploads/avatar/emptyavatar.png';
    //             // $leftimage    = MAmazonCloudFront::getCloudFrontUrl($leftimage);

    //             $output .= '{"name" : "' . $leftusername . '","link" :"' . $_ENV['BCPATH'] . '/userdetails/show/' . $leftuser . '",';
    //             $output .= self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
    //             $output .= '},';

    //             // Empty right
    //             $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '2');
    //         }

    //         // RIGHT side available
    //         elseif ($rightuser > 0) {

    //             // Empty left
    //             $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '1');

    //             $binaryrightdetails = MBinaryLinkDetails::getBinaryLinkDetails($rightuser, $matrix_id, $targetroot);

    //             $rightusername = $binaryrightdetails['membername'];
    //             $rightimage    = $binaryrightdetails['members_image'] ?: 'uploads/avatar/emptyavatar.png';
    //             // $rightimage    = MAmazonCloudFront::getCloudFrontUrl($rightimage);

    //             $output .= '{"name" : "' . $rightusername . '","link" :"' . $_ENV['BCPATH'] . '/userdetails/show/' . $rightuser . '","children":[';
    //             $output .= self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
    //             $output .= ']},';
    //         }
    //     }
    //     // CASE 3: BOTH EMPTY
    //     elseif ($referralslinkdetails->count() == 0) {

    //         $output .= '"children":[';
    //         $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '1');
    //         $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '2');
    //         $output .= ']';
    //         $output .= '};';
    //     }

    //     // FINAL OUTPUT
    //     $output = 'var treeData=' . $output;
    //  dd($output);
    //     return $output;
    // }

    // public static function getDepthBinaryGenealogy($members_id, $matrix_id, $targetroot)
    // {

    //     $output = '';
    //     if ($members_id > 0) {
    //         $groupTitleColor       = '#4169e1';
    //         $itemTitleColor        = '#B800E6';
    //         $binaryparentdetails   = MBinaryLinkDetails::getBinaryLinkDetails($members_id, $matrix_id, $targetroot);
    //         // dd($binaryparentdetails);
    //         $direct_id             = $binaryparentdetails['direct_id'];
    //         $matrix_doj            = $binaryparentdetails['matrix_doj'];
    //         $members_username      = $binaryparentdetails['membername'];
    //         $members_email         = $binaryparentdetails['members_email'];
    //         $members_image         = $binaryparentdetails['members_image'];
    //         $childroot             = $binaryparentdetails['root'];
    //         $sponsor_username      = $binaryparentdetails['sponsor_username'];
    //         $sponsor_username      = $direct_id > '0' ? $sponsor_username : 'Nil';
    //         $rankid                = $binaryparentdetails['rankid'];
    //         $rank_icon_path        = $binaryparentdetails['rank_icon_path'];


    //         $leftuser=MBinaryMembersPosition::getBinaryMembersPosition($members_id,$matrix_id,'1');
    //         $rightuser=MBinaryMembersPosition::getBinaryMembersPosition($members_id,$matrix_id,'2');

    //         $rank_icon_path        = $rankid == '' ? '0' : $rank_icon_path;
    //         // $where                 = 'spillover_id="' . $members_id . '" AND matrix_id="' . $matrix_id . '" ORDER BY link_id ASC ';
    //         // $referralslinkdetails  = MMatrixMemberLink::getMatrixLinkDetails($where);

    //     $referralslinkdetails = MemberLinks::where('spillover_id', $members_id)
    //         ->where('matrix_id', $matrix_id)
    //         ->where('position', '>', 0)
    //         ->orderBy('link_id', 'ASC')
    //         ->get();
    //     // dd($referralslinkdetails);

    //         if ($childroot <= $targetroot) {
    //             if (count((array)$referralslinkdetails) == '2') { //for both side  is filled
    //                 //showleftdetails
    //                 $binaryleftdetails    = MBinaryLinkDetails::getBinaryLinkDetails($leftuser, $matrix_id, $targetroot);
    //                 $leftdirect_id        = $binaryleftdetails['direct_id']??'';
    //                 $leftmatrix_doj       = $binaryleftdetails['matrix_doj']?? '';
    //                 $leftmembers_username = $binaryleftdetails['membername'] ?? '';
    //                 $leftmembers_email    = $binaryleftdetails['members_email']?? '';
    //                 $leftranktitle        = $binaryleftdetails['ranktitle']?? '';
    //                 $leftmembers_phone    = $binaryleftdetails['members_phone'] ?? '';
    //                 $leftmembers_image    = $binaryleftdetails['members_image']?? '';
    //                 $leftsponsor_username = $binaryleftdetails['sponsor_username']??'';
    //                 $leftsponsor_username = $leftdirect_id > '0' ? $leftsponsor_username : 'Nil';
    //                 $leftrankid           = $binaryleftdetails['rankid'] ?? '';
    //                 $leftrank_icon_path   = $binaryleftdetails['rank_icon_path'] ?? '';
    //                 $leftmembers_image    = $leftmembers_image != '' ? $leftmembers_image : 'uploads/avatar/emptyavatar.png';
    //                 $leftrank_icon_path   = $leftrank_icon_path == '' ? '' : $leftrank_icon_path;

    //                 // $leftmembers_image = MAmazonCloudFront::getCloudFrontUrl($leftmembers_image);
    //                 // $leftrank_icon_path = MAmazonCloudFront::getCloudFrontUrl($leftrank_icon_path);
    //                 $leftcontacttemplate  = $leftrankid > '0' ? 'contactTemplate' : 'contactTemplate1';
    //                 $count                = MBinaryMembersCount::getBinaryMemberscount($leftuser, $matrix_id);
    //                 $leftcount            = $count['left'];
    //                 $rightcount           = $count['right'];
    //                 $lefttotalmember      = $leftcount;
    //                 $righttotalmember     = $rightcount;
    //                 $leftranktitle        = $leftranktitle == '' ? 'Nil' : $leftranktitle;
    //                 $output .= '"children":[{"name" : "' . $leftmembers_username . '","link" :"' . env('BCPATH') . '/userdetails/show/' . $leftuser . '",';
    //                 $output .= self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
    //                 $output .= '},';
    //                 //showrightdetails
    //                 $binaryrightdetails    = MBinaryLinkDetails::getBinaryLinkDetails($rightuser, $matrix_id, $targetroot);
    //                 $rightdirect_id        = $binaryrightdetails['direct_id']?? '';
    //                 $rightmatrix_doj       = $binaryrightdetails['matrix_doj']?? '';
    //                 $rightmembers_username = $binaryrightdetails['membername']?? '';
    //                 $rightmembers_phone    = $binaryrightdetails['members_phone']?? '';
    //                 $rightranktitle        = $binaryrightdetails['ranktitle']?? '';
    //                 $rightmembers_email    = $binaryrightdetails['members_email']?? '';
    //                 $rightmembers_image    = $binaryrightdetails['members_image']?? '';
    //                 $rightsponsor_username = $binaryrightdetails['sponsor_username']?? '';
    //                 $rightsponsor_username = $rightdirect_id > '0' ? $rightsponsor_username : 'Nil';
    //                 $rightrankid           = $binaryrightdetails['rankid'] ??'';
    //                 $rightrank_icon_path   = $binaryrightdetails['rank_icon_path']??'';
    //                  $rightmembers_image    = $rightmembers_image != '' ?  $rightmembers_image : 'uploads/avatar/emptyavatar.png';
    //                 $rightrank_icon_path   = $rightrank_icon_path == '' ? '' : $rightrank_icon_path;

    //                 // $rightmembers_image = MAmazonCloudFront::getCloudFrontUrl($rightmembers_image);
    //                 // $rightrank_icon_path = MAmazonCloudFront::getCloudFrontUrl($rightrank_icon_path);
    //                 $rightcontacttemplate  = $rightrankid > '0' ? 'contactTemplate' : 'contactTemplate1';
    //                 $count                 = MBinaryMembersCount::getBinaryMemberscount($rightuser, $matrix_id);
    //                 $leftcount             = $count['left'];
    //                 $rightcount            = $count['right'];
    //                 $lefttotalmember       = $leftcount;
    //                 $righttotalmember      = $rightcount;
    //                 $rightranktitle        = $rightranktitle == '' ? 'Nil' : $rightranktitle;
    //                 $output .= '{"name" : "' . $rightmembers_username . '","link" :"' .env('BCPATH') . '/userdetails/show/' . $rightuser . '",';
    //                 $output .= self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
    //                 $output .= '}]';
    //             }elseif (count((array)$referralslinkdetails) == '1') { //for one side  is filled
    //                 if ($leftuser > 0) {
    //                     //showleftdetails
    //                     $binaryleftdetails         = MBinaryLinkDetails::getBinaryLinkDetails($leftuser, $matrix_id, $targetroot);
    //                     $leftdirect_id             = $binaryleftdetails['direct_id'];
    //                     $leftmatrix_doj            = $binaryleftdetails['matrix_doj'];
    //                     $leftmembers_username      = $binaryleftdetails['membername'];
    //                     $leftmembers_email         = $binaryleftdetails['members_email'];
    //                     $leftmembers_members_phone = $binaryleftdetails['members_phone'];
    //                     $leftranktitle             = $binaryleftdetails['ranktitle'];
    //                     $leftmembers_image         = $binaryleftdetails['members_image'];
    //                     $leftsponsor_username      = $binaryleftdetails['sponsor_username'];
    //                     $leftsponsor_username      = $leftdirect_id > '0' ? $leftsponsor_username : 'Nil';
    //                     $leftrankid                = $binaryleftdetails['rankid'];
    //                     $leftrank_icon_path        = $binaryleftdetails['rank_icon_path'];
    //                     $leftmembers_image         = $leftmembers_image != '' ? $leftmembers_image : 'uploads/avatar/emptyavatar.png';
    //                     $leftrank_icon_path        = $leftrank_icon_path == '' ? '' : $leftrank_icon_path;

    //                     // $leftmembers_image = MAmazonCloudFront::getCloudFrontUrl($leftmembers_image);
    //                     // $leftrank_icon_path = MAmazonCloudFront::getCloudFrontUrl($leftrank_icon_path);
    //                     $leftcontacttemplate       = $leftrankid > '0' ? 'contactTemplate' : 'contactTemplate1';
    //                     $count                     = MBinaryMembersCount::getBinaryMemberscount($leftuser, $matrix_id);
    //                     $leftcount                 = $count['left'];
    //                     $rightcount                = $count['right'];
    //                     $lefttotalmember           = $leftcount;
    //                     $righttotalmember          = $rightcount;
    //                     $leftranktitle             = $leftranktitle == '' ? 'Nil' : $leftranktitle;
    //                     $output .= '"children":[{"name" : "' . $leftmembers_username . '","link" :"' . env('BCPATH') . '/userdetails/show/' . $leftuser . '",';
    //                     $output .= self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
    //                     $output .= '},';
    //                     $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '2');
    //                     $output .= ']';
    //                 }
    //                 if ($rightuser > 0) {
    //                     $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '1');
    //                     $binaryrightdetails    = MBinaryLinkDetails::getBinaryLinkDetails($rightuser, $matrix_id, $targetroot);
    //                     $rightdirect_id        = $binaryrightdetails['direct_id'];
    //                     $rightmatrix_doj       = $binaryrightdetails['matrix_doj'];
    //                     $rightmembers_username = $binaryrightdetails['membername'];
    //                     $rightmembers_phone    = $binaryrightdetails['members_phone'];
    //                     $rightmembers_email    = $binaryrightdetails['members_email'];
    //                     $rightranktitle        = $binaryrightdetails['ranktitle'];
    //                     $rightmembers_image    = $binaryrightdetails['members_image'];
    //                     $rightsponsor_username = $binaryrightdetails['sponsor_username'];
    //                     $rightsponsor_username = $rightdirect_id > '0' ? $rightsponsor_username : 'Nil';
    //                     $rightrankid           = $binaryrightdetails['rankid'];
    //                     $rightrank_icon_path   = $binaryrightdetails['rank_icon_path'];
    //                     $rightmembers_image    = $rightmembers_image != '' ? $rightmembers_image : 'uploads/avatar/emptyavatar.png';
    //                     $rightrank_icon_path   = $rightrank_icon_path == '' ? '' : $rightrank_icon_path;

    //                     // $rightmembers_image = MAmazonCloudFront::getCloudFrontUrl($rightmembers_image);
    //                     // $rightrank_icon_path = MAmazonCloudFront::getCloudFrontUrl($rightrank_icon_path);
    //                     $rightcontacttemplate  = $rightrankid > '0' ? 'contactTemplate' : 'contactTemplate1';
    //                     $count                 = MBinaryMembersCount::getBinaryMemberscount($rightuser, $matrix_id);
    //                     $leftcount             = $count['left'];
    //                     $rightcount            = $count['right'];
    //                     $lefttotalmember       = $leftcount;
    //                     $righttotalmember      = $rightcount;
    //                     $rightranktitle        = $rightranktitle == '' ? 'Nil' : $rightranktitle;
    //                     $output .= '"children":[{"name" : "' . $rightmembers_username . '","link" :"' . env('BCPATH') . '/userdetails/show/' . $rightuser . '",';
    //                     $output .= self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
    //                     $output .= '},';
    //                     $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '1');
    //                     $output .= ']';
    //                 }
    //             }elseif(count((array)$referralslinkdetails) == '0' && $childroot < $targetroot) { //for both side  is empty
    //                 $output .= '"children":[';
    //                 $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '1');
    //                 $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '2');
    //                 $output .= ']';
    //             }
    //         }
    //     }
    //     // dd($output);
    //     return $output;
    // }
    // public static function getEmptyBianryGenealogyDetails($members_id, $matrix_id, $position)
    // {
    //     $emtpyimagepath = 'uploads/avatar/emptyavatar.png';
    //     // $emtpyimagepath = MAmazonCloudFront::getCloudFrontUrl($emtpyimagepath);
    //     $randommember   = mt_rand(10000000, 99999999);
    //     $output = '{ "name": "empty","link" :"' .env('BCPATH') . '/register/' . $_GET['sub1'] . '/' . $_GET['sub2'] . '/' . $members_id . '/' . $position . '" },';
    //     return $output;
    // }




// public static function getBinaryGenealogyDetails($members_id, $matrix_id)
// {
//     // LOAD MAIN MEMBER DETAILS
//     $binaryparentdetails = MBinaryLinkDetails::getBinaryLinkDetails($members_id, $matrix_id);

//     $direct_id        = $binaryparentdetails['direct_id'];
//     $matrix_doj       = $binaryparentdetails['matrix_doj'];
//     $spillover_id     = $binaryparentdetails['spillover_id'];
//     $members_username = $binaryparentdetails['membername'];
//     $members_phone    = $binaryparentdetails['members_phone'];
//     $members_email    = $binaryparentdetails['members_email'];

//     $memberImagePath = $binaryparentdetails['members_image'] ?: 'uploads/members/avatar.png';
//     $members_image   = asset($memberImagePath);

//     $parentroot       = $binaryparentdetails['root'];
//     $ranktitle        = $binaryparentdetails['ranktitle'];
//     $sponsor_username = $direct_id > 0 ? $binaryparentdetails['sponsor_username'] : 'Nil';
//     $rankid           = $binaryparentdetails['rankid'];
//     $rank_icon_path   = $binaryparentdetails['rank_icon_path'];

//     $leftuser  = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '1');
//     $rightuser = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '2');

//     $rank_icon_path = $rankid == '' ? '' : $rank_icon_path;
//     $targetroot     = $parentroot + 3;

//     // GET MEMBER COUNT
//     $count = MBinaryMembersCount::getBinaryMemberscount($members_id, $matrix_id);
//     $lefttotalmember  = $count['left'];
//     $righttotalmember = $count['right'];

//     $rank = $ranktitle != '' ? $ranktitle : 'Nil';

//     // GET REFERRAL / LINK DETAILS USING LARAVEL ELOQUENT
//     $referralslinkdetails = MemberLinks::where('spillover_id', $members_id)
//         ->where('matrix_id', $matrix_id)
//         ->orderBy('link_id', 'ASC')
//         ->get();

//     // dd($referralslinkdetails);
//     // BUILD OUTPUT JSON VIEW
//     if ($referralslinkdetails->count() == 0) {
//         $output = '{ "name" : "' . $members_username . '","link" :"' . env('BCPATH') . '/userdetails/show/' . $members_id . '",';
//     } else {
//         $output = '{ "name" : "' . $members_username . '","link" :"' . env('BCPATH'). '/userdetails/show/' . $members_id . '","children":[';
//     }

//     // CASE 1: BOTH LEFT + RIGHT AVAILABLE
//     if ($referralslinkdetails->count() == 2) {
//         $children = [];

//         // ---------------- LEFT ----------------
//         if ($leftuser > 0) {
//             $binaryleftdetails = MBinaryLinkDetails::getBinaryLinkDetails($leftuser, $matrix_id, $targetroot);
//             $leftusername   = $binaryleftdetails['membername'];
//             $leftimage      = $binaryleftdetails['members_image'] ?: 'uploads/avatar/emptyavatar.png';

//             $leftChild = '{"name" : "' . $leftusername . '","link" :"' . env('BCPATH') . '/userdetails/show/' . $leftuser . '",';
//             $leftChild .= self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
//             $leftChild .= '}';
//             $children[] = $leftChild;
//         }

//         // ---------------- RIGHT ----------------
//         if ($rightuser > 0) {
//             $binaryrightdetails = MBinaryLinkDetails::getBinaryLinkDetails($rightuser, $matrix_id, $targetroot);
//             $rightusername = $binaryrightdetails['membername'];
//             $rightimage    = $binaryrightdetails['members_image'] ?: 'uploads/avatar/emptyavatar.png';

//             $rightChild = '{"name" : "' . $rightusername . '","link" :"' . env('BCPATH'). '/userdetails/show/' . $rightuser . '",';
//             $rightChild .= self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
//             $rightChild .= '}';
//             $children[] = $rightChild;
//         }

//         $output .= implode(',', $children) . ']};';
//     }

//     // CASE 2: ONLY ONE SIDE AVAILABLE
//     elseif ($referralslinkdetails->count() == 1) {
//         $children = [];

//         // LEFT side available
//         if ($leftuser > 0) {
//             $binaryleftdetails = MBinaryLinkDetails::getBinaryLinkDetails($leftuser, $matrix_id, $targetroot);
//             $leftusername = $binaryleftdetails['membername'];
//             $leftimage    = $binaryleftdetails['members_image'] ?: 'uploads/avatar/emptyavatar.png';

//             $leftChild = '{"name" : "' . $leftusername . '","link" :"' . $_ENV['BCPATH'] . '/userdetails/show/' . $leftuser . '",';
//             $leftChild .= self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
//             $leftChild .= '}';
//             $children[] = $leftChild;
//         }

//         // RIGHT side available
//         elseif ($rightuser > 0) {
//             $binaryrightdetails = MBinaryLinkDetails::getBinaryLinkDetails($rightuser, $matrix_id, $targetroot);
//             $rightusername = $binaryrightdetails['membername'];
//             $rightimage    = $binaryrightdetails['members_image'] ?: 'uploads/avatar/emptyavatar.png';

//             $rightChild = '{"name" : "' . $rightusername . '","link" :"' . $_ENV['BCPATH'] . '/userdetails/show/' . $rightuser . '",';
//             $rightChild .= self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
//             $rightChild .= '}';
//             $children[] = $rightChild;
//         }

//         $output .= implode(',', $children) . ']};';
//     }

//     // CASE 3: BOTH EMPTY
//     elseif ($referralslinkdetails->count() == 0) {
//         $output .= '"children":[]};';
//     }

//     // FINAL OUTPUT
//     $output = 'var treeData=' . $output;
//     // dd($output);
//     return $output;
// }

// public static function getDepthBinaryGenealogy($members_id, $matrix_id, $targetroot)
// {
//     $output = '';

//     if ($members_id > 0) {
//         $binaryparentdetails = MBinaryLinkDetails::getBinaryLinkDetails($members_id, $matrix_id, $targetroot);

//         $direct_id        = $binaryparentdetails['direct_id'];
//         $matrix_doj       = $binaryparentdetails['matrix_doj'];
//         $members_username = $binaryparentdetails['membername'];
//         $members_email    = $binaryparentdetails['members_email'];
//         $members_image    = $binaryparentdetails['members_image'];
//         $childroot        = $binaryparentdetails['root'];
//         $sponsor_username = $binaryparentdetails['sponsor_username'];
//         $sponsor_username = $direct_id > '0' ? $sponsor_username : 'Nil';
//         $rankid           = $binaryparentdetails['rankid'];
//         $rank_icon_path   = $binaryparentdetails['rank_icon_path'];

//         $leftuser  = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '1');
//         $rightuser = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '2');

//         $rank_icon_path = $rankid == '' ? '0' : $rank_icon_path;

//         $referralslinkdetails =  MemberLinks::where('spillover_id', $members_id)
//         ->where('matrix_id', $matrix_id)
//         ->orderBy('link_id', 'ASC')
//         ->get();

//         if ($childroot <= $targetroot) {
//             $childrenCount = count((array)$referralslinkdetails);

//             if ($childrenCount == 2) { // Both sides filled
//                 $children = [];

//                 // Left child
//                 if ($leftuser > 0) {
//                     $binaryleftdetails = MBinaryLinkDetails::getBinaryLinkDetails($leftuser, $matrix_id, $targetroot);
//                     $leftmembers_username = $binaryleftdetails['membername'] ?? '';

//                     $leftChild = '{"name" : "' . $leftmembers_username . '","link" :"' . env('BCPATH') . '/userdetails/show/' . $leftuser . '",';
//                     $leftChild .= self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
//                     $leftChild .= '}';
//                     $children[] = $leftChild;
//                 }

//                 // Right child
//                 if ($rightuser > 0) {
//                     $binaryrightdetails = MBinaryLinkDetails::getBinaryLinkDetails($rightuser, $matrix_id, $targetroot);
//                     $rightmembers_username = $binaryrightdetails['membername'] ?? '';

//                     $rightChild = '{"name" : "' . $rightmembers_username . '","link" :"' . env('BCPATH') . '/userdetails/show/' . $rightuser . '",';
//                     $rightChild .= self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
//                     $rightChild .= '}';
//                     $children[] = $rightChild;
//                 }

//                 $output .= '"children":[' . implode(',', $children) . ']';
//             }
//             elseif ($childrenCount == 1) { // One side filled
//                 $children = [];

//                 if ($leftuser > 0) {
//                     $binaryleftdetails = MBinaryLinkDetails::getBinaryLinkDetails($leftuser, $matrix_id, $targetroot);
//                     $leftmembers_username = $binaryleftdetails['membername'];

//                     $leftChild = '{"name" : "' . $leftmembers_username . '","link" :"' . env('BCPATH') . '/userdetails/show/' . $leftuser . '",';
//                     $leftChild .= self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
//                     $leftChild .= '}';
//                     $children[] = $leftChild;
//                 }
//                 elseif ($rightuser > 0) {
//                     $binaryrightdetails = MBinaryLinkDetails::getBinaryLinkDetails($rightuser, $matrix_id, $targetroot);
//                     $rightmembers_username = $binaryrightdetails['membername'];

//                     $rightChild = '{"name" : "' . $rightmembers_username . '","link" :"' . env('BCPATH') . '/userdetails/show/' . $rightuser . '",';
//                     $rightChild .= self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
//                     $rightChild .= '}';
//                     $children[] = $rightChild;
//                 }

//                 $output .= '"children":[' . implode(',', $children) . ']';
//             }
//             elseif ($childrenCount == 0 && $childroot < $targetroot) { // Both sides empty
//                 $output .= '"children":[]';
//             }
//         }
//     }
//     // dd($output);
//     return $output;
// }
    public static function getBinaryGenealogyDetails($members_id, $matrix_id)
    {
        $node = self::buildNodeRecursive($members_id, $matrix_id);
        return 'var treeData = ' . json_encode($node, JSON_UNESCAPED_SLASHES) . ';';
    }

    private static function buildNodeRecursive($memberId, $matrix_id)
    {
        $details = MBinaryLinkDetails::getBinaryLinkDetails($memberId, $matrix_id);

        $node = [
            'name' => $details['membername'] ?? 'Unknown',
            'link' => env('BCPATH') . '/userdetails/show/' . $memberId,
        ];

        $left  = MBinaryMembersPosition::getBinaryMembersPosition($memberId, $matrix_id, '1');
        $right = MBinaryMembersPosition::getBinaryMembersPosition($memberId, $matrix_id, '2');

        $children = [];
        if ($left > 0)  $children[] = self::buildNodeRecursive($left, $matrix_id);
        if ($right > 0) $children[] = self::buildNodeRecursive($right, $matrix_id);

        if (!empty($children)) {
            $node['children'] = $children;
        }

        return $node;
    }
}



?>
