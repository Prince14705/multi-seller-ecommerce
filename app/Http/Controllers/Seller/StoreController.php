<?php

// app/Http/Controllers/Seller/StoreController.php
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        $store = Store::where('user_id', $user->id)->first();
        
        if (!$store) {
            $store = Store::create([
                'user_id' => $user->id,
                'name' => $user->name . "'s Store",
                'slug' => str_slug($user->name . '-store'),
                'email' => $user->email,
                'is_active' => true,
                'accepting_orders' => true,
            ]);
        }
        
        $store->load('galleryImages');
        
        return view('seller.store.profile', compact('store'));
    }
    
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $store = Store::where('user_id', $user->id)->firstOrFail();
        
        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'store_slug' => 'nullable|string|max:255|unique:stores,slug,' . $store->id,
            'tagline' => 'nullable|string|max:255',
            'description' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:5120',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|max:2048',
        ]);
        
        // Update store
        $store->name = $validated['store_name'];
        $store->slug = $validated['store_slug'] ?? str_slug($validated['store_name']);
        $store->tagline = $validated['tagline'];
        $store->description = $validated['description'];
        $store->email = $validated['email'];
        $store->phone = $validated['phone'];
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            if ($store->logo) {
                Storage::delete($store->logo);
            }
            $store->logo = $request->file('logo')->store('stores/logos');
        }
        
        // Handle banner upload
        if ($request->hasFile('banner')) {
            if ($store->banner) {
                Storage::delete($store->banner);
            }
            $store->banner = $request->file('banner')->store('stores/banners');
        }
        
        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('stores/gallery');
                $store->galleryImages()->create([
                    'image_path' => $path,
                    'file_name' => $image->getClientOriginalName(),
                ]);
            }
        }
        
        $store->save();
        
        return redirect()->route('seller.store.profile')
            ->with('success', 'Store profile updated successfully!');
    }
}