@extends('admin.dashboard')
@section('title', 'Messages & Disputes')

@section('content')
<div class="container-fluid pt-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3"><i class="fas fa-comments"></i> Messages & Disputes</h1>
            <p class="text-muted mb-0">Manage customer support messages and dispute resolution</p>
        </div>
        <div class="btn-group">
            <button class="btn btn-outline-primary"><i class="fas fa-filter"></i> Filter</button>
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
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Unread Messages</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">23</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-envelope fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-left-warning shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Open Disputes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">8</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Resolved Today</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">12</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-left-info shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Avg Response Time</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">2.4h</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-clock fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Messages List -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-inbox"></i> Recent Messages</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action unread-message">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">John Smith</h6>
                                <small>10 min ago</small>
                            </div>
                            <p class="mb-1">Order #12345 not delivered yet</p>
                            <small class="text-muted">Last reply: Customer</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Sarah Johnson</h6>
                                <small>25 min ago</small>
                            </div>
                            <p class="mb-1">Product damaged upon arrival</p>
                            <small class="text-muted">Last reply: Support Agent</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action unread-message">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Mike Wilson</h6>
                                <small>1 hour ago</small>
                            </div>
                            <p class="mb-1">Refund request for canceled order</p>
                            <small class="text-muted">Last reply: Customer</small>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Open Disputes -->
            <div class="card shadow mt-4">
                <div class="card-header bg-warning text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-exclamation-triangle"></i> Open Disputes</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Dispute ID</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>DSP-78945</td>
                                    <td>Refund</td>
                                    <td><span class="badge bg-warning">Under Review</span></td>
                                    <td><button class="btn btn-sm btn-primary">View</button></td>
                                </tr>
                                <tr>
                                    <td>DSP-78946</td>
                                    <td>Item Not Received</td>
                                    <td><span class="badge bg-danger">Urgent</span></td>
                                    <td><button class="btn btn-sm btn-primary">View</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message Thread -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="m-0 font-weight-bold">Conversation with John Smith</h6>
                        <small class="text-muted">Regarding Order #12345 - Delayed Delivery</small>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-outline-primary"><i class="fas fa-phone"></i></button>
                        <button class="btn btn-sm btn-outline-success"><i class="fas fa-video"></i></button>
                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-flag"></i></button>
                    </div>
                </div>
                <div class="card-body message-thread" style="height: 400px; overflow-y: auto;">
                    <!-- Message Thread Content -->
                    <div class="message received mb-3">
                        <div class="d-flex">
                            <img src="https://via.placeholder.com/32" class="rounded-circle me-2" alt="Customer">
                            <div>
                                <div class="message-bubble bg-light rounded p-3">
                                    <p class="mb-1">Hello, my order #12345 was supposed to be delivered yesterday but I haven't received any updates. Can you check the status for me?</p>
                                    <small class="text-muted">John Smith - 2024-01-15 14:30</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="message sent mb-3">
                        <div class="d-flex justify-content-end">
                            <div>
                                <div class="message-bubble bg-primary text-white rounded p-3">
                                    <p class="mb-1">Hello John, I've checked your order status. There's been a slight delay in shipping due to weather conditions. Your order is now expected to arrive tomorrow.</p>
                                    <small class="text-white-50">Support Agent - 2024-01-15 14:45</small>
                                </div>
                            </div>
                            <img src="https://via.placeholder.com/32" class="rounded-circle ms-2" alt="Agent">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Type your message...">
                        <button class="btn btn-primary"><i class="fas fa-paper-plane"></i> Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.unread-message { background-color: #f8f9fa; border-left: 3px solid #007bff; }
.message-bubble { max-width: 70%; }
.message.sent .message-bubble { margin-left: auto; }
</style>
@endsection