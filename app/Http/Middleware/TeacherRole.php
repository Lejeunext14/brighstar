<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TeacherRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'teacher') {
            return $next($request);
        }

        abort(403, 'Unauthorized access. Teacher role required.');
    }
}
