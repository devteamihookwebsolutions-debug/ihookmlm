<?php

/**
 * This class contains public functions related to MRegister
 *
 * @package         MRegister
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
?><?php

namespace Ecomputing\App\Model\Wordpress;
use Admin\App\Models\Middleware\MCryptoGraphy;
use Admin\App\Models\Middleware\MMatrixtTypeDetails;
use Admin\App\Models\Middleware\MMemberDetails;
use Admin\App\Models\PaymentConquest\MSpillover;
use Admin\App\Models\PaymentConquest\MStairStepCommission;
use Admin\App\Models\UserManager\MInsertUserDetails;
use Admin\App\Models\UserManager\MInsertUserMatrixLinkDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
class MRegister
{



    public function insertRegisterDetails()
    {
        $sponsor_username = trim(Request::post('sponsor'));
        $members_username = trim(Request::post('username'));
        $members_email    = trim(Request::post('email'));
        $members_password = trim(Request::post('password'));
        $members_zip      = trim(Request::post('zipcode'));
        $members_state    = trim(Request::post('state'));
        $members_country  = trim(Request::post('country'));
        $entry_criteria   = '1';  // only free matrix
        $members_ip_address = request()->ip();

        $prefix      = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');

        // Check if member already exists
        $existingMember = DB::table($prefix . 'members_table')
            ->where('members_username', $members_username)
            ->first();

        if ($existingMember) {
            return false; // Member already exists
        }

        // Get Shopify/WooCommerce user ID
        $shopUser = DB::table($storeprefix . 'users')
            ->where('user_login', $members_username)
            ->first();

        if (!$shopUser) {
            return false; // Shop user not found
        }

        $members_shop_id = $shopUser->ID;

        // Get sponsor details
        $sponsor = MMemberDetails::getPartMembersDetails('members_id', 'WHERE members_username="' . $sponsor_username . '"');
        $sponsor_id = $sponsor[0]['members_id'] ?? 0;

        // Get sponsor matrix
        $sponsorMatrix = DB::table($prefix . 'matrix_members_link_table')
            ->where('members_id', $sponsor_id)
            ->orderBy('link_id', 'asc')
            ->first();

        $matrix_id = $sponsorMatrix->matrix_id ?? 0;

        $matrixdetails = MMatrixtTypeDetails::getMatrixTypeDetails($matrix_id);
        $matrix_type_id = $matrixdetails['matrix_type_id'] ?? 0;
        $usertype = 'customer';

        // Encrypt password
        $members_password_crypt = MCryptoGraphy::encryptionData($members_password);
        // Create instance for user details insertion
        $userInsert = new MInsertUserDetails();
        $members_id = $userInsert->insertUserDetails(
            $members_username,
            $members_password_crypt,
            $members_email,
            $members_ip_address,
            $members_firstname ?? '',
            $members_lastname ?? '',
            $members_state,
            $members_city ?? '',
            $members_address ?? '',
            $members_address2 ?? '',
            $members_address3 ?? '',
            $members_phone ?? '',
            $members_zip,
            $members_country,
            $members_group_id ?? '',
            $members_alternate_email ?? '',
            $matrix_id,
            $members_from ?? '',
            $savedpath ?? '',
            $savedpath1 ?? '',
            $members_id_proof ?? '',
            $members_pan_tax_document ?? '',
            '',
            $members_shop_id,
            '',
            $members_username,
            $members_password
        );

        // Create instance for matrix link insertion
        $matrixLinkInsert = new MInsertUserMatrixLinkDetails();
        $matrixLinkInsert->insertUserMatrixLinkDetails(
            $members_id,
            $sponsor_id,
            $matrix_id,
            '',
            $entry_criteria,
            '',
            '',
            '',
            'shop_register',
            $usertype,
            $sponsor_username,
            '',
            '',
            'offline',
            $matrix_type_id,
            '',
            '',
            '',
            ''
        );


        // Handle spillover if applicable
        $direct_id   = $sponsor_id; // assuming direct_id as sponsor_id
        $spillover_id = 0;

        if ($spillover_id == 0 && $direct_id > 0) {
            MSpillover::setSpillover($members_id, $direct_id, $matrix_id, $matrix_type_id);

            if ($matrix_type_id == 7) { // Stair Step matrix
                $matrixRecord = DB::table($prefix . 'matrix_members_link_table')
                    ->where('members_id', $members_id)
                    ->where('matrix_id', $matrix_id)
                    ->first();

                $spillover_id = $matrixRecord->spillover_id ?? 0;

                MStairStepCommission::checkStairStep($spillover_id, $matrix_id, $members_id, $matrix_type_id);
            }
        }

        return true;
    }

    public function getCountryDetails()
    {
        $country = self::getCountryList();
        $site_url = url('/');

        echo '<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
            <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

            <div class="row">
                <div class="form-group row">
                    <div class="col-md-12 col-md-offset-0">
                        <div class="col-md-12 ">
                            <label for="reg_username">Country <span class="required" style="color:red;">*</span></label>
                            ' . $country . '
                            <input type="hidden" class="form-control" id="countryid" name="countryid" value="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group row">
                    <div class="col-md-12 col-md-offset-0">
                        <div class="col-md-12 ">
                            <label for="state">State <span class="required" style="color:red;">*</span></label>
                            <select id="state" name="state" class="text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500" style="height:50px;" required>
                                <option value="0">Select state</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            function getStateForWp(id) {
                // Set the countryid value
                document.getElementById("countryid").value = id;

                // Use the PHP site URL safely
                var site_url = "' . $site_url . '";

                // Make a GET request to fetch states
                fetch(site_url + "/getstatelistforwp/state/" + id)
                    .then(response => response.text())
                    .then(result => {
                        document.getElementById("state").innerHTML = result;
                    })
                    .catch(function(error) {
                        console.error("Error fetching state list:", error);
                    });
            }
            </script>';
    }

    public function getCountryList()
    {
        $prefix = config('services.ihook.prefix');

        // Fetch all countries
        $records = DB::table($prefix . 'country_master_table')
            ->orderBy('country_master_id', 'asc')
            ->get()
            ->toArray();

        if (!empty($records)) {
            // Convert to array of arrays (instead of stdClass objects)
            $recordsArray = array_map(function ($r) {
                return (array) $r;
            }, $records);

            // Call your DRegister helper to generate HTML/select options
            return DRegister::getCountryList($recordsArray, $Err ?? null);
        }

        return '';
    }

    public function getstatelistforwp($id)
    {
        $prefix = config('services.ihook.prefix');

        // Fetch all states for a given country
        $records = DB::table($prefix . 'state_table')
            ->where('country_id', $id)
            ->orderBy('state_name', 'asc')
            ->get()
            ->toArray();

        if (!empty($records)) {
            $recordsArray = array_map(function ($r) {
                return (array) $r;
            }, $records);

            // Call your DRegister helper to generate HTML options for states
            return DRegister::getstatelistforwp($recordsArray);
        }

        return '';
    }

}
