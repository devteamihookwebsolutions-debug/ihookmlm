<?php
namespace Admin\App\Models\Genealogy;
use Admin\App\Models\Middleware\MURLCrypt;
use Admin\App\Models\Member\Matrix;
use Admin\App\Models\Member\MatrixConfiguration;
use Admin\App\Models\Member\MemberLinks;

use Illuminate\Support\Facades\Session;


use Illuminate\Http\Request;


class MMembersCount
{


     public static function getDownlineMembersCount($memberId, $matrixId)
    {
        if ($memberId > 0) {
            $totalcount = MemberLinks::whereRaw('FIND_IN_SET(?, members_parents)', [$memberId])
                        ->where('matrix_id', $matrixId)
                        ->where('members_account_status', '>', 0)
                        ->where('members_status', '>', 0)
                        ->count();
        }else{
             $totalcount = 0;
        }
        // dd($totalcount);
        return $totalcount;
    }

      public  static function getDirectDownlineMembersCount($memberId, $matrixId)
    {
        if ($memberId > 0) {
           $totalcount =  MemberLinks::where('direct_id', $memberId)
                        ->where('matrix_id', $matrixId)
                        ->count();
        }
        else {
            $totalcount = 0;
        }
        dd($totalcount);
        return  $totalcount;
    }
}