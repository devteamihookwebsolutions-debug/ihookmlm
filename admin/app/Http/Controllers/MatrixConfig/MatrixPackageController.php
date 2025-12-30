<?php

namespace Admin\App\Http\Controllers\MatrixConfig;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Middleware\MPaymentGatewayDetails;
use Admin\App\Models\MatrixConfig\MatrixPackageDetails;
use Admin\App\Models\Middleware\MMatrixDetails;
use Admin\App\Models\MatrixConfig\MMatrixPackage;
use Admin\App\Models\Middleware\MMatrixtTypeDetails;
use Admin\App\Models\Middleware\MMatrixConfigurationWholeDetails;
use Admin\App\Models\Middleware\MMatrixTypes;
use Admin\App\Models\MatrixConfig\MDefaultMatrix;
use Admin\App\Models\MatrixConfig\MMatrixPackageDetails;
use Admin\App\Models\Middleware\MWalletType;
use Admin\App\Models\Middleware\MPackageDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Exception;


// use App\Models\PackageIcon;
// use App\Models\ShopProduct;
// use App\Models\SiteSetting; 
// use App\Models\CryptoCurrency;
// use App\Models\TaxDetail;
// use App\Models\WalletType;

class MatrixPackageController extends Controller
{
    public function __construct()
    {
        // Middleware for authentication
        // $this->middleware(function ($request, $next) {
        //     if (!Session::has('admin.id')) {
        //         return redirect()->to(env('ADMINPATH') . '/adminlogin');
        //     }
        //     return $next($request);
        // });
    }

    /**
     * Show add package form
     */
    public function showAddPackage(Request $request, $matrix_id)
    {
        try {
            $matrix_id = $matrix_id;

            // Get Chargebee Payment Gateway
            // $chargebee = PaymentGatewayDetail::where('paymentsettings_default_name', 'chargebee')->first();

             $output = [];
             $output['matrix_id'] =  $matrix_id;

            // if ($chargebee && $chargebee->paymentsettings_status === 'Active') {
            //     $matrixDetails = MMatrixDetails::find($matrix_id);
            //     $output['matrix_details'] = $matrixDetails;
            //     $output['chargebee_paymentsettings_status'] = '1';
            //     $output['chargebeeplanname'] = $matrixDetails->matrix_name ?? '';
            // } else {
            //     $output['chargebee_paymentsettings_status'] = '0';
            // }

            // Package Icon
            // $output['package_icon'] = MMatrixPackage::getPackageIcons(''); // assuming getIcons() is defined

            // Products
            // $output['products'] = ShopProduct::getEshopProducts(); // assuming getEshopProducts() is defined

            // Get Dashboard Type
            // $dashboardSetting = SiteSetting::where('sitesettings_name', 'dashboard_type')->first();
            // $dashboard_type = $dashboardSetting->sitesettings_value ?? '1';
            // $output['dashboard_type'] = $dashboard_type;

            // Crypto
            // if ($dashboard_type === '2') {
            //     $output['cryptocurrency'] = CryptoCurrency::getCurrency($request->product, $request->package_type); // assuming method exists
            // }

            // Tax Type
            // $taxtype = TaxDetail::getTaxTypeDetail(); // assuming returns array or collection
            // $output['taxtype'] = $taxtype[0]->taxtype ?? null;

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
        } catch (\Exception $e) {
           
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