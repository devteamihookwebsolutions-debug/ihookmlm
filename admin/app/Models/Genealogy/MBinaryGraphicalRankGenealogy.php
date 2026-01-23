<?php

/**
 * This class contains public functions related to MBinaryGraphicalRankGenealogy
 *
 * @package         MBinaryGraphicalRankGenealogy
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
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
