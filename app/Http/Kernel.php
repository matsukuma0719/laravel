<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * グローバルHTTPミドルウェア
     */
    protected $middleware = [
        // 省略：ここはデフォルトのままでOK
        \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
    ];

    /**
     * グループごとのミドルウェア
     */
    protected $middlewareGroups = [
        'web' => [
            // 省略
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // etc...
        ],

        'api' => [
            // 省略
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * 個別ルート用のミドルウェア
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,

      'allow.only.specific.ip' => \App\Http\Middleware\AllowOnlySpecificIp::class,

        // 他のミドルウェア
    ];
}
