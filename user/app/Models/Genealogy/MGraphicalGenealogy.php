<?php

/**
 * This class contains public functions related to MGraphicalGenealogy
 *
 * @package         MGraphicalGenealogy
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

use Illuminate\Support\Facades\DB;
use Admin\App\Models\Middleware\MMemberDetails;
use Admin\App\Models\Genealogy\MMembersCount;

class MGraphicalGenealogy
{
    public static function updateGenealogyDetails($members_id, $matrix_id)
    {
        $prefix = config('services.ihook.prefix', 'ihook');

        // Check if member exists in this matrix
        $exists = DB::table("{$prefix}_matrix_members_link_table")
            ->where('matrix_id', $matrix_id)
            ->where('members_id', $members_id)
            ->exists();

        if (!$exists) {
            return 'var data = [];';
        }

        // Get default sponsor from matrix config
        $default_sponsor = DB::table("{$prefix}_matrix_configuration_table")
            ->where('matrix_key', 'default_sponsor')
            ->where('matrix_id', $matrix_id)
            ->value('matrix_value') ?? 0;

        $cdnUrl = env('CDNCLOUDEXTURL', '');

        // Fetch all required data with proper GROUP BY to avoid only_full_group_by error
        $referrals = DB::table("{$prefix}_matrix_members_link_table AS a")
            ->select([
                'a.link_id',
                'a.members_id',
                'a.spillover_id',
                'a.direct_id',
                'a.rankid',
                'a.members_passup_id',
                'a.matrix_id',
                'b.members_email',
                'b.members_firstname',
                'b.members_lastname',
                'b.members_image',
                'b.members_phone',
                'b.members_username',
                'c.members_username AS sponsorname',
                'd.rank_value',                    // Rank name (e.g., "Diamond")
                'e.rank_value AS rank_icon_path'   // Icon path from ranksetting
            ])
            ->leftJoin("{$prefix}_members_table AS b", 'a.members_id', '=', 'b.members_id')
            ->leftJoin("{$prefix}_members_table AS c", 'c.members_id', '=', 'a.direct_id')
            ->leftJoin("{$prefix}_ranksetting AS d", function ($join) {
                $join->on('d.rank_id', '=', 'a.rankid')
                     ->where('d.rank_key', '=', 'rank_name'); // Change if your rank display key is different
            })
            ->leftJoin("{$prefix}_ranksetting AS e", function ($join) use ($matrix_id) {
                $join->on('e.rank_id', '=', 'a.rankid')
                     ->where('e.rank_key', '=', 'rank_icon_path')
                     ->where('e.matrix_id', '=', $matrix_id);
            })
            ->where(function ($query) use ($members_id) {
                $query->whereRaw("FIND_IN_SET(?, a.members_parents)", [$members_id])
                      ->orWhere('a.members_id', $members_id);
            })
            ->where('a.matrix_id', $matrix_id)
            ->groupBy([
                'a.link_id', 'a.members_id', 'a.spillover_id', 'a.direct_id', 'a.rankid',
                'a.members_passup_id', 'a.matrix_id',
                'b.members_email', 'b.members_firstname', 'b.members_lastname',
                'b.members_image', 'b.members_phone', 'b.members_username',
                'c.members_username', 'd.rank_value', 'e.rank_value'
            ])
            ->orderBy('a.spillover_id', 'ASC')
            ->get();

        $nodes = [];

        foreach ($referrals as $i => $row) {
            $spillover_id = $row->spillover_id ?? 0;

            // Force root node to have pid = 0 if not placed under default sponsor
            if ($default_sponsor != $members_id && $i === 0) {
                $spillover_id = 0;
            }

            $memberImage = !empty($row->members_image)
                ? $cdnUrl . '/' . $row->members_image
                : $cdnUrl . '/uploads/members/avatar.png';

            $fullName     = $row->members_username ?? 'Nil';
            $title        = trim($row->members_firstname . ' ' . $row->members_lastname);
            $title        = $title !== '' ? $title : 'Nil';
            $sponsorName  = $row->sponsorname ?? 'Nil';
            $rank         = $row->rank_value ?? 'Nil';

            // Passup details
            $passupDetails = '';
            if ($row->members_passup_id > 0) {
                $passup = MMemberDetails::getPartMembersDetails('members_username', $row->members_passup_id);
                $passupName = $passup['members_username'] ?? '';
                if ($passupName) {
                    $passupDetails = ', Passup : ' . $passupName;
                }
            }

            $description = __('Sponsor') . ' : ' . $sponsorName . $passupDetails;

            // Rank icon
            $rankIconPath = '';
            if ($row->rank_icon_path && $row->rankid > 0) {
                $rankIconPath = $cdnUrl . '/' . $row->rank_icon_path;
            }
            $rankImageField = $rankIconPath ? "'" . addslashes($rankIconPath) . "'" : '"0"';

            // Downline count
            $downlineCount = MMembersCount::getDownlineMemberscount($row->members_id, $row->matrix_id);
// dd($downlineCount);
            // Build node safely
            $nodes[] = "{
                id: '{$row->members_id}',
                name: '" . addslashes($fullName) . "',
                pid: " . (int)$spillover_id . ",
                title: '" . addslashes($title) . "',
                description: '" . addslashes($description) . "',
                phone: '" . addslashes($row->members_phone ?? '') . "',
                email: '" . addslashes($row->members_email ?? '') . "',
                rank: '" . addslashes(__('Rank') . ' : ' . $rank) . "',
                img: '" . addslashes($memberImage) . "',
                rankimage: {$rankImageField},
                members_id: '{$row->members_id}',
                matrix_id: {$row->matrix_id},
                downlinecount: '{$downlineCount}'
            }";
        }

        // Final safe JavaScript output
        $jsData = $nodes ? implode(",\n", $nodes) : '';

        return "var data = [{$jsData}];";
    }
}
