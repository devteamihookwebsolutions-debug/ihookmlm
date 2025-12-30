<?php
namespace Admin\App\Models\Genealogy;

use Admin\App\Models\Middleware\MBinaryMembersPosition;
use Admin\App\Models\Middleware\MURLCrypt;
use Admin\App\Models\Member\Matrix;
use Admin\App\Models\Member\MatrixConfiguration;
use Admin\App\Models\Member\MemberLinks;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Admin\App\Models\Genealogy\MBinaryLinkDetails;
use Admin\App\Models\Genealogy\MBinaryMembersCount;
use Admin\App\Models\Genealogy\MMembersCount;
use Admin\App\Models\Middleware\MMatrixMemberLink;


class MBinaryGraphicalRankGenealogy
{
// public static function getBinaryGenealogyDetails($members_id, $matrix_id)
// {
//     // dd('function reached');

//     $output            = '';
//     $rank_color_css    = '';
//     $rank_color_script = '';

//     $binaryparentdetails   = MBinaryLinkDetails::getBinaryLinkDetails($members_id, $matrix_id);
//     $direct_id             = $binaryparentdetails['direct_id'];
//     $matrix_doj            = $binaryparentdetails['matrix_doj'];
//     $spillover_id          = $binaryparentdetails['spillover_id'];
//     $members_username      = $binaryparentdetails['membername'];
//     $members_phone         = $binaryparentdetails['members_phone'];
//     $members_email         = $binaryparentdetails['members_email'];
//     $members_image         = $binaryparentdetails['members_image'];
//     $parentroot            = $binaryparentdetails['root'];
//     $ranktitle             = $binaryparentdetails['ranktitle'];
//     $sponsor_username      = $binaryparentdetails['sponsor_username'];
//     $sponsor_username      = $direct_id > 0 ? $sponsor_username : 'Nil';
//     $rankid                = $binaryparentdetails['rankid'];
//     $rank_icon_path        = $binaryparentdetails['rank_icon_path'] ?? '';
//     $rank_color            = $binaryparentdetails['rankcolor'];
//     $rankgenealogy_name    = $binaryparentdetails['rankgenealogy_name'];

//     $title = $members_username;
//     $title .= !empty($ranktitle) && $ranktitle !== 'Nil' ? ' - ' . $ranktitle : '';
//     $ranktitle = $ranktitle == '' ? 'Nil' : $ranktitle;

//     $members_image   = $members_image != '' ? $members_image : 'uploads/members/avatar.png';
//     $members_image   = env('CDNCLOUDEXTURL') . '/' . $members_image;
//     $rank_icon_path  = $rank_icon_path != '' ? env('CDNCLOUDEXTURL') . '/' . $rank_icon_path : '';

//     $leftuser  = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '1');
//     $rightuser = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '2');

//     $count            = MBinaryMembersCount::getBinaryMemberscount($members_id, $matrix_id);
//     $lefttotalmember  = $count['left'];
//     $righttotalmember = $count['right'];

//     // Root Node
//     $output .= '{ id: "' . $members_id . '", name: "' . $members_username . '", pid: 0, title: "' . $title . '", description: "Sponsor : ' . $sponsor_username . '", phone: "' . $members_phone . '", email: "' . $members_email . '", rank: "Rank : ' . $ranktitle . '", img: "' . $members_image . '", rankimage: "' . $rank_icon_path . '", leftmembercount:"Left total members : ' . $lefttotalmember . '", rightmembercount:"Right total members : ' . $righttotalmember . '", members_id: "' . $members_id . '", rankgenealogy_name: "' . $rankgenealogy_name . '"},';

//     if (!empty($rankgenealogy_name)) {
//         $rank_color_css    .= '.node.' . $rankgenealogy_name . ' rect { fill: ' . $rank_color . '; }';
//         $rank_color_script .= 'case "' . $rankgenealogy_name . '": node.tags = ["' . $rankgenealogy_name . '"]; break;';
//     }

//     $targetroot = $parentroot + 3;

//     $referralslinkdetails = MemberLinks::where('spillover_id', $members_id)
//         ->where('matrix_id', $matrix_id)
//         ->orderBy('link_id', 'ASC')
//         ->get();
// // dd($referralslinkdetails);
//     $childCount = count($referralslinkdetails);

//     // Case 1: Both legs filled
//     if ($childCount == 2) {
//         // Left Child
//         if ($leftuser > 0) {
//             $leftdetails            = MBinaryLinkDetails::getBinaryLinkDetails($leftuser, $matrix_id, $targetroot);
//             $leftmembers_username   = $leftdetails['membername'];
//             $leftranktitle          = $leftdetails['ranktitle'] ?? '';
//             $leftsponsor_username   = $leftdetails['direct_id'] > 0 ? $leftdetails['sponsor_username'] : 'Nil';
//             $leftmembers_phone      = $leftdetails['members_phone'];
//             $leftmembers_email      = $leftdetails['members_email'];
//             $leftmembers_image      = $leftdetails['members_image'] != '' ? $leftdetails['members_image'] : 'uploads/avatar/emptyavatar.png';
//             $leftmembers_image      = env('CDNCLOUDEXTURL') . '/' . $leftmembers_image;
//             $leftrank_icon_path     = !empty($leftdetails['rank_icon_path']) ? env('CDNCLOUDEXTURL') . '/' . $leftdetails['rank_icon_path'] : '';
//             $leftranktitle          = $leftranktitle == '' ? 'Nil' : $leftranktitle;
//             $lefttitle              = $leftmembers_username . (!empty($leftranktitle) && $leftranktitle !== 'Nil' ? ' - ' . $leftranktitle : '');

//             $leftcountData          = MBinaryMembersCount::getBinaryMemberscount($leftuser, $matrix_id);
//             $left_rankgenealogy     = $leftdetails['rankgenealogy_name'];
//             $left_rankcolor         = $leftdetails['rankcolor'];

//             $output .= '{ id: "' . $leftuser . '", name: "' . $leftmembers_username . '", pid: ' . $members_id . ', title: "' . $lefttitle . '", description: "Sponsor : ' . $leftsponsor_username . '", phone: "' . $leftmembers_phone . '", email: "' . $leftmembers_email . '", rank: "Rank : ' . $leftranktitle . '", img: "' . $leftmembers_image . '", rankimage: "' . $leftrank_icon_path . '", leftmembercount:"Left total members : ' . $leftcountData['left'] . '", rightmembercount:"Right total members : ' . $leftcountData['right'] . '", members_id: "' . $leftuser . '", rankgenealogy_name: "' . $left_rankgenealogy . '"},';

//             if (!empty($left_rankgenealogy)) {
//                 $rank_color_css    .= '.node.' . $left_rankgenealogy . ' rect { fill: ' . $left_rankcolor . '; }';
//                 $rank_color_script .= 'case "' . $left_rankgenealogy . '": node.tags = ["' . $left_rankgenealogy . '"]; break;';
//             }

//             $depthLeft = self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
//             $output            .= $depthLeft['gendata'];
//             $rank_color_css    .= $depthLeft['rankcolorcss'];
//             $rank_color_script .= $depthLeft['rankcolorscript'];
//         }

//         // Right Child
//         if ($rightuser > 0) {
//             $rightdetails            = MBinaryLinkDetails::getBinaryLinkDetails($rightuser, $matrix_id, $targetroot);
//             $rightmembers_username   = $rightdetails['membername'];
//             $rightranktitle          = $rightdetails['ranktitle'] ?? '';
//             $rightsponsor_username   = $rightdetails['direct_id'] > 0 ? $rightdetails['sponsor_username'] : 'Nil';
//             $rightmembers_phone      = $rightdetails['members_phone'];
//             $rightmembers_email      = $rightdetails['members_email'];
//             $rightmembers_image      = $rightdetails['members_image'] != '' ? $rightdetails['members_image'] : 'uploads/avatar/emptyavatar.png';
//             $rightmembers_image      = env('CDNCLOUDEXTURL') . '/' . $rightmembers_image;
//             $rightrank_icon_path     = !empty($rightdetails['rank_icon_path']) ? env('CDNCLOUDEXTURL') . '/' . $rightdetails['rank_icon_path'] : '';
//             $rightranktitle          = $rightranktitle == '' ? 'Nil' : $rightranktitle;
//             $righttitle              = $rightmembers_username . (!empty($rightranktitle) && $rightranktitle !== 'Nil' ? ' - ' . $rightranktitle : '');

//             $rightcountData          = MBinaryMembersCount::getBinaryMemberscount($rightuser, $matrix_id);
//             $right_rankgenealogy     = $rightdetails['rankgenealogy_name'];
//             $right_rankcolor         = $rightdetails['rankcolor'];

//             $output .= '{ id: "' . $rightuser . '", name: "' . $rightmembers_username . '", pid: ' . $members_id . ', title: "' . $righttitle . '", description: "Sponsor : ' . $rightsponsor_username . '", phone: "' . $rightmembers_phone . '", email: "' . $rightmembers_email . '", rank: "Rank : ' . $rightranktitle . '", img: "' . $rightmembers_image . '", rankimage: "' . $rightrank_icon_path . '", leftmembercount:"Left total members : ' . $rightcountData['left'] . '", rightmembercount:"Right total members : ' . $rightcountData['right'] . '", members_id: "' . $rightuser . '", rankgenealogy_name: "' . $right_rankgenealogy . '"},';

//             if (!empty($right_rankgenealogy)) {
//                 $rank_color_css    .= '.node.' . $right_rankgenealogy . ' rect { fill: ' . $right_rankcolor . '; }';
//                 $rank_color_script .= 'case "' . $right_rankgenealogy . '": node.tags = ["' . $right_rankgenealogy . '"]; break;';
//             }

//             $depthRight = self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
//             $output            .= $depthRight['gendata'];
//             $rank_color_css    .= $depthRight['rankcolorcss'];
//             $rank_color_script .= $depthRight['rankcolorscript'];
//         }
//     }

//     // Case 2: Only one leg filled
//     elseif ($childCount == 1) {
//         if ($leftuser > 0) {
//             // Add empty right node first
//             $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '2');

//             // Then real left child
//             $leftdetails            = MBinaryLinkDetails::getBinaryLinkDetails($leftuser, $matrix_id, $targetroot);
//             $leftmembers_username   = $leftdetails['membername'];
//             $leftranktitle          = $leftdetails['ranktitle'] ?? '';
//             $leftsponsor_username   = $leftdetails['direct_id'] > 0 ? $leftdetails['sponsor_username'] : 'Nil';
//             $leftmembers_phone      = $leftdetails['members_phone'];
//             $leftmembers_email      = $leftdetails['members_email'];
//             $leftmembers_image      = $leftdetails['members_image'] != '' ? $leftdetails['members_image'] : 'uploads/avatar/emptyavatar.png';
//             $leftmembers_image      = env('CDNCLOUDEXTURL') . '/' . $leftmembers_image;
//             $leftrank_icon_path     = !empty($leftdetails['rank_icon_path']) ? env('CDNCLOUDEXTURL') . '/' . $leftdetails['rank_icon_path'] : '';
//             $leftranktitle          = $leftranktitle == '' ? 'Nil' : $leftranktitle;
//             $lefttitle              = $leftmembers_username . (!empty($leftranktitle) && $leftranktitle !== 'Nil' ? ' - ' . $leftranktitle : '');

//             $leftcountData          = MBinaryMembersCount::getBinaryMemberscount($leftuser, $matrix_id);
//             $left_rankgenealogy     = $leftdetails['rankgenealogy_name'];
//             $left_rankcolor         = $leftdetails['rankcolor'];

//             $output .= '{ id: "' . $leftuser . '", name: "' . $leftmembers_username . '", pid: ' . $members_id . ', title: "' . $lefttitle . '", description: "Sponsor : ' . $leftsponsor_username . '", phone: "' . $leftmembers_phone . '", email: "' . $leftmembers_email . '", rank: "Rank : ' . $leftranktitle . '", img: "' . $leftmembers_image . '", rankimage: "' . $leftrank_icon_path . '", leftmembercount:"Left total members : ' . $leftcountData['left'] . '", rightmembercount:"Right total members : ' . $leftcountData['right'] . '", members_id: "' . $leftuser . '", rankgenealogy_name: "' . $left_rankgenealogy . '"},';

//             if (!empty($left_rankgenealogy)) {
//                 $rank_color_css    .= '.node.' . $left_rankgenealogy . ' rect { fill: ' . $left_rankcolor . '; }';
//                 $rank_color_script .= 'case "' . $left_rankgenealogy . '": node.tags = ["' . $left_rankgenealogy . '"]; break;';
//             }

//             $depthLeft = self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
//             $output            .= $depthLeft['gendata'];
//             $rank_color_css    .= $depthLeft['rankcolorcss'];
//             $rank_color_script .= $depthLeft['rankcolorscript'];
//         }

//         if ($rightuser > 0) {
//             // Add empty left node first
//             $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '1');

//             // Then real right child
//             $rightdetails            = MBinaryLinkDetails::getBinaryLinkDetails($rightuser, $matrix_id, $targetroot);
//             $rightmembers_username   = $rightdetails['membername'];
//             $rightranktitle          = $rightdetails['ranktitle'] ?? '';
//             $rightsponsor_username   = $rightdetails['direct_id'] > 0 ? $rightdetails['sponsor_username'] : 'Nil';
//             $rightmembers_phone      = $rightdetails['members_phone'];
//             $rightmembers_email      = $rightdetails['members_email'];
//             $rightmembers_image      = $rightdetails['members_image'] != '' ? $rightdetails['members_image'] : 'uploads/avatar/emptyavatar.png';
//             $rightmembers_image      = env('CDNCLOUDEXTURL') . '/' . $rightmembers_image;
//             $rightrank_icon_path     = !empty($rightdetails['rank_icon_path']) ? env('CDNCLOUDEXTURL') . '/' . $rightdetails['rank_icon_path'] : '';
//             $rightranktitle          = $rightranktitle == '' ? 'Nil' : $rightranktitle;
//             $righttitle              = $rightmembers_username . (!empty($rightranktitle) && $rightranktitle !== 'Nil' ? ' - ' . $rightranktitle : '');

//             $rightcountData          = MBinaryMembersCount::getBinaryMemberscount($rightuser, $matrix_id);
//             $right_rankgenealogy     = $rightdetails['rankgenealogy_name'];
//             $right_rankcolor         = $rightdetails['rankcolor'];

//             $output .= '{ id: "' . $rightuser . '", name: "' . $rightmembers_username . '", pid: ' . $members_id . ', title: "' . $righttitle . '", description: "Sponsor : ' . $rightsponsor_username . '", phone: "' . $rightmembers_phone . '", email: "' . $rightmembers_email . '", rank: "Rank : ' . $rightranktitle . '", img: "' . $rightmembers_image . '", rankimage: "' . $rightrank_icon_path . '", leftmembercount:"Left total members : ' . $rightcountData['left'] . '", rightmembercount:"Right total members : ' . $rightcountData['right'] . '", members_id: "' . $rightuser . '", rankgenealogy_name: "' . $right_rankgenealogy . '"},';

//             if (!empty($right_rankgenealogy)) {
//                 $rank_color_css    .= '.node.' . $right_rankgenealogy . ' rect { fill: ' . $right_rankcolor . '; }';
//                 $rank_color_script .= 'case "' . $right_rankgenealogy . '": node.tags = ["' . $right_rankgenealogy . '"]; break;';
//             }

//             $depthRight = self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
//             $output            .= $depthRight['gendata'];
//             $rank_color_css    .= $depthRight['rankcolorcss'];
//             $rank_color_script .= $depthRight['rankcolorscript'];
//         }
//     }

//     // Case 3: No children
//     elseif ($childCount == 0) {
//         $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '1');
//         $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '2');
//     }

//     $output    = 'var data=[' . $output . ']';
//         $returnoutput=array();
//         $returnoutput[0]=$output;
//         $returnoutput[1]=$rank_color_css;

//         // dd($returnoutput);
//         return $returnoutput;
// }
// public static function getDepthBinaryGenealogy($members_id, $matrix_id, $targetroot)
// {
//     $output            = '';
//     $rank_color_css    = '';
//     $rank_color_script = '';

//     if ($members_id <= 0) {
//         return [
//             'gendata'         => $output,
//             'rankcolorcss'    => $rank_color_css,
//             'rankcolorscript' => $rank_color_script
//         ];
//     }

//     $details   = MBinaryLinkDetails::getBinaryLinkDetails($members_id, $matrix_id, $targetroot);
//     $childroot = $details['root'] ?? 0;

//     // Stop if we've reached the target depth
//     if ($childroot <= $targetroot) {
//         return [
//             'gendata'         => $output,
//             'rankcolorcss'    => $rank_color_css,
//             'rankcolorscript' => $rank_color_script
//         ];
//     }

//     $leftuser  = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '1');
//     $rightuser = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '2');

//     $referrals = MemberLinks::where('spillover_id', $members_id)
//         ->where('matrix_id', $matrix_id)
//         ->orderBy('link_id', 'ASC')
//         ->get();

//     $childCount = $referrals->count();

//     // Case 1: Both legs filled
//     if ($childCount == 2) {
//         // LEFT CHILD
//         if ($leftuser > 0) {
//             $left = MBinaryLinkDetails::getBinaryLinkDetails($leftuser, $matrix_id, $targetroot);

//             $left_username   = $left['membername'];
//             $left_ranktitle  = !empty($left['ranktitle']) && $left['ranktitle'] !== 'Nil' ? $left['ranktitle'] : 'Nil';
//             $left_sponsor    = $left['direct_id'] > 0 ? $left['sponsor_username'] : 'Nil';
//             $left_phone      = $left['members_phone'];
//             $left_email      = $left['members_email'];
//             $left_image      = $left['members_image'] != '' ? $left['members_image'] : 'uploads/avatar/emptyavatar.png';
//             $left_image      = env('CDNCLOUDEXTURL') . '/' . $left_image;
//             $left_rankimg    = !empty($left['rank_icon_path']) ? env('CDNCLOUDEXTURL') . '/' . $left['rank_icon_path'] : '';
//             $left_title      = $left_username . ($left_ranktitle !== 'Nil' ? ' - ' . $left_ranktitle : '');

//             $count           = MBinaryMembersCount::getBinaryMemberscount($leftuser, $matrix_id);
//             $left_genealogy  = $left['rankgenealogy_name'] ?? '';
//             $left_color      = $left['rankcolor'] ?? '#cccccc';

//             $output .= '{ id: "' . $leftuser . '", name: "' . $left_username . '", pid: ' . $members_id . ', title: "' . $left_title . '", description: "Sponsor : ' . $left_sponsor . '", phone: "' . $left_phone . '", email: "' . $left_email . '", rank: "Rank : ' . $left_ranktitle . '", img: "' . $left_image . '", rankimage: "' . $left_rankimg . '", leftmembercount:"Left total members : ' . $count['left'] . '", rightmembercount:"Right total members : ' . $count['right'] . '", members_id: "' . $leftuser . '", rankgenealogy_name: "' . $left_genealogy . '"},';

//             if ($left_genealogy) {
//                 $rank_color_css    .= ".node.$left_genealogy rect { fill: $left_color; }\n";
//                 $rank_color_script .= "case \"$left_genealogy\": node.tags = [\"$left_genealogy\"]; break;\n";
//             }

//             // Recurse deeper
//             $depth = self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
//             $output            .= $depth['gendata'];
//             $rank_color_css    .= $depth['rankcolorcss'];
//             $rank_color_script .= $depth['rankcolorscript'];
//         }

//         // RIGHT CHILD
//         if ($rightuser > 0) {
//             $right = MBinaryLinkDetails::getBinaryLinkDetails($rightuser, $matrix_id, $targetroot);

//             $right_username   = $right['membername'];
//             $right_ranktitle  = !empty($right['ranktitle']) && $right['ranktitle'] !== 'Nil' ? $right['ranktitle'] : 'Nil';
//             $right_sponsor    = $right['direct_id'] > 0 ? $right['sponsor_username'] : 'Nil';
//             $right_phone      = $right['members_phone'];
//             $right_email      = $right['members_email'];
//             $right_image      = $right['members_image'] != '' ? $right['members_image'] : 'uploads/avatar/emptyavatar.png';
//             $right_image      = env('CDNCLOUDEXTURL') . '/' . $right_image;
//             $right_rankimg    = !empty($right['rank_icon_path']) ? env('CDNCLOUDEXTURL') . '/' . $right['rank_icon_path'] : '';
//             $right_title      = $right_username . ($right_ranktitle !== 'Nil' ? ' - ' . $right_ranktitle : '');

//             $count            = MBinaryMembersCount::getBinaryMemberscount($rightuser, $matrix_id);
//             $right_genealogy  = $right['rankgenealogy_name'] ?? '';
//             $right_color      = $right['rankcolor'] ?? '#cccccc';

//             $output .= '{ id: "' . $rightuser . '", name: "' . $right_username . '", pid: ' . $members_id . ', title: "' . $right_title . '", description: "Sponsor : ' . $right_sponsor . '", phone: "' . $right_phone . '", email: "' . $right_email . '", rank: "Rank : ' . $right_ranktitle . '", img: "' . $right_image . '", rankimage: "' . $right_rankimg . '", leftmembercount:"Left total members : ' . $count['left'] . '", rightmembercount:"Right total members : ' . $count['right'] . '", members_id: "' . $rightuser . '", rankgenealogy_name: "' . $right_genealogy . '"},';

//             if ($right_genealogy) {
//                 $rank_color_css    .= ".node.$right_genealogy rect { fill: $right_color; }\n";
//                 $rank_color_script .= "case \"$right_genealogy\": node.tags = [\"$right_genealogy\"]; break;\n";
//             }

//             $depth = self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
//             $output            .= $depth['gendata'];
//             $rank_color_css    .= $depth['rankcolorcss'];
//             $rank_color_script .= $depth['rankcolorscript'];
//         }
//     }

//     // Case 2: Only one leg filled
//     elseif ($childCount == 1) {
//         if ($leftuser > 0) {
//             $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '2');

//             $left = MBinaryLinkDetails::getBinaryLinkDetails($leftuser, $matrix_id, $targetroot);
//             $left_username   = $left['membername'];
//             $left_ranktitle  = !empty($left['ranktitle']) ? $left['ranktitle'] : 'Nil';
//             $left_sponsor    = $left['direct_id'] > 0 ? $left['sponsor_username'] : 'Nil';
//             $left_phone      = $left['members_phone'];
//             $left_email      = $left['members_email'];
//             $left_image      = $left['members_image'] != '' ? $left['members_image'] : 'uploads/avatar/emptyavatar.png';
//             $left_image      = env('CDNCLOUDEXTURL') . '/' . $left_image;
//             $left_rankimg    = !empty($left['rank_icon_path']) ? env('CDNCLOUDEXTURL') . '/' . $left['rank_icon_path'] : '';
//             $left_title      = $left_username . ($left_ranktitle !== 'Nil' ? ' - ' . $left_ranktitle : '');

//             $count           = MBinaryMembersCount::getBinaryMemberscount($leftuser, $matrix_id);
//             $left_genealogy  = $left['rankgenealogy_name'] ?? '';
//             $left_color      = $left['rankcolor'] ?? '#cccccc';

//             $output .= '{ id: "' . $leftuser . '", name: "' . $left_username . '", pid: ' . $members_id . ', title: "' . $left_title . '", description: "Sponsor : ' . $left_sponsor . '", phone: "' . $left_phone . '", email: "' . $left_email . '", rank: "Rank : ' . $left_ranktitle . '", img: "' . $left_image . '", rankimage: "' . $left_rankimg . '", leftmembercount:"Left total members : ' . $count['left'] . '", rightmembercount:"Right total members : ' . $count['right'] . '", members_id: "' . $leftuser . '", rankgenealogy_name: "' . $left_genealogy . '"},';

//             if ($left_genealogy) {
//                 $rank_color_css    .= ".node.$left_genealogy rect { fill: $left_color; }\n";
//                 $rank_color_script .= "case \"$left_genealogy\": node.tags = [\"$left_genealogy\"]; break;\n";
//             }

//             $depth = self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
//             $output            .= $depth['gendata'];
//             $rank_color_css    .= $depth['rankcolorcss'];
//             $rank_color_script .= $depth['rankcolorscript'];
//         }

//         if ($rightuser > 0) {
//             $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '1');

//             $right = MBinaryLinkDetails::getBinaryLinkDetails($rightuser, $matrix_id, $targetroot);
//             $right_username   = $right['membername'];
//             $right_ranktitle  = !empty($right['ranktitle']) ? $right['ranktitle'] : 'Nil';
//             $right_sponsor    = $right['direct_id'] > 0 ? $right['sponsor_username'] : 'Nil';
//             $right_phone      = $right['members_phone'];
//             $right_email      = $right['members_email'];
//             $right_image      = $right['members_image'] != '' ? $right['members_image'] : 'uploads/avatar/emptyavatar.png';
//             $right_image      = env('CDNCLOUDEXTURL') . '/' . $right_image;
//             $right_rankimg    = !empty($right['rank_icon_path']) ? env('CDNCLOUDEXTURL') . '/' . $right['rank_icon_path'] : '';
//             $right_title      = $right_username . ($right_ranktitle !== 'Nil' ? ' - ' . $right_ranktitle : '');

//             $count            = MBinaryMembersCount::getBinaryMemberscount($rightuser, $matrix_id);
//             $right_genealogy  = $right['rankgenealogy_name'] ?? '';
//             $right_color      = $right['rankcolor'] ?? '#cccccc';

//             $output .= '{ id: "' . $rightuser . '", name: "' . $right_username . '", pid: ' . $members_id . ', title: "' . $right_title . '", description: "Sponsor : ' . $right_sponsor . '", phone: "' . $right_phone . '", email: "' . $right_email . '", rank: "Rank : ' . $right_ranktitle . '", img: "' . $right_image . '", rankimage: "' . $right_rankimg . '", leftmembercount:"Left total members : ' . $count['left'] . '", rightmembercount:"Right total members : ' . $count['right'] . '", members_id: "' . $rightuser . '", rankgenealogy_name: "' . $right_genealogy . '"},';

//             if ($right_genealogy) {
//                 $rank_color_css    .= ".node.$right_genealogy rect { fill: $right_color; }\n";
//                 $rank_color_script .= "case \"$right_genealogy\": node.tags = [\"$right_genealogy\"]; break;\n";
//             }

//             $depth = self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
//             $output            .= $depth['gendata'];
//             $rank_color_css    .= $depth['rankcolorcss'];
//             $rank_color_script .= $depth['rankcolorscript'];
//         }
//     }

//     // Case 3: No children → add empty spots
//     elseif ($childCount == 0) {
//         $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '1');
//         $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '2');
//     }

//         $outputre = array(
//                 'gendata' => $output,
//                 'rankcolorcss' => $rank_color_css,
//                 'rankcolorscript' => $rank_color_script
//             );

//             // dd($outputre);
//         return $outputre;
// }
    // public static function getDepthBinaryGenealogy($members_id, $matrix_id, $targetroot)
    // {


