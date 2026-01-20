<?php

/**
 * This class contains public functions related to MUserLog
 *
 * @package         MUserLog
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

namespace User\App\Models\Logs;

use User\App\Models\MemberLog; // Make sure this path is correct
use Illuminate\Support\Facades\Request;

class MUserLog
{
    public static function userLog($userid, $message, $doname)
    {
        $log = new MemberLog();

        $log->members_log_members_id = $userid;
        $log->log                    = $message;
        $log->doname                 = $doname;
        $log->members_log_ip_used    = Request::ip();
        $log->members_log_time        = now();
        $log->created_at             = now();
        $log->created_by             = $userid;

        // Save to database
        $log->save();
    }
}
