<?php

use Admin\App\Models\Member\State;

if (!function_exists('getStatesWithId')) {
    /**
     * Get states by country code (e.g. 'IN') and return state_name + state_id
     *
     * @param string $countryCode
     * @return \Illuminate\Support\Collection
     */
    // function getStatesWithId($countryCode)
    // {
    //     return State::where('country_code', $countryCode)
    //                 ->get(['state_name', 'state_id']);
    // }


    function getStatesWithId($stateId)
    {
        return State::where('state_id', $stateId)   // correct PK
                    ->first(['state_name','state_id']);
    }
}



// if (!function_exists('getStatesByCountryCode')) {
//     function getStatesByCountryCode($countryCode)
//     {
//         return State::where('country_code', $countryCode)->get(['state_name']);
//     }
if (!function_exists('getStatesByCountryCode')) {
    function getStatesByCountryCode($countryCode)
    {
        return State::where('country_code', $countryCode)->get(['state_name','state_id']);
    }

}