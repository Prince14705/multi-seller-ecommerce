<?php

// app/Http/Controllers/Seller/SalesController.php
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Date range defaults
        $startDate = $request->filled('start_date') ? $request->start_date : now()->subDays(7);
        $endDate = $request->filled('end_date') ? $request->end_date : now();
        
        // Main statistics
        $currentStats = $this->getSalesStats($user->id, $startDate, $endDate);
        $previousStats = $this->getSalesStats(
            $user->id, 
            now()->parse($startDate)->subDays(7), 
            now()->parse($endDate)->subDays(7)
        );
        
        // Calculate growth percentages
        $stats = [
            'total_sales' => $currentStats['total_sales'],
            'total_orders' => $currentStats['total_orders'],
            'avg_order_value' => $currentStats['avg_order_value'],
            'conversion_rate' => $currentStats['conversion_rate'],
            'sales_growth' => $this->calculateGrowth($currentStats['total_sales'], $previousStats['total_sales']),
            'orders_growth' => $this->calculateGrowth($currentStats['total_orders'], $previousStats['total_orders']),
            'aov_growth' => $this->calculateGrowth($currentStats['avg_order_value'], $previousStats['avg_order_value']),
            'cr_growth' => $this->calculateGrowth($currentStats['conversion_rate'], $previousStats['conversion_rate']),
        ];
        
        // Sales trend data
        $salesTrend = $this->getSalesTrend($user->id, $startDate, $endDate);
        
        // Top products
        $topProducts = Product::where('user_id', $user->id)
            ->select('products.*')
            ->selectRaw('SUM(order_items.quantity) as total_quantity')
            ->selectRaw('SUM(order_items.price * order_items.quantity) as total_revenue')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.seller_id', $user->id)
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.payment_status', 'paid')
            ->groupBy('products.id')
            ->orderBy('total_revenue', 'desc')
            ->take(10)
            ->get();
        
        // Category sales
        $categorySales = DB::table('categories')
            ->select('categories.name as category')
            ->selectRaw('SUM(order_items.price * order_items.quantity) as sales')
            ->join('products', 'categories.id', '=', 'products.category_id')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.seller_id', $user->id)
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.payment_status', 'paid')
            ->groupBy('categories.id')
            ->get();
        
        // Hourly sales
        $hourlySales = Order::where('seller_id', $user->id)
            ->select(DB::raw('HOUR(created_at) as hour'))
            ->selectRaw('SUM(total_amount) as sales')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('payment_status', 'paid')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();
        
        // Daily stats
        $dailyStats = Order::where('seller_id', $user->id)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as orders'),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('AVG(total_amount) as avg_order_value')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('payment_status', 'paid')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function($item) {
                // Add items sold and conversion rate (these would need actual calculations)
                $item->items_sold = 0; // Would need to join with order_items
                $item->conversion_rate = 0; // Would need session data
                return $item;
            });
        
        return view('seller.sales.index', compact(
            'stats', 
            'salesTrend', 
            'topProducts', 
            'categorySales', 
            'hourlySales', 
            'dailyStats'
        ));
    }
    
    private function getSalesStats($sellerId, $startDate, $endDate)
    {
        return [
            'total_sales' => Order::where('seller_id', $sellerId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('payment_status', 'paid')
                ->sum('total_amount'),
            'total_orders' => Order::where('seller_id', $sellerId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('payment_status', 'paid')
                ->count(),
            'avg_order_value' => Order::where('seller_id', $sellerId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('payment_status', 'paid')
                ->avg('total_amount') ?? 0,
            'conversion_rate' => 0, // This would require session tracking
        ];
    }
    
    private function calculateGrowth($current, $previous)
    {
        if ($previous == 0) return $current > 0 ? 100 : 0;
        return (($current - $previous) / $previous) * 100;
    }
    
    private function getSalesTrend($sellerId, $startDate, $endDate)
    {
        $dates = [];
        $sales = [];
        
        $currentDate = now()->parse($startDate);
        $end = now()->parse($endDate);
        
        while ($currentDate <= $end) {
            $dateStr = $currentDate->format('Y-m-d');
            $dates[] = $currentDate->format('M d');
            
            $dailySales = Order::where('seller_id', $sellerId)
                ->whereDate('created_at', $dateStr)
                ->where('payment_status', 'paid')
                ->sum('total_amount');
            
            $sales[] = $dailySales;
            $currentDate->addDay();
        }
        
        return ['dates' => $dates, 'sales' => $sales];
    }
}
