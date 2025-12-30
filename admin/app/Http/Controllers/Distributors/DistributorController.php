<?php

namespace Admin\App\Http\Controllers\Distributors;

use Admin\App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Session;
use Illuminate\Support\Facades\Validator;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\MemberLinks;
use Admin\App\Models\Master\Country;
use Admin\App\Models\Member\State;
use Admin\App\Models\Member\plan;

class  DistributorController extends Controller
{



  public function index()
  {

$data = Member::leftJoin(
        'ihook_matrix_members_link_table',
        'ihook_matrix_members_link_table.members_id',
        '=',
        'ihook_members_table.members_id'
    )
    ->select(
        'ihook_members_table.*',
        'ihook_matrix_members_link_table.link_id',
        'ihook_matrix_members_link_table.members_parents'
    )
    ->paginate(10);

        // Convert to array
        $dataArray = $data->toArray();

        // Add country and state to each member
        foreach ($dataArray['data'] as $key => $member) {
            // Get country details
        $countryDetails = getCountryByCode($member['members_country']);
        $dataArray['data'][$key]['country_name'] = $countryDetails->country_master_name ?? null;

            // Get state details (assuming you have a function getStateDetails)
        $stateDetails = getStatesWithId($member['members_state']);
        $dataArray['data'][$key]['state_name'] = $stateDetails->state_name ?? null;
        }


        // dd($dataArray);
        // exit;
        return view('admin::distributors.distributors', [
            'data' => $dataArray['data'], 
            'paginator' => $data           
        ]);
  }


  public function checkEmail(Request $request)
       {
            $request->validate([
                'email' => 'required|email',
            ]);
            $email = $request->input('email');
            $exists = Member::where('members_email', $email)->exists();
            return response()->json(['exists' => $exists]);
        }

public function checkUsername(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50', 
        ]);

        $username = $request->input('username');

        $exists = Member::where('members_username', $username)->exists();

        return response()->json(['exists' => $exists]);
    }


public function fetchState(Request $request)
    {
        $states = getStatesByCountryCode($request->sortname);
        return response()->json(['states' => $states]);
    }
public function adddistrbutors()
  {
      return view('admin::distributors.adddistributors');
  }
public function add(Request $request)
    {
          $validator = Validator::make($request->all(), [
            'txtusername' => 'required',
             'members_email' => 'required|email|unique:ihook_members_table,members_email',
            'txtfirstname' => 'required',
            'txtlastname' => 'required',
            'txtpassword' => 'required|min:8',
            'txtrepassword' => 'required|min:8|same:password',
            'txtaddress' => 'required',
            'phone' =>  ['required', 'regex:/^[6-9][0-9]{9}$/'],
            'members_state' => 'required',
            'members_city'=>'required',
            'members_country' => 'required',
            'matrix_id' => 'required',
            'txtzipcode'=>'required'
        ]);


        $data = $request->all();
             
        // Member creation
        $member = new Member();
        $member->members_username = $data['txtusername'];
        $member->members_firstname = $data['txtfirstname'];
        $member->members_lastname = $data['txtlastname'];
        $member->members_email = $data['members_email'];
        $member->members_password = Hash::make($data['txtpassword']);
        $member->members_address = $data['txtaddress'];
        $member->members_country = $data['members_country'];
        $member->members_state = $data['members_state'];
        $member->members_city = $data['members_city'];
        $member->members_zip = $data['txtzipcode'];
        $member->members_phone = $data['phone'];
        $member->save();
                 
        if($member->id)
        {  
            // memberlink entry
            $memberId = $member->id;
            $memberLink = new MemberLinks();
            $memberLink->members_id = $memberId;
            $memberLink->matrix_id = $data['matrix_id']; 
            $memberLink->spillover_id=$data['sponsor_id'];
            $memberLink->members_subscription_plan=$data['view_packages'];
            $memberLink->members_subscription_date = date('Y-m-d');
            $memberLink->save();
        }
        // dd($memberLink);exit;
     // Redirect to distributors page with a success message
      return redirect()
    ->route('admin.distributors.index')
    ->with('success', 'Member has been successfully registered!');
    }

}