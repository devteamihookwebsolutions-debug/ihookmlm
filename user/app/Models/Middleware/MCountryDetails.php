<?php

use Illuminate\Support\Facades\DB;
use User\App\Models\Country;



if (!function_exists('getAllCountries')) {
    function getAllCountries()
    {
        return Country::get(['country_master_name', 'sortname']);
    }
}


