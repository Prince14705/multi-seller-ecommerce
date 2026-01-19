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
        .customer-avatar { width: 30px; height: 30px; border-radius: 50%; object-fit: cover; }
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
                            <button class="btn btn-primary" onclick="window.location.reload()"><i class="fas fa-sync"></i> Refresh</button>
                        </div>
                    </div>

                    <!-- Order Stats -->
                    <div class="row mb-4">
                        <div class="col-xl-2 col-md-4 mb-3">
                            <div class="card stat-card border-left-primary shadow h-100">
                                <div class="card-body text-center">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Orders</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_orders'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-4 mb-3">
                            <div class="card stat-card border-left-warning shadow h-100">
                                <div class="card-body text-center">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending_orders'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-4 mb-3">
                            <div class="card stat-card border-left-info shadow h-100">
                                <div class="card-body text-center">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Processing</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['processing_orders'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-4 mb-3">
                            <div class="card stat-card border-left-success shadow h-100">
                                <div class="card-body text-center">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Completed</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['completed_orders'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-4 mb-3">
                            <div class="card stat-card border-left-danger shadow h-100">
                                <div class="card-body text-center">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Cancelled</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['cancelled_orders'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-4 mb-3">
                            <div class="card stat-card border-left-secondary shadow h-100">
                                <div class="card-body text-center">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Total Revenue</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($stats['total_revenue'] ?? 0, 2) }}</div>
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
                                    <select class="form-select" id="statusFilter">
                                        <option value="">All Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="processing">Processing</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Date From</label>
                                    <input type="date" class="form-control" id="dateFrom">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Date To</label>
                                    <input type="date" class="form-control" id="dateTo">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Search</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="searchInput" placeholder="Order ID or Customer">
                                        <button class="btn btn-primary" onclick="filterOrders()"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Table -->
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">All Orders</h6>
                            <span class="text-muted">Showing {{ $orders->count() }} of {{ $stats['total_orders'] ?? 0 }} orders</span>
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
                                        @forelse($orders as $order)
                                        <tr>
                                            <td><strong>#{{ $order->order_number ?? $order->id }}</strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $order->customer->avatar ?? 'https://via.placeholder.com/30' }}" 
                                                         class="customer-avatar me-2" 
                                                         alt="{{ $order->customer->name ?? 'Customer' }}">
                                                    <div>
                                                        <div>{{ $order->customer->name ?? 'N/A' }}</div>
                                                        <small class="text-muted">{{ $order->customer->email ?? 'No email' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>${{ number_format($order->total_amount ?? 0, 2) }}</td>
                                            <td>
                                                @php
                                                    $status = $order->status ?? 'pending';
                                                    $badgeColor = 'warning';
                                                    if ($status === 'completed') $badgeColor = 'success';
                                                    if ($status === 'processing') $badgeColor = 'info';
                                                    if ($status === 'cancelled') $badgeColor = 'danger';
                                                    if ($status === 'shipped') $badgeColor = 'primary';
                                                @endphp
                                                <span class="badge bg-{{ $badgeColor }} order-status-badge">
                                                    {{ ucfirst($status) }}
                                                </span>
                                            </td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" onclick="viewOrder({{ $order->id }})" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-warning" onclick="editOrder({{ $order->id }})" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-bs-toggle="dropdown" title="Update Status">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#" onclick="updateOrderStatus({{ $order->id }}, 'pending')">Mark as Pending</a></li>
                                                        <li><a class="dropdown-item" href="#" onclick="updateOrderStatus({{ $order->id }}, 'processing')">Mark as Processing</a></li>
                                                        <li><a class="dropdown-item" href="#" onclick="updateOrderStatus({{ $order->id }}, 'completed')">Mark as Completed</a></li>
                                                        <li><a class="dropdown-item" href="#" onclick="updateOrderStatus({{ $order->id }}, 'cancelled')">Mark as Cancelled</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="fas fa-shopping-bag fa-2x mb-2"></i>
                                                <p>No orders found</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            @if($orders->hasPages())
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center mt-4">
                                    {{ $orders->links() }}
                                </ul>
                            </nav>
                            @endif
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
                                            <span class="badge bg-warning rounded-pill">{{ $stats['pending_orders'] ?? 0 }}</span>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            Processing Orders
                                            <span class="badge bg-info rounded-pill">{{ $stats['processing_orders'] ?? 0 }}</span>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            Refund Requests
                                            <span class="badge bg-danger rounded-pill">{{ $stats['refund_requests'] ?? 0 }}</span>
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
                                            <h4 class="text-primary">{{ $stats['total_orders'] ?? 0 }}</h4>
                                            <small class="text-muted">Total Orders</small>
                                        </div>
                                        <div class="col-3">
                                            <h4 class="text-success">${{ number_format($stats['total_revenue'] ?? 0, 2) }}</h4>
                                            <small class="text-muted">Total Revenue</small>
                                        </div>
                                        <div class="col-3">
                                            <h4 class="text-info">${{ number_format($stats['total_commission'] ?? 0, 2) }}</h4>
                                            <small class="text-muted">Commission</small>
                                        </div>
                                        <div class="col-3">
                                            <h4 class="text-warning">{{ $stats['success_rate'] ?? 0 }}%</h4>
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

    <!-- Order Details Modal -->
    <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="orderDetailsContent">
                    <!-- Order details will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // View Order Details
        function viewOrder(orderId) {
            fetch(`/admin/orders/${orderId}/details`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('orderDetailsContent').innerHTML = data.html;
                    new bootstrap.Modal(document.getElementById('orderDetailsModal')).show();
                })
                .catch(error => console.error('Error:', error));
        }

        // Edit Order
        function editOrder(orderId) {
            alert('Edit order: ' + orderId);
            // Implement edit functionality
        }

        // Update Order Status
        function updateOrderStatus(orderId, status) {
            if(confirm(`Are you sure you want to mark this order as ${status}?`)) {
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

        // Filter Orders
        function filterOrders() {
            const status = document.getElementById('statusFilter').value;
            const dateFrom = document.getElementById('dateFrom').value;
            const dateTo = document.getElementById('dateTo').value;
            const search = document.getElementById('searchInput').value;

            let url = new URL(window.location.href);
            let params = new URLSearchParams();

            if (status) params.append('status', status);
            if (dateFrom) params.append('date_from', dateFrom);
            if (dateTo) params.append('date_to', dateTo);
            if (search) params.append('search', search);

            window.location.href = url.pathname + '?' + params.toString();
        }

        // Auto-submit filters when values change
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('statusFilter').addEventListener('change', filterOrders);
            document.getElementById('dateFrom').addEventListener('change', filterOrders);
            document.getElementById('dateTo').addEventListener('change', filterOrders);
        });
    </script>
</body>
</html>