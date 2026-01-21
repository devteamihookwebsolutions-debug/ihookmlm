<?php

/**
 * This class contains public functions related to MCheckUser
 *
 * @package         MCheckUser
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
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
