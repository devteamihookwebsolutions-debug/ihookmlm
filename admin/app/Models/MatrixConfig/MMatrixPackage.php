<?php
namespace Admin\App\Models\MatrixConfig;

use Admin\App\Models\Middleware\MMatrixDetails;
use Admin\App\Display\MatrixConfig\DMatrixPackage;
use Illuminate\Http\Request;
// use Model\Factories\MChargebeeCreate;
// use Model\Middleware\MAmazonS3;
// use Model\Middleware\MCryptoConverter;
use Illuminate\Support\Facades\Storage;
use Admin\App\Models\Member\Package;
use Admin\App\Models\Member\PackageLevelCommission;
// use Model\Middleware\MPaymentGatewayDetails;


class MMatrixPackage
{


    public static function insertPackage($package, $matrix_id)
    {


  
        $packageStatus = 1;
        $packagePaymentMethod = 0;
        $packageDuration = 0;
        $packageGracePeriod = 0;
        $packagePaymentGateway = null;

        if ($package['package_paymentmethod1'] === 'onetime') {
            $packagePaymentMethod  = 0;
            $packageDuration       = $package['package_duration1'];
            $packageGracePeriod    = $package['package_grace_period'];
            $packagePaymentGateway = "";

        } elseif ($package['package_paymentmethod1'] === 'subscription') {
            $packagePaymentMethod  = 1;
            $packageDuration       = 0;
            $packageGracePeriod    = 0;
            $packagePaymentGateway = $package['package_paymentgateway1'];

        } elseif ($package['package_paymentmethod1'] === 'onetimestripe') {
            $packagePaymentMethod  = 0;
            $packageDuration       = 0;
            $packageGracePeriod    = 0;
            $packagePaymentGateway = $package['package_paymentgateway1'];

        } elseif ($package['package_paymentmethod1'] === 'both') {
            $packagePaymentMethod  = 2;
            $packageDuration       = $package['package_duration1'];
            $packageGracePeriod    = $package['package_grace_period'];
            $packagePaymentGateway = $package['package_paymentgateway1'];
        }


        // Image upload
        if (!empty($package['image_base64'])) {
            $image_base64 = $package['image_base64'];

            // Remove data URI prefix if present
            if (preg_match('/^data:image\/(\w+);base64,/', $image_base64, $type)) {
                $image_base64 = substr($image_base64, strpos($image_base64, ',') + 1);
                $extension = strtolower($type[1]); // jpg, png, gif, etc.
            } else {
                // Default to jpg if not found
                $extension = 'jpg';
            }

            $image_base64 = str_replace(' ', '+', $image_base64); // Fix spaces
            $imageData = base64_decode($image_base64);

            if ($imageData === false) {
                die('Base64 decode failed.');
            }

            // Generate a file name if not provided
            $fileName = $package['package_image'] ?? ('package_' . time() . '.' . $extension);
            $filePath = 'uploads/package_image/' . $fileName;

            if (!file_exists('uploads/package_image/')) {
                mkdir('uploads/package_image/', 0775, true);
            }

            // Save the image
            file_put_contents($filePath, $imageData);
            $packageIcon = $filePath;
        }

      

   
        // $matrix_details = MMatrixDetails::getMatrixDetails($matrix_id);
        
 
        // $matrix = MatrixDetail::find($request->matrix_id);
        // $chargebeePlanName = $matrix ? $matrix->matrix_name . '_' . $request->package_name : $request->package_name;
  
    
        $packages = new Package();
        $packages->package_name = $package['package_name'];
        $packages->package_type = $package['packagetype'];
        $packages->package_price = $package['package_price'];
        $packages->package_duration = $packageDuration;
        $packages->package_status = $packageStatus;
        $packages->package_direct_commission = $package['package_direct_commission'];
        $packages->package_direct_commission_method = $package['package_direct_commission_method'];
        $packages->package_pv = $package['package_pv'];
        $packages->matrix_id = $matrix_id ?? null; // Make sure $matrix_id is defined
        $packages->package_direct_commission_wallet_type = $package['package_direct_commission_wallet_type'];
        $packages->package_grace_period = $packageGracePeriod;
        $packages->package_paymentmethod = $packagePaymentMethod;
        $packages->pack_payment = json_encode($packagePaymentGateway); // Store array as JSON
        $packages->package_icon = $packageIcon;
        $packages->taxcode = $package['taxcode'] ?? null;
        $packages->package_description = $package['packagedescription'];
        $packages->package_totaloccurrence = $package['package_totaloccurrence'];
        // $packages->stripe_planid = $package['stripe_planid'] ?? null;
        // $packages->package_paymentmethod1 = $package['package_paymentmethod1'];
        $packages->usertochoose = $package['usertochoose'];
        $packages->save();

        return true;

     
    
    }

