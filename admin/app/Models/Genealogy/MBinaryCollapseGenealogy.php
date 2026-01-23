<?php

/**
 * This class contains public functions related to MBinaryCollapseGenealogy
 *
 * @package         MBinaryCollapseGenealogy
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
