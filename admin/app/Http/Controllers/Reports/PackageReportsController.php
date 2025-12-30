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
use Admin\App\Models\Reports\MPackageReports;
use Illuminate\Http\Request;
use Exception;
class PackageReportsController extends Controller
{
public static function showPackageReports()
    { 
        
    return view('reports.packagereports')
            ->with('success_message', 'reports page loaded.');
    }
public function getPackageReports(Request $request)
{
    try {
        $data = MPackageReports::getPackagereports($request);
        // dd($data);
        return response()->json($data);
    } catch (\Exception $e) {
        session()->flash('error_message', $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
