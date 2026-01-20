<?php

/**
 * This class contains public functions related to AdminServiceProvider
 *
 * @package         AdminServiceProvider
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
