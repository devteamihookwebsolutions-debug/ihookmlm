<?php
namespace Admin\App\Models\Middleware;
use Admin\App\Models\Member\MemberLinks;
use DateTime;

class MMatrixMemberLink
{

     public static function getMatrixLinkDetails($where)

    {

        return MemberLinks::where($where)->orderBy('link_id', 'ASC')->get();
    }

     public static function getPartMatrixLinkDetails($param, string $matrixLinkWhere)
    {
        return MemberLinks::whereRaw($matrixLinkWhere)->get();
    }

     public static function getPartMatrixLinkDetailsnew($param, string $matrixLinkWhere)
    {

        if (is_string($param)) {
            $param = array_map('trim', explode(',', $param));
        }

        return MemberLinks::select($param)->whereRaw($matrixLinkWhere)->get();
    }

}
