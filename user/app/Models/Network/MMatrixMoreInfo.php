<?php

/**
 * This class contains public functions related to MMatrixMoreInfo
 *
 * @package         MMatrixMoreInfo
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
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
