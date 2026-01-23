<?php

/**
 * This class contains public functions related to LevelCommissionController
 *
 * @package         LevelCommissionController
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
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
use Admin\App\Models\Member\LevelCommission;
use Admin\App\Models\MatrixConfig\MLevelCommission;

class LevelCommissionController extends Controller
{

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

            $mLevelCommission = new MLevelCommission();
            $mLevelCommission->deleteLevelCommission($request->id);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
             return response()->json(['error' => $e->getMessage()], 500);

        }
    }

}