    //     $output    = '';
    //     $rank_color_css = '';
    //     $rank_color_script = '';
    //     $outputdepthdate = array();

    //     if ($members_id > 0) {
    //         $groupTitleColor       = '#4169e1';
    //         $itemTitleColor        = '#B800E6';
    //         $binaryparentdetails   = MBinaryLinkDetails::getBinaryLinkDetails($members_id, $matrix_id, $targetroot);
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
    //         $rank_color            = $binaryparentdetails['rankcolor'];
    //         // $where                 = 'spillover_id="' . $members_id . '" AND matrix_id="' . $matrix_id . '" ORDER BY link_id ASC ';
    //         // $referralslinkdetails  = MMatrixMemberLink::getMatrixLinkDetails($where);
    //         $referralslinkdetails = MemberLinks::where('spillover_id', $members_id)
    //             ->where('matrix_id', $matrix_id)
    //             ->orderBy('link_id', 'ASC')
    //             ->get();

    //         if ($childroot <= $targetroot) {
    //             if (count((array)$referralslinkdetails) == '2') { //for both side  is filled
    //                 //showleftdetails
    //                 $binaryleftdetails    = MBinaryLinkDetails::getBinaryLinkDetails($leftuser, $matrix_id, $targetroot);
    //                 $leftdirect_id        = $binaryleftdetails['direct_id']??'';
    //                 $leftmatrix_doj       = $binaryleftdetails['matrix_doj']??'';
    //                 $leftmembers_username = $binaryleftdetails['membername']??'';
    //                 $leftmembers_email    = $binaryleftdetails['members_email']??'';
    //                 $leftranktitle        = $binaryleftdetails['ranktitle']??'';
    //                 $leftmembers_phone    = $binaryleftdetails['members_phone']??'';
    //                 $leftmembers_image    = $binaryleftdetails['members_image']??'';
    //                 $leftsponsor_username = $binaryleftdetails['sponsor_username']??'';
    //                 $leftsponsor_username = $leftdirect_id > '0' ? $leftsponsor_username : 'Nil';
    //                 $leftrankid           = $binaryleftdetails['rankid']??'';
    //                 $leftrank_icon_path   = $binaryleftdetails['rank_icon_path']??'';
    //                $leftmembers_image    = $leftmembers_image != '' ? $leftmembers_image : 'uploads/avatar/emptyavatar.png';
    //                 $leftrank_icon_path   = $leftrank_icon_path == '' ? '' : $leftrank_icon_path;
                    
