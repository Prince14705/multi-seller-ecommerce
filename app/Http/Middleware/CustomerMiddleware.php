<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if user is customer
        if (Auth::user()->role !== 'customer') {
            return redirect()->route('home')->with('error', 'Access denied.');
        }

        return $next($request);
    }
}