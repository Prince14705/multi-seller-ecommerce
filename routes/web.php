<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SellerController;

Route::get('/', function () {
    return view('welcome');
});

// Basic authentication routes
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// ADMIN ROUTES
Route::prefix('admin')->group(function () {
  
    // Admin Seller Management Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/sellers', [SellerController::class, 'index'])->name('sellers');
    Route::post('/sellers/{id}/approve', [SellerController::class, 'approve'])->name('sellers.approve');
    Route::post('/sellers/{id}/suspend', [SellerController::class, 'suspend'])->name('sellers.suspend');
    Route::get('/sellers/{id}', [SellerController::class, 'show'])->name('sellers.show');
});

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

    // Orders Management with filtering
    Route::get('/orders', function () {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect('/home');
        }
        
        $query = Order::with('user')->latest();

        // Apply filters
        if (request('status')) {
            $query->where('status', request('status'));
        }

        if (request('date_from')) {
            $query->whereDate('created_at', '>=', request('date_from'));
        }

        if (request('date_to')) {
            $query->whereDate('created_at', '<=', request('date_to'));
        }

        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->paginate(10);

        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            'total_revenue' => Order::sum('total_amount'),
            'total_commission' => Order::sum('total_amount') * 0.1, // 10% commission
            'success_rate' => Order::count() > 0 ? round((Order::where('status', 'completed')->count() / Order::count()) * 100, 1) : 0,
            'refund_requests' => 0, // You can add refund logic later
        ];

        return view('admin.orders', compact('stats', 'orders'));
    })->name('admin.orders');

    // Order Details
    Route::get('/orders/{id}/details', function ($id) {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        
        $html = '
        <div class="row">
            <div class="col-md-6">
                <h6>Order Information</h6>
                <p><strong>Order ID:</strong> #'.($order->order_number ?? $order->id).'</p>
                <p><strong>Status:</strong> <span class="badge bg-'.($order->status === 'completed' ? 'success' : 'warning').'">'.ucfirst($order->status ?? 'pending').'</span></p>
                <p><strong>Date:</strong> '.$order->created_at->format('M d, Y H:i').'</p>
                <p><strong>Total Amount:</strong> $'.number_format($order->total_amount ?? 0, 2).'</p>
            </div>
            <div class="col-md-6">
                <h6>Customer Information</h6>
                <p><strong>Name:</strong> '.($order->user->name ?? 'N/A').'</p>
                <p><strong>Email:</strong> '.($order->user->email ?? 'N/A').'</p>
                <p><strong>Phone:</strong> '.($order->user->phone ?? 'N/A').'</p>
            </div>
        </div>';

        return response()->json(['html' => $html]);
    });

    // CRUD Operations
    Route::put('/orders/{id}/status', function ($id) {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $order = Order::findOrFail($id);
        $order->update(['status' => request('status')]);
        return response()->json(['success' => true]);
    });

    Route::post('/sellers/{id}/approve', function ($id) {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $seller = User::findOrFail($id);
        $seller->update(['is_active' => true]);
        return response()->json(['success' => true]);
        
    });

    Route::delete('/sellers/{id}', function ($id) {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $seller = User::findOrFail($id);
        $seller->delete();
        return response()->json(['success' => true]);
    });

    Route::post('/products', function () {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $product = Product::create([
            'name' => request('name'),
            'description' => request('description'),
            'price' => request('price'),
            'stock' => request('stock'),
            'seller_id' => auth()->id(), // Admin adding product
            'status' => 'active'
        ]);
        return response()->json(['success' => true, 'product' => $product]);
    });

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
Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories');
    // Add these routes to your admin routes group
Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories');
Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('admin.categories.show');
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

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