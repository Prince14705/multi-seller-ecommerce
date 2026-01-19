@extends('admin.dashboard')
@section('title', 'Customer Deposits')

@section('content')
<div class="container-fluid pt-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3"><i class="fas fa-wallet"></i> Customer Deposits</h1>
            <p class="text-muted mb-0">Manage customer wallet deposits and transactions</p>
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
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Deposits</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$45,678</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Completed</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$42,150</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$2,350</div>
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
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Failed</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$1,178</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-times-circle fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Deposits -->
    <div class="card shadow mb-4">
        <div class="card-header bg-warning text-white">
            <h6 class="m-0 font-weight-bold"><i class="fas fa-exclamation-triangle"></i> Pending Deposit Requests</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-warning">
                        <tr>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Transaction ID</th>
                            <th>Requested Date</th>
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
                                        <small class="text-muted">john@example.com</small>
                                    </div>
                                </div>
                            </td>
                            <td>$500.00</td>
                            <td>Credit Card</td>
                            <td>TXN-789456123</td>
                            <td>2024-01-15 14:30</td>
                            <td>
                                <button class="btn btn-sm btn-success me-1"><i class="fas fa-check"></i> Approve</button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-times"></i> Reject</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/40" class="seller-avatar me-3" alt="Customer">
                                    <div>
                                        <strong>Sarah Johnson</strong><br>
                                        <small class="text-muted">sarah@example.com</small>
                                    </div>
                                </div>
                            </td>
                            <td>$250.00</td>
                            <td>PayPal</td>
                            <td>TXN-321654987</td>
                            <td>2024-01-15 11:20</td>
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

    <!-- All Deposits Table -->
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Deposit Transactions</h6>
            <div class="input-group" style="width: 300px;">
                <input type="text" class="form-control" placeholder="Search transactions...">
                <button class="btn btn-outline-primary"><i class="fas fa-search"></i></button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Transaction ID</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>TXN-123456789</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/40" class="seller-avatar me-3" alt="Customer">
                                    <div>
                                        <strong>Mike Wilson</strong><br>
                                        <small class="text-muted">mike@example.com</small>
                                    </div>
                                </div>
                            </td>
                            <td>$1,000.00</td>
                            <td>Bank Transfer</td>
                            <td>2024-01-14 09:15</td>
                            <td><span class="badge bg-success">Completed</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary" title="View"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-info" title="Receipt"><i class="fas fa-receipt"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>TXN-987654321</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/40" class="seller-avatar me-3" alt="Customer">
                                    <div>
                                        <strong>Emma Davis</strong><br>
                                        <small class="text-muted">emma@example.com</small>
                                    </div>
                                </div>
                            </td>
                            <td>$750.00</td>
                            <td>Credit Card</td>
                            <td>2024-01-13 16:45</td>
                            <td><span class="badge bg-success">Completed</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-info"><i class="fas fa-receipt"></i></button>
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