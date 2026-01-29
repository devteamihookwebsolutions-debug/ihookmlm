<?php

/**
 * This class contains public functions related to MGraphicalRankGenealogy
 *
 * @package         MGraphicalRankGenealogy
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
namespace Admin\App\Models\Genealogy;

use Admin\App\Models\Middleware\MMemberDetails;
use Illuminate\Support\Facades\DB;

class MGraphicalRankGenealogy
{
    public static function updateGenealogyDetails($members_id, $matrix_id)
    {
        $rank_color_css = '';
         $prefix = config('services.ihook.prefix');

        $recordDefault = DB::table($prefix.'_matrix_members_link_table')
            ->where('matrix_id', $matrix_id)
            ->where('members_id', $members_id)
            ->first();

        if (!$recordDefault) {
            return [[], '']; // Return empty if member not found
        }

        $recordsdefault = (array) $recordDefault;
        $default_members_id = $recordsdefault['members_id'];

        $referralslinkdetails = DB::table($prefix.'_matrix_members_link_table as a')
            ->leftJoin($prefix.'_members_table as b', 'a.members_id', '=', 'b.members_id')
            ->leftJoin($prefix.'_members_table as c', 'c.members_id', '=', 'a.direct_id')
            ->leftJoin($prefix.'_ranksetting as d', 'd.rank_id', '=', 'a.rankid')
            ->leftJoin($prefix.'_ranksetting as e', function($join) use ($matrix_id){
                $join->on('e.rank_id', '=', 'a.rankid')
                     ->where('e.rank_key', '=', 'rank_icon_path')
                     ->where('e.matrix_id', '=', $matrix_id);
            })
            ->leftJoin($prefix.'_ranksetting as f', function($join) use ($matrix_id){
                $join->on('f.rank_id', '=', 'a.rankid')
                     ->where('f.rank_key', '=', 'rank_color')
                     ->where('f.matrix_id', '=', $matrix_id);
            })
            ->select(
                'a.*',
                'b.members_email',
                'b.members_firstname',
                'b.members_lastname',
                'b.members_image',
                'b.rankgenealogy_name',
                'b.members_phone',
                'b.members_username',
                'c.members_username as sponsorname',
                'd.rank_key',
                'd.rank_value',
                'e.rank_value as rank_icon_path',
                'f.rank_value as rankcolor'
            )
            ->where(function($query) use ($members_id){
                $query->whereRaw("FIND_IN_SET(?, members_parents)", [$members_id])
                      ->orWhere('a.members_id', $members_id);
            })
            ->where('a.matrix_id', $matrix_id)
            ->orderBy('a.position', 'ASC')
            ->limit(1000)
            ->get();

        // Convert collection to array
        $referralslinkdetails = $referralslinkdetails->toArray();
        $totalusers = count($referralslinkdetails);

        $defaultSponsor = DB::table($prefix.'_matrix_configuration_table')
            ->where('matrix_key', 'default_sponsor')
            ->where('matrix_id', $matrix_id)
            ->value('matrix_value');

        $output = [];

        foreach ($referralslinkdetails as $i => $row) {

            if ($totalusers > 2000 && $i >= 43) continue; // replicate original logic for 2000+

            $spillover_id = $row->spillover_id;
            if ($defaultSponsor != $members_id && $i == 0) {
                $spillover_id = 0;
            }

            $members_passup_id = $row->members_passup_id;
            $passupdetails = '';
            if ($members_passup_id > 0) {
                $member_details = MMemberDetails::getPartMembersDetails('members_username', $members_passup_id);
                $passupmembername = $member_details['members_username'] ?? '';
                $passupdetails = ', Passup : ' . $passupmembername;
            }

            $members_firstname = $row->members_firstname ?? '';
            $members_lastname  = $row->members_lastname ?? '';
            $title = trim($members_firstname . ' ' . $members_lastname) ?: 'Nil';

            $members_fullname = $row->members_username ?? '';
            $members_email    = $row->members_email ?? '';
            $members_phone    = $row->members_phone ?? '';
            $rank             = $row->rank_value ?: 'Nil';
            $sponsor_name     = $row->sponsorname ?: 'Nil';
            $memberimage      = $row->members_image ?: 'uploads/members/avatar.png';
            $memberimage      = $_ENV['CDNCLOUDEXTURL'].'/'.$memberimage;

            $rank_icon_path = $row->rank_icon_path ? $_ENV['CDNCLOUDEXTURL'].'/'.$row->rank_icon_path : '0';
            $rank_color     = $row->rankcolor ?? '#4169e1';
            $rankgenealogy_name = $row->rankgenealogy_name ?? '';

            // Optional: Downline count (replicate original logic)
            $downlinecount = MMembersCount::getDownlineMemberscount($row->members_id, $row->matrix_id);

            $output[] = [
                'id' => (string) $row->members_id,
                'pid' => (string) $spillover_id,
                'name' => $members_fullname,
                'title' => $title,
                'description' => 'Sponsor : ' . $sponsor_name . $passupdetails,
                'phone' => $members_phone,
                'email' => $members_email,
                'rank' => 'Rank : ' . $rank,
                'img' => $memberimage,
                'rankimage' => $rank_icon_path,
                'members_id' => $row->members_id,
                'matrix_id' => $row->matrix_id,
                'rankgenealogy_name' => $rankgenealogy_name,
                'downlinecount' => $downlinecount
            ];

            // Build rank color CSS
            if ($rankgenealogy_name) {
                $rank_color_css .= ".node.$rankgenealogy_name rect { fill: $rank_color; }" . PHP_EOL;
            }
        }

        return [$output, $rank_color_css];
    }
}
