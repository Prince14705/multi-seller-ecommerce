<?php

// app/Http/Controllers/Seller/ProductController.php
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Product::where('user_id', $user->id)
            ->with(['images', 'category'])
            ->withCount('orders');
        
        // Apply filters
        if ($request->filled('status')) {
            if ($request->status == 'active') {
                $query->where('is_active', true);
            } elseif ($request->status == 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status == 'out_of_stock') {
                $query->where('stock_quantity', 0);
            }
        }
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
        }
        
        $products = $query->latest()->paginate(20);
        
        return view('seller.products.index', compact('products'));
    }
    
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('seller.products.create', compact('categories'));
    }
    
    public function categories()
    {
        $user = auth()->user();
        $categories = Category::where('user_id', $user->id)
            ->withCount('products')
            ->get();
        
        return view('seller.products.categories', compact('categories'));
    }
}