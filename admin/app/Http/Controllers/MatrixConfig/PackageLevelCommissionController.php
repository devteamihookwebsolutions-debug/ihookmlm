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

    // public function __construct()
    // {
    //     $this->middleware('auth:admin');
    // }

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