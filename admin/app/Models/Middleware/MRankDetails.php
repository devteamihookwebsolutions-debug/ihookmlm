<?php
/**
 * This class contains public static functions related to rank details.
 *
 * @package         MRankDetails
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://promlmsoftware.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
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
