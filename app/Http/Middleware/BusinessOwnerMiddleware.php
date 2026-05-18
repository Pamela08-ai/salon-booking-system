<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class BusinessOwnerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Only business owners should access the management pages.
        if (!Auth::check() || Auth::user()->role !== 'business_owner') {

            return redirect('/');

        }

        return $next($request);
    }
}
