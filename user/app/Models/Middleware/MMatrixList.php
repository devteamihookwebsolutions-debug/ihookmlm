<?php

use Illuminate\Support\Facades\DB;
use User\App\Models\Plan;

if (!function_exists('getAllmatrixs')) {
    function getAllmatrixs()
    {
        return Plan::all();
    }
}