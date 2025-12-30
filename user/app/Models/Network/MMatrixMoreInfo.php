<?php

namespace App\Models\Network;

use Illuminate\Support\Facades\DB;
use Admin\App\Models\Middleware\MMatrixMemberLink;
use Display\Network\DMatrixMoreInfo;

class MMatrixMoreInfo
{
    /**
     * This public static function is used to get network details of users
     * @return HTML data
     */
    public static function showMatrixMoreInformation()
    {
        $matrix_id = request('matrix_id');
        $sql       = "SELECT * FROM  " . env('IHOOK_PREFIX') . "_matrix_table WHERE matrix_id='" . $matrix_id . "'";
        $records = DB::select($sql);
        if ($records) {
            $records = $records[0];
            return DMatrixMoreInfo::showMatrixMoreInformation($records);
        } else {
            throw new \Exception("" . __('No records found') . "");
        }
    }
}
