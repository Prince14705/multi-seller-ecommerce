{{-- resources/views/seller/products/create.blade.php --}}
@extends('layouts.seller')

@section('title', 'Add Product - Seller Dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3">
                <i class="fas fa-plus-circle"></i> Add New Product
            </h1>
            <p class="text-muted mb-0">Create a new product listing</p>
        </div>
        <a href="{{ route('seller.products') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Products
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <!-- Basic Information -->
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="sku" class="form-label">SKU *</label>
                                <input type="text" class="form-control @error('sku') is-invalid @enderror" 
                                       id="sku" name="sku" value="{{ old('sku') }}" required>
                                @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="category_id" class="form-label">Category *</label>
                                <select class="form-control @error('category_id') is-invalid @enderror" 
                                        id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="price" class="form-label">Price ($) *</label>
                                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                       id="price" name="price" value="{{ old('price') }}" required>
                                @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="stock_quantity" class="form-label">Stock Quantity *</label>
                                <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" 
                                       id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" required>
                                @error('stock_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="weight" class="form-label">Weight (kg)</label>
                                <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror" 
                                       id="weight" name="weight" value="{{ old('weight') }}">
                                @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="6" required>{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="specifications" class="form-label">Specifications (JSON format)</label>
                            <textarea class="form-control @error('specifications') is-invalid @enderror" 
                                      id="specifications" name="specifications" rows="4">{{ old('specifications') }}</textarea>
                            <small class="text-muted">Example: {"color": "Red", "size": "Medium", "material": "Cotton"}</small>
                            @error('specifications')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-md-4">
                        <!-- Status -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Status</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" 
                                           id="is_active" name="is_active" value="1" checked>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                                <small class="text-muted">If inactive, product won't be visible to customers</small>
                            </div>
                        </div>

                        <!-- Images -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Product Images</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="images" class="form-label">Upload Images</label>
                                    <input type="file" class="form-control @error('images') is-invalid @enderror" 
                                           id="images" name="images[]" multiple accept="image/*">
                                    @error('images')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">You can upload multiple images. First image will be the main image.</small>
                                </div>
                                <div id="image-preview" class="row g-2 mt-2"></div>
                            </div>
                        </div>

                        <!-- Shipping -->
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Shipping Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="shipping_method" class="form-label">Shipping Method</label>
                                    <select class="form-control" id="shipping_method" name="shipping_method">
                                        <option value="">Default Shipping</option>
                                        <option value="free">Free Shipping</option>
                                        <option value="flat_rate">Flat Rate</option>
                                        <option value="calculated">Calculated Shipping</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="shipping_cost" class="form-label">Shipping Cost ($)</label>
                                    <input type="number" step="0.01" class="form-control" 
                                           id="shipping_cost" name="shipping_cost" value="{{ old('shipping_cost', 0) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Save Product
                    </button>
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview
    const imageInput = document.getElementById('images');
    const previewDiv = document.getElementById('image-preview');
    
    imageInput.addEventListener('change', function() {
        previewDiv.innerHTML = '';
        
        for (let file of this.files) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-6 col-md-4';
                col.innerHTML = `
                    <div class="position-relative">
                        <img src="${e.target.result}" 
                             class="img-thumbnail w-100" 
                             style="height: 100px; object-fit: cover;">
                    </div>
                `;
                previewDiv.appendChild(col);
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection