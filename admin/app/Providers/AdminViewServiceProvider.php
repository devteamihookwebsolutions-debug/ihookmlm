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