    //                 // $leftmembers_image = MAmazonCloudFront::getCloudFrontUrl($leftmembers_image);
    //                 // $leftrank_icon_path = MAmazonCloudFront::getCloudFrontUrl($leftrank_icon_path);
    //                 $rank_color           = $binaryleftdetails['rankcolor']??'';
    //                 $rankgenealogy_name   = $binaryleftdetails['rankgenealogy_name']??'';
    //                 $leftcontacttemplate  = $leftrankid > '0' ? 'contactTemplate' : 'contactTemplate1';
    //                 $count                = MBinaryMembersCount::getBinaryMemberscount($leftuser, $matrix_id);
    //                 $leftcount            = $count['left'];
    //                 $rightcount           = $count['right'];
    //                 $lefttotalmember      = $leftcount;
    //                 $righttotalmember     = $rightcount;
    //                 $leftranktitle        = $leftranktitle == '' ? 'Nil' : $leftranktitle;
    //                $output .= '{ id:  "' . $leftuser . '", name: "' . $leftmembers_username . '", pid: ' . $members_id . ', title: "' . $leftmembers_username . '", description: "Sponsor : ' . $leftsponsor_username . '", phone: "' . $leftmembers_phone . '", email: "' . $leftmembers_email . '",rank: "Rank : ' . $leftranktitle . '", img: "' . $leftmembers_image . '", rankimage: "' . $leftrank_icon_path . '",leftmembercount:"Left total members : ' . $lefttotalmember . '",rightmembercount:"Right total members : ' . $righttotalmember . '", members_id: "' . $leftuser . '", rankgenealogy_name: "' . $rankgenealogy_name . '"},';