     public static function showPackageDetails($matrix_id, $Err = null)
    {
        // Get the matrix_id from query string (like ?sub1=123)
        $matrix_id = $matrix_id;

        // Fetch packages
        $records = Package::where('matrix_id', $matrix_id)
                            ->orderBy('package_id', 'asc')
                            ->get();
       

        return DMatrixPackage::showPackageDetails($records,$Err);

    }

    public static function updatePackage($package, $matrix_id)
    {

            $packageDuration = $package['package_duration'] ?? 0;
            $packageGracePeriod = isset($package['package_grace_period']) ? trim($package['package_grace_period']) : 0;
            $packagePaymentGateway = '';
            $packPaymentFields = '';
            $planId = '';
            
            $packagePaymentMethod = 0; 

         if ($package['package_paymentmethod'] === 'onetime') {
            $packagePaymentMethod  = 0;
        } elseif ($package['package_paymentmethod'] === 'subscription') {
            $packagePaymentMethod  = 1;
        } elseif ($package['package_paymentmethod'] === 'onetimestripe') {
            $packagePaymentMethod  = 0;
        } elseif ($package['package_paymentmethod'] === 'both') {
            $packagePaymentMethod  = 2;
        }


        // Handle image upload
        $packageImage = $package['package_image_hidden'] ?? null;

        if (!empty($package['image_base64'])) {
            $image_base64 = $package['image_base64'];

            // Remove data URI prefix if present
            if (preg_match('/^data:image\/(\w+);base64,/', $image_base64, $type)) {
                $image_base64 = substr($image_base64, strpos($image_base64, ',') + 1);
                $extension = strtolower($type[1]); // jpg, png, gif, etc.
            } else {
                // Default to jpg if not found
                $extension = 'jpg';
            }

            $image_base64 = str_replace(' ', '+', $image_base64); // Fix spaces
            $imageData = base64_decode($image_base64);

            if ($imageData === false) {
                die('Base64 decode failed.');
            }

            // Generate a file name if not provided
            $fileName = $package['package_image'] ?? ('package_' . time() . '.' . $extension);
            $filePath = 'uploads/package_image/' . $fileName;

            if (!file_exists('uploads/package_image/')) {
                mkdir('uploads/package_image/', 0775, true);
            }

            // Save the image
            file_put_contents($filePath, $imageData);
            $packageImage = $filePath;
        } elseif (!empty($package['package_image_hidden'])) {
            $packageImage = $package['package_image_hidden'];
        }

        
        // Update the package
        $packages = Package::find($package['edit_package_id']);

        if ($packages) {
            $packages->package_name = $package['package_name'];
            $packages->matrix_id = $package['edit_matrix_id'];
            $packages->package_type = $package['packagetype'];
            $packages->package_paymentmethod = $packagePaymentMethod;;
            $packages->usertochoose = $package['usertochoose'];
            $packages->package_totaloccurrence = $package['package_totaloccurrence'];
            $packages->package_duration = $packageDuration;;
            $packages->package_grace_period =  $packageGracePeriod;
            $packages->package_price = $package['package_price'];
            $packages->package_direct_commission = $package['package_direct_commission'];
            $packages->package_direct_commission_method = $package['package_direct_commission_method'];
            $packages->package_direct_commission_wallet_type = $package['package_direct_commission_wallet_type'];
            $packages->package_pv = $package['package_pv'];
            $packages->package_description = $package['packagedescription'];
            $packages->package_icon = $packageImage ;
            $packages->taxcode = $package['taxcode'];
            // $packages->stripe_planid = $package['stripe_planid'];
            $packages->save();
            
        }
        // Optional: handle Chargebee integration
 
        return response()->json([
            'status' => 'success',
            'message' => 'Package updated successfully.',
            'package' => $package
        ]);
    }


    public static function deletePackage($package_id)
    {
        // Get the package ID from request
    $packageId = $package_id;
    $package = Package::find($packageId);

    if ($package) {
        // Delete related level commissions

        PackageLevelCommission::where('packagelevelcommission_package_id', $packageId)->delete();
        Package::where('package_id', $packageId)->delete();

    }
    return true;
    
    }

     public static function validatePackageName()
    {
        // $packageName = $request->input('package_name');
        // $matrixId    = $request->query('sub1');
        // $action      = $request->query('sub2'); // 'edit' or something else

        // $query = Package::where('package_name', $packageName);

        // if ($action === 'edit') {
        //     $query->where('matrix_id', '!=', $matrixId);
        // } else {
        //     $query->where('matrix_id', $matrixId);
        // }

        // $exists = $query->exists();

        // return response()->json([
        //     'valid' => !$exists, // true if name is available
        // ]);
       
    }

     public static function previewPackageIcon($icon_id)
    {
        $icon = PackageIcon::where('icon_id', $icon_id)->first();

       return $icon ? $icon->icon_key : null;
    }


}
    