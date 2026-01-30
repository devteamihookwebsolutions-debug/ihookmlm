<?php

/**
 * This class contains public functions related to UserLeadController
 *
 * @package         UserLeadController
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized
 *     to redistribute it and/or modify/and or sell it under any publication
 *     either user and enterprise versions of the License (or) any later version
 *     is applicable for the same. If you have received this software without a
 *     license, you must not use it, and you must destroy your copy of it immediately.
 *     If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/


?>
<?php
namespace User\App\Http\Controllers\Lead;

use User\App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use User\App\Models\Lead\LeadContact;

use Illuminate\Support\Facades\Auth;
use Admin\App\Models\Member\Country;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\State;
use Carbon\Carbon;

class UserLeadController extends Controller
{

    public function create()
    {

        $countries = Country::getCountries();
        // echo '<pre>';
        // print_r($countries);exit();
        return view('user::lead.addleadcontact', compact('countries'));
    }

    public function getStates($country_sortname)
    {
        $states = State::getStatesByCountryCode($country_sortname);
        // echo '<pre>';
        // print_r($states);exit();
        return response()->json($states);
    }

    public function checkEmail(Request $request)
    {
        $email = $request->email;
        $exists = LeadContact::checkEmail($email);
        return response()->json(['exists' => $exists]);
    }




    public function store(Request $request)
    {
        // $prefix = config('services.ihook.prefix', 'ihook');
        $validated = $request->validate([
            'fname'        => 'required|string|max:255',
            'lname'        => 'required|string|max:255',
            'phonenumber'  => 'required|string|max:20',
            'email'        => 'required|email|max:255|',
            'address'      => 'required|string|max:255',
            'country'      => 'required|string|max:10',
            'state'        => 'required|string|max:255',
            'city'         => 'required|string|max:255',
            'zipcode'      => 'required|string|max:20',

            'task'         => 'required|string|max:255',
            'birthday'     => 'required|date',
            'socialmedia'  => 'required|string|max:255',
            'tag'          => 'required|string',
            'note'         => 'required|string',
        ], [
            'email.unique' => 'This E-mail Already Exists',
            'email.required' => 'Email is required',
            'email.email' => 'Enter a valid email address',
            '*.required' => 'This field is required.',
        ]);

        $birthday = null;
        if ($request->birthday) {
            $birthday = Carbon::createFromFormat('m/d/Y', $request->birthday)
            ->format('Y-m-d');
        }

        $memberEmail = Auth::user()->members_id;
        // echo '<pre>';
        // print_r($memberEmail);exit();
        // $memberId = Member::getMemberId($memberEmail);

        LeadContact::create([
            'leads_member_id'   => $memberEmail,
            'leads_first_name' => $request->fname,
            'leads_last_name'  => $request->lname,
            'leads_phonenumber'=> $request->phonenumber,
            'leads_email'      => $request->email,
            'leads_address'    => $request->address,
            'leads_city'       => $request->city,
            'leads_state'      => $request->state,
            'leads_country'    => $request->country,
            'leads_notes'      => $request->note,
            'leads_task'       => $request->task,
            'leads_birthday'   => $birthday,
            'leads_social'     => $request->socialmedia,
            'leads_tag'        => $request->tag,
            'leads_status'     => 1,

            'created_on'       => now(),
            'modify_on'        => now(),
        ]);

       return redirect()->back()->with('success', 'Lead created successfully!');
    }


     public function allLeads()
    {
        $member_id = Auth::user()->members_id;
        $allLeads = LeadContact::getAllLeads($member_id);
        $userName = Member::getUser($member_id);

        // echo '<pre>';
        // print_r($userName);exit();

        return view('user::lead.allleads', compact('allLeads', 'userName'));
    }



}
