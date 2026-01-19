<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar { min-height: 100vh; background: #2c3e50; color: white; }
        .sidebar .nav-link { color: #bdc3c7; padding: 12px 20px; border-left: 3px solid transparent; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: white; background: #34495e; border-left: 3px solid #3498db; }
        .sidebar .nav-link i { width: 20px; margin-right: 10px; }
        .sidebar-header { padding: 20px; background: #34495e; border-bottom: 1px solid #46627f; }
        .main-content { background: #ecf0f1; min-height: 100vh; }
        .stat-card { transition: transform 0.3s; border: none; border-radius: 10px; }
        .stat-card:hover { transform: translateY(-5px); }
        .customer-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
        .search-form { max-width: 300px; }
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
                    
                    <li class="nav-item mt-3"><small class="text-uppercase text-muted px-3">User Management</small></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.sellers') }}"><i class="fas fa-users"></i> Manage Sellers</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('admin.customers') }}"><i class="fas fa-user-friends"></i> Customers</a></li>
                    
                    <li class="nav-item mt-3"><small class="text-uppercase text-muted px-3">Sales & Orders</small></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.orders') }}"><i class="fas fa-shopping-bag"></i> Orders</a></li>
                    
                    <li class="nav-item mt-3"><small class="text-uppercase text-muted px-3">Catalog</small></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.categories') }}"><i class="fas fa-tags"></i> Categories</a></li>
                </ul>
            </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 main-content px-4">
                <div class="container-fluid pt-4">
                    <!-- Page Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="h3"><i class="fas fa-user-friends"></i> Customer Management</h1>
                            <p class="text-muted mb-0">Manage customer accounts and activities</p>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-outline-primary"><i class="fas fa-download"></i> Export</button>
                            <button class="btn btn-primary" onclick="window.location.reload()"><i class="fas fa-sync"></i> Refresh</button>
                        </div>
                    </div>

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-left-primary shadow h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Customers</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalCustomers) }}</div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-left-success shadow h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active Customers</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($activeCustomers) }}</div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-left-warning shadow h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">New This Month</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($newThisMonth) }}</div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-user-plus fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-left-info shadow h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Avg. Orders/Customer</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($avgOrders, 1) }}</div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-shopping-cart fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customers Table -->
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">All Customers</h6>
                            <form action="{{ route('admin.customers') }}" method="GET" class="search-form">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" placeholder="Search customers..." value="{{ $search ?? '' }}">
                                    <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
                                    @if($search ?? '')
                                        <a href="{{ route('admin.customers') }}" class="btn btn-outline-secondary" title="Clear search">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Customer</th>
                                            <th>Contact</th>
                                            <th>Orders</th>
                                            <th>Total Spent</th>
                                            <th>Last Order</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($customers as $customer)
                                        @php
                                            $lastOrder = $customer->orders->first();
                                            $totalSpent = $customer->orders->sum('total_amount');
                                            $isActive = $customer->orders_count > 0;
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $customer->avatar ?? 'https://via.placeholder.com/40?text=' . substr($customer->name, 0, 1) }}" 
                                                         class="customer-avatar me-3" 
                                                         alt="{{ $customer->name }}"
                                                         onerror="this.src='https://via.placeholder.com/40?text={{ substr($customer->name, 0, 1) }}'">
                                                    <div>
                                                        <strong>{{ $customer->name }}</strong><br>
                                                        <small class="text-muted">Member since: {{ $customer->created_at->format('Y-m-d') }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $customer->email }}<br>
                                                <small class="text-muted">{{ $customer->phone ?? 'No phone' }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $customer->orders_count }}</span>
                                            </td>
                                            <td>
                                                <strong>${{ number_format($totalSpent, 2) }}</strong>
                                            </td>
                                            <td>
                                                @if($lastOrder)
                                                    {{ $lastOrder->created_at->format('M d, Y') }}
                                                @else
                                                    <span class="text-muted">No orders</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $isActive ? 'success' : 'warning' }}">
                                                    {{ $isActive ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.customers.show', $customer->id) }}" 
                                                       class="btn btn-outline-primary" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button class="btn btn-outline-warning" 
                                                            onclick="editCustomer({{ $customer->id }})"
                                                            title="Edit Customer">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-outline-info" 
                                                            onclick="messageCustomer({{ $customer->id }})"
                                                            title="Send Message">
                                                        <i class="fas fa-envelope"></i>
                                                    </button>
                                                    @if($customer->orders_count == 0)
                                                    <form action="{{ route('admin.customers.destroy', $customer->id) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-outline-danger"
                                                                onclick="return confirm('Are you sure you want to delete this customer?')"
                                                                title="Delete Customer">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                <i class="fas fa-user-friends fa-2x mb-2"></i>
                                                <p>No customers found</p>
                                                @if($search ?? '')
                                                    <a href="{{ route('admin.customers') }}" class="btn btn-primary">Clear Search</a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            @if($customers->hasPages())
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center mt-4">
                                    {{ $customers->withQueryString()->links() }}
                                </ul>
                            </nav>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editCustomer(customerId) {
            alert('Edit customer: ' + customerId);
            // Implement edit functionality
        }

        function messageCustomer(customerId) {
            alert('Message customer: ' + customerId);
            // Implement message functionality
        }

        // Auto-refresh every 30 seconds
        setInterval(() => {
            // You can implement auto-refresh here if needed
        }, 30000);
    </script>
</body>
</html>