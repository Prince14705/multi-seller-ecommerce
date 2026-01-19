{{-- resources/views/seller/orders/index.blade.php --}}
@extends('layouts.seller')

@section('title', 'Orders - Seller Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3">
                <i class="fas fa-shopping-bag"></i> Order Management
            </h1>
            <p class="text-muted mb-0">Manage and track your customer orders</p>
        </div>
        <div class="btn-group">
            <button class="btn btn-outline-success" onclick="window.print()">
                <i class="fas fa-print"></i> Print
            </button>
            <button class="btn btn-success" onclick="exportOrders()">
                <i class="fas fa-file-export"></i> Export
            </button>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('seller.orders') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="date_from" class="form-label">Date From</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" 
                           value="{{ request('date_from') }}">
                </div>
                <div class="col-md-3">
                    <label for="date_to" class="form-label">Date To</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" 
                           value="{{ request('date_to') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Orders ({{ $orders->total() }})
            </h6>
            <div class="text-muted">
                Showing {{ $orders->firstItem() ?? 0 }}-{{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }}
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Order Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('seller.orders.show', $order->id) }}" 
                                   class="text-decoration-none">
                                    <strong>#{{ $order->order_number }}</strong>
                                </a>
                                @if($order->is_urgent)
                                <span class="badge bg-danger ms-1">Urgent</span>
                                @endif
                            </td>
                            <td>
                                <div>{{ $order->user->name }}</div>
                                <small class="text-muted">{{ $order->user->email }}</small>
                            </td>
                            <td>
                                {{ $order->items_count }} items
                                @if($order->items->count() > 0)
                                <br>
                                <small class="text-muted">
                                    {{ $order->items->first()->product->name }}
                                    @if($order->items_count > 1)
                                    + {{ $order->items_count - 1 }} more
                                    @endif
                                </small>
                                @endif
                            </td>
                            <td>
                                <strong>${{ number_format($order->total_amount, 2) }}</strong>
                                <br>
                                <small class="text-muted">
                                    Shipping: ${{ number_format($order->shipping_amount, 2) }}
                                </small>
                            </td>
                            <td>
                                <span class="badge 
                                    @if($order->status == 'pending') bg-warning
                                    @elseif($order->status == 'processing') bg-info
                                    @elseif($order->status == 'shipped') bg-primary
                                    @elseif($order->status == 'delivered') bg-success
                                    @elseif($order->status == 'cancelled') bg-danger
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                @if($order->payment_status == 'paid')
                                <span class="badge bg-success">Paid</span>
                                @elseif($order->payment_status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                                @else
                                <span class="badge bg-danger">Failed</span>
                                @endif
                                <br>
                                <small class="text-muted">{{ ucfirst($order->payment_method) }}</small>
                            </td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('seller.orders.show', $order->id) }}" 
                                       class="btn btn-outline-primary" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($order->status == 'pending')
                                    <button class="btn btn-outline-success" 
                                            onclick="updateOrderStatus({{ $order->id }}, 'processing')"
                                            title="Start Processing">
                                        <i class="fas fa-play"></i>
                                    </button>
                                    @elseif($order->status == 'processing')
                                    <button class="btn btn-outline-info" 
                                            onclick="updateOrderStatus({{ $order->id }}, 'shipped')"
                                            title="Mark as Shipped">
                                        <i class="fas fa-shipping-fast"></i>
                                    </button>
                                    @elseif($order->status == 'shipped')
                                    <button class="btn btn-outline-success" 
                                            onclick="updateOrderStatus({{ $order->id }}, 'delivered')"
                                            title="Mark as Delivered">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                    @endif
                                    <a href="{{ route('seller.orders.invoice', $order->id) }}" 
                                       class="btn btn-outline-secondary" title="Invoice" target="_blank">
                                        <i class="fas fa-file-invoice"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-shopping-bag fa-2x text-muted mb-3"></i>
                                <h5>No orders found</h5>
                                <p class="text-muted">You don't have any orders yet</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($orders->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Page {{ $orders->currentPage() }} of {{ $orders->lastPage() }}
                </div>
                <div>
                    {{ $orders->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Order Stats -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Total Orders
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_orders'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Revenue
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($stats['revenue'], 2) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Pending Orders
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending_orders'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-info shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Avg. Order Value
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($stats['avg_order_value'], 2) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateOrderStatus(orderId, status) {
    if (confirm('Update order status?')) {
        fetch(`/seller/orders/${orderId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error updating status');
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function exportOrders() {
    const params = new URLSearchParams(window.location.search);
    window.open(`/seller/orders/export?${params.toString()}`, '_blank');
}
</script>
@endsection