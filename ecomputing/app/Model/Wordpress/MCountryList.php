<?php

/**
 * This class contains public functions related to MCountryList
 *
 * @package         MCountryList
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

namespace Ecomputing\App\Model\Wordpress;

use Illuminate\Support\Facades\DB;
use Admin\App\Models\Middleware\MSiteDetails;


class MCountryList
{
    public function getCountryDetails()
    {
        // Get site URL from settings
        $sitesettingsurldetails = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="site_url"');
        $site_url = $sitesettingsurldetails[0]['sitesettings_value'];

        // Get the country list
        $country = self::getCountryList();

        echo '<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
            <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <div class="row">
            <div class="form-group row">
                <div class="col-md-12 col-md-offset-0">
                    <div class="col-md-12 ">
                        <label for="reg_username">Country <span class="required" style="color:red;">*</span></label>
                        ' . $country . '
                        <input aria-label="label" type="hidden" class="form-control" id="countryid" name="countryid" value="">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group row">
                <div class="col-md-12 col-md-offset-0">
                    <div class="col-md-12 ">
                        <label for="reg_username">State <span class="required" style="color:red;">*</span></label>
                        <select aria-label="label" id="state" class="text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500" name="state" style="height: 50px;" required><option value="0">Select state</option></select>
                    </div>
                </div>
            </div>
        </div>

        <script>
        // Define the function to fetch states based on the country ID
        function getStateForWp(id) {
            // Set the countryid value to the hidden input element
            document.getElementById("countryid").value = id;

            // Get the site URL from PHP
            var site_url = "' . $site_url . '"; // PHP variable embedded in JavaScript

            // Create a new XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Configure the GET request
            xhr.open("GET", site_url + "/getstatelistforwp/state/" + id, true);

            // Set up the callback function for when the request is successful
            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    // On success, populate the state dropdown with the result
                    document.getElementById("state").innerHTML = xhr.responseText;
                } else {
                    console.error(\'Request failed with status: \' + xhr.status);
                }
            };

            // Set up the callback function for when the request fails
            xhr.onerror = function () {
                console.error(\'Network error while fetching state list\');
            };

            // Send the request
            xhr.send();
        }
        </script>';
    }


    public function getCountryList()
    {
        $prefix = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');

        $table = $prefix . '_country_master_table';
        $records = DB::table($table)->orderBy('country_master_id', 'asc')->get();

        $html  = '<select aria-label="label" id="country" class="text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500" name="country" onchange="getStateForWp(this.value)" style="height: 50px;" required>';
        $html .= '<option value="0">Select country</option>';

        if ($records && $records->count() > 0) {
            foreach ($records as $row) {
                $id = isset($row->country_master_id) ? $row->country_master_id : '';
                $name = isset($row->country_master_name) ? $row->country_master_name : '';
                // Escape output
                $html .= '<option value="' . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</option>';
            }
        }

        $html .= '</select>';

        return $html;
    }
    /**
     * This public function is used  to get country name
     * @param int $country_id
     * @return  string
     */
    public function getCountryName($country_id)
    {
        $prefix = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');

        $table = $prefix . '_country_master_table';
        $country_id = intval($country_id);

        $name = DB::table($table)
            ->where('country_master_id', $country_id)
            ->value('country_master_name');

        return $name !== null ? (string) $name : '';
    }

}