    //                 $rank_color_css .= '.node.' . $rankgenealogy_name . ' rect {
    //                     fill: ' . $rank_color . ';
    //                 }';
    //                 $rank_color_script .= 'case "' . $rankgenealogy_name . '":
    //                 node.tags = ["' . $rankgenealogy_name . '"];
    //                 break;';

    //                 //showrightdetails
    //                 $binaryrightdetails    = MBinaryLinkDetails::getBinaryLinkDetails($rightuser, $matrix_id, $targetroot);
    //                 $rightdirect_id        = $binaryrightdetails['direct_id']??'';
    //                 $rightmatrix_doj       = $binaryrightdetails['matrix_doj']??'';
    //                 $rightmembers_username = $binaryrightdetails['membername']??'';
    //                 $rightmembers_phone    = $binaryrightdetails['members_phone']??'';
    //                 $rightranktitle        = $binaryrightdetails['ranktitle']??'';
    //                 $rightmembers_email    = $binaryrightdetails['members_email']??'';
    //                 $rightmembers_image    = $binaryrightdetails['members_image']??'';
    //                 $rightsponsor_username = $binaryrightdetails['sponsor_username']??'';
    //                 $rightsponsor_username = $rightdirect_id > '0' ? $rightsponsor_username : 'Nil';
    //                 $rightrankid           = $binaryrightdetails['rankid']??'';
    //                 $rightrank_icon_path   = $binaryrightdetails['rank_icon_path']??'';
    //                $rightmembers_image    = $rightmembers_image != '' ?  $rightmembers_image : 'uploads/avatar/emptyavatar.png';
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
    //                 $output .= '{ id:  "' . $rightuser . '", name: "' . $rightmembers_username . '", pid: ' . $members_id . ', title: "' . $rightmembers_username . '", description: "Sponsor : ' . $rightsponsor_username . '", phone: "' . $rightmembers_phone . '", email: "' . $rightmembers_email . '",rank: "Rank : ' . $rightranktitle . '", img: "' . $rightmembers_image . '", rankimage: "' . $rightrank_icon_path . '",leftmembercount:"Left total members : ' . $lefttotalmember . '",rightmembercount:"Right total members : ' . $righttotalmember . '", members_id: "' . $members_id . '", rankgenealogy_name: "' . $rankgenealogy_name . '"},';

