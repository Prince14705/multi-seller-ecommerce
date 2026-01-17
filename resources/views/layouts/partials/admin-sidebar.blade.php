<div class="col-md-3 col-lg-2 sidebar d-md-block collapse">
    <div class="sidebar-header">
        <h6 class="mb-0">
            <i class="fas fa-tachometer-alt"></i> Admin Panel
        </h6>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
               href="{{ route('admin.dashboard') }}">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.sellers*') ? 'active' : '' }}" 
               href="{{ route('admin.sellers') }}">
                <i class="fas fa-users"></i> Sellers
                @if($pendingSellersCount = \App\Models\User::where('role', 'seller')->where('is_approved', false)->count())
                    <span class="badge bg-danger float-end">{{ $pendingSellersCount }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}" 
               href="{{ route('admin.products') }}">
                <i class="fas fa-box"></i> Products
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}" 
               href="{{ route('admin.orders') }}">
                <i class="fas fa-shopping-bag"></i> Orders
                @if($pendingOrdersCount = \App\Models\Order::where('status', 'pending')->count())
                    <span class="badge bg-warning float-end">{{ $pendingOrdersCount }}</span>
                @endif
            </a>
        </li>
    </ul>
    
    <div class="sidebar-header mt-4">
        <h6 class="mb-0">
            <i class="fas fa-store"></i> Store Front
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
                <i class="fas fa-history"></i> Order History
            </a>
        </li>
    </ul>
</div>