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


