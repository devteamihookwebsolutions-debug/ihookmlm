<?php
/**
 * This class contains functions related to genealogy
 *
 * @package         MGenealogy
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2023, Sunsofty.
 * @version         Version 8.1
 */

namespace User\App\Models\Genealogy;

use Query\Bin_Query;
use Model\Middleware\MMembersDetails;
use Model\Middleware\MAmazonS3;
use Admin\App\Models\Genealogy\MBinaryLinkDetails;
use Admin\App\Models\Middleware\MBinaryMembersPosition;
use Admin\App\Models\Middleware\MMatrixMemberLink;
use Admin\App\Models\Middleware\MAmazonCloudFront;

class MBinaryCollapseGenealogy
{

public static function getBinaryGenealogyDetails($members_id, $matrix_id)
{
    $node = self::buildNodeRecursive($members_id, $matrix_id);
    return 'var treeData = ' . json_encode($node, JSON_UNESCAPED_SLASHES) . ';';
}

private static function buildNodeRecursive($memberId, $matrix_id)
{
    $details = MBinaryLinkDetails::getBinaryLinkDetails($memberId, $matrix_id);

    $node = [
        'name'  => $details['membername'] ?? 'Unknown',
        'link'  => env('BCPATH') . '/userdetails/show/' . $memberId,
    ];

    $left  = MBinaryMembersPosition::getBinaryMembersPosition($memberId, $matrix_id, '1');
    $right = MBinaryMembersPosition::getBinaryMembersPosition($memberId, $matrix_id, '2');

    $children = [];

    // Left child
    if ($left > 0) {
        $children[] = self::buildNodeRecursive($left, $matrix_id);
    }

    // Right child
    if ($right > 0) {
        $children[] = self::buildNodeRecursive($right, $matrix_id);
    }

    // Agar dono taraf koi real downline nahi hai, to "Empty" placeholder add karo
    if (empty($children)) {
        $children[] = [
            'name'      => 'Empty',
            'title'     => 'This member has no downlines',
            'image'     => 'uploads/avatar/empty-small.png', // optional, agar image support hai
            'className' => 'no-downline-msg',               // CSS class for styling
            'link'      => 'javascript:void(0)'
        ];
    }

    $node['children'] = $children;

    return $node;
}


}
