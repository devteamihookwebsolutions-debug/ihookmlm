<?php

/**
 * This class contains public functions related to MFindSponsor
 *
 * @package         MFindSponsor
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
use Illuminate\Support\Facades\DB;
use Admin\App\Models\Middleware\MSiteDetails;


class MFindSponsor
{
    /**
     * This public function is used  to get sponsor list from mlm
     *
     */
    public function getSponsorDetails()
    {
        // Get site URL from settings
        $sitesettingsurldetails = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="site_url"');
        $site_url = $sitesettingsurldetails[0]['sitesettings_value'];

        // Get WooCommerce path from settings
        $woocommerce_pathdetails = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="woocommerce_path"');
        $woocommerce_path = $woocommerce_pathdetails[0]['sitesettings_value'];
        $woocommerce_pathparse = explode('://', $woocommerce_path);
        $woocommerce_pathdomain = $woocommerce_pathparse[1];

        // Get country list
        $countryList = new MCountryList();
        $country = $countryList->getCountryList();

        echo '<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
            <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <div id="showsearch" style="margin-top: 100px;">
            <div class="row">
                <h2 style="text-align:center;">Find a Distributor</h2>
                <p style="text-align:center;">To find a distributor in your area, enter your search criteria(s) and click search.</p>
                <form class="form-horizontal" action="/action_page.php">
                    <div class="form-group row">
                        <div class="col-md-5 col-md-offset-5">
                            <div class="col-md-5 ">
                                <input aria-label="label" type="number" class="form-control" id="zipcode" placeholder="Zip/Postal Code" name="zipcode">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="text-align:center;"><p>-or-</p></div>
                    <div class="form-group row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="col-md-5 ">
                                ' . $country . '
                                <input aria-label="label" type="hidden" class="form-control" id="countryid" name="countryid" value="">
                            </div>
                            <div class="col-md-2" style="text-align: center;"><p style="margin-top: 5px;">-or-</p></div>
                            <div class="col-md-5 ">
                                <select aria-label="label" id="state" class="text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500" name="state" required><option value="0">Select state</option></select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="cent"><button aria-label="button" onclick="myPublicFunction()" class="btn btn-success">Find</button></div>
        </div>
        <div id="showtable"></div>
        <div id="showsponsor" style="margin-top: 50px;"></div>

        <style>
        .cent { text-align: center; }
        #et-secondary-nav .menu-item-has-children>a:first-child:after, #top-menu .menu-item-has-children>a:first-child:after { top: 10px; }
        .et-cart-info span:before { top: 10px; position: absolute; }
        #et_search_icon:before { top: 6px; left: 13px; }
        #top-menu li { padding-right: 0px; }
        </style>

        <script>
        // Fetch the states for the selected country
        function getState(id) {
            document.getElementById("countryid").value = id;

            var xhr = new XMLHttpRequest();
            xhr.open(\'GET\', "' . $site_url . '/getstatelistforwp/state/" + id, true);
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    document.getElementById("state").innerHTML = xhr.responseText;
                }
            };
            xhr.onerror = function() {
                console.error(\'Error fetching states.\');
            };
            xhr.send();
        }

        // Find distributors based on selected country, state, or zip
        function myPublicFunction() {
            var countryId = document.getElementById("countryid").value;
            var stateId = document.getElementById("state").value;
            var postalCode = document.getElementById("zipcode").value;

            if (countryId !== "" && stateId !== "") {
                var xhr = new XMLHttpRequest();
                xhr.open(\'GET\', "' . $site_url . '/getdistribtr/distrbtr/" + countryId + "/" + stateId, true);
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        if (xhr.responseText !== "No matching results") {
                            document.getElementById("showsearch").style.display = "block";
                            document.getElementById("showtable").innerHTML = xhr.responseText;
                        } else {
                            document.getElementById("showsearch").style.display = "block";
                            document.getElementById("showtable").innerHTML = xhr.responseText;
                        }
                    }
                };
                xhr.send();
            }

            if (postalCode) {
                var xhrPostal = new XMLHttpRequest();
                xhrPostal.open(\'GET\', "' . $site_url . '/getdistribtrbyzip/distrbtrbyzip/" + postalCode, true);
                xhrPostal.onload = function() {
                    if (xhrPostal.status >= 200 && xhrPostal.status < 300) {
                        if (xhrPostal.responseText !== "No matching results") {
                            document.getElementById("showsearch").style.display = "block";
                            document.getElementById("showtable").innerHTML = xhrPostal.responseText;
                        }
                    }
                };
                xhrPostal.send();
            }
        }

        // Show distributor information
        function showDistributor(val) {
            var xhr = new XMLHttpRequest();
            xhr.open(\'GET\', "' . $site_url . '/getdistribtrspnsr/spnsr/" + val, true);
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    document.getElementById("showsearch").style.display = "none";
                    document.getElementById("showtable").style.display = "none";
                    document.getElementById("showsponsor").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        // Redirect to the distributor registration page
        function redirectRegister(memid) {
            var xhr = new XMLHttpRequest();
            xhr.open(\'GET\', "' . $site_url . '/getmemname/memname/" + memid, true);
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    window.location.href = "https://" + xhr.responseText + "." + "' . $woocommerce_pathdomain . '" + "/?dis=1";
                }
            };
            xhr.send();
        }

        // Show the search results page
        function showSearch() {
            window.location.href = "' . $woocommerce_path . '/find-distributor/";
            document.getElementById("showsearch").style.display = "block";
            document.getElementById("showtable").style.display = "none";
            document.getElementById("showsponsor").style.display = "none";
        }
        </script>';
    }


    public function getDistributors()
    {
        $country_id = isset($_GET['sub1']) ? $_GET['sub1'] : '';
        $state_id   = isset($_GET['sub2']) ? $_GET['sub2'] : '';
        $prefix = config('services.ihook.prefix');

        if ($state_id == '0') {
            $results = DB::table($prefix . '_members_table')
                ->where('members_country', $country_id)
                ->get();
        } else {
            $results = DB::table($prefix . '_members_table')
                ->where('members_country', $country_id)
                ->where('members_state', $state_id)
                ->get();
        }

        // Convert collection of objects to array of associative arrays for existing code compatibility
        $records = array_map(function ($item) {
            return (array) $item;
        }, $results->all());

        // initialize output
        $output = '';
        $output .= '<div id="recordtable">
              <div class="container" style="width:100% !important">
                  <h2><center>Distributors near you</center></h2>
                  <p><center>Please select a distributor from the list below. Or <a href="javascript:void(0);" onclick="showsearch(); return false;">click here  </a> to start over.</center></p>
                  <table class="table">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>CITY</th>
                        <th>STATE</th>
                        <th>ACTION</th>
                      </tr>
                    </thead>
                    <tbody>';
        // instantiate list helpers to call instance methods
        $countryList = new MCountryList();
        $stateList   = new MStateList();
        $cityList    = new MCityList();

        $total = \count($records);
        for ($i = 0; $i < $total; $i++) {
            $country_name = $countryList->getCountryName($records[$i]['members_country']);
            $state_name   = $stateList->getStateName($records[$i]['members_state']);
            $city_name    = $cityList->getCityName($records[$i]['members_city']);
            $output .= '  <tr>
                            <td>' . $records[$i]['members_id'] . '</td>
                            <td>' . $records[$i]['members_username'] . '</td>
                            <td>' . $city_name . '</td>
                            <td>' . $state_name . ',' . $country_name . '</td>
                             <td><button aria-label="button" onclick="showdistributor(' . $records[$i]['members_id'] . ');" class="btn btn-warning">SELECT</button></td>
                          </tr>';
        }
        $output .= '</tbody>
                  </table>
                </div>
            </div>';
        if (!empty($records)) {
            echo $output;
        } else {
            echo "<p><center>No matching results.</center></p>";
        }
    }

    public function getDistributorsbyZip()
    {
        $zipcode = isset($_GET['sub1']) ? trim($_GET['sub1']) : '';
        $prefix = config('services.ihook.prefix');

        if ($zipcode === '') {
            echo '<p><center style="color:red;">No matching results.</center></p>';
            return;
        }

        // Try common postal code column names; adjust columns if your schema differs
        $results = DB::table($prefix . '_members_table')
            ->where(function ($q) use ($zipcode) {
                $q->where('members_postalcode', $zipcode)
                  ->orWhere('members_zip', $zipcode)
                  ->orWhere('members_postal_code', $zipcode);
            })
            ->get();

        // Convert collection of objects to array of associative arrays for existing code compatibility
        $records = array_map(function ($item) {
            return (array) $item;
        }, $results->all());

        // initialize output
        $output = '';
        $output .= '<div id="recordtable">
              <div class="container" style="width:100% !important">
                  <h2><center>Distributors near you</center></h2>
                  <p><center>Please select a distributor from the list below. Or <a href="javascript:void(0);" onclick="showsearch(); return false;">click here  </a> to start over.</center></p>
                  <table class="table">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>CITY</th>
                        <th>STATE</th>
                        <th>ACTION</th>
                      </tr>
                    </thead>
                    <tbody>';
        // instantiate list helpers to call instance methods
        $countryList = new MCountryList();
        $stateList   = new MStateList();
        $cityList    = new MCityList();

        $total = \count($records);
        for ($i = 0; $i < $total; $i++) {
            $country_name = $countryList->getCountryName($records[$i]['members_country']);
            $state_name   = $stateList->getStateName($records[$i]['members_state']);
            $city_name    = $cityList->getCityName($records[$i]['members_city']);
             $output .= '  <tr>

                            <td>' . $records[$i]['members_id'] . '</td>
                            <td>' . $records[$i]['members_username'] . '</td>
                            <td>' . $city_name . '</td>
                            <td>' . $state_name . ',' . $country_name . '</td>
                            <td><button aria-label="button" onclick="showdistributor(' . $records[$i]['members_id'] . ');" class="btn btn-warning">SELECT</button></td>
                          </tr>';
        }
        $output .= '</tbody>
                  </table>
                </div>
            </div>';
        if ($records != '') {
            echo $output;
        } else {
            echo '<p><center style="color:red;">No matching results.</center></p>';
        }
    }

    public function getDistribtrSponsor()
    {
        $prefix = config('services.ihook.prefix');

        $spnsr_id = isset($_GET['sub1']) ? (int) $_GET['sub1'] : 0;

        // Use Laravel's DB facade (fully-qualified to avoid adding use statements)
        $member = DB::table($prefix . '_members_table')
            ->where('members_id', $spnsr_id)
            ->first();

        if (!$member) {
            echo '<p><center>No matching results.</center></p>';
            return;
        }

        $id = htmlspecialchars($member->members_id, ENT_QUOTES, 'UTF-8');
        $username = htmlspecialchars($member->members_username, ENT_QUOTES, 'UTF-8');

        $output = '<div id="sopnsordetail">'
            . '<div class="container" style="width:100% !important">'
            . '<h2><center>Selected Sponsor</center></h2>'
            . '<p><center>You have chosen to enroll under ' . $id . ', ' . $username . '. If this is the individual you would like to enroll under, click "OK". If this is not the individual you would like to enroll under, click "Cancel" and use the search feature to identify your desired sponsor.</center></p>'
            . '<h1><center>Your sponsor will be: ' . $id . ', ' . $username . '</center></h1>'
            . '</div>'
            . '<div class="cent"><button aria-label="button" onclick="redirectregister(' . $id . ');" class="btn btn-default">OK</button>&nbsp;<button aria-label="button" onclick="showsearch()" class="btn btn-danger">CANCEL</button></div>'
            . '</div>';

        echo $output;
    }

    /**
    * This public function is used to get members name
    * @param int $memid
    * @return string
    */
    public function getMembername($memid)
    {
        $prefix = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');

        $id = (int) $memid;
        $member = DB::table($prefix . '_members_table')
            ->where('members_id', $id)
            ->select('members_username')
            ->first();

        return $member ? $member->members_username : '';
    }

}
