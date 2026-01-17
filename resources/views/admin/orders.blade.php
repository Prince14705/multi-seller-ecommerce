<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Management - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar { min-height: 100vh; background: #2c3e50; color: white; transition: all 0.3s; }
        .sidebar .nav-link { color: #bdc3c7; padding: 12px 20px; border-left: 3px solid transparent; transition: all 0.3s; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: white; background: #34495e; border-left: 3px solid #3498db; }
        .sidebar .nav-link i { width: 20px; margin-right: 10px; }
        .sidebar-header { padding: 20px; background: #34495e; border-bottom: 1px solid #46627f; }
        .main-content { background: #ecf0f1; min-height: 100vh; }
        .stat-card { transition: transform 0.3s; border: none; border-radius: 10px; }
        .stat-card:hover { transform: translateY(-5px); }
        .order-status-badge { font-size: 0.75rem; }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><i class="fas fa-shopping-cart"></i> E-Commerce Admin</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3"><i class="fas fa-user-circle"></i> {{ auth()->user()->name }}</span>
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="sidebar-header">
                    <h6 class="mb-0"><i class="fas fa-tachometer-alt"></i> Admin Panel</h6>
                </div>
                
                <ul class="nav flex-column mt-3">
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                    
                    <li class="nav-item mt-3"><small class="text-uppercase text-muted px-3">Sales & Orders</small></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('admin.orders') }}"><i class="fas fa-shopping-bag"></i> Orders</a></li>
                    
                    <li class="nav-item mt-3"><small class="text-uppercase text-muted px-3">User Management</small></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.sellers') }}"><i class="fas fa-users"></i> Manage Sellers</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.customers') }}"><i class="fas fa-user-friends"></i> Customers</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.deposits') }}"><i class="fas fa-wallet"></i> Deposits</a></li>
                    
                    <li class="nav-item mt-3"><small class="text-uppercase text-muted px-3">Catalog</small></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.categories') }}"><i class="fas fa-tags"></i> Categories</a></li>
                    
                    <li class="nav-item mt-3"><small class="text-uppercase text-muted px-3">Support</small></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.messages') }}"><i class="fas fa-comments"></i> Messages</a></li>
                    
                    <li class="nav-item mt-3"><small class="text-uppercase text-muted px-3">Settings</small></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.payment-settings') }}"><i class="fas fa-credit-card"></i> Payment</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.language-settings') }}"><i class="fas fa-language"></i> Language</a></li>
                </ul>
            </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 main-content px-4">
                <div class="container-fluid pt-4">
                    <!-- Page Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="h3"><i class="fas fa-shopping-bag"></i> Orders Management</h1>
                            <p class="text-muted mb-0">Track and manage all customer orders</p>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-outline-primary"><i class="fas fa-download"></i> Export</button>
                            <button class="btn btn-primary"><i class="fas fa-sync"></i> Refresh</button>
                        </div>
                    </div>

                    <!-- Order Stats -->
                    <div class="row mb-4">
                        <div class="col-xl-2 col-md-4 mb-3">
                            <div class="card stat-card border-left-primary shadow h-100">
                                <div class="card-body text-center">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Orders</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">1,248</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-4 mb-3">
                            <div class="card stat-card border-left-warning shadow h-100">
                                <div class="card-body text-center">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">45</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-4 mb-3">
                            <div class="card stat-card border-left-info shadow h-100">
                                <div class="card-body text-center">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Processing</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">28</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-4 mb-3">
                            <div class="card stat-card border-left-success shadow h-100">
                                <div class="card-body text-center">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Completed</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">1,150</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-4 mb-3">
                            <div class="card stat-card border-left-danger shadow h-100">
                                <div class="card-body text-center">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Cancelled</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">25</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-4 mb-3">
                            <div class="card stat-card border-left-secondary shadow h-100">
                                <div class="card-body text-center">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Returns</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters and Search -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select">
                                        <option value="">All Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="processing">Processing</option>
                                        <option value="shipped">Shipped</option>
                                        <option value="delivered">Delivered</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Date From</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Date To</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Search</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Order ID or Customer">
                                        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Table -->
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">All Orders</h6>
                            <span class="text-muted">Showing 1-10 of 1,248 orders</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Seller</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>#ORD-001</strong></td>
                                            <td>John Doe<br><small class="text-muted">john@example.com</small></td>
                                            <td>TechStore Pro</td>
                                            <td>$245.99</td>
                                            <td><span class="badge bg-success order-status-badge">Delivered</span></td>
                                            <td>2024-01-15</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" title="View Details"><i class="fas fa-eye"></i></button>
                                                <button class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-sm btn-info" title="Track"><i class="fas fa-shipping-fast"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>#ORD-002</strong></td>
                                            <td>Jane Smith<br><small class="text-muted">jane@example.com</small></td>
                                            <td>FashionHub</td>
                                            <td>$89.50</td>
                                            <td><span class="badge bg-warning order-status-badge">Pending</span></td>
                                            <td>2024-01-15</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                                <button class="btn btn-sm btn-success" title="Approve"><i class="fas fa-check"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>#ORD-003</strong></td>
                                            <td>Mike Johnson<br><small class="text-muted">mike@example.com</small></td>
                                            <td>ElectroWorld</td>
                                            <td>$1,299.00</td>
                                            <td><span class="badge bg-info order-status-badge">Processing</span></td>
                                            <td>2024-01-14</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                                <button class="btn btn-sm btn-success"><i class="fas fa-check"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>#ORD-004</strong></td>
                                            <td>Sarah Wilson<br><small class="text-muted">sarah@example.com</small></td>
                                            <td>HomeEssentials</td>
                                            <td>$156.75</td>
                                            <td><span class="badge bg-danger order-status-badge">Cancelled</span></td>
                                            <td>2024-01-14</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                                <button class="btn btn-sm btn-secondary"><i class="fas fa-history"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>#ORD-005</strong></td>
                                            <td>David Brown<br><small class="text-muted">david@example.com</small></td>
                                            <td>SportsGear</td>
                                            <td>$67.25</td>
                                            <td><span class="badge bg-success order-status-badge">Delivered</span></td>
                                            <td>2024-01-13</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                                <button class="btn btn-sm btn-info"><i class="fas fa-print"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center mt-4">
                                    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card shadow">
                                <div class="card-header bg-warning text-white">
                                    <h6 class="m-0 font-weight-bold"><i class="fas fa-exclamation-triangle"></i> Pending Actions</h6>
                                </div>
                                <div class="card-body">
                                    <div class="list-group list-group-flush">
                                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            Pending Orders
                                            <span class="badge bg-warning rounded-pill">45</span>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            Refund Requests
                                            <span class="badge bg-danger rounded-pill">12</span>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            Return Requests
                                            <span class="badge bg-info rounded-pill">8</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card shadow">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="m-0 font-weight-bold"><i class="fas fa-chart-line"></i> Orders Overview</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-3">
                                            <h4 class="text-primary">1,248</h4>
                                            <small class="text-muted">Total Orders</small>
                                        </div>
                                        <div class="col-3">
                                            <h4 class="text-success">$45,678</h4>
                                            <small class="text-muted">Total Revenue</small>
                                        </div>
                                        <div class="col-3">
                                            <h4 class="text-info">$4,567</h4>
                                            <small class="text-muted">Commission</small>
                                        </div>
                                        <div class="col-3">
                                            <h4 class="text-warning">94.2%</h4>
                                            <small class="text-muted">Success Rate</small>
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
        // Order status filter
        document.addEventListener('DOMContentLoaded', function() {
            const statusFilter = document.querySelector('select');
            statusFilter.addEventListener('change', function() {
                // Filter functionality would be implemented here
                console.log('Filtering by:', this.value);
            });
        });
    </script>
</body>
</html>