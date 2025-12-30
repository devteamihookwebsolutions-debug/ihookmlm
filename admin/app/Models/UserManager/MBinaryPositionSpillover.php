<?php

namespace Admin\App\Models\UserManager;


use DB;
use User\App\Models\MemberLinks;

use User\Models\Middleware\MPackageDetails;


class MBinaryPositionSpillover
{

public static function getSpilloverFromPosition($matrix_id, $position, $position_direct_id)
{
    $spillover_id = $position_direct_id;


    $leftSpill = MemberLinks::where('matrix_id', $matrix_id)
        ->where('position', 1)
        ->where('members_filled_status', 0)
        ->whereRaw('FIND_IN_SET(?, members_parents)', [$position_direct_id])
        ->whereNotExists(function ($q) {
            $q->select(DB::raw(1))
              ->from('ihook_matrix_members_link_table as child')
              ->whereColumn('child.direct_id', 'ihook_matrix_members_link_table.members_id')
              ->where('child.position', 1)
              ->where('child.members_filled_status', 0);
        })
        ->orderByDesc('root')
        ->first();

    if ($leftSpill) {
        $spillover_id = $leftSpill->members_id;
        MemberLinks::where('members_id', $position_direct_id)
            ->where('matrix_id', $matrix_id)
            ->update(['left_most_members_id' => $spillover_id]);
        return $spillover_id;
    }

  
    $rightSpill = MemberLinks::where('matrix_id', $matrix_id)
        ->where('position', 2)
        ->where('members_filled_status', 0)
        ->whereRaw('FIND_IN_SET(?, members_parents)', [$position_direct_id])
        ->whereNotExists(function ($q) {
            $q->select(DB::raw(1))
              ->from('ihook_matrix_members_link_table as child')
              ->whereColumn('child.direct_id', 'ihook_matrix_members_link_table.members_id')
              ->where('child.position', 2)
              ->where('child.members_filled_status', 0);
        })
        ->orderByDesc('root')
        ->first();

    if ($rightSpill) {
        $spillover_id = $rightSpill->members_id;
        MemberLinks::where('members_id', $position_direct_id)
            ->where('matrix_id', $matrix_id)
            ->update(['right_most_members_id' => $spillover_id]);
    }

    return $spillover_id;
}

}
