<?php
namespace User\App\Models\Genealogy;
use Admin\App\Models\Middleware\MURLCrypt;
use Admin\App\Models\Member\Matrix;
use Admin\App\Models\Member\MatrixConfiguration;
use Admin\App\Models\Member\MemberLinks;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\RankSetting;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Admin\App\Models\Middleware\MBinaryMembersPosition;



class MBinaryMembersCount
{

    public static function getBinaryMembersCount($memberId, $matrixId)
{

    // Get the direct sponsor
    $directMember = MemberLinks::where('matrix_id', $matrixId)
        ->where('members_id', $memberId)
        ->first();

    $membersUsername = 'Nil';
    if ($directMember && $directMember->direct_id > 0) {
        $sponsor = Member::find($directMember->direct_id);
        $membersUsername = $sponsor ? $sponsor->members_username : 'Nil';
    }

    // Get left and right positions
    $leftUser = MBinaryMembersPosition::getBinaryMembersPosition($memberId, $matrixId, '1');
    $rightUser = MBinaryMembersPosition::getBinaryMembersPosition($memberId, $matrixId, '2');

    // Count left members
    $leftTotalCount = 0;
    if ($leftUser > 0) {
        $leftTotalCount = MemberLinks::where('matrix_id', $matrixId)
            ->where('members_account_status', '>', 0)
            ->where('members_status', '>', 0)
            ->whereRaw("FIND_IN_SET(?, members_parents)", [$leftUser])
            ->count();
        $leftTotalCount += 1; // Include the parent itself
    }

    // Count right members
    $rightTotalCount = 0;
    if ($rightUser > 0) {
        $rightTotalCount = MemberLinks::where('matrix_id', $matrixId)
            ->where('members_account_status', '>', 0)
            ->where('members_status', '>', 0)
            ->whereRaw("FIND_IN_SET(?, members_parents)", [$rightUser])
            ->count();
        $rightTotalCount += 1; // Include the parent itself
    }

    return [
        'left' => $leftTotalCount,
        'right' => $rightTotalCount,
        'sponsorname' => $membersUsername
    ];
}

}
