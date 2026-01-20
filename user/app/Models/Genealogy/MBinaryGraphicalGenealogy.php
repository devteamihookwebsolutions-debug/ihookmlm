<?php

/**
 * This class contains public functions related to MBinaryGraphicalGenealogy
 *
 * @package         MBinaryGraphicalGenealogy
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
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
