<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Check if the authenticated user is an admin
            if (Auth::user()->role == 'admin') {
                // User is admin, proceed with the request
                return $next($request);
            } else {
                // User is not an admin, abort the request with a 403 Forbidden status
                return abort(403, 'Access Denied! You are not an admin.');
            }
        } else {
            // User is not authenticated, redirect to login page or return a 401 Unauthorized status
            // You can adjust this based on your application's needs
            return abort(401, 'Please log in first.');
        }
    }
}
