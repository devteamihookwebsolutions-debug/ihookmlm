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


namespace Admin\App\Http\Controllers\Bonus;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Bonus\MSendBonus;
use Admin\App\Models\Middleware\MWalletType;
use Admin\App\Models\Middleware\MSiteDetails;
use Admin\App\Models\Middleware\MAutoSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Admin\App\Models\Member\Member;
use Illuminate\Support\Facades\DB;
class SendBonusController extends Controller
{

    public function showSendBonus()
    {
        try {
        $output = [];

        $output['member'] = MSendBonus::showUser();
        $output['wallet_type'] = MWalletType::getWalletType("wallet_type", "wallet_type", "");
        $output['member'] =  MAutoSearch::getAllMembersNew();
        $where = "WHERE sitesettings_name ='dashboard_type' ";
        $sitesettings = MSiteDetails::getSiteSettingsDetails($where);
        $output['dashboard_type'] = $sitesettings[0]['sitesettings_value'];
        if ($output['dashboard_type'] == '2') {
            $output['cryptocurrency'] = MCryptoCurrency::getCryptoCurrency();
        }
        
            // Return blade view instead of Bin_Template
         return view('Bonus.sendbonus', $output);

        } catch (Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect()->route('Bonus.sendbonus');
        }
    }
     public function bonususernamechck(Request $request)
    {
        // Validate input
        $request->validate([
            'username' => 'required'
        ]);

        $username = $request->input('username');

        // Query using the Member model
        $exists = Member::where('members_username', $username)->exists();

        // Return JSON response
        return response()->json([
            'status' => $exists ? 'success' : 'error',
            'message' => $exists ? 'Username exists' : 'Username does not exist',
        ]);
    }

public function updateSendBonus(Request $request)
{
    // dd($request->all());
       // Call the SendBonus update function
        return MSendBonus::updateSendBonus($request);

}
// public function getMembers(Request $request)
// {
//      dd($request);
//      MAutoSearch::getMembers();
     
// }
// public function getMembers(Request $request)
// {
//     // dd($request);
//     try {
//         $searchVal = $request->query('sub1');
//         $do = $request->query('do');

//         if ($searchVal) {
//             $records = MAutoSearch::getMembers($searchVal, '', '');
//             $html = DAutoSearchMembers::getMembers($records, $do);
//             return response($html);
//         }

//         return response()->json(['message' => 'No search value provided.'], 400);

//     } catch (\Exception $e) {
//         return response()->json(['error' => $e->getMessage()], 500);
//     }
// }



}