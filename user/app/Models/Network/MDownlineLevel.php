<?php

namespace App\Models\Network;

use Illuminate\Support\Facades\DB;
use Admin\App\Models\Middleware\MMatrixMemberLink;
use Display\Network\DDownlineLevel;

class MDownlineLevel
{
    public static function getLevelUsers($id)
    {
        $level = request()->query('sub2');
        $matrix_id=request()->query('sub1');
        if ($level > 0 || $level == '') {
            $where_root  = 'members_id = "' . $id . '" AND matrix_id="'.$matrix_id.'"';
            $member_link = MMatrixMemberLink::getPartMatrixLinkDetails('root', $where_root);
            $root        = $member_link[0]['root'] + $level;
            $wheres = 'AND a.root="' . $root . '" AND a.direct_id="' . $id . '"';

            if (request('search.value') != '') {
                $wheres .= " AND e.members_username='" . trim(request('search.value')) . "'";
            }

           $sql    = "SELECT a.direct_id,a.matrix_id,e.members_username,e.members_doj,e.members_id,f.members_username as sponsor
         FROM  " . env('IHOOK_PREFIX') . "matrix_members_link_table AS a
        LEFT JOIN    " . env('IHOOK_PREFIX') . "members_table AS  f ON f.members_id=a.direct_id
        LEFT JOIN    " . env('IHOOK_PREFIX') . "members_table AS  e ON e.members_id=a.members_id
        WHERE a.members_account_status!='-1' " . $wheres . "  LIMIT " . request('start') . "," . request('length') . "";
            $records = DB::select($sql);
             $sQuery_count = "SELECT count(*) as total
         FROM  " . env('IHOOK_PREFIX') . "matrix_members_link_table AS a
        LEFT JOIN    " . env('IHOOK_PREFIX') . "members_table AS  f ON f.members_id=a.direct_id
        LEFT JOIN    " . env('IHOOK_PREFIX') . "members_table AS  e ON e.members_id=a.members_id
        WHERE a.members_account_status!='-1' " . $wheres . "";
            $iTotal = DB::select($sQuery_count)[0]->total;
        } else {
            $records = '';
            $iTotal  = 0;
        }
        return DDownlineLevel::getLevelUsers($records, $iTotal);
    }

    public static function getLevel($id)
    {
        $matrix_id=request()->query('sub1');
        $where_root  = 'members_id = "' . $id . '" AND matrix_id="'.$matrix_id.'"';
        $member_link = MMatrixMemberLink::getPartMatrixLinkDetails('root', $where_root);

        $root        = $member_link[0]['root'];
        $sql = "SELECT members_id,root FROM  " . env('IHOOK_PREFIX') . "matrix_members_link_table
        WHERE members_account_status!='-1' AND root>0 AND direct_id='" . $id . "' GROUP BY root ";
        $records = DB::select($sql);

        return DDownlineLevel::getLevel($records, $root);
    }
}
