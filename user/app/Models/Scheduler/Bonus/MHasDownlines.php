<?php

/**
 * This class contains public functions related to MHasDownlines
 *
 * @package         MHasDownlines
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

namespace User\App\Models\Scheduler\Bonus;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MHasDownlines
{
    /**
     * Check if a member has the required downlines at specific levels or total.
     *
     * @param int   $userId         Member ID to check
     * @param array $levelCriteria  e.g., [1 => 2, 3 => 1] means "at least 2 in level 1, 1 in level 3"
     *                              or ['ALL' => 10] means "at least 10 total downlines"
     * @param int   $matrixId       Matrix ID
     * @param string $condition     Comparison operator: '<', '<=', '>', '>=', '==', '!='
     *
     * @return bool true if condition satisfied, false otherwise
     */
    public static function hasDownlines(int $userId, array $levelCriteria, int $matrixId, string $condition = '>='): bool
    {
        if (empty($levelCriteria) || !is_array($levelCriteria)) {
            return false;
        }

        $prefix = config('services.ihook.prefix', 'ihook');

        if (isset($levelCriteria['ALL'])) {
            $requiredCount = (int) $levelCriteria['ALL'];

            $totalDownlines = DB::table("{$prefix}_matrix_members_link_table")
                ->whereRaw("FIND_IN_SET(?, members_parents)", [$userId])
                ->where('matrix_id', $matrixId)
                ->where('members_account_status', '>', 0)
                ->where('members_status', '>', 0)
                ->count();

            return self::compare($totalDownlines, $requiredCount, $condition);
        }
        $userRoot = DB::table("{$prefix}_matrix_members_link_table")
            ->where('members_id', $userId)
            ->where('matrix_id', $matrixId)
            ->value('root');

        if (is_null($userRoot)) {
            Log::warning("Root not found for member {$userId} in matrix {$matrixId}");
            return false;
        }

        foreach ($levelCriteria as $level => $requiredCount) {
            $level = (int) $level;
            $requiredCount = (int) $requiredCount;

            $targetRoot = $userRoot + $level;

            $downlineCountAtLevel = DB::table("{$prefix}_matrix_members_link_table")
                ->whereRaw("FIND_IN_SET(?, members_parents)", [$userId])
                ->where('root', $targetRoot)
                ->where('matrix_id', $matrixId)
                ->where('members_account_status', '>', 0)
                ->where('members_status', '>', 0)
                ->count();

            if (!self::compare($downlineCountAtLevel, $requiredCount, $condition)) {
                Log::info("Level check failed: Member {$userId} has {$downlineCountAtLevel} downlines at level {$level}, required {$condition} {$requiredCount}");
                return false;
            }
        }

        return true;
    }

    /**
     * Helper to compare two values based on condition
     */
    private static function compare(int $actual, int $required, string $condition): bool
    {
        return match ($condition) {
            '<'  => $actual <  $required,
            '<=' => $actual <= $required,
            '>'  => $actual >  $required,
            '>=' => $actual >= $required,
            '==' => $actual == $required,
            '!=' => $actual != $required,
            default => false,
        };
    }
}
