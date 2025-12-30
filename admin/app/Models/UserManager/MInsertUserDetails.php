<?php

namespace Admin\App\Models\UserManager;
use User\App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class MInsertUserDetails
{
public function insertUserDetails(
    $members_username,
    $members_password,
    $members_email,
    $members_firstname,
    $members_lastname,
    $members_state,
    $members_city,
    $members_address,
    $members_phone,
    $members_zip,
    $members_country,
    $members_from,
    $members_dob,
    $members_payment_id,
    $epin_code
) {

    $members_subdomain_name = $members_username ;
    $scheme = env('SCHEME', 'https');
    $basePath = env('BASEPATH', 'https://example.com');
    $baseHost = preg_replace('#^https?://#', '', $basePath);
    $subdomain = $members_subdomain_name ?: $members_username;
    $members_subdomain = $scheme . '://' . strtolower($subdomain) . '.' . $baseHost;

    $member = new Member();
    $member->members_username = $members_username ;
    $member->members_firstname = $members_firstname ;
    $member->members_lastname = $members_lastname ;
    $member->members_email = $members_email;
    $member->members_password = $members_password ;
    $member->members_dob = $members_dob;
    $member->members_address = $members_address ;
    $member->members_country = $members_country ;
    $member->members_state = $members_state ;
    $member->members_city = $members_city ;
    $member->members_zip = $members_zip ;
    $member->members_phone = $members_phone ;
    $member->members_doj = now();
    $member->members_payment_id = $members_payment_id ;
    $member->members_ein_number = $epin_code ?? null;
        // dd($member->save());

    $member->save();
    $members_id = $member->members_id;

       if (!empty($epin_code)) {
    DB::table('ihook_epin_table')
        ->where('epin_code', $epin_code)
        ->where('epin_status', 0)
        ->update([
            'epin_status'    => 1,
            'epin_user_id'   => $members_id,
            'epin_used_date' => now()->format('Y-m-d')
        ]);
}
    return $members_id;

    }
}
