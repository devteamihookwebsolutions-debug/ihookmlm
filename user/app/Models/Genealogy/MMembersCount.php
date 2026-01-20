<?php

/**
 * This class contains public functions related to MMembersCount
 *
 * @package         MMembersCount
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
namespace User\App\Models\Genealogy;
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

        return  $totalcount;
    }
}
