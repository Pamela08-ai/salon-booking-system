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
        // Only customers should access the booking pages.
        if (!Auth::check() || Auth::user()->role !== 'customer') {
            return redirect('/');
        }

        return $next($request);
    }
}
