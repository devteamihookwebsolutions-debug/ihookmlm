<?php

/**
 * This class contains public functions related to MMemberDetails
 *
 * @package         MMemberDetails
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
use Admin\App\Models\Member\HistoryType;
use Admin\App\Models\Member\MemberLinks;
use Admin\App\Models\Member\MatrixType;
use Admin\App\Models\Member\Member;

class MMemberDetails
{

    public static function getUserDetails($members_id)
    {
        return Member::find($members_id);
    }

    public static function getWhereMemberDetails($where)
    {
        // Eloquent handles where conditions safely
    //   dd('asjfhdka');

       return Member::where('members_id', $where)->first();
    }

    public static function getPartMembersDetails($columns, $memberId)
    {
        // dd($memberId);
        // Only select specific columns
        return Member::select($columns)->where('members_id', $memberId)->first();
    }

    public static function getHistoryType($historyType)
    {
        return HistoryType::where('history_type_name', $historyType)
                          ->value('history_name');
    }

}


