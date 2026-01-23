<?php

/**
 * This class contains public functions related to UserViewServiceProvider
 *
 * @package         UserViewServiceProvider
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

namespace User\App\Providers;

use Illuminate\Support\ServiceProvider;

class UserViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Add your user views folder as a namespaced path
        $this->loadViewsFrom(base_path('user/resources/views'), 'user');
    }
}
