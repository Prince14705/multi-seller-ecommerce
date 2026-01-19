<?php
// app/Http/Controllers/Seller/DashboardController.php
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'total_orders' => Order::where('seller_id', $user->id)->count(),
            'pending_orders' => Order::where('seller_id', $user->id)
                ->where('status', 'pending')
                ->count(),
            'total_products' => Product::where('user_id', $user->id)->count(),
            'total_revenue' => Order::where('seller_id', $user->id)
                ->where('payment_status', 'paid')
                ->sum('total_amount'),
            'active_products' => Product::where('user_id', $user->id)
                ->where('is_active', true)
                ->count(),
        ];
        
        $recentOrders = Order::where('seller_id', $user->id)
            ->with(['user', 'items.product'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('seller.dashboard', compact('stats', 'recentOrders'));
    }
}