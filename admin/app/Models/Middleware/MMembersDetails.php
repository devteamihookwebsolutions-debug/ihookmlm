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
