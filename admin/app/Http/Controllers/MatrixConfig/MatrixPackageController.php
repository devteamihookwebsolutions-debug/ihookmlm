<?php

/**
 * This class contains public functions related to MatrixPackageController
 *
 * @package         MatrixPackageController
 * @category        Controller
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

namespace Admin\App\Http\Controllers\MatrixConfig;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\MatrixConfig\MMatrixPackage;
use Admin\App\Models\Middleware\MWalletType;
use Admin\App\Models\Middleware\MPackageDetails;
use Illuminate\Http\Request;
use Exception;

class MatrixPackageController extends Controller
{
       public function showAddPackage(Request $request, $matrix_id)
    {
        try {
            $matrix_id = $matrix_id;

             $output = [];
             $output['matrix_id'] =  $matrix_id;
            // Wallet Type
            $output['package_direct_commission_wallet_type'] = MWalletType::getWalletType(
                "package_direct_commission_wallet_type",
                "package_direct_commission_wallet_type",
                "package_direct_commission_wallet_type"
            );

                    // Render Blade view
            return view('matrixconfig.addpackage', $output);

        } catch (Exception $e) {
            return redirect()->route('matrix.insertPackage', ['matrix_id' => $matrix_id])
                ->with('error_message', $e->getMessage());
        }
    }

    /**
     * Validate package name
     */
    public function validatePackageName()
    {
        try {
            MMatrixPackage::validatePackageName();
        } catch (Exception $e) {

             return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Insert a new package
     */
     public function insertPackage(Request $request, $matrix_id)
    {

        ini_set('memory_limit', '2G');

        try {

            $package = $request->all();

            // Insert package logic
            MMatrixPackage::insertPackage($package,$matrix_id);


        } catch (Exception $e) {
              return response()->json(['error' => $e->getMessage()], 500);

        }
    }

    /**
     * View all packages
     */
    public function viewAllPackages(Request $request, $matrix_id)
    {
       try {


        echo MMatrixPackage::showPackageDetails($matrix_id, '');
            // Return view or JSON response depending on your use case

            // Or if you want JSON response:
            // return response()->json(['details' => $details]);

        } catch (Exception $e) {
            // Redirect back with error message in session flash data
         return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show edit package form
     */
  public function showEditPackage(Request $request, $package_id, $matrix_id)
{
    try {
        $output = [
            'package_id' => $package_id,
            'matrix_id'  => $matrix_id,
        ];

        $packageDetails = MPackageDetails::getPackageDetails($package_id);
        $output['errval'] = $packageDetails;

        // Unserialize pack_payment
        $packpayment_arr = [];
        $pack_payment_serialized = $packageDetails['pack_payment'] ?? '';

        if (!empty($pack_payment_serialized)) {
            $pack_payment_ser = @unserialize($pack_payment_serialized);
            if ($pack_payment_ser !== false || $pack_payment_serialized === 'b:0;') {
                foreach ($pack_payment_ser as $value) {
                    $packpayment_arr[$value] = "1";
                }
            }
        }
        $output['pack_payment'] = $packpayment_arr;

        // Wallet type
        $walletKey = $packageDetails['package_direct_commission_wallet_type'] ?? 'package_direct_commission_wallet_type';
        $output['package_direct_commission_wallet_type'] = MWalletType::getWalletType(
            "package_direct_commission_wallet_type",
            "",
            $walletKey
        );

        return response()->json($output);

    } catch (\Exception $e) {
        \Log::error('Edit Package Error: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to load package: ' . $e->getMessage()], 500);
    }
}

    /**
     * Update a package
     */
    public function updatePackage(Request $request, $package_id, $matrix_id)
    {
        try {


        $package = $request->all();

        // Perform the update logic
        MMatrixPackage::updatePackage($package, $matrix_id);

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Package updated successfully!');
        } catch (Exception $e) {
            // Flash an error message to the session
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Preview a package icon
     */
    public function previewPackageIcon(Request $request,$matrix_id)
    {
        try {
        $iconId = $matrix_id;
        $previewUrl =  MMatrixPackage::previewPackageIcon($iconId);

        return response()->json(['preview_url' => $previewUrl]);
        } catch (\Exception $e) {

             return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete a package
     */
    public function deletePackage($package_id)
    {
        try {


        MMatrixPackage::deletePackage($package_id);


        } catch (\Exception $e) {
            // You can also use withErrors or with('error_message') for flash messages
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }




}
