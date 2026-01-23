<?php

/**
 * This class contains public functions related to BonusAchievedController
 *
 * @package         BonusAchievedController
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

namespace Admin\App\Http\Controllers\Reports;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Reports\MBonusAchieved;
use Illuminate\Http\Request;
use Exception;

class  BonusAchievedController extends Controller
{

       public static function bonusAchieved()
    {

         // Just return the Blade view — no JSON
        return view('reports.bonusachievedreports')
            ->with('success_message', 'adminearnings reports page loaded.');

    }
    /**
     * This public function is used  to get admin earnings records from db
     * @return JSON data
     */
    public static function getBonusAchieved(Request $request)
    {

        $data = MBonusAchieved::bonusAchieved($request);
        // dd($data);
        return response()->json($data, 200, [], JSON_UNESCAPED_SLASHES);
        // return response()->json($data);
    }


    /**
     * This public function is used  to show admin earnings details
     * @return HTML data
     */
    public static function sendBonusAchieved()
    {

            MBonusAchieved::sendBonusAchieved();

    }
    public static function deleteBonusAchieved()
     {
        MBonusAchieved::deleteBonusAchieved();
     }
}
