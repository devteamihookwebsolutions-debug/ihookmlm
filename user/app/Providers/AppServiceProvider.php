<?php

namespace User\App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        foreach (glob(app_path('Models/Middleware') . '/*.php') as $filename) {
        require_once $filename;
    }
    }
}