    //                 $rank_color_css .= '.node.' . $rankgenealogy_name . ' rect {
    //                     fill: ' . $rank_color . ';
    //                 }';
    //                 $rank_color_script .= 'case "' . $rankgenealogy_name . '":
    //                 node.tags = ["' . $rankgenealogy_name . '"];
    //                 break;';

    //                 $depthdata = self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
    //                 $output .= $depthdata['gendata'];
    //                 $rank_color_css .= $depthdata['rankcolorcss'];
    //                 $rank_color_script .= $depthdata['rankcolorscript'];
    //                 $depthdata = self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
    //                 $output .= $depthdata['gendata'];
    //                 $rank_color_css .= $depthdata['rankcolorcss'];
    //                 $rank_color_script .= $depthdata['rankcolorscript'];
    //             }
    //             if (count((array)$referralslinkdetails) == '1') { //for one side  is filled
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
    //                     $rank_color                = $binaryleftdetails['rankcolor'];
    //                     $rankgenealogy_name        = $binaryleftdetails['rankgenealogy_name'];
    //                     $leftcontacttemplate       = $leftrankid > '0' ? 'contactTemplate' : 'contactTemplate1';
    //                     $count                     = MBinaryMembersCount::getBinaryMemberscount($leftuser, $matrix_id);
    //                     $leftcount                 = $count['left'];
    //                     $rightcount                = $count['right'];
    //                     $lefttotalmember           = $leftcount;
    //                     $righttotalmember          = $rightcount;
    //                     $leftranktitle             = $leftranktitle == '' ? 'Nil' : $leftranktitle;
    //                     $output .= '{ id:  "' . $leftuser . '", name: "' . $leftmembers_username . '", pid: ' . $members_id . ', title: "' . $leftmembers_username . '", description: "Sponsor : ' . $leftsponsor_username . '", phone: "' . $leftmembers_members_phone . '", email: "' . $leftmembers_email . '",rank: "Rank : ' . $leftranktitle . '", img: "' . $leftmembers_image . '", rankimage: "' . $leftrank_icon_path . '",leftmembercount:"Left total members : ' . $lefttotalmember . '",rightmembercount:"Right total members : ' . $righttotalmember . '", members_id: "' . $members_id . '", rankgenealogy_name: "' . $rankgenealogy_name . '"},';

