<?php

/**
 * This class contains public functions related to MUnilevelCompactGenealogy
 *
 * @package         MUnilevelCompactGenealogy
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

use Admin\App\Models\Genealogy\MBinaryLinkDetails;
use Admin\App\Models\Middleware\MURLCrypt;
use DB;

class MUnilevelCompactGenealogy
{
    public static function getCompactGenealogytree($token = null, $member_id = null, $matrix_id = null)
    {
        $auth_user_id = auth()->user()->members_id;

        // Determine root member
        if ($member_id && is_numeric($member_id)) {
            $members_id = (int)$member_id;
        } elseif ($token) {
            $decoded = MURLCrypt::decode($token);
            if ($decoded && isset($decoded[0])) {
                $members_id = $decoded[0];
                $matrix_id = $decoded[1] ?? $matrix_id;
            } else {
                $members_id = $auth_user_id;
            }
        } else {
            $members_id = $auth_user_id;
        }

        $prefix = config('ihook.prefix', 'ihook');

        if (!$matrix_id || !is_numeric($matrix_id)) {
            $matrix_id = DB::table("{$prefix}_matrix_members_link_table")
                ->where('members_id', $members_id)
                ->value('matrix_id') ?? 1;
        }
        $matrix_id = (int)$matrix_id;

        $root = MBinaryLinkDetails::getBinaryLinkDetails($members_id, $matrix_id);
        if (!$root) {
            return '<div class="text-white text-center py-20">Member not found.</div>';
        }

        $username = $root['membername'] ?? 'Unknown';
        $image = $root['members_image'] ?? '';
        $rank_icon = $root['rank_value'] ?? '';
        $rank_title = $root['ranktitle'] ?? '';
        $newToken = MURLCrypt::encode($matrix_id, $members_id);
        $clickUrl = url('/user/network/view/' . $newToken . '/' . $members_id . '/' . $matrix_id);
        $avatar = $image ? asset(ltrim($image, '/')) : asset('/assets/img/avatar/avatar.png');
        $rankImg = $rank_icon ? asset(ltrim($rank_icon, '/')) : '';

        $level1 = self::getDirectDownlines($members_id, $matrix_id);

        $output = '
        <section class="bg-gray-800 min-h-screen py-8 overflow-x-auto">
            <div class="flex flex-col items-center">';

        $output .= '
                <div class="text-center">
                    <a href="' . $clickUrl . '">
                        <img src="' . $avatar . '"
                             alt="' . htmlspecialchars($username) . '"
                             class="w-32 h-32 mx-auto rounded-full border-6 border-indigo-600 object-cover shadow-xl">
                    </a>
                    <p class="bg-white text-teal-800 font-bold text-lg py-2 px-8 rounded-full mt-3 shadow-lg inline-block">
                        ' . htmlspecialchars($username) . '
                    </p>';

        if ($rankImg) {
            $output .= '<img src="' . $rankImg . '"
                             class="w-12 h-12 mx-auto rounded-full border-4 border-gray-800 shadow-lg"
                             title="' . htmlspecialchars($rank_title) . '">';
        }

        $output .= '
                </div>';

        if (empty($level1)) {
            $output .= '<p class="text-white text-lg mt-10">No downlines yet.</p>';
        } else {
            // Connecting line
            $output .= '<div class="w-1 h-12 bg-white/60"></div>';
            $output .= '<div class="w-full max-w-5xl border-t-2 border-white/60"></div>';

            // Level 1 Members
            $output .= '<div class="flex justify-center gap-10 flex-wrap max-w-6xl px-4">';
            $output .= self::renderLevel1MembersOnly($level1, $matrix_id);
            $output .= '</div>';
        }

        $output .= '
            </div>
        </section>';

        return $output;
    }

    private static function getDirectDownlines($parent_id, $matrix_id)
    {
        $prefix = config('ihook.prefix', 'ihook');

        return DB::table("{$prefix}_matrix_members_link_table")
            ->where('matrix_id', $matrix_id)
            ->where('direct_id', $parent_id)
            ->where('members_id', '!=', $parent_id)
            ->orderBy('position')
            ->orderBy('link_id')
            ->pluck('members_id')
            ->toArray();
    }

    private static function renderLevel1MembersOnly($member_ids, $matrix_id)
    {
        $html = '';

        foreach ($member_ids as $mid) {
            $details = MBinaryLinkDetails::getBinaryLinkDetails($mid, $matrix_id);
            $name = $details['membername'] ?? 'Unknown';
            $img = $details['members_image'] ?? '';
            $rank_icon = $details['rank_value'] ?? '';
            $rank_title = $details['ranktitle'] ?? '';
            $token = MURLCrypt::encode($matrix_id, $mid);
            $url = url('/user/network/view/' . $token . '/' . $mid . '/' . $matrix_id);
            $avatar = $img ? asset(ltrim($img, '/')) : asset('/assets/img/avatar/avatar.png');
            $rankImg = $rank_icon ? asset(ltrim($rank_icon, '/')) : '';

            $html .= '
            <div class="flex flex-col items-center">
                <div class="w-1 h-10 bg-white/60"></div>
                <div class="text-center">
                    <a href="' . $url . '">
                        <img src="' . $avatar . '"
                             alt="' . htmlspecialchars($name) . '"
                             class="w-24 h-24 rounded-full border-6 border-indigo-500 object-cover bg-white shadow-lg">
                    </a>
                    <p class="bg-white text-teal-800 font-semibold text-base py-2 px-6 rounded-full mt-3 shadow-md">
                        ' . htmlspecialchars($name) . '
                    </p>';

            if ($rankImg) {
                $html .= '<img src="' . $rankImg . '"
                               class="w-10 h-10 mx-auto rounded-full border-4 border-gray-800 shadow-md -mt-7"
                               title="' . htmlspecialchars($rank_title) . '">';
            }

            $html .= '
                </div>
            </div>';
        }

        return $html;
    }
}
