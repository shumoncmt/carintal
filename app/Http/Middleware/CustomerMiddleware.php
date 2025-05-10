<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isCustomer()) {
            return $next($request);
        }
        // abort(403, 'Unauthorized action.');
        return redirect('/login')->with('error', 'Please login to access this page.');
    }
}
