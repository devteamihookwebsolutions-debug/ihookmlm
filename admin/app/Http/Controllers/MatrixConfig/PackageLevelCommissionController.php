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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Exception;

use Admin\App\Models\MatrixConfig\MPackageLevelCommission;
use Illuminate\Http\JsonResponse;


class PackageLevelCommissionController extends Controller
{

    public static function showPackageLevelCommission(Request $request, $matrix_id,$packageId)
        {
            try {
            $output['package_commission_settings'] = MPackageLevelCommission::showPackageLevelCommission($matrix_id,$packageId);


            return response()->json($output);

        } catch (\Exception $e) {

             return response()->json(['error' => $e->getMessage()], 500);


        }

    }

    public function validatePackageLevelCommission(Request $request)
    {
        ini_set('memory_limit', '2G');

        try {

            $package_level = $request->all();

            // Insert Package Level Commission
            MPackageLevelCommission::insertPackageLevelCommission($package_level);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

       public static function deletePackageLevelCommission(Request $request)
    {

        try {

            // Perform deletion
            MPackageLevelCommission::deletePackageLevelCommission($request);

        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

}
