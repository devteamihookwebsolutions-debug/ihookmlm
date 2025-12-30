<?php

namespace User\App\Models\Genealogy;

use Admin\App\Models\Genealogy\MBinaryLinkDetails;
use Admin\App\Models\Middleware\MBinaryMembersPosition;
use Admin\App\Models\Middleware\MURLCrypt;
use DB;

class MBinaryCompactGenealogy
{
    public static function getCompactGenealogytree($token = null, $member_id = null, $matrix_id = null)
    {
        // Step 1: Determine members_id (priority order)
        $auth_user_id = auth()->user()->members_id;

        // If direct member_id given in URL (like /1/1), use it
        if ($member_id && is_numeric($member_id)) {
            $members_id = (int)$member_id;
        }
        // Else decode from token
        elseif ($token) {
            $decoded = MURLCrypt::decode($token);
            if ($decoded && isset($decoded[0])) {
                $members_id = $decoded[0];
                $matrix_id  = $decoded[1] ?? $matrix_id;
            } else {
                $members_id = $auth_user_id;
            }
        } else {
            $members_id = $auth_user_id;
        }

        // Step 2: Determine matrix_id
        if (!$matrix_id || !is_numeric($matrix_id)) {
            $first = DB::table('ihook_matrix_members_link_table')
                ->where('members_id', $members_id)
                ->orderBy('link_id')
                ->value('matrix_id');
            $matrix_id = $first ?? 1;
        } else {
            $matrix_id = (int)$matrix_id;
        }

        // Step 3: Get Root Member (the one we are viewing)
        $root = MBinaryLinkDetails::getBinaryLinkDetails($members_id, $matrix_id);
        if (!$root) {
            return '<div class="text-white text-center py-20">Member not found.</div>';
        }

        $username   = $root['membername'] ?? 'Unknown';
        $image      = $root['members_image'] ?? '';
        $rank_icon  = $root['rank_value'] ?? '';
        $rank_title = $root['ranktitle'] ?? '';

        // Generate new URL: /view/token/member_id/matrix_id
        $newToken = MURLCrypt::encode($matrix_id, $members_id);
        $clickUrl = url('/user/network/view/' . $newToken . '/' . $members_id . '/' . $matrix_id);

        $avatar  = $image ? asset(ltrim($image, '/')) : asset('/assets/img/avatar/avatar.png');
        $rankImg = $rank_icon ? asset(ltrim($rank_icon, '/')) : '';

        $leftId  = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, 1);
        $rightId = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, 2);

        $output = '
        <section class="bg-gray-800 flex justify-center flex-col py-12 relative min-h-screen">
            <div class="relative w-full flex items-center justify-center">
                <div class="flex flex-col m-auto">

                    <!-- Root Node -->
                    <div class="mb-12 relative flex justify-center text-center
                        before:content-[\'\'] before:absolute before:top-[115%] before:left-14 before:right-14
                        before:h-[2px] before:bg-white/70">

                        <div class="relative text-center
                            after:content-[\'\'] after:absolute after:w-[2px] after:h-[25px]
                            after:bottom-0 after:left-1/2 after:bg-white/70 after:translate-y-full">

                            <a href="' . $clickUrl . '">
                                <img src="' . $avatar . '" alt="' . htmlspecialchars($username) . '"
                                     class="w-28 h-28 border-4 border-indigo-600 rounded-full overflow-hidden object-cover bg-white mx-auto">
                            </a>

                            <p class="bg-white py-1 px-3 rounded text-teal-800 font-medium m-0 mt-2">
                                ' . htmlspecialchars($username) . '
                            </p>';

        if ($rankImg) {
            $output .= '<img src="' . $rankImg . '" class="w-12 h-12 mx-auto -mt-6 rounded-full border-4 border-gray-800" title="' . htmlspecialchars($rank_title) . '">';
        }

        $output .= '
                        </div>
                    </div>

                    <div class="relative w-full flex items-center justify-center gap-32">
                        ' . self::renderLeg($leftId, $matrix_id) . '
                        ' . self::renderLeg($rightId, $matrix_id) . '
                    </div>
                </div>
            </div>
        </section>';

        return $output;
    }

    private static function renderLeg($child_id, $matrix_id)
    {
        if (!$child_id) return self::emptyLeg();

        $d = MBinaryLinkDetails::getBinaryLinkDetails($child_id, $matrix_id);
        $name = $d['membername'] ?? 'Unknown';
        $img  = $d['members_image'] ?? '';
        $rank = $d['rank_value'] ?? '';
        $rank_title = $d['ranktitle'] ?? '';

        // Correct clickable URL with member_id & matrix_id
        $token = MURLCrypt::encode($matrix_id, $child_id);
        $url   = url('/user/network/view/' . $token . '/' . $child_id . '/' . $matrix_id);

        $avatar  = $img ? asset(ltrim($img, '/')) : asset('/assets/img/avatar/avatar.png');
        $rankImg = $rank ? asset(ltrim($rank, '/')) : '';

        $html = '
        <div class="flex flex-col items-center">
            <div class="relative mb-12">
                <div class="absolute -top-12 left-1/2 w-0.5 h-12 bg-white/70 -translate-x-1/2"></div>
                <div class="relative text-center">
                    <a href="' . $url . '">
                        <img src="' . $avatar . '" alt="' . htmlspecialchars($name) . '"
                             class="w-24 h-24 border-4 border-indigo-500 rounded-full object-cover bg-white mx-auto">
                    </a>
                    <p class="bg-white py-1 px-3 rounded text-teal-800 font-medium mt-2">
                        ' . htmlspecialchars($name) . '
                    </p>';

        if ($rankImg) {
            $html .= '<img src="' . $rankImg . '" class="w-10 h-10 mx-auto -mt-6 rounded-full border-4 border-gray-800" title="' . htmlspecialchars($rank_title) . '">';
        }

        $html .= '</div></div>';

        $leftGrand  = MBinaryMembersPosition::getBinaryMembersPosition($child_id, $matrix_id, 1);
        $rightGrand = MBinaryMembersPosition::getBinaryMembersPosition($child_id, $matrix_id, 2);

        $html .= '<div class="flex gap-20">';
        $html .= $leftGrand  ? self::renderGrandChild($leftGrand, $matrix_id) : self::emptyGrandChild();
        $html .= $rightGrand ? self::renderGrandChild($rightGrand, $matrix_id) : self::emptyGrandChild();
        $html .= '</div></div>';

        return $html;
    }

    private static function renderGrandChild($id, $matrix_id)
    {
        $d = MBinaryLinkDetails::getBinaryLinkDetails($id, $matrix_id);
        $name = $d['membername'] ?? 'Unknown';
        $img  = $d['members_image'] ?? '';
        $token = MURLCrypt::encode($matrix_id, $id);
        $url   = url('/user/network/view/' . $token . '/' . $id . '/' . $matrix_id);
        $avatar = $img ? asset(ltrim($img, '/')) : asset('/assets/img/avatar/avatar.png');

        return '
        <div class="relative text-center">
            <div class="absolute -top-12 left-1/2 w-0.5 h-12 bg-white/70 -translate-x-1/2"></div>
            <a href="' . $url . '">
                <img src="' . $avatar . '" class="w-16 h-16 rounded-full border-4 border-purple-500 object-cover bg-white">
            </a>
            <p class="bg-white text-teal-800 text-xs font-medium py-1 px-2 rounded mt-1">
                ' . htmlspecialchars($name) . '
            </p>
        </div>';
    }

    private static function emptyLeg()
    {
        return '
        <div class="flex flex-col items-center">
            <div class="relative mb-12">
                <div class="absolute -top-12 left-1/2 w-0.5 h-12 bg-white/70 -translate-x-1/2"></div>
                <img src="' . asset('/img/compact_emptyavatar.png') . '" class="w-24 h-24 rounded-full border-4 border-dashed border-gray-500 opacity-50">
                <p class="bg-gray-700 text-gray-400 py-1 px-3 rounded mt-2 text-sm">empty</p>
            </div>
            <div class="flex gap-20">
                ' . self::emptyGrandChild() . self::emptyGrandChild() . '
            </div>
        </div>';
    }

    private static function emptyGrandChild()
    {
        return '
        <div class="relative text-center">
            <div class="absolute -top-12 left-1/2 w-0.5 h-12 bg-white/70 -translate-x-1/2"></div>
            <img src="' . asset('/img/compact_emptyavatar.png') . '" class="w-16 h-16 rounded-full border-4 border-dashed border-gray-600 opacity-40">
            <p class="text-gray-500 text-xs mt-1">empty</p>
        </div>';
    }
}
