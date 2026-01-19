<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard - E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: #27ae60;
            color: white;
            transition: all 0.3s;
        }
        .sidebar .nav-link {
            color: #d5f4e6;
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover {
            color: white;
            background: #219653;
            border-left: 3px solid #2ecc71;
        }
        .sidebar .nav-link.active {
            color: white;
            background: #219653;
            border-left: 3px solid #2ecc71;
        }
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        .sidebar-header {
            padding: 20px;
            background: #219653;
            border-bottom: 1px solid #1e8449;
        }
        .main-content {
            background: #f8f9fa;
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
        .seller-badge {
            background: linear-gradient(45deg, #27ae60, #2ecc71);
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: #27ae60;">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <i class="fas fa-store"></i> Seller Dashboard
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
                    @if(auth()->user()->is_approved)
                        <span class="badge seller-badge ms-2">Approved</span>
                    @else
                        <span class="badge bg-warning ms-2">Pending Approval</span>
                    @endif
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
                        <i class="fas fa-store-alt"></i> Seller Panel
                    </h6>
                    <small class="text-light">{{ auth()->user()->name }}'s Store</small>
                </div>
                
                <ul class="nav flex-column mt-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('seller.dashboard') }}">
                            <i class="fas fa-chart-line"></i> Dashboard
                        </a>
                    </li>
                    
                    <!-- Sales & Analytics Section -->
                    <li class="nav-item mt-3">
                        <small class="text-uppercase text-light px-3">Sales & Analytics</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-shopping-bag"></i> Orders
                            <span class="badge bg-warning float-end">8</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-chart-bar"></i> Sales Analytics
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-money-bill-wave"></i> Earnings
                        </a>
                    </li>
                    
                    <!-- Product Management Section -->
                    <li class="nav-item mt-3">
                        <small class="text-uppercase text-light px-3">Products</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-box"></i> My Products
                            <span class="badge bg-info float-end">{{ $stats['total_products'] }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-plus-circle"></i> Add Product
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-file-upload"></i> Bulk Upload
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-tags"></i> Categories
                        </a>
                    </li>
                    
                    <!-- Orders & Fulfillment -->
                    <li class="nav-item mt-3">
                        <small class="text-uppercase text-light px-3">Orders</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-clipboard-list"></i> Order Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-shipping-fast"></i> Fulfillment
                            <span class="badge bg-primary float-end">5</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-undo-alt"></i> Returns
                            <span class="badge bg-warning float-end">2</span>
                        </a>
                    </li>
                    
                    <!-- Payments & Finance -->
                    <li class="nav-item mt-3">
                        <small class="text-uppercase text-light px-3">Finance</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-wallet"></i> Payments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-hand-holding-usd"></i> Payouts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-chart-pie"></i> Revenue Report
                        </a>
                    </li>
                    
                    <!-- Communication -->
                    <li class="nav-item mt-3">
                        <small class="text-uppercase text-light px-3">Communication</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-comments"></i> Messages
                            <span class="badge bg-info float-end">3</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-star"></i> Reviews & Ratings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-question-circle"></i> Product Q&A
                            <span class="badge bg-warning float-end">4</span>
                        </a>
                    </li>
                    
                    <!-- Store Settings -->
                    <li class="nav-item mt-3">
                        <small class="text-uppercase text-light px-3">Store Settings</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-store"></i> Store Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-palette"></i> Appearance
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-truck"></i> Shipping Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-cog"></i> General Settings
                        </a>
                    </li>
                </ul>
                
                <!-- Quick Links -->
                <div class="sidebar-header mt-4">
                    <h6 class="mb-0">
                        <i class="fas fa-external-link-alt"></i> Quick Links
                    </h6>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            <i class="fas fa-shopping-cart"></i> Visit Store
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/home">
                            <i class="fas fa-user"></i> My Account
                        </a>
                    </li>
                    @if(auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Admin Panel
                        </a>
                    </li>
                    @endif
                </ul>
            </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 main-content px-4">
                <div class="container-fluid pt-4">
                    <!-- Page Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="h3">
                                <i class="fas fa-tachometer-alt"></i> Seller Dashboard
                            </h1>
                            <p class="text-muted mb-0">Welcome back, {{ auth()->user()->name }}! Here's your store overview.</p>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-outline-success">
                                <i class="fas fa-download"></i> Export Report
                            </button>
                            <button class="btn btn-success">
                                <i class="fas fa-sync"></i> Refresh
                            </button>
                        </div>
                    </div>

                    @if(!auth()->user()->is_approved)
                    <div class="alert alert-warning">
                        <i class="fas fa-clock"></i>
                        <strong>Your account is pending approval.</strong> You can add products, but they won't be visible to customers until your account is approved by an administrator.
                    </div>
                    @endif

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <!-- Total Revenue -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-left-success shadow h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Revenue
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">$2,845</div>
                                            <div class="mt-2 mb-0 text-muted text-xs">
                                                <span class="text-success mr-2">
                                                    <i class="fas fa-arrow-up"></i> 15%
                                                </span>
                                                <span>Since last month</span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Orders -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-left-primary shadow h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Orders
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_orders'] }}</div>
                                            <div class="mt-2 mb-0 text-muted text-xs">
                                                <span class="text-success mr-2">
                                                    <i class="fas fa-arrow-up"></i> 12%
                                                </span>
                                                <span>Since last month</span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-shopping-bag fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Products -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-left-info shadow h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Active Products
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_products'] }}</div>
                                            <div class="mt-2 mb-0 text-muted text-xs">
                                                <span class="text-warning mr-2">
                                                    <i class="fas fa-box"></i> Manage
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-box fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Orders -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-left-warning shadow h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pending Orders
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending_orders'] }}</div>
                                            <div class="mt-2 mb-0 text-muted text-xs">
                                                <span class="text-danger mr-2">
                                                    <i class="fas fa-clock"></i> Needs attention
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts and Additional Stats -->
                    <div class="row">
                        <!-- Recent Orders -->
                        <div class="col-lg-8 mb-4">
                            <div class="card shadow">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-shopping-bag"></i> Recent Orders
                                    </h6>
                                    <a href="#" class="btn btn-sm btn-primary">View All</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Customer</th>
                                                    <th>Product</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>#ORD-156</td>
                                                    <td>John Doe</td>
                                                    <td>Wireless Headphones</td>
                                                    <td>$89.99</td>
                                                    <td><span class="badge bg-success">Completed</span></td>
                                                    <td>2024-01-15</td>
                                                </tr>
                                                <tr>
                                                    <td>#ORD-157</td>
                                                    <td>Jane Smith</td>
                                                    <td>Smart Watch</td>
                                                    <td>$199.99</td>
                                                    <td><span class="badge bg-warning">Processing</span></td>
                                                    <td>2024-01-15</td>
                                                </tr>
                                                <tr>
                                                    <td>#ORD-158</td>
                                                    <td>Mike Johnson</td>
                                                    <td>Bluetooth Speaker</td>
                                                    <td>$59.99</td>
                                                    <td><span class="badge bg-info">Shipped</span></td>
                                                    <td>2024-01-14</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="col-lg-4 mb-4">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-bolt"></i> Quick Actions
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="#" class="btn btn-outline-success text-start">
                                            <i class="fas fa-plus-circle me-2"></i>Add New Product
                                        </a>
                                        <a href="#" class="btn btn-outline-primary text-start">
                                            <i class="fas fa-clipboard-list me-2"></i>Manage Orders
                                        </a>
                                        <a href="#" class="btn btn-outline-warning text-start">
                                            <i class="fas fa-comments me-2"></i>Check Messages
                                        </a>
                                        <a href="#" class="btn btn-outline-info text-start">
                                            <i class="fas fa-chart-bar me-2"></i>View Analytics
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Store Performance -->
                            <div class="card shadow mt-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-success">
                                        <i class="fas fa-chart-line"></i> Store Performance
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="list-group list-group-flush">
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Conversion Rate</span>
                                            <span class="badge bg-success">4.2%</span>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Average Rating</span>
                                            <span class="badge bg-warning">4.5/5</span>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Response Time</span>
                                            <span class="badge bg-info">2.1h</span>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Store Visits</span>
                                            <span class="badge bg-primary">1.2K</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings Overview -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-money-bill-wave"></i> Earnings Overview
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-3 mb-3">
                                            <div class="border rounded p-3">
                                                <h4 class="text-success">$2,845</h4>
                                                <small class="text-muted">Total Earnings</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="border rounded p-3">
                                                <h4 class="text-primary">$284.50</h4>
                                                <small class="text-muted">Commission (10%)</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="border rounded p-3">
                                                <h4 class="text-info">$2,560.50</h4>
                                                <small class="text-muted">Net Earnings</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="border rounded p-3">
                                                <h4 class="text-warning">$1,200</h4>
                                                <small class="text-muted">Pending Payout</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center mt-3">
                                        <button class="btn btn-success">
                                            <i class="fas fa-hand-holding-usd"></i> Request Payout
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple sidebar active state management
        document.addEventListener('DOMContentLoaded', function() {
            const currentUrl = window.location.href;
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            
            navLinks.forEach(link => {
                if (link.href === currentUrl) {
                    link.classList.add('active');
                }
                
                link.addEventListener('click', function() {
                    navLinks.forEach(nl => nl.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>
</html>