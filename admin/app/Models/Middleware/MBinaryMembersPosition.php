<?php

/**
 * This class contains public functions related to MBinaryMembersPosition
 *
 * @package         MBinaryMembersPosition
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
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
