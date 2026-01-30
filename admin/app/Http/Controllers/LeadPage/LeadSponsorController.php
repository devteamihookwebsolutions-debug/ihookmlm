<?php

/**
 * This class contains public functions related to LeadSponsorController
 *
 * @package         LeadSponsorController
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace Admin\App\Http\Controllers\LeadPage;

use Admin\App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Admin\App\Models\LeadPage\MLeadContacts;
use Admin\App\Models\Member\Country;
use Illuminate\Support\Facades\Auth;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\State;
use User\App\Models\lead\LeadContact;
use Admin\App\Models\Member\SiteSetting;
use Admin\App\Models\Middleware\MSendMail;
use Carbon\Carbon;
use Exception;

class  LeadSponsorController extends Controller
{

    public function index()
    {
        // echo 'hai';exit();

    }

    public function addLeads()
    {

    // dd('askjdfhk');
        $countries = Country::getCountries();
        return view('leadpage.addleadcontacts', compact('countries'));
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

     public function searchSponsor(Request $request)
    {
        $query = $request->get('q', '');
        $sponsors = Member::getMembers($query);
        return response()->json($sponsors);
    }




    public function store(Request $request)
    {
        // dd('function reached or not');
        $prefix = config('services.ihook.prefix');

        $request->validate([
            'sponsor' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'phonenumber' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
          'email' => 'required|email|max:255',
            'note' => 'required',
            'task' => 'required',
            'birthday' => 'required|date',
            'socialmedia' => 'required',
            'tag' => 'required',
        ]);

        // Get sponsor member
        // $sponsor = Member::where('members_username', $request->sponsor)->first();
        // $sponsor = Member::
        $sponsor = $request->sponsor;

        if (!$sponsor) {
            return back()->with('error', 'Sponsor not found.');
        }

   $birthday = null;

if (!empty($request->birthday)) {
    try {
        $birthday = Carbon::parse(trim($request->birthday))->toDateString();
    } catch (\Exception $e) {
        return back()->withErrors([
            'birthday' => 'Invalid birthday format',
        ]);
    }
}



        // Insert lead contact
        $lead = LeadContact::create([
            'leads_member_id' => $sponsor,
            'leads_first_name' => $request->fname,
            'leads_last_name' => $request->lname,
            'leads_phonenumber' => $request->phonenumber,
            'leads_address' => $request->address,
            'leads_city' => $request->city,
            'leads_state' => $request->state,
            'leads_country' => $request->country,
            'leads_email' => $request->email,
            'leads_notes' => $request->note,
            'leads_task' => $request->task,
            'leads_birthday' => $birthday,
            'leads_social' => $request->socialmedia,
            'leads_tag' => $request->tag,
            'leads_status'     => 1,
            'created_on'       => now(),
            'modify_on'        => now(),
        ]);


        // Check email notification setting
        $emailSetting = SiteSetting::where('sitesettings_name', 'email_notification_user')->first();

        if ($emailSetting && $emailSetting->sitesettings_value == '1') {

            // Get email template for lead registration
            $langId = session('sitelang_id', 1);

            $records = DB::table($prefix .'_mailtemplates_table')
                ->where('mail_default_name', 'lead_registration_mail')
                ->where('mail_status', 1)
                ->where('mail_lang', $langId)
                ->first();

            if (!$records) {
                $records = DB::table($prefix .'_mailtemplates_table')
                    ->where('mail_default_name', 'lead_registration_mail')
                    ->where('mail_status', 1)
                    ->where('mail_lang', 1)
                    ->first();
            }

            if ($records) {
                $message = $records->mail_content;

            $message = str_replace(
                '[name]',
                $request->fname . ' ' . $request->lname,
                $message
            );

            $message = str_replace(
                '[username]',
                $request->fname . ' ' . $request->lname,
                $message
            );

            $message = str_replace(
                '[email]',
                $request->email,
                $message
            );
                 MSendMail::send(
                $records,               // template record
                $request->email,        // TO email (IMPORTANT)
                $message,               // HTML content
                '',                     // cc
                '',                     // bcc
                ''                      // attachments
            );
            }

        }

        return back()->with('success', 'Contact added successfully.');
    }


}
