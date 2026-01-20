<?php

/**
 * This class contains public functions related to MMatrixBinary
 *
 * @package         MMatrixBinary
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
namespace Admin\App\Models\MatrixConfig;
use Admin\App\Models\Member\BinaryRatio;
use Admin\App\Models\Member\CarryOver;
use Illuminate\Http\Request;
use Admin\App\Display\MatrixConfig\DMatrixBinary;

class MMatrixBinary
{

    public static function getBinaryRatio($name, $id, $editable)
    {
        // Retrieve all records where status = 0
        $records = BinaryRatio::where('status', 0)->get();

        // Assuming DMatrixBinary::getBinaryRatio is a custom method somewhere in your app
        return DMatrixBinary::getBinaryRatio($records, $name, $id, $editable);
    }

        public static function getCarryOver($name, $id, $editable)
    {
        // Fetch all carryover records with status = 0
        $records = Carryover::where('status', 0)->get();

        // Assuming DMatrixBinary::getCarryOver() is still to be used
        return DMatrixBinary::getCarryOver($records, $name, $id, $editable);
    }
}
