<?php

namespace User\App\Models\Scheduler\Rank;

use Illuminate\Support\Facades\DB;

class MCheckUser
{
    /**
     * Check if user exists in the matrix
     */

public static function checkUser($member_id, $matrix_id)
{
    $prefix = config('services.ihook.prefix', 'ihook_');

    return DB::table("{$prefix}_matrix_members_link_table")
        ->where('members_id', $member_id)
        ->where('matrix_id', $matrix_id)
        ->count();
}
}
