{{-- resources/views/seller/store/profile.blade.php --}}
@extends('layouts.seller')

@section('title', 'Store Profile - Seller Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3">
                <i class="fas fa-store"></i> Store Profile
            </h1>
            <p class="text-muted mb-0">Manage your store information and branding</p>
        </div>
        <button class="btn btn-success" onclick="document.getElementById('storeForm').submit()">
            <i class="fas fa-save"></i> Save Changes
        </button>
    </div>

    <div class="row">
        <!-- Store Information -->
        <div class="col-lg-8">
            <form id="storeForm" action="{{ route('seller.store.profile.update') }}" 
                  method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-info-circle"></i> Basic Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="store_name" class="form-label">Store Name *</label>
                                <input type="text" class="form-control @error('store_name') is-invalid @enderror" 
                                       id="store_name" name="store_name" 
                                       value="{{ old('store_name', $store->name) }}" required>
                                @error('store_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="store_slug" class="form-label">Store URL Slug</label>
                                <div class="input-group">
                                    <span class="input-group-text">yourstore.com/</span>
                                    <input type="text" class="form-control @error('store_slug') is-invalid @enderror" 
                                           id="store_slug" name="store_slug" 
                                           value="{{ old('store_slug', $store->slug) }}">
                                </div>
                                @error('store_slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Leave empty to use store name</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tagline" class="form-label">Tagline</label>
                            <input type="text" class="form-control @error('tagline') is-invalid @enderror" 
                                   id="tagline" name="tagline" 
                                   value="{{ old('tagline', $store->tagline) }}">
                            @error('tagline')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">A short description that appears under your store name</small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Store Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description', $store->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Detailed description about your store. This helps customers understand what you offer.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Contact Email *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" 
                                       value="{{ old('email', $store->email) }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Contact Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" 
                                       value="{{ old('phone', $store->phone) }}">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="established_year" class="form-label">Established Year</label>
                                <input type="number" class="form-control" 
                                       id="established_year" name="established_year" 
                                       value="{{ old('established_year', $store->established_year) }}"
                                       min="1900" max="{{ date('Y') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="employee_count" class="form-label">Employee Count</label>
                                <select class="form-control" id="employee_count" name="employee_count">
                                    <option value="">Select</option>
                                    <option value="1-10" {{ old('employee_count', $store->employee_count) == '1-10' ? 'selected' : '' }}>1-10</option>
                                    <option value="11-50" {{ old('employee_count', $store->employee_count) == '11-50' ? 'selected' : '' }}>11-50</option>
                                    <option value="51-200" {{ old('employee_count', $store->employee_count) == '51-200' ? 'selected' : '' }}>51-200</option>
                                    <option value="201-500" {{ old('employee_count', $store->employee_count) == '201-500' ? 'selected' : '' }}>201-500</option>
                                    <option value="501+" {{ old('employee_count', $store->employee_count) == '501+' ? 'selected' : '' }}>501+</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="annual_revenue" class="form-label">Annual Revenue</label>
                                <select class="form-control" id="annual_revenue" name="annual_revenue">
                                    <option value="">Select</option>
                                    <option value="Under $100K" {{ old('annual_revenue', $store->annual_revenue) == 'Under $100K' ? 'selected' : '' }}>Under $100K</option>
                                    <option value="$100K - $500K" {{ old('annual_revenue', $store->annual_revenue) == '$100K - $500K' ? 'selected' : '' }}>$100K - $500K</option>
                                    <option value="$500K - $1M" {{ old('annual_revenue', $store->annual_revenue) == '$500K - $1M' ? 'selected' : '' }}>$500K - $1M</option>
                                    <option value="$1M - $5M" {{ old('annual_revenue', $store->employee_count) == '$1M - $5M' ? 'selected' : '' }}>$1M - $5M</option>
                                    <option value="Over $5M" {{ old('annual_revenue', $store->annual_revenue) == 'Over $5M' ? 'selected' : '' }}>Over $5M</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Store Images -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-images"></i> Store Images
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Logo -->
                            <div class="col-md-6 mb-4">
                                <label for="logo" class="form-label">Store Logo</label>
                                <div class="mb-3">
                                    @if($store->logo)
                                    <img src="{{ asset('storage/' . $store->logo) }}" 
                                         id="logoPreview" 
                                         class="img-thumbnail mb-2" 
                                         style="max-height: 150px;">
                                    @else
                                    <div class="border rounded d-flex align-items-center justify-content-center mb-2" 
                                         style="height: 150px; background: #f8f9fa;">
                                        <i class="fas fa-store fa-3x text-muted"></i>
                                    </div>
                                    @endif
                                </div>
                                <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                       id="logo" name="logo" accept="image/*" 
                                       onchange="previewImage(this, 'logoPreview')">
                                @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Recommended size: 300x300px, PNG or JPG</small>
                            </div>

                            <!-- Banner -->
                            <div class="col-md-6 mb-4">
                                <label for="banner" class="form-label">Store Banner</label>
                                <div class="mb-3">
                                    @if($store->banner)
                                    <img src="{{ asset('storage/' . $store->banner) }}" 
                                         id="bannerPreview" 
                                         class="img-thumbnail mb-2 w-100" 
                                         style="height: 150px; object-fit: cover;">
                                    @else
                                    <div class="border rounded d-flex align-items-center justify-content-center mb-2" 
                                         style="height: 150px; background: #f8f9fa;">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                    @endif
                                </div>
                                <input type="file" class="form-control @error('banner') is-invalid @enderror" 
                                       id="banner" name="banner" accept="image/*" 
                                       onchange="previewImage(this, 'bannerPreview')">
                                @error('banner')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Recommended size: 1200x300px, PNG or JPG</small>
                            </div>
                        </div>

                        <!-- Gallery Images -->
                        <div class="mb-3">
                            <label for="gallery_images" class="form-label">Gallery Images</label>
                            <input type="file" class="form-control" 
                                   id="gallery_images" name="gallery_images[]" 
                                   multiple accept="image/*">
                            <small class="text-muted">Upload multiple images to showcase your store (max 10 images)</small>
                        </div>

                        @if($store->galleryImages->count() > 0)
                        <div class="row g-2 mt-3" id="galleryPreview">
                            @foreach($store->galleryImages as $image)
                            <div class="col-6 col-md-3">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                         class="img-thumbnail w-100" 
                                         style="height: 100px; object-fit: cover;">
                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1"
                                            onclick="removeGalleryImage({{ $image->id }})">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Social Media -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-share-alt"></i> Social Media Links
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="facebook_url" class="form-label">
                                    <i class="fab fa-facebook text-primary me-2"></i> Facebook
                                </label>
                                <input type="url" class="form-control" id="facebook_url" name="facebook_url" 
                                       value="{{ old('facebook_url', $store->facebook_url) }}" 
                                       placeholder="https://facebook.com/yourpage">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="instagram_url" class="form-label">
                                    <i class="fab fa-instagram text-danger me-2"></i> Instagram
                                </label>
                                <input type="url" class="form-control" id="instagram_url" name="instagram_url" 
                                       value="{{ old('instagram_url', $store->instagram_url) }}" 
                                       placeholder="https://instagram.com/yourprofile">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="twitter_url" class="form-label">
                                    <i class="fab fa-twitter text-info me-2"></i> Twitter
                                </label>
                                <input type="url" class="form-control" id="twitter_url" name="twitter_url" 
                                       value="{{ old('twitter_url', $store->twitter_url) }}" 
                                       placeholder="https://twitter.com/yourhandle">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="linkedin_url" class="form-label">
                                    <i class="fab fa-linkedin text-primary me-2"></i> LinkedIn
                                </label>
                                <input type="url" class="form-control" id="linkedin_url" name="linkedin_url" 
                                       value="{{ old('linkedin_url', $store->linkedin_url) }}" 
                                       placeholder="https://linkedin.com/company/yourcompany">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="youtube_url" class="form-label">
                                    <i class="fab fa-youtube text-danger me-2"></i> YouTube
                                </label>
                                <input type="url" class="form-control" id="youtube_url" name="youtube_url" 
                                       value="{{ old('youtube_url', $store->youtube_url) }}" 
                                       placeholder="https://youtube.com/c/yourchannel">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pinterest_url" class="form-label">
                                    <i class="fab fa-pinterest text-danger me-2"></i> Pinterest
                                </label>
                                <input type="url" class="form-control" id="pinterest_url" name="pinterest_url" 
                                       value="{{ old('pinterest_url', $store->pinterest_url) }}" 
                                       placeholder="https://pinterest.com/yourprofile">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Business Information -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-building"></i> Business Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="business_type" class="form-label">Business Type</label>
                                <select class="form-control" id="business_type" name="business_type">
                                    <option value="">Select Type</option>
                                    <option value="sole_proprietorship" {{ old('business_type', $store->business_type) == 'sole_proprietorship' ? 'selected' : '' }}>Sole Proprietorship</option>
                                    <option value="partnership" {{ old('business_type', $store->business_type) == 'partnership' ? 'selected' : '' }}>Partnership</option>
                                    <option value="llc" {{ old('business_type', $store->business_type) == 'llc' ? 'selected' : '' }}>LLC (Limited Liability Company)</option>
                                    <option value="corporation" {{ old('business_type', $store->business_type) == 'corporation' ? 'selected' : '' }}>Corporation</option>
                                    <option value="non_profit" {{ old('business_type', $store->business_type) == 'non_profit' ? 'selected' : '' }}>Non-Profit Organization</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tax_id" class="form-label">Tax ID / VAT Number</label>
                                <input type="text" class="form-control" id="tax_id" name="tax_id" 
                                       value="{{ old('tax_id', $store->tax_id) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="business_address" class="form-label">Business Address</label>
                            <textarea class="form-control" id="business_address" name="business_address" 
                                      rows="3">{{ old('business_address', $store->business_address) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="return_policy" class="form-label">Return Policy</label>
                            <textarea class="form-control" id="return_policy" name="return_policy" 
                                      rows="4">{{ old('return_policy', $store->return_policy) }}</textarea>
                            <small class="text-muted">Clearly state your return and refund policy</small>
                        </div>

                        <div class="mb-3">
                            <label for="shipping_policy" class="form-label">Shipping Policy</label>
                            <textarea class="form-control" id="shipping_policy" name="shipping_policy" 
                                      rows="4">{{ old('shipping_policy', $store->shipping_policy) }}</textarea>
                            <small class="text-muted">Describe your shipping methods, timeframes, and costs</small>
                        </div>

                        <div class="mb-3">
                            <label for="privacy_policy" class="form-label">Privacy Policy</label>
                            <textarea class="form-control" id="privacy_policy" name="privacy_policy" 
                                      rows="4">{{ old('privacy_policy', $store->privacy_policy) }}</textarea>
                            <small class="text-muted">Explain how you handle customer data and privacy</small>
                        </div>
                    </div>
                </div>

                <!-- Store Status -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-toggle-on"></i> Store Status
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" 
                                           id="is_active" name="is_active" value="1" 
                                           {{ old('is_active', $store->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Store Active
                                    </label>
                                </div>
                                <small class="text-muted">If disabled, your store won't be visible to customers</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" 
                                           id="accepting_orders" name="accepting_orders" value="1" 
                                           {{ old('accepting_orders', $store->accepting_orders) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="accepting_orders">
                                        Accepting New Orders
                                    </label>
                                </div>
                                <small class="text-muted">Temporarily stop accepting new orders</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="vacation_message" class="form-label">Vacation Message</label>
                            <textarea class="form-control" id="vacation_message" name="vacation_message" 
                                      rows="3">{{ old('vacation_message', $store->vacation_message) }}</textarea>
                            <small class="text-muted">Display a message when store is on vacation mode</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="vacation_start" class="form-label">Vacation Start Date</label>
                                <input type="date" class="form-control" id="vacation_start" name="vacation_start" 
                                       value="{{ old('vacation_start', $store->vacation_start) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="vacation_end" class="form-label">Vacation End Date</label>
                                <input type="date" class="form-control" id="vacation_end" name="vacation_end" 
                                       value="{{ old('vacation_end', $store->vacation_end) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Preview Sidebar -->
        <div class="col-lg-4">
            <!-- Store Preview -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-eye"></i> Store Preview
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($store->logo)
                        <img src="{{ asset('storage/' . $store->logo) }}" 
                             id="previewLogo" 
                             class="rounded-circle mb-3" 
                             style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" 
                             style="width: 100px; height: 100px;">
                            <i class="fas fa-store fa-2x text-muted"></i>
                        </div>
                        @endif
                        <h4 id="previewName">{{ $store->name ?? 'Your Store Name' }}</h4>
                        <p id="previewTagline" class="text-muted">{{ $store->tagline ?? 'Your tagline here' }}</p>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('store.show', $store->slug) }}" 
                           class="btn btn-outline-primary" target="_blank">
                            <i class="fas fa-external-link-alt"></i> View Live Store
                        </a>
                        <button class="btn btn-outline-secondary" onclick="updatePreview()">
                            <i class="fas fa-sync"></i> Refresh Preview
                        </button>
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3">Store Statistics</h6>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Products</span>
                            <span class="badge bg-primary">{{ $store->products_count ?? 0 }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Orders</span>
                            <span class="badge bg-success">{{ $store->orders_count ?? 0 }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Rating</span>
                            <span class="badge bg-warning">{{ number_format($store->avg_rating ?? 0, 1) }}/5</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Followers</span>
                            <span class="badge bg-info">{{ $store->followers_count ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt"></i> Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('seller.products.create') }}" 
                           class="btn btn-outline-success text-start">
                            <i class="fas fa-plus-circle me-2"></i> Add New Product
                        </a>
                        <a href="{{ route('seller.orders') }}" 
                           class="btn btn-outline-primary text-start">
                            <i class="fas fa-shopping-bag me-2"></i> Manage Orders
                        </a>
                        <a href="{{ route('seller.store.appearance') }}" 
                           class="btn btn-outline-warning text-start">
                            <i class="fas fa-palette me-2"></i> Customize Appearance
                        </a>
                        <a href="{{ route('seller.store.shipping') }}" 
                           class="btn btn-outline-info text-start">
                            <i class="fas fa-truck me-2"></i> Shipping Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    const file = input.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

function removeGalleryImage(imageId) {
    if (confirm('Remove this image from gallery?')) {
        fetch(`/seller/store/gallery/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

function updatePreview() {
    // Update preview with form values
    document.getElementById('previewName').textContent = 
        document.getElementById('store_name').value || 'Your Store Name';
    document.getElementById('previewTagline').textContent = 
        document.getElementById('tagline').value || 'Your tagline here';
    
    // Update logo preview if new logo selected
    const logoInput = document.getElementById('logo');
    if (logoInput.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewLogo').src = e.target.result;
        };
        reader.readAsDataURL(logoInput.files[0]);
    }
}

// Auto-update preview as user types
document.getElementById('store_name').addEventListener('input', function() {
    document.getElementById('previewName').textContent = this.value || 'Your Store Name';
});

document.getElementById('tagline').addEventListener('input', function() {
    document.getElementById('previewTagline').textContent = this.value || 'Your tagline here';
});

// Auto-generate slug from store name
document.getElementById('store_name').addEventListener('blur', function() {
    const slugField = document.getElementById('store_slug');
    if (!slugField.value) {
        let slug = this.value.toLowerCase()
            .replace(/[^\w\s]/gi, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
        slugField.value = slug;
    }
});
</script>
@endsection