<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Here you may specify an array of paths that should be checked for your views.
    | Of course, the usual Laravel view path is already registered for you.
    |
    */

    'paths' => [
        resource_path('views'),
        base_path('admin/resources/views'),
        base_path('user/resources/views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be stored.
    | Typically, this is within the storage directory. You're free to change it.
    |
    */

    'compiled' => env('VIEW_COMPILED_PATH', realpath(storage_path('framework/views'))),

];
