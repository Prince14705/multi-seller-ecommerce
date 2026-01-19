<?php

// app/Http/Controllers/Seller/OrderController.php
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Order::where('seller_id', $user->id)
            ->with(['user', 'items.product'])
            ->withCount('items');
        
        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $orders = $query->latest()->paginate(20);
        
        // Statistics
        $stats = [
            'total_orders' => Order::where('seller_id', $user->id)->count(),
            'revenue' => Order::where('seller_id', $user->id)
                ->where('payment_status', 'paid')
                ->sum('total_amount'),
            'pending_orders' => Order::where('seller_id', $user->id)
                ->where('status', 'pending')
                ->count(),
            'avg_order_value' => Order::where('seller_id', $user->id)
                ->where('payment_status', 'paid')
                ->avg('total_amount') ?? 0,
        ];
        
        return view('seller.orders.index', compact('orders', 'stats'));
    }
    
    public function fulfillment()
    {
        $user = auth()->user();
        $orders = Order::where('seller_id', $user->id)
            ->whereIn('status', ['processing', 'shipped'])
            ->with(['user', 'items.product'])
            ->latest()
            ->paginate(20);
        
        return view('seller.orders.fulfillment', compact('orders'));
    }
    
    public function returns()
    {
        $user = auth()->user();
        $returnRequests = OrderItem::whereHas('order', function($q) use ($user) {
                $q->where('seller_id', $user->id);
            })
            ->where('return_status', '!=', null)
            ->with(['order.user', 'product'])
            ->latest()
            ->paginate(20);
        
        return view('seller.orders.returns', compact('returnRequests'));
    }
}