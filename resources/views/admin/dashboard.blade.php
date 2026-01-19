<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: #2c3e50;
            color: white;
            transition: all 0.3s;
        }
        .sidebar .nav-link {
            color: #bdc3c7;
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover {
            color: white;
            background: #34495e;
            border-left: 3px solid #3498db;
        }
        .sidebar .nav-link.active {
            color: white;
            background: #34495e;
            border-left: 3px solid #3498db;
        }
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        .sidebar-header {
            padding: 20px;
            background: #34495e;
            border-bottom: 1px solid #46627f;
        }
        .main-content {
            background: #ecf0f1;
            min-height: 100vh;
        }
        .stat-card {
            transition: transform 0.3s;
            border: none;
            border-radius: 10px;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .navbar-brand {
            font-weight: bold;
        }
        .seller-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .action-buttons .btn {
            margin: 2px;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <i class="fas fa-shopping-cart"></i> E-Commerce Admin
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
                </span>
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="sidebar-header">
                    <h6 class="mb-0">
                        <i class="fas fa-tachometer-alt"></i> Admin Panel
                    </h6>
                </div>
                
                <ul class="nav flex-column mt-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-chart-line"></i> Dashboard
                        </a>
                    </li>
                    
                    <!-- Sales & Orders Section -->
                    <li class="nav-item mt-3">
                        <small class="text-uppercase text-muted px-3">Sales & Orders</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.orders') }}">
                            <i class="fas fa-shopping-bag"></i> Orders
                            @if(isset($pendingOrdersCount) && $pendingOrdersCount > 0)
                            <span class="badge bg-warning float-end">{{ $pendingOrdersCount }}</span>
                            @endif
                        </a>
                    </li>
                    
                    <!-- User Management Section -->
                    <li class="nav-item mt-3">
                        <small class="text-uppercase text-muted px-3">User Management</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.sellers') }}">
                            <i class="fas fa-users"></i> Manage Sellers
                            @if(isset($pendingSellersCount) && $pendingSellersCount > 0)
                            <span class="badge bg-danger float-end">{{ $pendingSellersCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.customers') }}">
                            <i class="fas fa-user-friends"></i> Customer Management
                        </a>
                    </li>
                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.deposits') }}">
                            <i class="fas fa-coins"></i> Customer Deposits
                            @if(isset($depositStats) && $depositStats['pending_deposits'] > 0)
                                <span class="badge bg-warning float-end">{{ $depositStats['pending_deposits'] }}</span>
                            @endif
                        </a>
                    </li> 
                    <!-- Catalog Management -->
                    <li class="nav-item mt-3">
                        <small class="text-uppercase text-muted px-3">Catalog</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.categories') }}">
                            <i class="fas fa-tags"></i> Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-box"></i> All Products
                        </a>
                    </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-eye"></i> Products Oversight
                            @if(isset($productStats) && $productStats['pending_review'] > 0)
                                <span class="badge bg-warning float-end">{{ $productStats['pending_review'] }}</span>
                            @endif
                        </a>
                    </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-handshake"></i> Affiliate Products
                            @if(isset($affiliateStats) && $affiliateStats['active_affiliates'] > 0)
                                <span class="badge bg-info float-end">{{ $affiliateStats['active_affiliates'] }}</span>
                            @endif
                        </a>
                    </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-cloud-upload-alt"></i> Bulk Upload Oversight
                            @if(isset($uploadStats) && $uploadStats['pending_uploads'] > 0)
                                <span class="badge bg-warning float-end">{{ $uploadStats['pending_uploads'] }}</span>
                            @endif
                        </a>
                    </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-comments"></i> Product Discussions
                            @if(isset($discussionStats) && $discussionStats['unanswered'] > 0)
                                <span class="badge bg-danger float-end">{{ $discussionStats['unanswered'] }}</span>
                            @endif
                        </a>
                    </li>
                    
                    <!-- Support & Communication -->
                    <li class="nav-item mt-3">
                        <small class="text-uppercase text-muted px-3">Support</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.messages') }}">
                            <i class="fas fa-comments"></i> Messages
                        </a>
                    </li>
                    
                    <!-- Settings -->
                    <li class="nav-item mt-3">
                        <small class="text-uppercase text-muted px-3">Settings</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.payment-settings') }}">
                            <i class="fas fa-credit-card"></i> Payment
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.language-settings') }}">
                            <i class="fas fa-language"></i> Language
                        </a>
                    </li>
                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.language-settings') }}">
                            <i class="fas fa-globe"></i> Manage Country/Regions
                            <!-- <span class="badge bg-info float-end">195</span> -->
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.language-settings') }}">
                            <i class="fas fa-tags"></i> Coupons Management 
                            <!-- <span class="badge bg-success float-end">24</span> -->
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.language-settings') }}">
                            <i class="fas fa-blog"></i> Blog 
                            <!-- <span class="badge bg-warning float-end">8</span> -->
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.language-settings') }}">
                            <i class="fas fa-cogs"></i> General Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.language-settings') }}">
                            <i class="fas fa-home"></i> Home/Menu Page Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.language-settings') }}">
                            <i class="fas fa-envelope"></i> Email Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.language-settings') }}">
                            <i class="fas fa-share-alt"></i> Social Settings 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.language-settings') }}">
                            <i class="fas fa-search"></i> SEO Tools 
                            <!-- <span class="badge bg-success float-end">5</span> -->
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.language-settings') }}">
                            <i class="fas fa-users-cog"></i> Staff Management
                            <!-- <span class="badge bg-primary float-end">12</span> -->
                        </a>
                    </li>
                    
                </ul>
            </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 main-content px-4">
                <div class="container-fluid pt-4">
                    <!-- Page Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="h3 mb-0 text-gray-800">
                                <i class="fas fa-tachometer-alt"></i> Dashboard Overview
                            </h1>
                            <p class="text-muted">Real-time analytics and statistics</p>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-outline-primary">
                                <i class="fas fa-download"></i> Export Report
                            </button>
                            <button class="btn btn-primary" onclick="window.location.reload()">
                                <i class="fas fa-sync"></i> Refresh
                            </button>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <!-- Revenue -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-left-primary shadow h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Revenue
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                ${{ number_format($stats['total_revenue'] ?? 0, 2) }}
                                            </div>
                                            <div class="mt-2 mb-0 text-muted text-xs">
                                                <span class="text-success mr-2">
                                                    <i class="fas fa-dollar-sign"></i> All Time
                                                </span>
                                                <span>Revenue</span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Orders -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-left-success shadow h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Orders
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_orders'] ?? 0 }}</div>
                                            <div class="mt-2 mb-0 text-muted text-xs">
                                                <span class="text-warning mr-2">
                                                    <i class="fas fa-clock"></i> {{ $stats['pending_orders'] ?? 0 }} pending
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-shopping-bag fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sellers -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-left-info shadow h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Active Sellers
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_sellers'] ?? 0 }}</div>
                                            <div class="mt-2 mb-0 text-muted text-xs">
                                                <span class="text-danger mr-2">
                                                    <i class="fas fa-clock"></i> {{ $stats['pending_sellers'] ?? 0 }} pending
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-store fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Customers -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-left-warning shadow h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Total Customers
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_customers'] ?? 0 }}</div>
                                            <div class="mt-2 mb-0 text-muted text-xs">
                                                <span class="text-success mr-2">
                                                    <i class="fas fa-users"></i> Registered
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Recent Orders -->
                        <div class="col-lg-8 mb-4">
                            <div class="card shadow">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-shopping-bag"></i> Recent Orders
                                    </h6>
                                    <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-primary">View All</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Customer</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($recentOrders) && $recentOrders->count() > 0)
                                                    @foreach($recentOrders as $order)
                                                    <tr>
                                                        <td><strong>#{{ $order->order_number ?? 'N/A' }}</strong></td>
                                                        <td>{{ $order->customer->name ?? 'N/A' }}</td>
                                                        <td>${{ number_format($order->total_amount ?? 0, 2) }}</td>
                                                        <td>
                                                            @php
                                                                $status = $order->status ?? 'pending';
                                                                $badgeColor = 'warning';
                                                                if ($status === 'completed') $badgeColor = 'success';
                                                                if ($status === 'shipped') $badgeColor = 'info';
                                                                if ($status === 'cancelled') $badgeColor = 'danger';
                                                            @endphp
                                                            <span class="badge bg-{{ $badgeColor }}">
                                                                {{ ucfirst($status) }}
                                                            </span>
                                                        </td>
                                                        <td>{{ ($order->created_at ?? now())->format('M d, Y') }}</td>
                                                        <td class="action-buttons">
                                                            <button class="btn btn-sm btn-primary" onclick="viewOrder({{ $order->id }})" title="View">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-warning" onclick="editOrder({{ $order->id }})" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-success" onclick="updateOrderStatus({{ $order->id }}, 'completed')" title="Complete">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted py-4">
                                                            <i class="fas fa-shopping-bag fa-2x mb-2"></i>
                                                            <p>No orders found</p>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Sellers -->
                            <div class="card shadow mt-4">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-users"></i> Recent Sellers
                                    </h6>
                                    <a href="{{ route('admin.sellers') }}" class="btn btn-sm btn-primary">Manage All</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Seller</th>
                                                    <th>Email</th>
                                                    <th>Products</th>
                                                    <th>Status</th>
                                                    <th>Joined</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($recentSellers) && $recentSellers->count() > 0)
                                                    @foreach($recentSellers as $seller)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ $seller->avatar ?? 'https://via.placeholder.com/40' }}" 
                                                                     class="seller-avatar me-3" 
                                                                     alt="{{ $seller->name ?? 'Seller' }}">
                                                                <div>
                                                                    <strong>{{ $seller->name ?? 'Unknown Seller' }}</strong>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{ $seller->email ?? 'N/A' }}</td>
                                                        <td>{{ $seller->products_count ?? 0 }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ ($seller->is_active ?? false) ? 'success' : 'warning' }}">
                                                                {{ ($seller->is_active ?? false) ? 'Active' : 'Pending' }}
                                                            </span>
                                                        </td>
                                                        <td>{{ ($seller->created_at ?? now())->format('M d, Y') }}</td>
                                                        <td class="action-buttons">
                                                            <button class="btn btn-sm btn-primary" onclick="viewSeller({{ $seller->id }})" title="View">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            @if(!($seller->is_active ?? false))
                                                            <button class="btn btn-sm btn-success" onclick="approveSeller({{ $seller->id }})" title="Approve">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                            @endif
                                                            <button class="btn btn-sm btn-danger" onclick="deleteSeller({{ $seller->id }})" title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted py-4">
                                                            <i class="fas fa-users fa-2x mb-2"></i>
                                                            <p>No sellers registered</p>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar Content -->
                        <div class="col-lg-4 mb-4">
                            <!-- Quick Actions -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-bolt"></i> Quick Actions
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.sellers') }}" class="btn btn-outline-primary text-start">
                                            <i class="fas fa-users me-2"></i>Approve Sellers
                                            @if(isset($stats['pending_sellers']) && $stats['pending_sellers'] > 0)
                                            <span class="badge bg-danger float-end">{{ $stats['pending_sellers'] }}</span>
                                            @endif
                                        </a>
                                        <a href="{{ route('admin.orders') }}" class="btn btn-outline-success text-start">
                                            <i class="fas fa-chart-bar me-2"></i>View Sales Report
                                        </a>
                                        <a href="{{ route('admin.messages') }}" class="btn btn-outline-warning text-start">
                                            <i class="fas fa-comments me-2"></i>Check Messages
                                        </a>
                                        <button class="btn btn-outline-info text-start" data-bs-toggle="modal" data-bs-target="#addProductModal">
                                            <i class="fas fa-plus me-2"></i>Add New Product
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Top Products -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-chart-line"></i> Top Products
                                    </h6>
                                </div>
                                <div class="card-body">
                                    @if(isset($topProducts) && $topProducts->count() > 0)
                                        @foreach($topProducts as $product)
                                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                            <img src="{{ (is_array($product->images ?? null) ? ($product->images[0] ?? 'https://via.placeholder.com/40') : ($product->images ?? 'https://via.placeholder.com/40')) }}" 
                                                 class="rounded me-3" 
                                                 alt="{{ $product->name ?? 'Product' }}"
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ Str::limit($product->name ?? 'Unknown Product', 20) }}</h6>
                                                <small class="text-muted">
                                                    ${{ number_format($product->price ?? 0, 2) }} • 
                                                    {{ $product->sold_count ?? 0 }} sold
                                                </small>
                                            </div>
                                            <div class="action-buttons">
                                                <button class="btn btn-sm btn-outline-primary" onclick="viewProduct({{ $product->id }})">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="text-center text-muted py-4">
                                            <i class="fas fa-box-open fa-2x mb-2"></i>
                                            <p>No products available</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- System Stats -->
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-chart-pie"></i> System Statistics
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-6 mb-3">
                                            <div class="border rounded p-2">
                                                <div class="h6 text-primary mb-1">{{ $stats['total_products'] ?? 0 }}</div>
                                                <small class="text-muted">Total Products</small>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <div class="border rounded p-2">
                                                <div class="h6 text-success mb-1">{{ $stats['completed_orders'] ?? 0 }}</div>
                                                <small class="text-muted">Completed Orders</small>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <div class="border rounded p-2">
                                                <div class="h6 text-info mb-1">{{ $stats['active_sellers'] ?? 0 }}</div>
                                                <small class="text-muted">Active Sellers</small>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <div class="border rounded p-2">
                                                <div class="h6 text-warning mb-1">{{ $stats['active_products'] ?? 0 }}</div>
                                                <small class="text-muted">Active Products</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Price</label>
                                    <input type="number" class="form-control" name="price" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Stock</label>
                                    <input type="number" class="form-control" name="stock" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category_id">
                                <option value="">Select Category</option>
                                <!-- Categories will be loaded here -->
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="addProduct()">Add Product</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // CRUD Operations
        function viewOrder(orderId) {
            alert('Viewing order: ' + orderId);
            // Implement order view functionality
        }

        function editOrder(orderId) {
            alert('Editing order: ' + orderId);
            // Implement order edit functionality
        }

        function updateOrderStatus(orderId, status) {
            if(confirm('Are you sure you want to mark this order as ' + status + '?')) {
                // AJAX call to update order status
                fetch(`/admin/orders/${orderId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status: status })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        alert('Order status updated successfully!');
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        function viewSeller(sellerId) {
            alert('Viewing seller: ' + sellerId);
            // Implement seller view functionality
        }

        function approveSeller(sellerId) {
            if(confirm('Are you sure you want to approve this seller?')) {
                fetch(`/admin/sellers/${sellerId}/approve`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        alert('Seller approved successfully!');
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        function deleteSeller(sellerId) {
            if(confirm('Are you sure you want to delete this seller? This action cannot be undone.')) {
                fetch(`/admin/sellers/${sellerId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        alert('Seller deleted successfully!');
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        function viewProduct(productId) {
            alert('Viewing product: ' + productId);
            // Implement product view functionality
        }

        function addProduct() {
            const form = document.getElementById('addProductForm');
            const formData = new FormData(form);

            fetch('/admin/products', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert('Product added successfully!');
                    $('#addProductModal').modal('hide');
                    form.reset();
                    location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Auto-refresh data every 30 seconds
        setInterval(() => {
            // You can implement auto-refresh here if needed
        }, 30000);

        // Sidebar active state management
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>