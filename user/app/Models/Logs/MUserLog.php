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
