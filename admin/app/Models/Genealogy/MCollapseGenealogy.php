<?php

/**
 * This class contains public functions related to MCollapseGenealogy
 *
 * @package         MCollapseGenealogy
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
namespace Admin\App\Models\Genealogy;

use Admin\App\Models\Middleware\MMatrixMemberLink;
use Admin\App\Models\Middleware\MMemberDetails;
class MCollapseGenealogy
{
     /**
     * This public static function is used  to get collapse genealogy data
     * @param int $members_id
     * @param int $matrix_id
     * @return bool
    */
    public static function updateGenealogyDetails($members_id, $matrix_id)
    {
        $userdetails = MMemberDetails::getPartMembersDetails('members_username', $members_id);
        $members_username = $userdetails['members_username'];

        $children = [];
        $referralslinkdetails = MMatrixMemberLink::getMatrixLinkDetail($members_id, $matrix_id);

        foreach ($referralslinkdetails as $ref) {
            $children[] = self::buildNode($ref['members_id'], $matrix_id);
        }

        return [
            'name' => $members_username,
            'children' => $children ?: []
        ];
    }

    private static function buildNode($members_id, $matrix_id, $depth = 0)
    {
        $userdetails = MMemberDetails::getPartMembersDetails('members_username', $members_id);
        $members_username = $userdetails['members_username'];

        $node = [
            'name' => $members_username,
            'link' => $_ENV['BCPATH'] . '/collapsegenealogy/viewtree/' . $matrix_id . '/' . $members_id . '/' . $members_id,
        ];

        if ($depth < 6) {
            $children = [];
            $referrals = MMatrixMemberLink::getMatrixLinkDetail($members_id, $matrix_id);
            foreach ($referrals as $ref) {
                $children[] = self::buildNode($ref['members_id'], $matrix_id, $depth + 1);
            }
            if (!empty($children)) {
                $node['children'] = $children;
            }
        }

        return $node;
    }

}

