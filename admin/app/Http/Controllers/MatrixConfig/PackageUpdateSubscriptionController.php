<?php

namespace Admin\App\Http\Controllers\MatrixConfig;

use Admin\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Exception;
use Admin\App\Models\Middleware\PaymentGatewayDetails;
use Admin\App\Models\MatrixConfig\MatrixPackageDetails;
use Admin\App\Models\Middleware\MMatrixDetails;
use Admin\App\Models\MatrixConfig\MMatrixPackage;
use App\Models\MatrixConfig\MPackageLevelCommission;
use App\Models\Middleware\MPackageDetails;
use App\Models\MatrixConfig\MPackageUpdateSubscription;
use Illuminate\Http\JsonResponse;

class PackageUpdateSubscriptionController extends Controller
{

    // 

    public static function updateSubscription(Request $request)
    {
        try {
            $package_id = $request->query('sub1');

            $packageDetails = MPackageDetails::getPackageDetails($package_id);

            $pack_payment_ser = unserialize($packageDetails['pack_payment']);
            $packpayment_arr = [];

            foreach ($pack_payment_ser as $value) {
                $packpayment_arr[$value] = "1";
            }

            $output = [
                'errval' => $packageDetails,
                'pack_payment' => $packpayment_arr,
                'pack_payment_fields' => unserialize($packageDetails['pack_payment_fields']),
            ];

            return response()->json($output);

        } catch (Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return Redirect::to(env('ADMINPATH') . '/matrix/updatesubscription');
        }
    }
     public static function updateSubPackagePay()
    {
        try {
            MPackageUpdateSubscription::updateSubPackagePay();
            return redirect()->back()->with('success', 'Package updated successfully!');
        } catch (Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return Redirect::to(env('ADMINPATH') . '/matrix/updatesubpackagepay');
        }
    }

}