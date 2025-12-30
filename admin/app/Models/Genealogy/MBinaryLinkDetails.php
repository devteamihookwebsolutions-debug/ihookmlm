<?php
namespace Admin\App\Models\Genealogy;
use Admin\App\Models\Middleware\MURLCrypt;
use Admin\App\Models\Member\Matrix;
use Admin\App\Models\Member\MatrixConfiguration;
use Admin\App\Models\Member\MemberLinks;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\RankSetting;


use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;


class MBinaryLinkDetails
{

      public static function getBinaryLinkDetails($members_id, $matrix_id)
    {
        // 1. Fetch the matrix member link record
        $link = MemberLinks::where('members_id', $members_id)
            ->where('matrix_id', $matrix_id)
            ->first();


        if (!$link) {
            return null; // same as returning nothing in original code if not found
        }

        // 2. Fetch related member and sponsor details
        $member = Member::find($link->members_id);
        $sponsor = Member::find($link->direct_id);

        // 3. Fetch rank details
        $rankIcon = RankSetting::where('rank_id', $link->rankid)
            ->where('rank_key', 'rank_icon_path')
            ->where('matrix_id', $matrix_id)
            ->first();

        $rankTitle = RankSetting::where('rank_id', $link->rankid)
            ->where('rank_key', 'rank_title')
            ->where('matrix_id', $matrix_id)
            ->first();

        $rankColor = RankSetting::where('rank_id', $link->rankid)
            ->where('rank_key', 'rank_color')
            ->where('matrix_id', $matrix_id)
            ->first();

        // 4. Combine all details into a single object (like original array record)
       $binaryParentDetails = [
            'root' => $link->root,
            'spillover_id' => $link->spillover_id,
            'direct_id' => $link->direct_id,
            'matrix_doj' => $link->matrix_doj,
            'rankid' => $link->rankid,
            'members_email' => $member->members_email ?? null,
            'members_image' => $member->members_image ?? null,
            'rankgenealogy_name' => $member->rankgenealogy_name ?? null,
            'members_phone' => $member->members_phone ?? null,
            'membername' => $member->members_username ?? null,
            'sponsor_username' => $sponsor->members_username ?? null,
            'rank_icon_path' => $rankIcon->rank_value ?? null,
            'ranktitle' => $rankTitle->rank_value ?? null,
            'rankcolor' => $rankColor->rank_value ?? null,
            'members_id' => $members_id,
        ];

        // 5. Return the object (same flow as original)
        // dd($binaryParentDetails);
        return $binaryParentDetails;
    }

}