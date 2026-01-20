<?php

/**
 * This class contains public functions related to MDefaultMatrix
 *
 * @package         MDefaultMatrix
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
namespace Admin\App\Models\MatrixConfig;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\MemberLinks;
use Admin\App\Display\MatrixConfig\DDefaultMatrix;
use Illuminate\Http\Request;


class MDefaultMatrix
{

public static function getDefaultSponsor($default_sponsor, $matrix_id)

{


    $membersTable = (new Member)->getTable();
    $linksTable = (new MemberLinks)->getTable();

   $records = Member::leftJoin($linksTable, $linksTable . '.members_id', '=', $membersTable . '.members_id')
    ->where($linksTable . '.matrix_id', $matrix_id)
    ->select($membersTable . '.*', $linksTable . '.matrix_id', $linksTable . '.members_id')
    ->limit(50)
    ->get();

    // Get the username of the default sponsor
    $sponsor = Member::where('members_id', $default_sponsor)->first();
    $members_username = $sponsor ? $sponsor->members_username : null;

    // Assuming DDefaultMatrix::showDefaultSponsor accepts these params
    return DDefaultMatrix::showDefaultSponsor($records, $default_sponsor, $members_username);
}

public function getUserCount(Request $request)
{
    $email = trim($request->input('default_sponsor'));

    // Check if a member with this email exists
    $exists = Member::where('members_email', $email)->exists();

    if ($exists) {
        return response()->json('false');
    } else {
        return response()->json('true');
    }
}

}
