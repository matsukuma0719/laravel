<?php

// app/Http/Middleware/AllowOnlySpecificIp.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AllowOnlySpecificIp
{
    public function handle(Request $request, Closure $next)
    {
        $allowedIps = ['35.74.155.180'];
        if (!in_array($request->ip(), $allowedIps)) {
            abort(403, 'Unauthorized IP address.');
        }
        return $next($request);
    }
}

