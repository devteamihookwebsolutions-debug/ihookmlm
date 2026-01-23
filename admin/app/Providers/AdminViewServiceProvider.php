<?php

/**
 * This class contains public functions related to AdminViewServiceProvider
 *
 * @package         AdminViewServiceProvider
 * @category        Provider
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Providers;

use Illuminate\Support\ServiceProvider;

class AdminViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Restrict views to only the Admin module
        config(['view.paths' => [base_path('admin/resources/views')]]);

        // Add optional view namespace (e.g., view('admin::dashboard'))
        $this->loadViewsFrom(base_path('admin/resources/views'), 'admin');
    }
}