    //                      $rank_color_css .= '.node.' . $rankgenealogy_name . ' rect {
    //                         fill: ' . $rank_color . ';
    //                     }';
    //                     $rank_color_script .= 'case "' . $rankgenealogy_name . '":
    //                         node.tags = ["' . $rankgenealogy_name . '"];
    //                         break;';
    //                     $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '2');
    //                     $depthdata = self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
    //                     $output .= $depthdata['gendata'];
    //                     $rank_color_css .= $depthdata['rankcolorcss'];
    //                     $rank_color_script .= $depthdata['rankcolorscript'];
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
    //                     $rank_color            = $binaryrightdetails['rankcolor'];
    //                     $rankgenealogy_name    = $binaryrightdetails['rankgenealogy_name'];
    //                     $output .= '{ id:  "' . $rightuser . '", name: "' . $rightmembers_username . '", pid: ' . $members_id . ', title: "' . $rightmembers_username . '", description: "Sponsor : ' . $rightsponsor_username . '", phone: "' . $rightmembers_phone . '", email: "' . $rightmembers_email . '",rank: "Rank : ' . $rightranktitle . '", img: "' . $rightmembers_image . '", rankimage: "' . $rightrank_icon_path . '",leftmembercount:"Left total members : ' . $lefttotalmember . '",rightmembercount:"Right total members : ' . $righttotalmember . '", members_id: "' . $members_id . '", rankgenealogy_name: "' . $rankgenealogy_name . '"},';

