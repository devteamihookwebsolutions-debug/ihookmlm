<?php

/**
 * This class contains public static functions related to genealogy
 *
 * @package         MCompactGenealogy
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2023, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
 *****************************************************************************/

namespace Admin\App\Model\Genealogy;

use Admin\App\Models\Genealogy\MBinaryLinkDetails;
use Admin\App\Models\Genealogy\MBinaryMembersCount;
use Admin\App\Models\Middleware\MMemberDetails;
use Admin\App\Models\Middleware\MURLCrypt;
use Illuminate\Support\Facades\DB;


class MCompactGenealogy
{
    /**
     * This public static function is used to get genealogy data
     * @param int $members_id
     * @param int $matrix_id
     * @return string
     */
    public static function getCompactGenealogytree($members_id, $matrix_id)
    {
        $output = '';
        $binaryparentdetails   = MBinaryLinkDetails::getBinaryLinkDetails($members_id, $matrix_id);
        $direct_id             = $binaryparentdetails['direct_id'] ?? 0;
        $matrix_doj            = $binaryparentdetails['matrix_doj'] ?? '';
        $spillover_id          = $binaryparentdetails['spillover_id'] ?? 0;
        $members_username      = $binaryparentdetails['membername'] ?? '';
        $members_phone         = $binaryparentdetails['members_phone'] ?? '';
        $members_email         = $binaryparentdetails['members_email'] ?? '';
        $members_image         = $binaryparentdetails['members_image'] ?? '';
        $parentroot            = $binaryparentdetails['root'] ?? 0;
        $ranktitle             = $binaryparentdetails['ranktitle'] ?? '';
        $sponsor_username      = $binaryparentdetails['sponsor_username'] ?? '';
        $sponsor_username      = $direct_id > 0 ? $sponsor_username : 'Nil';
        $rankid                = $binaryparentdetails['rankid'] ?? 0;

        $targetroot            = $parentroot + 3;
        $parentcontacttemplate = $rankid > 0 ? 'contactTemplate' : 'contactTemplate1';

        $memberimage = $members_image
            ? config('app.url') . '/' . $members_image
            : asset('/img/compact_emptyavatar.png');

        $rank_icon_path = '';
        if ($rankid > 0) {
            $rank_icon_path = $binaryparentdetails['rank_value'] ?? '';
            if (empty($rank_icon_path) || $rank_icon_path === 'uploads/avatar/rankavathar.svg') {
                $rank_icon_path = asset($rank_icon_path);
            } else {
                $rank_icon_path = config('app.url') . '/' . $rank_icon_path;
            }
        }

        $count             = MBinaryMembersCount::getBinaryMemberscount($members_id, $matrix_id);
        $leftcount         = $count['left'] ?? 0;
        $rightcount        = $count['right'] ?? 0;
        $lefttotalmember   = $leftcount;
        $righttotalmember  = $rightcount;
        $rank              = $ranktitle === '' ? 'Nil' : $ranktitle;
        $crypturl          = MURLCrypt::getEncryptURL($matrix_id, $members_id);

        $output .= '
            <!-- hv-container -->
            <div class="bg-white dark:bg-neutral-900 flex min-h-screen flex-col items-center justify-start p-2 py-10 text-center overflow-auto">
            <div class="tree whitespace-nowrap overflow-auto relative mx-auto" data-testid="family-tree-root">
            <ul class="relative flex flex-row items-baseline justify-center">';

        $output .= '<li class="float-left list-none relative pt-14 px-2 mt-14">
                    <div class="border-solid border-neutral-300 border p-2 rounded-md inline-block">
                        <div class="!border-none py-1 px-2 inline-block" data-testid="person-container">
                            <span role="img" aria-label="Avatar for ' . htmlspecialchars($members_username) . '" title="Avatar for ' . htmlspecialchars($members_username) . '" class="bg-female inline-block relative h-10 w-10 cursor-pointer overflow-hidden rounded-full">
                                <a href="' . url('/user/network/view/' . $crypturl) . '"><img src="' . $memberimage . '" alt="" class="w-10 h-10 rounded-full overflow-hidden bg-white"></a>
                            </span>
                            <p class="m-0 text-black dark:text-white">' . htmlspecialchars($members_username) . '</p>
                        </div>';

        if ($rank_icon_path !== '') {
            $output .= '<div class="rank">
            <img name="rankphoto" class="block mx-auto w-8 h-8" src="' . $rank_icon_path . '" title="' . htmlspecialchars($rank) . '"></div>';
        }

        $output .= '</div><ul class="pt-14 relative flex flex-row items-baseline justify-center">';

        $firstchildroot = $parentroot + 1;
        $prefix = config('ihook.prefix', 'ihook');

        $sqlmembers = "SELECT SQL_CALC_FOUND_ROWS
                a.*,
                b.members_email, b.members_firstname, b.members_lastname, b.members_image, b.members_phone, b.members_username,
                c.members_username AS sponsorname,
                d.rank_key, d.rank_value,
                e.rank_value AS rank_icon_path
            FROM {$prefix}_matrix_members_link_table AS a
            LEFT JOIN {$prefix}_members_table AS b ON a.members_id = b.members_id
            LEFT JOIN {$prefix}_members_table AS c ON c.members_id = a.direct_id
            LEFT JOIN {$prefix}_ranksetting AS d ON d.rank_id = a.rankid
            LEFT JOIN {$prefix}_ranksetting AS e ON (e.rank_id = a.rankid AND e.rank_key = 'rank_icon_path' AND e.matrix_id = ?)
            WHERE (FIND_IN_SET(?, a.members_parents) OR a.members_id = ?)
              AND a.root = ?
            GROUP BY a.members_id
            ORDER BY a.position ASC";

        $referralslinkdetails = DB::select($sqlmembers, [$matrix_id, $members_id, $members_id, $firstchildroot]);

        if (!empty($referralslinkdetails)) {
            foreach ($referralslinkdetails as $ref) {
                $ref = (array) $ref;

                $ref_members_id             = $ref['members_id'] ?? 0;
                $ref_spillover_id           = $ref['spillover_id'] ?? 0;
                $ref_members_email          = $ref['members_email'] ?? '';
                $ref_members_image          = $ref['members_image'] ?? '';
                $ref_memberimage            = $ref_members_image
                    ? config('app.url') . '/' . $ref_members_image
                    : asset('/img/compact_emptyavatar.png');
                $ref_members_fullname       = $ref['members_username'] ?? '';
                $ref_members_phone          = $ref['members_phone'] ?? '';
                $ref_linkid                 = $ref['link_id'] ?? 0;
                $ref_sponsor_name           = $ref['sponsorname'] ?? '';
                $ref_rank_value             = $ref['rank_value'] ?? '';
                $ref_members_passup_id      = $ref['members_passup_id'] ?? 0;
                $ref_members_passup_direct_id = $ref['members_passup_direct_id'] ?? 0;

                $passupdetails = '';
                if ($ref_members_passup_id > 0) {
                    $member_details = MMemberDetails::getPartMembersDetails('members_username', $ref_members_passup_id);
                    $passupmembername = $member_details['members_username'] ?? '';
                    $passupdetails = ', Passup: ' . htmlspecialchars($passupmembername);
                }

                $ref_sponsor_name = $ref_sponsor_name === '' ? 'Nil' : $ref_sponsor_name;
                $ref_rank = $ref_rank_value === '' ? 'Nil' : $ref_rank_value;

                $ref_rank_icon_path = '';
                if ($rankid > 0) {
                    $ref_rank_icon_path = $ref['rank_icon_path'] ?? '';
                    if (empty($ref_rank_icon_path) || $ref_rank_icon_path === 'uploads/avatar/rankavathar.svg') {
                        $ref_rank_icon_path = asset($ref_rank_icon_path);
                    } else {
                        $ref_rank_icon_path = config('app.url') . '/' . $ref_rank_icon_path;
                    }
                }

                $ref_crypturl = MURLCrypt::getEncryptURL($matrix_id, $ref_members_id);

                $output .= '<li class="float-left list-none relative pt-14 px-2 mt-14">
                    <div class="border-solid border-neutral-300 border p-2 rounded-md inline-block">
                        <div class="!border-none py-1 px-2 inline-block" data-testid="person-container">
                            <span role="img" aria-label="Avatar for ' . htmlspecialchars($ref_members_fullname) . '" title="' . htmlspecialchars($ref_members_fullname) . '" class="bg-male inline-block relative h-10 w-10 cursor-pointer overflow-hidden rounded-full">
                                <a href="' . url('/user/network/view/' . $ref_crypturl) . '"><img src="' . $ref_memberimage . '" alt="" class="w-10 h-10 rounded-full overflow-hidden bg-white"></a>
                            </span>
                            <p class="m-0 text-black dark:text-white">' . htmlspecialchars($ref_members_fullname) . '</p>
                        </div>';

                if ($ref_rank_icon_path !== '') {
                    $output .= '<div class="rank"><img name="rankphoto" style="height: 40px;width:40px;" src="' . $ref_rank_icon_path . '" class="w-10 h-10 rounded-full overflow-hidden bg-white" title="' . htmlspecialchars($ref_rank) . '"></div>';
                }

                $output .= '</div>';
                $output .= self::getDepthCompactGenealogy($ref_members_id, $matrix_id, $firstchildroot);
                $output .= '</li>';
            }
        } else {
            $output .= self::getEmptyCompactGenealogytree($members_id, $matrix_id);
        }

        $output .= '</ul></li></ul></div></div>';

        return $output;
    }

    public static function getDepthCompactGenealogy($members_id, $matrix_id, $firstchildroot)
    {
        $secondchildroot = $firstchildroot + 1;
        $outputChild = '<ul class="pt-14 relative flex flex-row items-baseline justify-center">';

        if ($members_id > 0) {
            $prefix = config('ihook.prefix', 'ihook');

            $sql = "SELECT SQL_CALC_FOUND_ROWS
                    a.*,
                    b.members_email, b.members_firstname, b.members_lastname, b.members_image, b.members_phone, b.members_username,
                    c.members_username AS sponsorname,
                    d.rank_key, d.rank_value,
                    e.rank_value AS rank_icon_path
                FROM {$prefix}_matrix_members_link_table AS a
                LEFT JOIN {$prefix}_members_table AS b ON a.members_id = b.members_id
                LEFT JOIN {$prefix}_members_table AS c ON c.members_id = a.direct_id
                LEFT JOIN {$prefix}_ranksetting AS d ON d.rank_id = a.rankid
                LEFT JOIN {$prefix}_ranksetting AS e ON (e.rank_id = a.rankid AND e.rank_key = 'rank_icon_path' AND e.matrix_id = ?)
                WHERE (FIND_IN_SET(?, a.members_parents) OR a.members_id = ?)
                  AND a.root = ?
                GROUP BY a.link_id
                ORDER BY a.position ASC";

            $children = DB::select($sql, [$matrix_id, $members_id, $members_id, $secondchildroot]);

            if (!empty($children)) {
                foreach ($children as $child) {
                    $child = (array) $child;

                    $child_members_id       = $child['members_id'] ?? 0;
                    $child_members_image    = $child['members_image'] ?? '';
                    $child_memberimage      = $child_members_image
                        ? config('app.url') . '/' . $child_members_image
                        : asset('/img/compact_emptyavatar.png');
                    $child_members_fullname = $child['members_username'] ?? '';
                    $child_rank_value       = $child['rank_value'] ?? '';
                    $child_rank             = $child_rank_value === '' ? 'Nil' : $child_rank_value;

                    $child_rank_icon_path = '';
                    if ($child_rank !== 'Nil') {
                        $child_rank_icon_path = $child['rank_icon_path'] ?? '';
                        if (empty($child_rank_icon_path) || $child_rank_icon_path === 'uploads/avatar/rankavathar.svg') {
                            $child_rank_icon_path = asset($child_rank_icon_path);
                        } else {
                            $child_rank_icon_path = config('app.url') . '/' . $child_rank_icon_path;
                        }
                    }

                    $child_crypturl = MURLCrypt::getEncryptURL($matrix_id, $child_members_id);

                    $outputChild .= '<li class="float-left list-none relative pt-14 px-2 mt-14">
                        <div class="border-solid border-neutral-300 border p-2 rounded-md inline-block">
                            <div class="!border-none py-1 px-2 inline-block" data-testid="person-container">
                                <span role="img" aria-label="Avatar for ' . htmlspecialchars($child_members_fullname) . '" title="' . htmlspecialchars($child_members_fullname) . '" class="inline-block relative h-10 w-10 cursor-pointer overflow-hidden rounded-full">
                                    <a href="' . url('/user/network/view/' . $child_crypturl) . '"><img src="' . $child_memberimage . '" alt="" class="w-10 h-10 rounded-full overflow-hidden bg-white"></a>
                                </span>
                                <p class="m-0 text-black dark:text-white">' . htmlspecialchars($child_members_fullname) . '</p>
                            </div>';

                    if ($child_rank_icon_path !== '') {
                        $outputChild .= '<div class="rank"><img name="rankphoto" style="height: 40px;width:40px;" src="' . $child_rank_icon_path . '" class="w-10 h-10 rounded-full overflow- hidden bg-white" title="' . htmlspecialchars($child_rank) . '"></div>';
                    }

                    $outputChild .= '</div></li>';
                }
            } else {
                $outputChild .= self::getEmptyCompactGenealogytree($members_id, $matrix_id);
            }
        }

        $outputChild .= '</ul>';
        return $outputChild;
    }

    public static function getEmptyCompactGenealogytree($members_id, $matrix_id)
    {
        $emptyImagePath = asset('/img/compact_emptyavatar.png');

        return '<li class="float-left list-none relative pt-14 px-2 mt-14">
                    <div class="border-solid border-neutral-300 border p-2 rounded-md inline-block">
                        <div class="!border-none py-1 px-2 inline-block" data-testid="person-container">
                            <span role="img" aria-label="Empty slot" title="Empty slot" class="bg-female inline-block relative h-10 w-10 cursor-pointer overflow-hidden rounded-full">
                                <img src="' . $emptyImagePath . '" alt="" class="w-10 h-10 rounded-full overflow-hidden bg-white">
                            </span>
                            <p class="m-0 text-black dark:text-white">empty</p>
                        </div>
                    </div>
                </li>';
    }
}
