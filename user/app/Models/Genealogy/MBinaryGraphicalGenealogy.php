<?php
namespace User\App\Models\Genealogy;

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

class MBinaryGraphicalGenealogy
{

// public static function getBinaryGenealogyDetails($members_id, $matrix_id)
// {
//     $binaryparentdetails   = MBinaryLinkDetails::getBinaryLinkDetails($members_id, $matrix_id);
//     $direct_id             = $binaryparentdetails['direct_id'];
//     $members_username      = $binaryparentdetails['membername'];
//     $members_phone         = $binaryparentdetails['members_phone'];
//     $members_email         = $binaryparentdetails['members_email'];
//     $members_image         = $binaryparentdetails['members_image'];
//     $parentroot            = $binaryparentdetails['root'];
//     $ranktitle             = $binaryparentdetails['ranktitle'];
//     $sponsor_username      = $binaryparentdetails['sponsor_username'];
//     $sponsor_username      = $direct_id > '0' ? $sponsor_username : 'Nil';
//     $rankid                = $binaryparentdetails['rankid'];
//     $rank_icon_path        = $binaryparentdetails['rank_icon_path'];

//     $leftuser  = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '1');
//     $rightuser = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '2');

//     $memberimage     = $members_image != '' ? $members_image : 'uploads/members/avatar.png';
//     $memberimage     = env('CDNCLOUDEXTURL') . '/' . $memberimage;
//     $rank_icon_path  = $rankid ? env('CDNCLOUDEXTURL') . '/' . $rank_icon_path : '';

//     $count           = MBinaryMembersCount::getBinaryMemberscount($members_id, $matrix_id);
//     $lefttotalmember = $count['left'];
//     $righttotalmember= $count['right'];
//     $rank            = $ranktitle ?: 'Nil';
//     $downlinecount   = MMembersCount::getDownlineMemberscount($members_id, $matrix_id);

//     $targetroot = $parentroot + 3;

//     // Root User
//     $output = '{ id: "' . $members_id . '", name: "' . $members_username . '", pid: 0, title: "' . $members_username . '", description: "Sponsor : ' . $sponsor_username . '", phone: "' . $members_phone . '", email: "' . $members_email . '", rank: "Rank : ' . $rank . '", img: "' . $memberimage . '", rankimage: "' . $rank_icon_path . '", leftmembercount:"Left total members : ' . $lefttotalmember . '", rightmembercount:"Right total members : ' . $righttotalmember . '", members_id: "' . $members_id . '", downlinecount:"' . $downlinecount . '"},';

//     $referralslinkdetails = MemberLinks::where('spillover_id', $members_id)
//         ->where('matrix_id', $matrix_id)
//         ->orderBy('link_id', 'ASC')
//         ->get();

//     $childCount = count($referralslinkdetails);

//     if ($childCount == 2) {
//         // Both sides filled
//         if ($leftuser > 0) {
//             $output .= self::addChildNode($leftuser, $members_id, $matrix_id, $targetroot);
//             $output .= self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
//         }
//         if ($rightuser > 0) {
//             $output .= self::addChildNode($rightuser, $members_id, $matrix_id, $targetroot);
//             $output .= self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
//         }
//     }
//     elseif ($childCount == 1) {
//         // Only one side
//         if ($leftuser > 0) {
//             $output .= self::addChildNode($leftuser, $members_id, $matrix_id, $targetroot);
//             $output .= self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
//         }
//         if ($rightuser > 0) {
//             $output .= self::addChildNode($rightuser, $members_id, $matrix_id, $targetroot);
//             $output .= self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
//         }
//     }
//     // If $childCount == 0 → Do nothing (no empty nodes)

//     $output = 'var data=[' . $output . '];';
//     // dd($output);
//     return $output;
// }

// public static function getDepthBinaryGenealogy($members_id, $matrix_id, $targetroot)
// {
//     $output = '';
//     if ($members_id <= 0) return $output;

//     $details = MBinaryLinkDetails::getBinaryLinkDetails($members_id, $matrix_id, $targetroot);
//     $childroot = $details['root'] ?? 0;

//     if ($childroot > $targetroot) return $output; // Depth limit reached

//     $leftuser  = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '1');
//     $rightuser = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '2');

//     $referrals = MemberLinks::where('spillover_id', $members_id)
//         ->where('matrix_id', $matrix_id)
//         ->get();

//     $childCount = count($referrals);

//     if ($childCount == 2) {
//         if ($leftuser > 0) {
//             $output .= self::addChildNode($leftuser, $members_id, $matrix_id, $targetroot);
//             $output .= self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
//         }
//         if ($rightuser > 0) {
//             $output .= self::addChildNode($rightuser, $members_id, $matrix_id, $targetroot);
//             $output .= self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
//         }
//     }
//     elseif ($childCount == 1) {
//         if ($leftuser > 0) {
//             $output .= self::addChildNode($leftuser, $members_id, $matrix_id, $targetroot);
//             $output .= self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
//         }
//         if ($rightuser > 0) {
//             $output .= self::addChildNode($rightuser, $members_id, $matrix_id, $targetroot);
//             $output .= self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
//         }
//     }
//     // If no children → do nothing (no empty nodes)

//     return $output;
// }

// // Helper function - repeated code avoid பண்ண
// private static function addChildNode($child_id, $parent_id, $matrix_id, $targetroot)
// {
//     $details            = MBinaryLinkDetails::getBinaryLinkDetails($child_id, $matrix_id, $targetroot);
//     $username           = $details['membername'] ?? '';
//     $phone              = $details['members_phone'] ?? '';
//     $email              = $details['members_email'] ?? '';
//     $image              = $details['members_image'] ? $details['members_image'] : 'uploads/avatar/emptyavatar.png';
//     $image              = env('CDNCLOUDEXTURL') . '/' . $image;
//     $sponsor            = ($details['direct_id'] > 0 ? $details['sponsor_username'] : 'Nil') ?? 'Nil';
//     $rank               = $details['ranktitle'] ?: 'Nil';
//     $rank_icon          = $details['rankid'] ? env('CDNCLOUDEXTURL') . '/' . $details['rank_icon_path'] : '';

//     $count              = MBinaryMembersCount::getBinaryMemberscount($child_id, $matrix_id);
//     $leftcount          = $count['left'];
//     $rightcount         = $count['right'];
//     $downlinecount      = MMembersCount::getDownlineMemberscount($child_id, $matrix_id);

//     return '{ id: "' . $child_id . '", name: "' . $username . '", pid: ' . $parent_id . ', title: "' . $username . '", description: "Sponsor : ' . $sponsor . '", phone: "' . $phone . '", email: "' . $email . '", rank: "Rank : ' . $rank . '", img: "' . $image . '", rankimage: "' . $rank_icon . '", leftmembercount:"Left total members : ' . $leftcount . '", rightmembercount:"Right total members : ' . $rightcount . '", members_id: "' . $child_id . '", downlinecount:"' . $downlinecount . '"},';
// }


public static function getBinaryGenealogyDetails($members_id, $matrix_id)
{
    $treeData = [];

    self::buildTreeNode($treeData, $members_id, $matrix_id, 0);

    $jsOutput = "var data = " . json_encode($treeData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . ";";

    return $jsOutput;
}

private static function buildTreeNode(&$treeData, $memberId, $matrixId, $parentId = 0)
{
    if (!$memberId || $memberId <= 0) {
        return;
    }

    // Fetch member details
    $details = MBinaryLinkDetails::getBinaryLinkDetails($memberId, $matrixId);

    $username = $details['membername'] ?? 'Unknown';
    $phone    = $details['members_phone'] ?? '';
    $email    = $details['members_email'] ?? '';
    $image    = !empty($details['members_image'])
        ? env('CDNCLOUDEXTURL') . '/' . $details['members_image']
        : env('CDNCLOUDEXTURL') . '/uploads/members/avatar.png';

    $rankTitle = empty($details['ranktitle']) ? 'Nil' : $details['ranktitle'];
    $rankIcon  = !empty($details['rank_icon_path'])
        ? env('CDNCLOUDEXTURL') . '/' . $details['rank_icon_path']
        : '';

    $sponsor = ($details['direct_id'] ?? 0) > 0
        ? ($details['sponsor_username'] ?? 'Nil')
        : 'Nil';

    // Counts
    $count = MBinaryMembersCount::getBinaryMemberscount($memberId, $matrixId);
    $leftCount  = $count['left'] ?? 0;
    $rightCount = $count['right'] ?? 0;
    $downlineCount = MMembersCount::getDownlineMemberscount($memberId, $matrixId);

    $title = $username;
    if ($rankTitle !== 'Nil') {
        $title .= ' - ' . $rankTitle;
    }

    // Add current member to tree
    $treeData[] = [
        'id'                 => (string)$memberId,
        'name'               => $username,
        'title'              => $title,
        'pid'                => $parentId == 0 ? 0 : (int)$parentId,
        'description'        => "Sponsor: " . $sponsor,
        'phone'              => $phone,
        'email'              => $email,
        'rank'               => "Rank: " . $rankTitle,
        'img'                => $image,
        'rankimage'          => $rankIcon,
        'leftmembercount'    => "Left total members: " . $leftCount,
        'rightmembercount'   => "Right total members: " . $rightCount,
        'members_id'         => (string)$memberId,
        'downlinecount'      => (string)$downlineCount,
    ];

    // Get real children only children
    $leftChild  = MBinaryMembersPosition::getBinaryMembersPosition($memberId, $matrixId, '1'); // Left
    $rightChild = MBinaryMembersPosition::getBinaryMembersPosition($memberId, $matrixId, '2'); // Right

    // Only add if real member exists
    if ($leftChild > 0) {
        self::buildTreeNode($treeData, $leftChild, $matrixId, $memberId);
    }

    if ($rightChild > 0) {
        self::buildTreeNode($treeData, $rightChild, $matrixId, $memberId);
    }

    // No empty nodes added ever
}
}
