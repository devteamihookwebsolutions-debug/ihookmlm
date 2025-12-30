<?php

use Illuminate\Support\Facades\DB;
use User\App\Models\Package;


if (!function_exists('getAllPackage')) {
    function getAllPackage()
    {
        return Package::all();
    }
}
if (!function_exists('getPackageById')) {
    function getPackageById($id)
    {
        return Package::where('package_id', $id)->first();
    }
}