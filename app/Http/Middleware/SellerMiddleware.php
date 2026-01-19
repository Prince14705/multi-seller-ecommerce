<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if user is a seller
        $user = Auth::user();
        
        // Assuming you have a 'role' column in users table
        // Or you can check if user has a store
        if (!$user->is_seller && !$user->hasRole('seller')) {
            // If user is admin, allow access to seller dashboard
            if ($user->is_admin) {
                return $next($request);
            }
            
            abort(403, 'Access denied. Seller privileges required.');
        }

        // Check if seller is approved (if your system has approval process)
        if (isset($user->is_approved) && !$user->is_approved) {
            // Still allow access but show warning
            // You can add a flash message here if needed
        }

        return $next($request);
    }
}