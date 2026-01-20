<?php

/**
 * This class contains public functions related to MRankDetails
 *
 * @package         MRankDetails
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
?><?php

namespace Admin\App\Models\Middleware;

use Illuminate\Support\Facades\DB;

class MRankDetails
{
    /**
     * This public static function is used to get rank details
     *
     * @param string $where
     * @return array
     */
    public static function getRankDetails($where)
    {
        // 그대로 SQL structure maintain pannirukken
        $sql = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "ranksetting " . $where;

        $records = DB::select($sql);

        // Laravel DB::select returns array of objects
        // old code expects array, so convert
        return json_decode(json_encode($records), true);
    }
}
