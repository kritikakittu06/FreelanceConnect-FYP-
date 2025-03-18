<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::check() && Auth::user()->role->value === $role) {
            return $next($request);
        }
        return redirect('/')->with('toast.error', 'Unauthorized'); // Redirect if unauthorized
    }
}
