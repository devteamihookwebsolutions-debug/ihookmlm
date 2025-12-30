<?php
/**
 * This class contains functions related to graphical genealogy
 *
 * @package         MGraphicalGenealogy
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright      Copyright (c) 2020 - 2023, Sunsofty.
 * @version        Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php
namespace Admin\App\Models\Genealogy;

use Admin\App\Models\Middleware\MMembersDetails;
use DB;

class MGraphicalGenealogy
{

    public static function updateGenealogyDetails($members_id, $matrix_id)
    {
        $prefix = config('ihook.prefix', 'ihook');

        // Keep original IDs
        $memberId = $members_id;
        $matrixId = $matrix_id;

        // Fetch Member (optional, do NOT overwrite IDs)
        $member   = DB::table("{$prefix}_members_table")
                    ->where('members_id', $memberId)
                    ->first();

        // Fetch Matrix (optional)
        $matrix   = DB::table("{$prefix}_matrix_table")
                    ->where('matrix_id', $matrixId)
                    ->first();

            $sql = "
                SELECT
                    a.*,
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
                LEFT JOIN {$prefix}_members_table AS b
                    ON a.members_id=b.members_id
                LEFT JOIN {$prefix}_members_table AS c
                    ON c.members_id=a.direct_id
                LEFT JOIN {$prefix}_ranksetting AS d
                    ON d.rank_id=a.rankid
                LEFT JOIN {$prefix}_ranksetting AS e
                    ON e.rank_id=a.rankid
                    AND e.rank_key='rank_icon_path'
                    AND e.matrix_id=?
                WHERE
                    (FIND_IN_SET(?, a.members_parents) OR a.members_id = ?)
                    AND a.matrix_id = ?
                ORDER BY a.spillover_id ASC
            ";


        $referralslinkdetails = DB::select($sql, [$matrixId, $memberId, $memberId, $matrixId]);

        // --- Fetch default sponsor ---
        $dfsponsors = DB::select(
            "SELECT * FROM {$prefix}_matrix_configuration_table
            WHERE matrix_key='default_sponsor' AND matrix_id=?",
            [$matrixId]
        );

        $default_sponsor = $dfsponsors[0]->matrix_value ?? null;

        $totalusers = count($referralslinkdetails);
        $output = '';

        if ($totalusers > 0) {

            foreach ($referralslinkdetails as $i => $row) {

                // Access data from stdClass correctly
                $spillover_id  = $row->spillover_id;
                $members_email = $row->members_email;
                $members_firstname = $row->members_firstname;
                $members_lastname  = $row->members_lastname;
                $memberimage       = $row->members_image ?: 'uploads/members/avatar.png';
                $memberimage       = $_ENV['CDNCLOUDEXTURL'].'/'.$memberimage;

                $members_fullname = $row->members_username;
                $members_phone    = $row->members_phone;
                $sponsor_name     = $row->sponsorname ?: 'Nil';

                $rank_value  = $row->rank_value ?: 'Nil';
                $rank_icon   = $row->rank_icon_path
                                ? $_ENV['CDNCLOUDEXTURL'].'/'.$row->rank_icon_path
                                : '0';

                // Adjust spillover ID for top node
                if ($default_sponsor != $memberId && $i == 0) {
                    $spillover_id = 0;
                }

                $title = trim($members_firstname.' '.$members_lastname) ?: 'Nil';

                $downlinecount = MMembersCount::getDownlineMemberscount($row->members_id, $row->matrix_id);

                // Build JSON node
                $output .= '{'
                    . 'id:"'.$row->members_id.'",'
                    . 'name:"'.$members_fullname.'",'
                    . 'pid:'.$spillover_id.','
                    . 'title:"'.$title.'",'
                    . 'description:"Sponsor: '.$sponsor_name.'",'
                    . 'phone:"'.$members_phone.'",'
                    . 'email:"'.$members_email.'",'
                    . 'rank:"Rank: '.$rank_value.'",'
                    . 'img:"'.$memberimage.'",'
                    . 'rankimage:"'.$rank_icon.'",'
                    . 'members_id:"'.$row->members_id.'",'
                    . 'matrix_id:"'.$row->matrix_id.'",'
                    . 'downlinecount:"'.$downlinecount.'"'
                . '},';
            }
        }

        return 'var data=[' . rtrim($output, ',') . ']';
    }

}

