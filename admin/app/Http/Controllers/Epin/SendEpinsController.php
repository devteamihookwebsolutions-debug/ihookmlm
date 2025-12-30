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


namespace Admin\App\Http\Controllers\Epin;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Epin\MSendEpins;
use Admin\App\Models\Member\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Admin\App\Models\Middleware\MAutoSearch;
use Exception;

class SendEpinsController extends Controller
{

     public function showSendEpin(Request $request)
    {
        // dd('funciorn eeac');
        // try {
           $output['member'] =  MAutoSearch::getAllMembers();
        //    dd($output);
            $epinTypes = MSendEpins::getEpinType($request->all());
            // dd($epinTypes);
            // Clear session messages
            session()->forget(['success', 'error_message']);

            // Return Blade view with data
            return view('epin.sendepin', [
                'epintype' => $epinTypes,
                'member'  => $output['member']

            ]);

        // } catch (\Exception $e) {

        //     // Store error message in session
        //     session()->flash('error_message', $e->getMessage());

        //     // Redirect to your route
        //     // return redirect()->route('distributor.order');
        // }
    }

    public function bonususernamechck(Request $request)
{
    // Validate input
    $request->validate([
        'username' => 'required'
    ]);

    $username = $request->input('username');

    // Get member details (id + username)
    $member = Member::where('members_username', $username)->first();

    if ($member) {
        return response()->json([
            'status'  => 'success',
            'message' => 'Username exists',
            'member_id' => $member->members_id,
            'username'  => $member->members_username,
        ]);
    }

    return response()->json([
        'status'  => 'error',
        'message' => 'Username does not exist',
        'member_id' => null
    ]);
}



public static function updateEpins(Request $request)
{

    // dd('safhdk');
    // dd($request->all());
       // Call the SendBonus update function
        return MSendEpins::updateEpins($request);

}
public function getPackageAmount($id, $type)
{
    // dd('askfldfh');
    $amount = MSendEpins::getPackageAmount($id, $type);

    return response()->json(['amount' => $amount]);
}


}
