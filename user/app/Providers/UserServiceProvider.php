<?php

/**
 * This class contains public functions related to UserServiceProvider
 *
 * @package         UserServiceProvider
 * @category        Provider
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
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
