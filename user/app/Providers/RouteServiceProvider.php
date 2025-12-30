<?php

namespace User\App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                ->prefix('user')
                ->as('user.')                // <-- THIS IS THE KEY
                ->namespace('User\App\Http\Controllers')
                ->group(base_path('user/routes/web.php'));
                    });
    }
}
