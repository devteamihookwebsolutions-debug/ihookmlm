<?php

use Illuminate\Support\Facades\DB;
use User\App\Models\Payment;

if (!function_exists('getAllPayments')) {
    function getAllPayments()
    {
        return Payment::where('paymentsettings_status', 'Active')->get();
    }
}
