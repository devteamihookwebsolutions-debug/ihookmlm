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
