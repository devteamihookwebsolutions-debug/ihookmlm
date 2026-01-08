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

namespace Admin\App\Models\Genealogy;

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
        return self::buildNodeRecursive($members_id, $matrix_id);
    }

    private static function buildNodeRecursive($memberId, $matrix_id)
    {
        $details = MBinaryLinkDetails::getBinaryLinkDetails($memberId, $matrix_id);

        $node = [
            'name' => $details['membername'] ?? 'Unknown',
            'link' => env('BCPATH', '') . '/userdetails/show/' . $memberId,
        ];

        $left  = MBinaryMembersPosition::getBinaryMembersPosition($memberId, $matrix_id, '1');
        $right = MBinaryMembersPosition::getBinaryMembersPosition($memberId, $matrix_id, '2');

        $children = [];

        if ($left > 0) {
            $children[] = self::buildNodeRecursive($left, $matrix_id);
        }

        if ($right > 0) {
            $children[] = self::buildNodeRecursive($right, $matrix_id);
        }

        if (!empty($children)) {
            $node['children'] = $children;
        } else {
            $node['children'] = [];
        }
        return $node;
    }

}
