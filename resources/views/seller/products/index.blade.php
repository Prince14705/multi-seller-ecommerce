{{-- resources/views/seller/products/index.blade.php --}}
@extends('layouts.seller')

@section('title', 'My Products - Seller Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3">
                <i class="fas fa-box"></i> My Products
            </h1>
            <p class="text-muted mb-0">Manage your product listings</p>
        </div>
        <a href="{{ route('seller.products.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Add New Product
        </a>
    </div>

    <!-- Products Table -->
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Products ({{ $products->total() }})
            </h6>
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Filter by Status
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}">Active</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'inactive']) }}">Inactive</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'out_of_stock']) }}">Out of Stock</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>
                                @if($product->images->count() > 0)
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                     alt="{{ $product->name }}" 
                                     style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td><code>{{ $product->sku }}</code></td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>
                                @if($product->stock_quantity > 10)
                                <span class="badge bg-success">{{ $product->stock_quantity }}</span>
                                @elseif($product->stock_quantity > 0)
                                <span class="badge bg-warning">{{ $product->stock_quantity }}</span>
                                @else
                                <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </td>
                            <td>
                                @if($product->is_active)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $product->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('products.show', $product->id) }}" 
                                       class="btn btn-outline-primary" target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('seller.products.edit', $product->id) }}" 
                                       class="btn btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('seller.products.destroy', $product->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" 
                                                onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-box-open fa-2x text-muted mb-3"></i>
                                <h5>No products found</h5>
                                <p class="text-muted">Start by adding your first product!</p>
                                <a href="{{ route('seller.products.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus-circle"></i> Add Product
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($products->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection