<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

// Basic authentication routes
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// ADMIN ROUTES
Route::prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        if (!auth()->check()) {
            return redirect('/login');
        }
        
        if (auth()->user()->role !== 'admin') {
            return redirect('/home')->with('error', 'Admin access required');
        }
        
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_sellers' => \App\Models\User::where('role', 'seller')->count(),
            'total_products' => \App\Models\Product::count(),
            'total_orders' => \App\Models\Order::count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    })->name('admin.dashboard');

    // Orders Management
    Route::get('/orders', function () {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect('/home');
        }
        
        $orders = \App\Models\Order::with('user')->latest()->get();
        return view('admin.orders', compact('orders'));
    })->name('admin.orders');

    // Seller Management
    Route::get('/sellers', function () {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect('/home');
        }
        
        $sellers = \App\Models\User::where('role', 'seller')->get();
        return view('admin.sellers', compact('sellers'));
    })->name('admin.sellers');

    // Customer Management
    Route::get('/customers', function () {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect('/home');
        }
        
        $customers = \App\Models\User::where('role', 'customer')->get();
        return view('admin.customers', compact('customers'));
    })->name('admin.customers');

    // Categories Management
    Route::get('/categories', function () {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect('/home');
        }
        
        return view('admin.categories');
    })->name('admin.categories');

    // Customer Deposits
    Route::get('/deposits', function () {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect('/home');
        }
        
        return view('admin.deposits');
    })->name('admin.deposits');

    // Messages & Disputes
    Route::get('/messages', function () {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect('/home');
        }
        
        return view('admin.messages');
    })->name('admin.messages');

    // Payment Settings
    Route::get('/payment-settings', function () {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect('/home');
        }
        
        return view('admin.payment-settings');
    })->name('admin.payment-settings');

    // Language Settings
    Route::get('/language-settings', function () {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect('/home');
        }
        
        return view('admin.language-settings');
    })->name('admin.language-settings');
});

// SELLER ROUTES  
Route::get('/seller/dashboard', function () {
    if (!auth()->check()) {
        return redirect('/login');
    }
    
    if (auth()->user()->role !== 'seller' && auth()->user()->role !== 'admin') {
        return redirect('/home')->with('error', 'Seller access required');
    }
    
    $seller = auth()->user();
    $stats = [
        'total_products' => \App\Models\Product::where('seller_id', $seller->id)->count(),
        'total_orders' => 0,
        'pending_orders' => 0,
    ];
    
    return view('seller.dashboard', compact('stats'));
})->name('seller.dashboard');

// Basic product routes
Route::get('/products', function () {
    $products = \App\Models\Product::where('is_active', true)->get();
    return view('products.index', compact('products'));
})->name('products.index');