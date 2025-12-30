<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('hjksdhfk');
// });

// Include your admin module routes
require base_path('admin/routes/web.php');
require base_path('user/routes/web.php');