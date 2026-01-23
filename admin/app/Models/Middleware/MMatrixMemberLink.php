<?php

/**
 * This class contains public functions related to MMatrixtTypeDetails
 *
 * @package         MMatrixtTypeDetails
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace Admin\App\Models\Middleware;
use Admin\App\Models\Member\MemberLinks;
use DateTime;

class MMatrixMemberLink
{

     public static function getMatrixLinkDetails($where)

    {
        return MemberLinks::where($where)->orderBy('link_id', 'ASC')->get();
    }

    public static function getMatrixLinkDetail($members_id, $matrix_id)
    {
        return MemberLinks::where('spillover_id', $members_id)
                          ->where('matrix_id', $matrix_id)
                          ->orderBy('position', 'ASC')
                          ->get()
                          ->toArray();
    }
     public static function getPartMatrixLinkDetails($param, string $matrixLinkWhere)
    {
        return MemberLinks::whereRaw($matrixLinkWhere)->get();
    }

     public static function getPartMatrixLinkDetailsnew($param, string $matrixLinkWhere)
    {

        if (is_string($param)) {
            $param = array_map('trim', explode(',', $param));
        }

        return MemberLinks::select($param)->whereRaw($matrixLinkWhere)->get();
    }

}
