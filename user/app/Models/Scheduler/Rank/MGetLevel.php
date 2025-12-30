<?php

namespace User\App\Models\Scheduler\Rank;
use Admin\App\Models\Middleware\MMatrixMemberLink;
use Illuminate\Support\Facades\DB;

class MGetLevel
{
    /**
     * Get achieved levels for rank
     *
     * @param int $member_id
     * @param int $matrix_id
     * @param int $levelcnt
     * @return int
     */
    public static function getLevel($member_id, $matrix_id, $levelcnt)
    {
        /* -------------------------------------------------
         * Get level width from matrix configuration
         * ------------------------------------------------- */
        $level_width = DB::table(env('IHOOK_PREFIX') . '_matrix_configuration_table')
            ->where('matrix_id', $matrix_id)
            ->where('matrix_key', 'level_width')
            ->value('matrix_value');

        if (!$level_width) {
            return 0;
        }

        /* -------------------------------------------------
         * Get member root level
         * ------------------------------------------------- */
        $where_root = 'members_id = "' . $member_id . '" AND matrix_id = "' . $matrix_id . '"';

        $member_link = MMatrixMemberLink::getPartMatrixLinkDetails('root', $where_root);

        if (empty($member_link)) {
            return 0;
        }

        $level = $member_link[0]['root'] + 1;
        $count = 0;

        /* -------------------------------------------------
         * Loop through levels
         * ------------------------------------------------- */
        for ($i = 0; $i < $levelcnt; $i++) {
            $j = $i + 1;

            $total_level = DB::table(env('IHOOK_PREFIX') . '_matrix_members_link_table')
                ->whereRaw('FIND_IN_SET(?, members_parents)', [$member_id])
                ->where('root', $level)
                ->where('matrix_id', $matrix_id)
                ->where('members_account_status', '1')
                ->count();

            $level = $level + $j;

            if ($total_level >= pow($level_width, $j)) {
                $count++;
            }
        }

        return $count;
    }
}
