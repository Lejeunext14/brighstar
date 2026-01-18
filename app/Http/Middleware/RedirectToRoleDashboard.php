<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectToRoleDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Check if user was just authenticated in this request
        if (auth()->check() && session()->has('auth.password_confirmed_at')) {
            $user = auth()->user();
            
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($user->role === 'teacher') {
                return redirect('/teacher/dashboard');
            } elseif ($user->role === 'parent') {
                return redirect('/parent/dashboard');
            }
        }
        
        return $response;
    }
}
