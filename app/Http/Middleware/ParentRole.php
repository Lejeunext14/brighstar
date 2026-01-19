<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ParentRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'parent') {
            return $next($request);
        }

        abort(403, 'Unauthorized access. Parent role required.');
    }
}
