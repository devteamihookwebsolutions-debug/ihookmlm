<?php

/**
 * This class contains public functions related to MlinearCompactGenealogy
 *
 * @package         MlinearCompactGenealogy
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

namespace User\App\Models\Genealogy;

use Admin\App\Models\Middleware\MURLCrypt;
use Illuminate\Support\Facades\DB;
use User\App\Models\Genealogy\MBinaryLinkDetails;
use User\App\Models\Genealogy\MBinaryMembersCount;

class MlinearCompactGenealogy
{
    /**
     * Get compact genealogy tree HTML (non-binary matrices like unilevel)
     *
     * @param int $members_id
     * @param int $matrix_id
     * @return string HTML output
     */
    public static function getCompactGenealogytree($members_id, $matrix_id)
    {
        $output = '';

        // Get parent/sponsor details
        $binaryparentdetails = MBinaryLinkDetails::getBinaryLinkDetails($members_id, $matrix_id);
        $direct_id           = $binaryparentdetails['direct_id'] ?? 0;
        $matrix_doj          = $binaryparentdetails['matrix_doj'] ?? '';
        $spillover_id        = $binaryparentdetails['spillover_id'] ?? 0;
        $members_username    = $binaryparentdetails['membername'] ?? '';
        $members_phone       = $binaryparentdetails['members_phone'] ?? '';
        $members_email       = $binaryparentdetails['members_email'] ?? '';
        $members_image       = $binaryparentdetails['members_image'] ?? '';
        $parentroot          = $binaryparentdetails['root'] ?? 0;
        $ranktitle           = $binaryparentdetails['ranktitle'] ?? '';
        $sponsor_username    = $binaryparentdetails['sponsor_username'] ?? '';
        $sponsor_username    = $direct_id > 0 ? $sponsor_username : 'Nil';
        $rankid              = $binaryparentdetails['rankid'] ?? 0;

        $targetroot = $parentroot + 3;
        $memberimage = $members_image
            ? config('services.cdn.url') . '/' . $members_image
            : asset('assets/img/compact_emptyavatar.png');

        $rank_icon_path = '';
        if ($rankid > 0) {
            $rank_icon_path = $binaryparentdetails['rank_value'] ?? '';
            if (empty($rank_icon_path) || $rank_icon_path === 'uploads/avatar/rankavathar.svg') {
                $rank_icon_path = asset($rank_icon_path);
            } else {
                $rank_icon_path = config('services.cdn.url') . '/' . $rank_icon_path;
            }
        }

        // Member counts (left/right - though not used in compact, kept for consistency)
        $count = MBinaryMembersCount::getBinaryMemberscount($members_id, $matrix_id);
        $leftcount = $count['left'] ?? 0;
        $rightcount = $count['right'] ?? 0;

        $rank = $ranktitle ?: 'Nil';
        $crypturl = MURLCrypt::getEncryptURL($matrix_id, $members_id);

        // Start building HTML tree
        $output .= '
        <div class="bg-white dark:bg-neutral-900 flex min-h-screen flex-col items-center justify-start p-2 py-10 text-center overflow-auto">
            <div class="tree whitespace-nowrap overflow-auto relative mx-auto" data-testid="family-tree-root">
                <ul class="relative flex flex-row items-baseline justify-center">';

        // Root member (top level)
        $output .= '<li class="float-left list-none relative pt-14 px-2 mt-14">
                        <div class="border-solid border-neutral-300 border p-2 rounded-md inline-block">
                            <div class="!border-none py-1 px-2 inline-block" data-testid="person-container">
                                <span role="img" aria-label="Avatar for ' . $members_username . '" class="bg-female inline-block relative h-10 w-10 cursor-pointer overflow-hidden rounded-full">
                                    <a href="' . url('/network/view/' . $crypturl) . '">
                                        <img src="' . $memberimage . '" alt="" class="w-10 h-10 rounded-full overflow-hidden bg-white">
                                    </a>
                                </span>
                                <p class="m-0 text-black dark:text-white">' . $members_username . '</p>
                            </div>';

        if ($rank_icon_path) {
            $output .= '<div class="rank"><img name="rankphoto" class="block mx-auto w-8 h-8" src="' . $rank_icon_path . '" title="' . $rank . '"></div>';
        }

        $output .= '</div>
                    <ul class="pt-14 relative flex flex-row items-baseline justify-center">';

        $firstchildroot = $parentroot + 1;

        // Get first level downlines
        $referralslinkdetails = self::getMembersAtRootLevel($members_id, $matrix_id, $firstchildroot);

        if (count($referralslinkdetails) > 0) {
            foreach ($referralslinkdetails as $referral) {
                $output .= self::renderMemberNode($referral, $matrix_id, $firstchildroot);
            }
        } else {
            $output .= self::getEmptyCompactGenealogytree($members_id, $matrix_id);
        }

        $output .= '    </ul>
                    </li>
                </ul>
            </div>
        </div>';

        return $output;
    }

    /**
     * Recursive function to get deeper levels
     */
    public static function getDepthCompactGenealogy($members_id, $matrix_id, $currentroot)
    {
        $nextroot = $currentroot + 1;
        $outputChild = '<ul class="pt-14 relative flex flex-row items-baseline justify-center">';

        $children = self::getMembersAtRootLevel($members_id, $matrix_id, $nextroot);

        if (count($children) > 0) {
            foreach ($children as $child) {
                $outputChild .= self::renderMemberNode($child, $matrix_id, $nextroot, false); // no further recursion beyond depth 2 in original
            }
        } else {
            $outputChild .= self::getEmptyCompactGenealogytree($members_id, $matrix_id);
        }

        $outputChild .= '</ul>';

        return $outputChild;
    }

    /**
     * Render single member node (shared logic)
     */
    private static function renderMemberNode($member, $matrix_id, $currentroot, $withRecursion = true)
    {
        // Use object syntax -> instead of array ['key']
        $members_id       = $member->members_id;
        $members_image    = $member->members_image ?? '';
        $members_username = $member->members_username ?? 'Unknown';
        $rank_icon_path   = $member->rank_icon_path ?? '';
        $rank_value       = $member->rank_value ?? 'Nil';

        $memberimage = $members_image
            ? config('services.cdn.url') . '/' . $members_image
            : asset('assets/img/compact_emptyavatar.png');

        // Handle rank icon path correctly
        if (!empty($rank_icon_path)) {
            if ($rank_icon_path === 'uploads/avatar/rankavathar.svg') {
                $rank_icon_path = asset($rank_icon_path);
            } else {
                $rank_icon_path = config('services.cdn.url') . '/' . $rank_icon_path;
            }
        }

        $crypturl = MURLCrypt::getEncryptURL($matrix_id, $members_id);

        $output = '<li class="float-left list-none relative pt-14 px-2 mt-14">
                    <div class="border-solid border-neutral-300 border p-2 rounded-md inline-block">
                        <div class="!border-none py-1 px-2 inline-block" data-testid="person-container">
                            <span role="img" aria-label="Avatar for ' . $members_username . '" class="inline-block relative h-10 w-10 cursor-pointer overflow-hidden rounded-full">
                                <a href="' . url('/network/view/' . $crypturl) . '">
                                    <img src="' . $memberimage . '" alt="" class="w-10 h-10 rounded-full overflow-hidden bg-white">
                                </a>
                            </span>
                            <p class="m-0 text-black dark:text-white">' . $members_username . '</p>
                        </div>';

        if ($rank_icon_path) {
            $output .= '<div class="rank">
                            <img name="rankphoto" style="height: 40px;width:40px;" src="' . $rank_icon_path . '" title="' . $rank_value . '">
                        </div>';
        }

        $output .= '</div>';

        if ($withRecursion) {
            $output .= self::getDepthCompactGenealogy($members_id, $matrix_id, $currentroot);
        }

        $output .= '</li>';

        return $output;
    }
    /**
     * Get members at specific root level (replaces raw SQL)
     */
    private static function getMembersAtRootLevel($parent_members_id, $matrix_id, $root_level)
    {
        $prefix = config('services.ihook.prefix', 'ihook');

        return DB::select("
            SELECT
                a.members_id,
                a.direct_id,
                a.rankid,
                a.position,
                a.members_parents,
                a.root,
                a.members_passup_id,
                a.members_passup_direct_id,
                b.members_email,
                b.members_firstname,
                b.members_lastname,
                b.members_image,
                b.members_phone,
                b.members_username,
                c.members_username AS sponsorname,
                d.rank_key,
                d.rank_value,
                e.rank_value AS rank_icon_path
            FROM {$prefix}_matrix_members_link_table AS a
            LEFT JOIN {$prefix}_members_table AS b ON a.members_id = b.members_id
            LEFT JOIN {$prefix}_members_table AS c ON c.members_id = a.direct_id
            LEFT JOIN {$prefix}_ranksetting AS d ON d.rank_id = a.rankid
            LEFT JOIN {$prefix}_ranksetting AS e ON (
                e.rank_id = a.rankid
                AND e.rank_key = 'rank_icon_path'
                AND e.matrix_id = ?
            )
            WHERE (FIND_IN_SET(?, a.members_parents) OR a.members_id = ?)
            AND a.root = ?
            GROUP BY
                a.members_id,
                a.direct_id,
                a.rankid,
                a.position,
                a.members_parents,
                a.root,
                a.members_passup_id,
                a.members_passup_direct_id,
                b.members_email,
                b.members_firstname,
                b.members_lastname,
                b.members_image,
                b.members_phone,
                b.members_username,
                c.members_username,
                d.rank_key,
                d.rank_value,
                e.rank_value
            ORDER BY a.position ASC
        ", [$matrix_id, $parent_members_id, $parent_members_id, $root_level]);
    }

    /**
     * Empty slot placeholder
     */
    public static function getEmptyCompactGenealogytree($members_id, $matrix_id)
    {
        $emptyImage = asset('assets/img/compact_emptyavatar.png');

        return '<li class="float-left list-none relative pt-14 px-2 mt-14">
                    <div class="border-solid border-neutral-300 border p-2 rounded-md inline-block">
                        <div class="!border-none py-1 px-2 inline-block" data-testid="person-container">
                            <span role="img" aria-label="Empty slot" class="bg-female inline-block relative h-10 w-10 cursor-pointer overflow-hidden rounded-full">
                                <img src="' . $emptyImage . '" alt="" class="w-10 h-10 rounded-full overflow-hidden bg-white">
                            </span>
                            <p class="m-0 text-black dark:text-white">empty</p>
                        </div>
                    </div>
                </li>';
    }
}
