<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AllowOnlySpecificIp
{
    // 許可するIPアドレス（複数可）
private $allowedIps = [
    '127.0.0.1',
    '::1',
    // 一時的に全部許可したいなら '*' や '0.0.0.0' など
];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // クライアントIPを取得
        $clientIp = $request->ip();

        if (!in_array($clientIp, $this->allowedIps)) {
            // アクセス拒否（403 Forbidden）
            abort(403, 'Forbidden.');
        }

        return $next($request);
    }
}
