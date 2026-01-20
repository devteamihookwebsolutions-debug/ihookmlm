<?php

/**
 * This class contains public functions related to BinaryBottomUser
 *
 * @package         BinaryBottomUser
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

namespace User\App\Models;

use Illuminate\Support\Facades\DB;

class BinaryBottomUser
{
    public static function get($memberId, $matrixId)
    {
        $left  = $memberId;
        $right = $memberId;

        // ---- LEFT MOST ----
        $sqlLeft = "
            SELECT mmlt1.members_id
            FROM ihook_matrix_members_link_table mmlt1
            WHERE mmlt1.matrix_id = ?
              AND mmlt1.position = '1'
              AND FIND_IN_SET(?, mmlt1.members_parents)
              AND NOT EXISTS (
                  SELECT 1 FROM ihook_matrix_members_link_table mmlt2
                  WHERE mmlt2.matrix_id = mmlt1.matrix_id
                    AND mmlt2.position = '1'
                    AND FIND_IN_SET(mmlt1.members_id, mmlt2.members_parents)
              )
            LIMIT 1";

        $leftRow = DB::selectOne($sqlLeft, [$matrixId, $memberId]);
        if ($leftRow && $leftRow->members_id) {
            $left = $leftRow->members_id;
        }

        // ---- RIGHT MOST ----
        $sqlRight = str_replace('position = \'1\'', 'position = \'2\'', $sqlLeft);
        $rightRow = DB::selectOne($sqlRight, [$matrixId, $memberId]);
        if ($rightRow && $rightRow->members_id) {
            $right = $rightRow->members_id;
        }

        // update the link record (just like old code)
        MatrixMemberLink::where('members_id', $memberId)
            ->where('matrix_id', $matrixId)
            ->update([
                'left_most_members_id'  => $left,
                'right_most_members_id' => $right,
            ]);

        return ['leftuser' => $left, 'rightuser' => $right];
    }
}
