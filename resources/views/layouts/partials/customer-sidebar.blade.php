<div class="col-md-3 col-lg-2 sidebar d-md-block collapse">
    <div class="sidebar-header">
        <h6 class="mb-0">
            <i class="fas fa-user"></i> Customer Panel
        </h6>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('products.index') }}">
                <i class="fas fa-home"></i> Store Home
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('cart') ? 'active' : '' }}" 
               href="{{ route('cart') }}">
                <i class="fas fa-shopping-cart"></i> Shopping Cart
                @if(session('cart'))
                    <span class="badge bg-primary float-end">{{ count(session('cart')) }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('orders.history') ? 'active' : '' }}" 
               href="{{ route('orders.history') }}">
                <i class="fas fa-history"></i> Order History
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-heart"></i> Wishlist
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-cog"></i> Settings
            </a>
        </li>
    </ul>
</div>