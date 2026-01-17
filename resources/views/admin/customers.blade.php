@extends('admin.dashboard')
@section('title', 'Customer Management')

@section('content')
<div class="container-fluid pt-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3"><i class="fas fa-user-friends"></i> Customer Management</h1>
            <p class="text-muted mb-0">Manage customer accounts and activities</p>
        </div>
        <div class="btn-group">
            <button class="btn btn-outline-primary"><i class="fas fa-download"></i> Export</button>
            <button class="btn btn-primary"><i class="fas fa-sync"></i> Refresh</button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Customers</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">2,456</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">2,120</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">156</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">3.2</div>
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
            <div class="input-group" style="width: 300px;">
                <input type="text" class="form-control" placeholder="Search customers...">
                <button class="btn btn-outline-primary"><i class="fas fa-search"></i></button>
            </div>
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
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/40" class="seller-avatar me-3" alt="Customer">
                                    <div>
                                        <strong>John Smith</strong><br>
                                        <small class="text-muted">Member since: 2023-05-15</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                john.smith@example.com<br>
                                <small class="text-muted">+1 234 567 8900</small>
                            </td>
                            <td>15</td>
                            <td>$2,450.00</td>
                            <td>2024-01-14</td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary" title="View"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-info" title="Message"><i class="fas fa-envelope"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/40" class="seller-avatar me-3" alt="Customer">
                                    <div>
                                        <strong>Sarah Johnson</strong><br>
                                        <small class="text-muted">Member since: 2023-08-22</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                sarah.j@example.com<br>
                                <small class="text-muted">+1 234 567 8901</small>
                            </td>
                            <td>8</td>
                            <td>$1,230.00</td>
                            <td>2024-01-12</td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-info"><i class="fas fa-envelope"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/40" class="seller-avatar me-3" alt="Customer">
                                    <div>
                                        <strong>Mike Wilson</strong><br>
                                        <small class="text-muted">Member since: 2024-01-05</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                mike.wilson@example.com<br>
                                <small class="text-muted">+1 234 567 8902</small>
                            </td>
                            <td>2</td>
                            <td>$345.00</td>
                            <td>2024-01-10</td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-info"><i class="fas fa-envelope"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/40" class="seller-avatar me-3" alt="Customer">
                                    <div>
                                        <strong>Emma Davis</strong><br>
                                        <small class="text-muted">Member since: 2023-11-30</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                emma.davis@example.com<br>
                                <small class="text-muted">+1 234 567 8903</small>
                            </td>
                            <td>0</td>
                            <td>$0.00</td>
                            <td>-</td>
                            <td><span class="badge bg-warning">Inactive</span></td>
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
@endsection