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


namespace Admin\App\Http\Controllers\Funds;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Funds\MFunds;
use Illuminate\Http\Request;
use Exception;

class CFundTransferController extends Controller
{
        public  function showFunds()
    {
           // Just return the Blade view — no JSON
    return view('funds.fundtransfer')
        ->with('success', ' page loaded.');
    }


//     public  function showFundTransfers()
//    {
    
//            $output=MFunds::showFundTransfers();
//         //    dd($output);
//            return $output;
//      }
public static function showFundTransfers(Request $request)
{
    $data = MFunds::showFundTransfers($request);
    // dd($data);
  return response()->json($data, 200, [], JSON_UNESCAPED_SLASHES);
}

       
}