    //                      $rank_color_css .= '.node.' . $rankgenealogy_name . ' rect {
    //                         fill: ' . $rank_color . ';
    //                     }';
    //                     $rank_color_script .= 'case "' . $rankgenealogy_name . '":
    //                         node.tags = ["' . $rankgenealogy_name . '"];
    //                         break;';
    //                     $depthdata  = self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
    //                     $output .= $depthdata['gendata'];
    //                     $rank_color_css .= $depthdata['rankcolorcss'];
    //                     $rank_color_script .= $depthdata['rankcolorscript'];
    //                 }
    //             }
    //             if (count((array)$referralslinkdetails) == '0' && $childroot < $targetroot) { //for both side  is empty
    //                 $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '1');
    //                 $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '2');
    //             }
    //         }
    //     }



  

    //     $outputre = array(
    //             'gendata' => $output,
    //             'rankcolorcss' => $rank_color_css,
    //             'rankcolorscript' => $rank_color_script
    //         );

    //     return $outputre;

        
    // }


//   public static function getEmptyBianryGenealogyDetails($members_id, $matrix_id, $position)
//     {
//         $emtpyimagepath = 'uploads/avatar/emptyavatar.png';
// 		//$emtpyimagepath = MAmazonCloudFront::getCloudFrontUrl($emtpyimagepath);

//         $emtpyimagepath = env('CDNCLOUDEXTURL').'/'.$emtpyimagepath;
//         $randommember   = mt_rand(10000000, 99999999);
//         $output = '{ id:  ' . $randommember . ', name: "", pid: ' . $members_id . ',position:"' . $position . '", title: "",img: "' . $emtpyimagepath . '"},';
//         return $output;
//     }

public static function getBinaryGenealogyDetails($members_id, $matrix_id)
{
    $output            = '';
    $rank_color_css    = '';
    $rank_color_script = '';

    // Root member details
    $binaryparentdetails = MBinaryLinkDetails::getBinaryLinkDetails($members_id, $matrix_id);

    $direct_id          = $binaryparentdetails['direct_id'];
    $members_username   = $binaryparentdetails['membername'];
    $members_phone      = $binaryparentdetails['members_phone'];
    $members_email      = $binaryparentdetails['members_email'];
    $members_image      = $binaryparentdetails['members_image'] ?: 'uploads/members/avatar.png';
    $members_image      = env('CDNCLOUDEXTURL') . '/' . $members_image;

    $ranktitle          = $binaryparentdetails['ranktitle'] == '' ? 'Nil' : $binaryparentdetails['ranktitle'];
    $sponsor_username   = $direct_id > 0 ? $binaryparentdetails['sponsor_username'] : 'Nil';
    $rank_icon_path     = !empty($binaryparentdetails['rank_icon_path'])
        ? env('CDNCLOUDEXTURL') . '/' . $binaryparentdetails['rank_icon_path']
        : '';
    $rankgenealogy_name = $binaryparentdetails['rankgenealogy_name'] ?? '';
    $rank_color         = $binaryparentdetails['rankcolor'] ?? '#cccccc';

    $title = $members_username . ($ranktitle !== 'Nil' ? ' - ' . $ranktitle : '');

    $count              = MBinaryMembersCount::getBinaryMemberscount($members_id, $matrix_id);
    $lefttotalmember    = $count['left'];
    $righttotalmember   = $count['right'];

    // Root Node
    $output .= '{';
    $output .= 'id: "' . $members_id . '", ';
    $output .= 'name: "' . $members_username . '", ';
    $output .= 'pid: 0, ';
    $output .= 'title: "' . $title . '", ';
    $output .= 'description: "Sponsor : ' . $sponsor_username . '", ';
    $output .= 'phone: "' . $members_phone . '", ';
    $output .= 'email: "' . $members_email . '", ';
    $output .= 'rank: "Rank : ' . $ranktitle . '", ';
    $output .= 'img: "' . $members_image . '", ';
    $output .= 'rankimage: "' . $rank_icon_path . '", ';
    $output .= 'leftmembercount: "Left total members : ' . $lefttotalmember . '", ';
    $output .= 'rightmembercount: "Right total members : ' . $righttotalmember . '", ';
    $output .= 'members_id: "' . $members_id . '", ';
    $output .= 'rankgenealogy_name: "' . $rankgenealogy_name . '"';
    $output .= '},';

    // Add rank color for root
    if (!empty($rankgenealogy_name)) {
        $rank_color_css    .= ".node.$rankgenealogy_name rect { fill: $rank_color; }\n";
        $rank_color_script .= "case \"$rankgenealogy_name\": node.tags = [\"$rankgenealogy_name\"]; break;\n";
    }

    // Get direct children positions
    $leftuser  = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '1');
    $rightuser = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '2');

    $referrals = MemberLinks::where('spillover_id', $members_id)
        ->where('matrix_id', $matrix_id)
        ->orderBy('link_id', 'ASC')
        ->get();

    $childCount = $referrals->count();

    // Recursively build tree (no depth limit)
    if ($leftuser > 0) {
        $leftData = self::buildGenealogyNode($leftuser, $members_id, $matrix_id);
        $output .= $leftData['gendata'];
        $rank_color_css .= $leftData['rankcolorcss'];
        $rank_color_script .= $leftData['rankcolorscript'];
    }

    if ($rightuser > 0) {
        $rightData = self::buildGenealogyNode($rightuser, $members_id, $matrix_id);
        $output .= $rightData['gendata'];
        $rank_color_css .= $rightData['rankcolorcss'];
        $rank_color_script .= $rightData['rankcolorscript'];
    }

    // Add empty placeholders only if leg is missing
    if ($childCount < 2) {
        if ($leftuser <= 0) {
            $output .= self::getEmptyNode($members_id, 'left');
        }
        if ($rightuser <= 0) {
            $output .= self::getEmptyNode($members_id, 'right');
        }
    }

    // Critical: Remove trailing comma before closing array
    $output = rtrim($output, ',');

    $jsOutput = "var data = [{$output}];";

    return [
        $jsOutput,
        $rank_color_css,
        $rank_color_script
    ];
}

