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