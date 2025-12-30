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