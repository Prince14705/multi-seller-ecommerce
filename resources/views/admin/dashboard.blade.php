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
                            <span class="badge bg-warning float-end">15</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-chart-bar"></i> Sales Analytics
                        </a>
                    </li>
                    
                    <!-- User Management Section -->
                    <li class="nav-item mt-3">
                        <small class="text-uppercase text-muted px-3">User Management</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.sellers') }}">
                            <i class="fas fa-users"></i> Manage Sellers
                            <span class="badge bg-danger float-end">3</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.customers') }}">
                            <i class="fas fa-user-friends"></i> Customer Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.deposits') }}">
                            <i class="fas fa-wallet"></i> Customer Deposits
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
                    
                    <!-- Support & Communication -->
                    <li class="nav-item mt-3">
                        <small class="text-uppercase text-muted px-3">Support</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.messages') }}">
                            <i class="fas fa-comments"></i> Messages
                            <span class="badge bg-info float-end">8</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-exclamation-circle"></i> Disputes
                            <span class="badge bg-danger float-end">2</span>
                        </a>
                    </li>
                    
                    <!-- Settings -->
                    <li class="nav-item mt-3">
                        <small class="text-uppercase text-muted px-3">Settings</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.payment-settings') }}">
                            <i class="fas fa-credit-card"></i> Payment Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.language-settings') }}">
                            <i class="fas fa-language"></i> Language Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-cog"></i> System Settings
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
                            <i class="fas fa-store"></i> Visit Store
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/home">
                            <i class="fas fa-user"></i> My Account
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 main-content px-4">
                <div class="container-fluid pt-4">
                    <!-- Page Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3">
                            <i class="fas fa-tachometer-alt"></i> Dashboard Overview
                        </h1>
                        <div class="btn-group">
                            <button class="btn btn-outline-primary">
                                <i class="fas fa-download"></i> Export Report
                            </button>
                            <button class="btn btn-primary">
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
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">$12,489</div>
                                            <div class="mt-2 mb-0 text-muted text-xs">
                                                <span class="text-success mr-2">
                                                    <i class="fas fa-arrow-up"></i> 12%
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

                        <!-- Orders -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-left-success shadow h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Orders
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_orders'] }}</div>
                                            <div class="mt-2 mb-0 text-muted text-xs">
                                                <span class="text-success mr-2">
                                                    <i class="fas fa-arrow-up"></i> 8%
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

                        <!-- Sellers -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-left-info shadow h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Active Sellers
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_sellers'] }}</div>
                                            <div class="mt-2 mb-0 text-muted text-xs">
                                                <span class="text-warning mr-2">
                                                    <i class="fas fa-clock"></i> 3 pending
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
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_users'] - $stats['total_sellers'] - 1 }}</div>
                                            <div class="mt-2 mb-0 text-muted text-xs">
                                                <span class="text-success mr-2">
                                                    <i class="fas fa-arrow-up"></i> 15%
                                                </span>
                                                <span>Since last month</span>
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

                    <!-- Charts and Additional Stats -->
                    <div class="row">
                        <!-- Recent Orders -->
                        <div class="col-lg-8 mb-4">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-shopping-bag"></i> Recent Orders
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Customer</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>#ORD-001</td>
                                                    <td>John Doe</td>
                                                    <td>$120.00</td>
                                                    <td><span class="badge bg-success">Completed</span></td>
                                                    <td>2024-01-15</td>
                                                </tr>
                                                <tr>
                                                    <td>#ORD-002</td>
                                                    <td>Jane Smith</td>
                                                    <td>$89.50</td>
                                                    <td><span class="badge bg-warning">Processing</span></td>
                                                    <td>2024-01-15</td>
                                                </tr>
                                                <tr>
                                                    <td>#ORD-003</td>
                                                    <td>Mike Johnson</td>
                                                    <td>$245.75</td>
                                                    <td><span class="badge bg-info">Shipped</span></td>
                                                    <td>2024-01-14</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <a href="{{ route('admin.orders') }}" class="btn btn-primary btn-sm">View All Orders</a>
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
                                        <a href="{{ route('admin.sellers') }}" class="btn btn-outline-primary text-start">
                                            <i class="fas fa-users me-2"></i>Approve Sellers
                                        </a>
                                        <a href="{{ route('admin.orders') }}" class="btn btn-outline-success text-start">
                                            <i class="fas fa-chart-bar me-2"></i>View Sales Report
                                        </a>
                                        <a href="{{ route('admin.messages') }}" class="btn btn-outline-warning text-start">
                                            <i class="fas fa-comments me-2"></i>Check Messages
                                        </a>
                                        <a href="{{ route('admin.payment-settings') }}" class="btn btn-outline-info text-start">
                                            <i class="fas fa-cog me-2"></i>Payment Settings
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Pending Actions -->
                            <div class="card shadow mt-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-warning">
                                        <i class="fas fa-clock"></i> Pending Actions
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="list-group list-group-flush">
                                        <a href="{{ route('admin.sellers') }}" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">Seller Approvals</h6>
                                                <span class="badge bg-danger">3</span>
                                            </div>
                                            <small class="text-muted">3 new seller applications waiting</small>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">Dispute Cases</h6>
                                                <span class="badge bg-warning">2</span>
                                            </div>
                                            <small class="text-muted">Customer-seller disputes to resolve</small>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">Refund Requests</h6>
                                                <span class="badge bg-info">5</span>
                                            </div>
                                            <small class="text-muted">Pending refund approvals</small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Commission Overview -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-percentage"></i> Commission Overview
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-3 mb-3">
                                            <div class="border rounded p-3">
                                                <h4 class="text-success">10%</h4>
                                                <small class="text-muted">Current Commission Rate</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="border rounded p-3">
                                                <h4 class="text-primary">$1,248</h4>
                                                <small class="text-muted">Total Commission This Month</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="border rounded p-3">
                                                <h4 class="text-info">45</h4>
                                                <small class="text-muted">Commissionable Orders</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="border rounded p-3">
                                                <h4 class="text-warning">$8,320</h4>
                                                <small class="text-muted">Pending Payouts</small>
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