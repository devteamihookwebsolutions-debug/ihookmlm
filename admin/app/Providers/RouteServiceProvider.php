<?php

namespace Admin\App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
        Route::middleware('web')
            ->prefix('admin')
            ->as('admin.')               // <-- THIS IS THE KEY
            ->namespace('Admin\App\Http\Controllers')
            ->group(base_path('admin/routes/web.php'));
        });
    }
}
