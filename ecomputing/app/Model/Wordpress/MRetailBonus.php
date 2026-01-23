<?php

/**
 * This class contains public functions related to MRetailBonus
 *
 * @package         MRetailBonus
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
?><?php
namespace Ecomputing\App\Model\Wordpress;
use Illuminate\Support\Facades\DB;

class MRetailBonus
{

    public function getUsertype()
    {
        $prefix = config('services.ihook.prefix');
        $shopid = trim($_POST['shopid']);

        // Get member by shop ID
        $member = DB::table($prefix . 'members_table')
            ->where('members_shop_id', $shopid)
            ->first();

        if (!$member) {
            echo '';
            return;
        }

        $userid = $member->members_id;

        // Get matrix link details
        $matrixLink = DB::table($prefix . 'matrix_members_link_table')
            ->where('members_id', $userid)
            ->first();

        $usertype = $matrixLink->user_type ?? '';

        echo $usertype;
    }

    public function getRetailBonus()
    {
        $prefix = config('services.ihook.prefix');
        $shopid = trim($_POST['shopid']);

        // Get member by shop ID
        $member = DB::table($prefix . 'members_table')
            ->where('members_shop_id', $shopid)
            ->first();

        if (!$member) {
            echo '';
            return;
        }

        $members_id = $member->members_id;

        // Get all matrix links for this member
        $linkPlan = DB::table($prefix . 'matrix_members_link_table')
            ->where('members_id', $members_id)
            ->get();

        $largermembercount = 0;
        $largermatrix_id = 0;
        $matrix_id = 0;

        foreach ($linkPlan as $link) {
            $matrix_id = $link->matrix_id;

            // Count downline members
            $downlineCount = DB::table($prefix . 'matrix_members_link_table')
                ->whereRaw("FIND_IN_SET(?, members_parents)", [$members_id])
                ->where('matrix_id', $matrix_id)
                ->count();

            if ($downlineCount > $largermembercount) {
                $largermatrix_id = $matrix_id;
                $largermembercount = $downlineCount;
            }
        }

        // Fallback if no larger matrix found
        if ($largermatrix_id <= 0) {
            $largermatrix_id = $matrix_id;
        }

        // Get retail bonus
        $retail = DB::table($prefix . 'retailbonus')
            ->where('matrix_id', $largermatrix_id)
            ->first();

        if (!$retail) {
            echo '';
            return;
        }

        echo $retail->retailcommission_percentage . '|' . $retail->commissionpercentage;
    }

}

