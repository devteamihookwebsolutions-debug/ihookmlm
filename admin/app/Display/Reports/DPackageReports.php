<?php

/**
 * This class contains public functions related to DPackageReports
 *
 * @package         DPackageReports
 * @category        Display
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

namespace Admin\App\Display\Reports;


use Illuminate\Http\JsonResponse;

class DPackageReports
{
      public static function getPackagereports($records, $totalPages, $totalRecords)
    {
        // dd($records);
                $memData = [];

        if (!empty($records) && count((array)$records) > 0) {
            foreach ($records as $index => $record) {
                $no = $index + 1;


                $memData[] = [
                    'No' => $no,
                    'name' => $record->members_username,// Removed <a href> link as requested earlier
                    'package_name'=>$record->package_name

                ];
            }
        }

         // Build response structure
        // $response = [
        //     'total_pages' => $totalPages ?? 0,
        //     'records' => $memData,
        //     'total_records' => $totalRecords ?? 0,
        // ];
        // //  dd($response);
        // return response()->json($response);
        return [
            'total_pages' => $totalPages ?? 0,
            'records' => $memData,
           'total_records' => $totalRecords ?? 0,
        ];
    }
}
