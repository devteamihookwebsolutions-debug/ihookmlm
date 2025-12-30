<?php

// Get base URL from .env
$base = rtrim(config('app.url'), '/') . '/';

return [

    'name' => env('APP_NAME', 'Laravel'),

    'env' => env('APP_ENV', 'production'),

    'debug' => (bool) env('APP_DEBUG', false),

    'url' => env('APP_URL', '/'),

    'timezone' => 'UTC',

    'locale' => env('APP_LOCALE', 'en'),
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    'cipher' => 'AES-256-CBC',
    'key' => env('APP_KEY'),
    'previous_keys' => [
        ...array_filter(explode(',', env('APP_PREVIOUS_KEYS', '')))
    ],

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

    'ADMINPATH'  => $base . ltrim(env('BCPATH', 'admin'), '/'),

    // Optional: Current panel (admin or user)
    'current_panel' => env('CURRENT_PANEL', 'user'),

    // Encryption key for SafeCrypto
    'encryption_key' => env('ENCRYPTION_KEY', 'fallback-secret-change-in-prod'),

    'helpers' => [
        Admin\App\Helpers\CurrencyHelper::class,
    ],

    'providers' => [

        // Laravel Core
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        // Admin Panel
        Admin\App\Providers\RouteServiceProvider::class,
        Admin\App\Providers\AdminServiceProvider::class,
        Admin\App\Providers\AdminViewServiceProvider::class,

        // User Panel
        User\App\Providers\UserServiceProvider::class,
        User\App\Providers\RouteServiceProvider::class,
        User\App\Providers\UserViewServiceProvider::class,
    ],

];
