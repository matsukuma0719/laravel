<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{

    protected $middleware = [

        \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
    ];


    protected $middlewareGroups = [
        'web' => [
             \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,

        ],

        'api' => [
   
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'check.api.key' => \App\Http\Middleware\CheckApiKey::class,
        'allow.only.specific.ip' => \App\Http\Middleware\AllowOnlySpecificIp::class,

        // 他のミドルウェア
    ];
}