// New unified recursive function (replaces getDepthBinaryGenealogy)
private static function buildGenealogyNode($members_id, $parent_id, $matrix_id)
{
    $output            = '';
    $rank_color_css    = '';
    $rank_color_script = '';

    if ($members_id <= 0) {
        return [
            'gendata'         => $output,
            'rankcolorcss'    => $rank_color_css,
            'rankcolorscript' => $rank_color_script
        ];
    }

    $details = MBinaryLinkDetails::getBinaryLinkDetails($members_id, $matrix_id);

    $username   = $details['membername'];
    $ranktitle  = empty($details['ranktitle']) || $details['ranktitle'] === 'Nil' ? 'Nil' : $details['ranktitle'];
    $sponsor    = $details['direct_id'] > 0 ? $details['sponsor_username'] : 'Nil';
    $phone      = $details['members_phone'];
    $email      = $details['members_email'];
    $image      = !empty($details['members_image'])
        ? env('CDNCLOUDEXTURL') . '/' . $details['members_image']
        : env('CDNCLOUDEXTURL') . '/uploads/avatar/emptyavatar.png';

    $rank_icon  = !empty($details['rank_icon_path'])
        ? env('CDNCLOUDEXTURL') . '/' . $details['rank_icon_path']
        : '';

    $genealogy_name = $details['rankgenealogy_name'] ?? '';
    $rank_color     = $details['rankcolor'] ?? '#cccccc';

    $title = $username . ($ranktitle !== 'Nil' ? ' - ' . $ranktitle : '');

    $count = MBinaryMembersCount::getBinaryMemberscount($members_id, $matrix_id);

    // Add current node
    $output .= '{';
    $output .= 'id: "' . $members_id . '", ';
    $output .= 'name: "' . $username . '", ';
    $output .= 'pid: ' . $parent_id . ', ';
    $output .= 'title: "' . $title . '", ';
    $output .= 'description: "Sponsor : ' . $sponsor . '", ';
    $output .= 'phone: "' . $phone . '", ';
    $output .= 'email: "' . $email . '", ';
    $output .= 'rank: "Rank : ' . $ranktitle . '", ';
    $output .= 'img: "' . $image . '", ';
    $output .= 'rankimage: "' . $rank_icon . '", ';
    $output .= 'leftmembercount: "Left total members : ' . $count['left'] . '", ';
    $output .= 'rightmembercount: "Right total members : ' . $count['right'] . '", ';
    $output .= 'members_id: "' . $members_id . '", ';
    $output .= 'rankgenealogy_name: "' . $genealogy_name . '"';
    $output .= '},';

    // Add rank styling
    if (!empty($genealogy_name)) {
        $rank_color_css    .= ".node.$genealogy_name rect { fill: $rank_color; }\n";
        $rank_color_script .= "case \"$genealogy_name\": node.tags = [\"$genealogy_name\"]; break;\n";
    }

    // Get children
    $leftChild  = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '1');
    $rightChild = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '2');

    $hasLeft  = $leftChild > 0;
    $hasRight = $rightChild > 0;

    // Recurse into children
    if ($leftChild > 0) {
        $leftData = self::buildGenealogyNode($leftChild, $members_id, $matrix_id);
        $output           .= $leftData['gendata'];
        $rank_color_css   .= $leftData['rankcolorcss'];
        $rank_color_script .= $leftData['rankcolorscript'];
    }
    if ($rightChild > 0) {
        $rightData = self::buildGenealogyNode($rightChild, $members_id, $matrix_id);
        $output           .= $rightData['gendata'];
        $rank_color_css   .= $rightData['rankcolorcss'];
        $rank_color_script .= $rightData['rankcolorscript'];
    }



    return [
        'gendata'         => $output,
        'rankcolorcss'    => $rank_color_css,
        'rankcolorscript' => $rank_color_script
    ];
}

// Safe empty node with unique ID
private static function getEmptyNode($parent_id, $side)
{
    $uniqueId = 'empty_' . $parent_id . '_' . $side;
    return '{ id: "' . $uniqueId . '", name: "Available", pid: ' . $parent_id . ', title: "Join Here", img: "' . env('CDNCLOUDEXTURL') . '/uploads/avatar/emptyavatar.png", rank: "Rank : Nil", description: "Open Position", leftmembercount: "Left total members : 0", rightmembercount: "Right total members : 0" },';
}
}