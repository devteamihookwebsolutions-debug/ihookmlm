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