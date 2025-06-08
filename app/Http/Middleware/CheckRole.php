<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Ensure the user is authenticated and has the correct role_id
        if (Auth::check() && Auth::user()->role_id == $role) {
            return $next($request); // Proceed if role matches
        }

        // Redirect with an error message if the role doesn't match
        return redirect('/login')->withErrors(['role' => 'Access Denied']);
    }
}

