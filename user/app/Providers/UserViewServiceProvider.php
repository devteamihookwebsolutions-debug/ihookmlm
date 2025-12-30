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
