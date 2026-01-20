<?php

/**
 * This class contains public functions related to MMatrixPackageDetails
 *
 * @package         MMatrixPackageDetails
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
use Admin\App\Models\Member\Package;
use Admin\App\Display\MatrixConfig\DMatrixPackageDetails;
use Illuminate\Http\Request;


class MMatrixPackageDetails
{

public static function getMatrixPackageDetails( $Err, $matrixId)
{

    // Get packages using Eloquent
    $records = Package::where('matrix_id', $matrixId)
                ->orderBy('package_id', 'asc')
                ->get();



    return DMatrixPackageDetails::showMatrixPackageDetails($records, $Err);
}

}
