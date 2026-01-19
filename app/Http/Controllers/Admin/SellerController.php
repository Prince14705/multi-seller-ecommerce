<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    /**
     * Display a listing of sellers.
     */
    public function index()
    {
        $sellers = User::where('role', 'seller')
            ->orWhere('is_seller', true)
            ->latest()
            ->paginate(10);
            
        return view('admin.sellers.index', compact('sellers'));
    }

    /**
     * Display the specified seller.
     */
    public function show($id)
    {
        $seller = User::findOrFail($id);
        return view('admin.sellers.show', compact('seller'));
    }

    /**
     * Approve a seller.
     */
    public function approve($id)
    {
        $seller = User::findOrFail($id);
        $seller->update([
            'is_approved' => true,
            'is_active' => true
        ]);
        
        return redirect()->route('admin.sellers')
            ->with('success', 'Seller approved successfully!');
    }

    /**
     * Suspend a seller.
     */
    public function suspend($id)
    {
        $seller = User::findOrFail($id);
        $seller->update(['is_active' => false]);
        
        return redirect()->route('admin.sellers')
            ->with('warning', 'Seller suspended successfully!');
    }

    /**
     * Remove the specified seller.
     */
    public function destroy($id)
    {
        $seller = User::findOrFail($id);
        $seller->delete();
        
        return redirect()->route('admin.sellers')
            ->with('success', 'Seller deleted successfully!');
    }
}