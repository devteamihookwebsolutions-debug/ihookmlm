<?php

/**
 * This class contains public functions related to PVDetailsController
 *
 * @package         PVDetailsController
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace User\App\Http\Controllers\Reports;

use User\App\Http\Controllers\Controller;
use User\App\Models\Reports\MPVDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class  PVDetailsController extends Controller
{
    public function showPVDetails(Request $request)
    {


        try {

                   // Logged-in user ID
            $user_id = Auth::user()->members_id;

            $startdate = $request->input('start-date', '');
            $enddate   = $request->input('end-date', '');

            //  MPVDetails::getGPVHistory($request);

            // Get PV data using your model
            $pvdata = MPVDetails::getPVAndGPVHistory($user_id, $startdate, $enddate);

            // Send data to Blade
            return view('user::reports.pvdetails', [
                'startdate' => $startdate,
                'enddate'   => $enddate,
                'pvdata'    => $pvdata
            ]);

            // dd($pvdata);
        } catch (\Exception $e) {

            // Store error
            session()->flash('error_message', $e->getMessage());

            // Redirect
            return redirect()->route('user.dashboard');
        }
    }

}
