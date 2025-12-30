<?php

namespace User\App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register sub-providers (recommended)
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(UserViewServiceProvider::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         // Load all helper files in Middleware folder
            foreach (glob(__DIR__ . '/../Models/Middleware/*.php') as $filename) {
                require_once $filename;
            }
        // Add a view namespace for the admin module
        View::addNamespace('user', base_path('user/resources/views'));
        // Load module-specific views and routes
        $this->loadViewsFrom(base_path('user/resources/views'), 'user');
        $this->loadRoutesFrom(base_path('user/routes/web.php'));
        $this->commands([
        \User\App\Console\Commands\RankUpgradeCron::class,
        \User\App\Console\Commands\ProcessRankLevelCommission::class,
        ]);
    }
}
