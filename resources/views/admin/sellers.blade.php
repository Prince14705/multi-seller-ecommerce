<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sellers Management - Admin Dashboard</title>
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
        .seller-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
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
                    <li class="nav-item"><a class="nav-link active" href="{{ route('admin.sellers') }}"><i class="fas fa-users"></i> Manage Sellers</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.customers') }}"><i class="fas fa-user-friends"></i> Customers</a></li>
                    
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
                            <h1 class="h3"><i class="fas fa-users"></i> Sellers Management</h1>
                            <p class="text-muted mb-0">Manage and monitor all sellers on your platform</p>
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

                    <!-- Seller Stats -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-left-primary shadow h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Sellers</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalSellers ?? 0 }}</div>
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
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Approved</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $approvedSellers ?? 0 }}</div>
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
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingSellers ?? 0 }}</div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-clock fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-left-info shadow h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Products</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProducts ?? 0 }}</div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-box fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sellers Table -->
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">All Sellers</h6>
                            <span class="text-muted">{{ ($sellers ?? collect())->count() }} of {{ $totalSellers ?? 0 }} sellers</span>
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
                                        @forelse($sellers ?? [] as $seller)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $seller->avatar ?? 'https://via.placeholder.com/40' }}" 
                                                         class="seller-avatar me-2" 
                                                         alt="{{ $seller->name }}">
                                                    <div>
                                                        <strong>{{ $seller->name }}</strong>
                                                        <br>
                                                        <small class="text-muted">ID: {{ $seller->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $seller->email }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $seller->products_count ?? 0 }}</span>
                                            </td>
                                            <td>
                                                @if($seller->is_approved)
                                                    <span class="badge bg-success">Approved</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td>{{ $seller->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.sellers.show', $seller->id) }}" class="btn btn-outline-primary" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if(!$seller->is_approved)
                                                    <form action="{{ route('admin.sellers.approve', $seller->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-success" title="Approve">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                    <form action="{{ route('admin.sellers.suspend', $seller->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-danger" 
                                                                onclick="return confirm('Are you sure you want to suspend this seller?')"
                                                                title="Suspend">
                                                            <i class="fas fa-ban"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="fas fa-users fa-2x mb-2"></i>
                                                <p>No sellers found</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>