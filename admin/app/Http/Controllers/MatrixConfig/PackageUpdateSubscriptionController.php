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
use Admin\App\Models\Middleware\MPackageDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Exception;
use Model\MatrixConfig\MPackageUpdateSubscription;

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
