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