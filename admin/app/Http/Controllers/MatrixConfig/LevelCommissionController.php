<?php

namespace Admin\App\Http\Controllers\MatrixConfig;

use Admin\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Admin\App\Models\Member\LevelCommission;
use Admin\App\Models\MatrixConfig\MLevelCommission;



class LevelCommissionController extends Controller
{

    // public function __construct()
    // {
    //     // Ensure admin is authenticated
    //     $this->middleware(function ($request, $next) {
    //         if (!Session::has('admin.id')) {
    //             return redirect()->to(env('ADMINPATH') . '/adminlogin');
    //         }
    //         return $next($request);
    //     });
    // }

    /**
     * Show Level Commission Settings
     */
    public function showLevelCommission(Request $request, $matrix_id)
    {

        try {
            $output = [];
            $output['level_commission_settings'] = MLevelCommission::showLevelCommission($matrix_id);

            return response()->json($output);

        } catch (\Exception $e) {

             return response()->json(['error' => $e->getMessage()], 500);
           
        }
    }

    /**
     * Insert/Validate Level Commission
     */
    public function validateLevelCommission(Request $request)
    {
        
        ini_set('memory_limit', '2G');

        try {

            $levels = $request->all();

            MLevelCommission::insertLevelCommission($levels);
        } catch (\Exception $e) {
             return response()->json(['error' => $e->getMessage()], 500);
          
        }
    }

    /**
     * Delete Level Commission
     */
    public function deleteLevelCommission(Request $request)
    {
        try {
          
            MLevelCommission::deleteLevelCommission($request->id);

            
        } catch (\Exception $e) {
             return response()->json(['error' => $e->getMessage()], 500);
            
        }
    }
    
}