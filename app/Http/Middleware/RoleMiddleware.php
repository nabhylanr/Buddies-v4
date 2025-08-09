<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return $next($request);
        }
        
        if ($user->hasRole($role)) {
            return $next($request);
        }
        
        if ($user->isUser()) {
            return redirect('/calendar')->with('error', 'You do not have permission to access this page.');
        } elseif ($user->isImplementor()) {
            return redirect('/dashboard')->with('error', 'You do not have permission to access this page.');
        }
        
        return redirect('/login');
    }
}