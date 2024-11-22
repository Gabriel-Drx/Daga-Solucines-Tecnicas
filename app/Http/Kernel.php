<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ];

    protected $routeMiddleware = [
        // Otros middlewares
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.custom' => \App\Http\Middleware\AuthMiddleware::class, // Middleware personalizado
        'checkUserSession' => \App\Http\Middleware\CheckUserSession::class,
        'authlogin' => \App\Http\Middleware\TestMiddleware::class,
        'nocache' => \App\Http\Middleware\NoCache::class,


    ];
    
}

