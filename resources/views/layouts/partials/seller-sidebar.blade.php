<div class="col-md-3 col-lg-2 sidebar d-md-block collapse">
    <div class="sidebar-header">
        <h6 class="mb-0">
            <i class="fas fa-store"></i> Seller Panel
        </h6>
        <small class="text-muted">
            @if(Auth::user()->is_approved)
                <span class="badge bg-success">Approved</span>
            @else
                <span class="badge bg-warning">Pending Approval</span>
            @endif
        </small>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}" 
               href="{{ route('seller.dashboard') }}">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('seller.products*') ? 'active' : '' }}" 
               href="{{ route('seller.products') }}">
                <i class="fas fa-box"></i> My Products
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('seller.products.create') ? 'active' : '' }}" 
               href="{{ route('seller.products.create') }}">
                <i class="fas fa-plus-circle"></i> Add Product
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('seller.orders*') ? 'active' : '' }}" 
               href="{{ route('seller.orders') }}">
                <i class="fas fa-shopping-bag"></i> Orders
                @php
                    $sellerPendingOrders = \App\Models\Order::whereHas('items.product', function($query) {
                        $query->where('seller_id', Auth::id());
                    })->where('status', 'pending')->count();
                @endphp
                @if($sellerPendingOrders)
                    <span class="badge bg-warning float-end">{{ $sellerPendingOrders }}</span>
                @endif
            </a>
        </li>
    </ul>
    
    <div class="sidebar-header mt-4">
        <h6 class="mb-0">
            <i class="fas fa-user"></i> Customer Area
        </h6>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('products.index') }}">
                <i class="fas fa-home"></i> Store Home
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('cart') }}">
                <i class="fas fa-shopping-cart"></i> Shopping Cart
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('orders.history') }}">
                <i class="fas fa-history"></i> My Orders
            </a>
        </li>
    </ul>
</div>