<?php

namespace Admin\App\Models\Middleware;

use Illuminate\Support\Facades\DB;

class MBinaryMembersPosition
{
    public static function getBinaryMembersPosition($members_id, $matrix_id, $position)
    {
        $child = DB::table('ihook_matrix_members_link_table')
            ->where('matrix_id', $matrix_id)
            ->where('position', $position)
            ->whereRaw("FIND_IN_SET(?, members_parents)", [$members_id])
            ->orderByRaw("LENGTH(members_parents) ASC")
            ->value('members_id');

        if ($child) {
            return $child;
        }

        return DB::table('ihook_matrix_members_link_table')
            ->where('matrix_id', $matrix_id)
            ->where('spillover_id', $members_id)
            ->where('position', $position)
            ->value('members_id');
    }
}
