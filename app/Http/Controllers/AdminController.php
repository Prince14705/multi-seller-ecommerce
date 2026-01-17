<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_amount'),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_products' => Product::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_categories' => Category::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function sellers()
    {
        $stats = $this->getDashboardStats();
        return view('admin.sellers', compact('stats'));
    }

    public function customers()
    {
        $stats = $this->getDashboardStats();
        return view('admin.customers', compact('stats'));
    }

    public function categories()
    {
        $stats = $this->getDashboardStats();
        return view('admin.categories', compact('stats'));
    }

    public function deposits()
    {
        $stats = $this->getDashboardStats();
        return view('admin.deposits', compact('stats'));
    }

    public function messages()
    {
        $stats = $this->getDashboardStats();
        return view('admin.messages', compact('stats'));
    }

    public function paymentSettings()
    {
        $stats = $this->getDashboardStats();
        return view('admin.payment-settings', compact('stats'));
    }

    public function languageSettings()
    {
        $stats = $this->getDashboardStats();
        return view('admin.language-settings', compact('stats'));
    }

    private function getDashboardStats()
    {
        return [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_amount'),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_products' => Product::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_categories' => Category::count(),
        ];
    }
}