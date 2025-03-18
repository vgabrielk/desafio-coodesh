<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureJsonRequest
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->expectsJson()) {
            $request->headers->set('Accept', 'application/json');
            $request->headers->set('Content', 'application/json');
        }

        return $next($request);
    }
}
