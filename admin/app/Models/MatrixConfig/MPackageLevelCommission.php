<?php
namespace Admin\App\Models\MatrixConfig;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Admin\App\Models\Member\Package;
use Admin\App\Models\Member\PackageLevelCommission;
use Admin\App\Models\Member\MatrixConfiguration;



class MPackageLevelCommission
{

     public  static function showPackageLevelCommission($matrixId,$packageId)
    {


        $records = PackageLevelCommission::where('matrix_id', $matrixId)
            ->where('packagelevelcommission_package_id', $packageId)
            ->get();

        return $records;

    }

    public static function insertPackageLevelCommission($package_level)
        {

            // Collect request data (same variable names)
            $packagelevelcommission_name = $package_level['name'];
            $packagelevelcommission_amount =$package_level['commission'];
            $method = $package_level['method'];
            $matrix_id = $package_level['matrixid'];
            $packagelevelcommission_package_id = $package_level['pid'];
            $wallet = $package_level['wallet'];
            $levels = $package_level['id'];
            // $cryptocurrency = $request->input('cryptocurrency');

            // Handle method type
            if ($method == 'Flat') {
                $packagelevelcommission_method = 'flat';
            } else {
                $packagelevelcommission_method = '%';
            }

            // Handle wallet type
            if ($wallet == 'C-Wallet') {
                $packagelevelcommission_wallet_type = '1';
            } else {
                $packagelevelcommission_wallet_type = '2';
            }

            // Check if record exists for this level, package, and matrix
            $existing = PackageLevelCommission::where('levels', $levels)
                ->where('packagelevelcommission_package_id', $packagelevelcommission_package_id)
                ->where('matrix_id', $matrix_id)
                ->first();


            if ($existing) {
                // Update existing record

                   PackageLevelCommission::where('packagelevelcommission_id', $existing->packagelevelcommission_id)->update([
                    'packagelevelcommission_name' => $packagelevelcommission_name,
                    'packagelevelcommission_amount' => $packagelevelcommission_amount,
                    'packagelevelcommission_method' => $packagelevelcommission_method,
                    'packagelevelcommission_package_id' => $packagelevelcommission_package_id,
                    'packagelevelcommission_wallet_type' => $packagelevelcommission_wallet_type,

                ]);
            } else {
                // Get all existing levels for this package & matrix
                $recordslevel = PackageLevelCommission::where('packagelevelcommission_package_id', $packagelevelcommission_package_id)
                    ->where('matrix_id', $matrix_id)
                    ->get();

                $levels = $recordslevel->count() + 1;

                // Insert a new record

                $pacakgelevelRecord = new PackageLevelCommission();
                $pacakgelevelRecord->packagelevelcommission_name = $packagelevelcommission_name;
                $pacakgelevelRecord->packagelevelcommission_amount = $packagelevelcommission_amount;
                $pacakgelevelRecord->packagelevelcommission_method = $packagelevelcommission_method;
                $pacakgelevelRecord->packagelevelcommission_package_id = $packagelevelcommission_package_id;
                $pacakgelevelRecord->matrix_id = $matrix_id;
                $pacakgelevelRecord->packagelevelcommission_wallet_type = $packagelevelcommission_wallet_type;
                $pacakgelevelRecord->levels = $levels;

                $pacakgelevelRecord->save();
            }

            // Update the matrix configuration
            MatrixConfiguration::where('matrix_id', $matrix_id)
                ->where('matrix_key', 'package_level_commisison_status')
                ->update(['matrix_value' => '1']);

            return true;
        }

    public static function deletePackageLevelCommission(Request $request)
    {

        PackageLevelCommission::where('levels', $request->id)
            ->where('matrix_id', $request->matrix_id)
            ->where('packagelevelcommission_package_id', $request->package_id)
            ->delete();

             return response()->json(['success' => true]);

    }

}
