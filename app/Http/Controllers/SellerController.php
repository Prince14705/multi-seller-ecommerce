<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index()
    {
        // Get all sellers - try different approaches
        try {
            // Method 1: Check if is_seller column exists
            $sellers = User::where('is_seller', true)->get();
        } catch (\Exception $e) {
            // Method 2: If column doesn't exist, get all users for now
            $sellers = User::latest()->get();
        }

        // Calculate statistics with safe defaults
        $totalSellers = $sellers->count();
        $approvedSellers = $sellers->where('is_approved', true)->count();
        $pendingSellers = $sellers->where('is_approved', false)->count();
        $totalProducts = Product::count();
        $totalSales = Order::count();
        $totalRevenue = Order::sum('total_amount') ?? 0;

        return view('admin.sellers', compact(
            'sellers',
            'totalSellers',
            'approvedSellers',
            'pendingSellers',
            'totalProducts',
            'totalSales',
            'totalRevenue'
        ));
    }

    public function approve($id)
    {
        $seller = User::findOrFail($id);
        $seller->update(['is_approved' => true]);

        return redirect()->back()->with('success', 'Seller approved successfully!');
    }

    public function suspend($id)
    {
        $seller = User::findOrFail($id);
        $seller->update(['is_approved' => false]);

        return redirect()->back()->with('success', 'Seller suspended successfully!');
    }

    public function show($id)
    {
        $seller = User::findOrFail($id);
        return view('admin.sellers.show', compact('seller'));
    }
}