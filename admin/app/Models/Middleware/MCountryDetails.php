<?php

use Admin\App\Models\Member\Country;

if (!function_exists('getAllCountries')) {
    function getAllCountries()
    {
        return Country::select('country_master_name', 'sortname')->get();
    }
   if (!function_exists('getCountryByCode')) {
    function getCountryByCode($code)
    {
        return Country::where('sortname', $code)  // or 'country_code', depending on table
                      ->select('country_master_name', 'sortname')
                      ->first();
    }
}
}
