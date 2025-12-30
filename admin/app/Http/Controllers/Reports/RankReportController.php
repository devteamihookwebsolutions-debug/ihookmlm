<?php

/**
 * This class contains public functions related to Total Commission reports 
 *
 * @package         
 * @category        Controller
 * @author         
 * @link           
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
 * Licence Agreement: 
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Http\Controllers\Reports;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Reports\MRankReports;
use Illuminate\Http\Request;
use Exception;

class RankReportController extends Controller
{
  public static function rankbonus()
        {
     
        return view('reports.rankreports')
            ->with('success_message', 'Commission reports page loaded.');
    
    }

        /**
         * This public function is used to get rank bonus reports
         * @return json data
         */
      public function getRankBonus(Request $request)
        {
            return MRankReports::rankbonus($request, 'rankbonus');
        }
}
