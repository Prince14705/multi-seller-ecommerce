<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function dashboard()
    {
        $seller = Auth::user();
        $stats = [
            'total_products' => Product::where('seller_id', $seller->id)->count(),
            'total_orders' => Order::whereHas('items.product', function($query) use ($seller) {
                $query->where('seller_id', $seller->id);
            })->count(),
            'pending_orders' => Order::whereHas('items.product', function($query) use ($seller) {
                $query->where('seller_id', $seller->id);
            })->where('status', 'pending')->count(),
        ];

        return view('seller.dashboard', compact('stats'));
    }

    public function products()
    {
        $products = Product::where('seller_id', Auth::id())->get();
        return view('seller.products', compact('products'));
    }

    public function createProduct()
    {
        return view('seller.products-create');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'seller_id' => Auth::id(),
        ]);

        return redirect()->route('seller.products')->with('success', 'Product created successfully.');
    }

    public function editProduct($id)
    {
        $product = Product::where('seller_id', Auth::id())->findOrFail($id);
        return view('seller.products-edit', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::where('seller_id', Auth::id())->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        return redirect()->route('seller.products')->with('success', 'Product updated successfully.');
    }

    public function orders()
    {
        $orders = Order::whereHas('items.product', function($query) {
            $query->where('seller_id', Auth::id());
        })->with(['user', 'items.product'])->get();

        return view('seller.orders', compact('orders'));
    }
}