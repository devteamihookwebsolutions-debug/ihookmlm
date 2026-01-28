<?php

/**
 * This class contains public functions related to MInsertUserDetails
 *
 * @package         MInsertUserDetails
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Models\UserManager;

use Admin\App\Models\ShopAncillary\MShopUserInsert;
use User\App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        $members_subdomain_name = $members_username;
        $scheme = env('SCHEME', 'https');
        $basePath = env('BASEPATH', 'https://example.com');
        $baseHost = preg_replace('#^https?://#', '', $basePath);
        $subdomain = $members_subdomain_name ?: $members_username;
        $members_subdomain = $scheme . '://' . strtolower($subdomain) . '.' . $baseHost;

        $member = new Member();
        $member->members_username   = $members_username;
        $member->members_firstname  = $members_firstname;
        $member->members_lastname   = $members_lastname;
        $member->members_email      = $members_email;
        $member->members_password   = $members_password;
        $member->members_dob        = $members_dob;
        $member->members_address    = $members_address;
        $member->members_country    = $members_country;
        $member->members_state      = $members_state;
        $member->members_city       = $members_city;
        $member->members_zip        = $members_zip;
        $member->members_phone      = $members_phone;
        $member->members_doj        = now();
        $member->members_payment_id = $members_payment_id;
        $member->members_ein_number = $epin_code ?? null;

        $member->save();
        $members_id = $member->members_id;

        Log::info("New member created successfully", [
            'members_id' => $members_id,
            'username'   => $members_username,
            'email'      => $members_email,
            'doj'        => $member->members_doj
        ]);

        // EPIN update logic
        if (!empty($epin_code)) {
            DB::table('ihook_epin_table')
                ->where('epin_code', $epin_code)
                ->where('epin_status', 0)
                ->update([
                    'epin_status'    => 1,
                    'epin_user_id'   => $members_id,
                    'epin_used_date' => now()->format('Y-m-d')
                ]);

            Log::info("EPIN marked as used", [
                'epin_code'   => $epin_code,
                'used_by_id'  => $members_id
            ]);
        }

            Log::info("Preparing to create shop user account", [
                'username' => $members_username,
                'email'    => $members_email,
                'doj'      => $member->members_doj
            ]);

            $rest_shop_id = MShopUserInsert::insertShopUsers(
                $members_username,
                $members_password,
                $members_email,
                $member->members_doj,
                $members_firstname,
                $members_lastname,
                $members_phone,
                $members_address,
                $members_city,
                $members_zip,
                $members_state,
               $members_country
            );

            Log::info("Shop user insert completed successfully", [
                'rest_shop_id'      => $rest_shop_id,
                'members_id'        => $members_id,
                'username'          => $members_username,
                'email'             => $members_email
            ]);


        return $members_id;
    }
}
