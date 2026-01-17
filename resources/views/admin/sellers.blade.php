<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Management - Admin Dashboard</title>
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
        .seller-avatar { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; }
        .table th { border-top: none; font-weight: 600; }
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
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.orders') }}"><i class="fas fa-shopping-bag"></i> Orders</a></li>
                    
                    <li class="nav-item mt-3"><small class="text-uppercase text-muted px-3">User Management</small></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('admin.sellers') }}"><i class="fas fa-users"></i> Manage Sellers</a></li>
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
                            <h1 class="h3"><i class="fas fa-users"></i> Seller Management</h1>
                            <p class="text-muted mb-0">Manage seller accounts and approvals</p>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-outline-primary"><i class="fas fa-download"></i> Export</button>
                            <button class="btn btn-primary"><i class="fas fa-sync"></i> Refresh</button>
                        </div>
                    </div>

                    <!-- Seller Stats -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-left-primary shadow h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Sellers</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">156</div>
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
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active Sellers</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">142</div>
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
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Approval</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">8</div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-clock fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-left-danger shadow h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Suspended</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">6</div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-ban fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Approvals Section -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-warning text-white">
                            <h6 class="m-0 font-weight-bold"><i class="fas fa-exclamation-triangle"></i> Pending Approvals</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-warning">
                                        <tr>
                                            <th>Seller</th>
                                            <th>Store Name</th>
                                            <th>Email</th>
                                            <th>Applied Date</th>
                                            <th>Documents</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://via.placeholder.com/40" class="seller-avatar me-3" alt="Seller">
                                                    <div>
                                                        <strong>John Smith</strong><br>
                                                        <small class="text-muted">+1 234 567 8900</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>TechGadgets Pro</td>
                                            <td>john.smith@example.com</td>
                                            <td>2024-01-15</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fas fa-file-pdf"></i> View</button>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-success me-1"><i class="fas fa-check"></i> Approve</button>
                                                <button class="btn btn-sm btn-danger"><i class="fas fa-times"></i> Reject</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://via.placeholder.com/40" class="seller-avatar me-3" alt="Seller">
                                                    <div>
                                                        <strong>Sarah Johnson</strong><br>
                                                        <small class="text-muted">+1 234 567 8901</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Fashion Boutique</td>
                                            <td>sarah.j@example.com</td>
                                            <td>2024-01-14</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fas fa-file-pdf"></i> View</button>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-success me-1"><i class="fas fa-check"></i> Approve</button>
                                                <button class="btn btn-sm btn-danger"><i class="fas fa-times"></i> Reject</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- All Sellers Table -->
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">All Sellers</h6>
                            <div class="input-group" style="width: 300px;">
                                <input type="text" class="form-control" placeholder="Search sellers...">
                                <button class="btn btn-outline-primary"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Seller Info</th>
                                            <th>Store Details</th>
                                            <th>Products</th>
                                            <th>Sales</th>
                                            <th>Status</th>
                                            <th>Rating</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://via.placeholder.com/40" class="seller-avatar me-3" alt="Seller">
                                                    <div>
                                                        <strong>Mike Wilson</strong><br>
                                                        <small class="text-muted">mike@techstore.com</small><br>
                                                        <small class="text-muted">Joined: 2023-12-01</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <strong>TechStore Pro</strong><br>
                                                <small class="text-muted">Electronics & Gadgets</small><br>
                                                <span class="badge bg-success">Verified</span>
                                            </td>
                                            <td>45</td>
                                            <td>$12,450</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                            <td>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half-alt"></i>
                                                    <small class="text-muted">4.5/5</small>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" title="View"><i class="fas fa-eye"></i></button>
                                                <button class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-sm btn-info" title="Message"><i class="fas fa-envelope"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://via.placeholder.com/40" class="seller-avatar me-3" alt="Seller">
                                                    <div>
                                                        <strong>Emma Davis</strong><br>
                                                        <small class="text-muted">emma@fashionhub.com</small><br>
                                                        <small class="text-muted">Joined: 2023-11-15</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <strong>FashionHub</strong><br>
                                                <small class="text-muted">Clothing & Accessories</small><br>
                                                <span class="badge bg-success">Verified</span>
                                            </td>
                                            <td>78</td>
                                            <td>$8,920</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                            <td>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <small class="text-muted">4.0/5</small>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                                <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-sm btn-info"><i class="fas fa-envelope"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://via.placeholder.com/40" class="seller-avatar me-3" alt="Seller">
                                                    <div>
                                                        <strong>David Brown</strong><br>
                                                        <small class="text-muted">david@homeessentials.com</small><br>
                                                        <small class="text-muted">Joined: 2024-01-05</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <strong>HomeEssentials</strong><br>
                                                <small class="text-muted">Home & Kitchen</small><br>
                                                <span class="badge bg-warning">Pending</span>
                                            </td>
                                            <td>12</td>
                                            <td>$1,230</td>
                                            <td><span class="badge bg-warning">Under Review</span></td>
                                            <td>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <small class="text-muted">3.0/5</small>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                                <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-sm btn-info"><i class="fas fa-envelope"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://via.placeholder.com/40" class="seller-avatar me-3" alt="Seller">
                                                    <div>
                                                        <strong>Lisa Anderson</strong><br>
                                                        <small class="text-muted">lisa@beautyspot.com</small><br>
                                                        <small class="text-muted">Joined: 2023-10-20</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <strong>BeautySpot</strong><br>
                                                <small class="text-muted">Cosmetics & Skincare</small><br>
                                                <span class="badge bg-success">Verified</span>
                                            </td>
                                            <td>63</td>
                                            <td>$15,780</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                            <td>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <small class="text-muted">5.0/5</small>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                                <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-sm btn-info"><i class="fas fa-envelope"></i></button>
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
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple JavaScript for interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effects to table rows
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#f8f9fa';
                });
                row.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                });
            });
            
            // Approve/Reject buttons functionality
            const approveButtons = document.querySelectorAll('.btn-success');
            const rejectButtons = document.querySelectorAll('.btn-danger');
            
            approveButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const sellerName = this.closest('tr').querySelector('strong').textContent;
                    if (confirm(`Are you sure you want to approve ${sellerName}?`)) {
                        alert(`${sellerName} has been approved successfully!`);
                        // In a real application, you would make an API call here
                    }
                });
            });
            
            rejectButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const sellerName = this.closest('tr').querySelector('strong').textContent;
                    if (confirm(`Are you sure you want to reject ${sellerName}?`)) {
                        alert(`${sellerName} has been rejected.`);
                        // In a real application, you would make an API call here
                    }
                });
            });
        });
    </script>
</body>
</html>