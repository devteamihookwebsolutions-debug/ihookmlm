<?php

namespace Admin\App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register sub-providers
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(AdminViewServiceProvider::class);
    }

    public function boot(): void
    {
        // Load all helper files in Middleware folder
            foreach (glob(__DIR__ . '/../Models/Middleware/*.php') as $filename) {
                require_once $filename;
            }
        // Add a view namespace for the admin module
        View::addNamespace('admin', base_path('admin/resources/views'));
        // Load views and routes for the admin module
        $this->loadViewsFrom(base_path('admin/resources/views'), 'admin');
        $this->loadRoutesFrom(base_path('admin/routes/web.php'));

      
    }
}
