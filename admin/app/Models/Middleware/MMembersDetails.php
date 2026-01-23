<?php

/**
 * This class contains public functions related to MMembersDetails
 *
 * @package         MMembersDetails
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

use Illuminate\Support\Facades\DB;
use User\App\Models\Member;

if (!function_exists('getAllMember')) {
    function getAllMember()
    {
        return Member::all();
    }
}
if (!function_exists('getMemberWithId')) {
    function getMemberWithId($id)
    {
        return Member::where('members_id', $id)->first();
    }
}

if (!function_exists('getMemberLastRecord')) {
    function getMemberLastRecord()
    {
        return Member::orderBy('members_id', 'desc')->first();
    }
}
