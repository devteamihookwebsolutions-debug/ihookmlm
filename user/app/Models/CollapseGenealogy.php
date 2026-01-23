<?php

/**
 * This class contains public functions related to CollapseGenealogy
 *
 * @package         CollapseGenealogy
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
namespace User\App\Models;

use Illuminate\Support\Facades\Crypt;

class CollapseGenealogy
{
    public static function build($memberId, $matrixId)
    {
        $member = Member::findOrFail($memberId);
        $root = [
            'name' => $member->members_username,
            'link' => self::encryptLink($memberId, $matrixId),
            'children' => []
        ];

        $link = MatrixMemberLink::where('members_id', $memberId)
                                ->where('matrix_id', $matrixId)
                                ->first();

        if ($link) {
            $root['children'] = self::getChildren($link, $matrixId, 0);
        }

        return $root;
    }

    private static function getChildren($parentLink, $matrixId, $depth)
    {
        if ($depth >= 6) return []; // limit depth

        $children = [];
        foreach ($parentLink->children as $childLink) {
            $member = $childLink->member;
            $node = [
                'name' => $member->members_username,
                'link' => self::encryptLink($childLink->members_id, $matrixId),
                'children' => self::getChildren($childLink, $matrixId, $depth + 1)
            ];
            $children[] = $node;
        }

        return $children;
    }

    private static function encryptLink($memberId, $matrixId)
    {
        return route('genealogy.collapse.viewtree', Crypt::encrypt([$memberId, $matrixId]));
    }
}
