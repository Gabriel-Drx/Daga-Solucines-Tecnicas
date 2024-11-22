<?php

return [

    'name' => env('APP_NAME', 'Laravel'),

    'env' => env('APP_ENV', 'production'),

    'debug' => (bool) env('APP_DEBUG', false),

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL', null),

    'timezone' => env('APP_TIMEZONE', 'UTC'),

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    'log_level' => env('LOG_LEVEL', 'debug'),

    'log_path' => storage_path('logs'),

    'security_headers' => [
        'strict_transport_security' => env('STRICT_TRANSPORT_SECURITY', 'max-age=31536000; includeSubDomains'),
        'content_security_policy' => env('CONTENT_SECURITY_POLICY', "default-src 'self';"),
    ],

    'filesystems' => [
        'default' => env('FILESYSTEM_DISK', 'local'),
    ],

    'cache' => [
        'default_store' => env('CACHE_STORE', 'file'),
        'prefix' => env('CACHE_PREFIX', 'laravel_cache'),
    ],

    'uuids' => [
        'default_version' => env('UUID_VERSION', 4),
    ],

    'queue' => [
        'default' => env('QUEUE_CONNECTION', 'sync'),
    ],

    'auth' => [
        'session_lifetime' => env('SESSION_LIFETIME', 120),
    ],

    'supported_locales' => ['en', 'es', 'fr'],

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

];
