{{-- resources/views/seller/sales/index.blade.php --}}
@extends('layouts.seller')

@section('title', 'Sales Analytics - Seller Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3">
                <i class="fas fa-chart-bar"></i> Sales Analytics
            </h1>
            <p class="text-muted mb-0">Track your sales performance and insights</p>
        </div>
        <div class="btn-group">
            <button class="btn btn-outline-secondary" onclick="printReport()">
                <i class="fas fa-print"></i> Print Report
            </button>
            <button class="btn btn-success" onclick="exportData()">
                <i class="fas fa-download"></i> Export Data
            </button>
        </div>
    </div>

    <!-- Date Range Selector -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form id="dateFilterForm" class="row g-3">
                <div class="col-md-3">
                    <label for="period" class="form-label">Time Period</label>
                    <select class="form-control" id="period" onchange="updateDateRange()">
                        <option value="today">Today</option>
                        <option value="yesterday">Yesterday</option>
                        <option value="last7" selected>Last 7 Days</option>
                        <option value="last30">Last 30 Days</option>
                        <option value="this_month">This Month</option>
                        <option value="last_month">Last Month</option>
                        <option value="this_year">This Year</option>
                        <option value="custom">Custom Range</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" 
                           value="{{ date('Y-m-d', strtotime('-7 days')) }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="end_date" 
                           value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" class="btn btn-primary w-100" onclick="loadData()">
                        <i class="fas fa-filter"></i> Apply Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Sales
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                $<span id="totalSales">{{ number_format($stats['total_sales'], 2) }}</span>
                            </div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span id="salesGrowth" class="{{ $stats['sales_growth'] >= 0 ? 'text-success' : 'text-danger' }} mr-2">
                                    <i class="fas fa-arrow-{{ $stats['sales_growth'] >= 0 ? 'up' : 'down' }}"></i>
                                    {{ abs($stats['sales_growth']) }}%
                                </span>
                                <span>vs previous period</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Orders
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span id="totalOrders">{{ $stats['total_orders'] }}</span>
                            </div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span id="ordersGrowth" class="{{ $stats['orders_growth'] >= 0 ? 'text-success' : 'text-danger' }} mr-2">
                                    <i class="fas fa-arrow-{{ $stats['orders_growth'] >= 0 ? 'up' : 'down' }}"></i>
                                    {{ abs($stats['orders_growth']) }}%
                                </span>
                                <span>vs previous period</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-bag fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Average Order Value
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                $<span id="avgOrderValue">{{ number_format($stats['avg_order_value'], 2) }}</span>
                            </div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span id="aovGrowth" class="{{ $stats['aov_growth'] >= 0 ? 'text-success' : 'text-danger' }} mr-2">
                                    <i class="fas fa-arrow-{{ $stats['aov_growth'] >= 0 ? 'up' : 'down' }}"></i>
                                    {{ abs($stats['aov_growth']) }}%
                                </span>
                                <span>vs previous period</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calculator fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Conversion Rate
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span id="conversionRate">{{ number_format($stats['conversion_rate'], 2) }}</span>%
                            </div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span id="crGrowth" class="{{ $stats['cr_growth'] >= 0 ? 'text-success' : 'text-danger' }} mr-2">
                                    <i class="fas fa-arrow-{{ $stats['cr_growth'] >= 0 ? 'up' : 'down' }}"></i>
                                    {{ abs($stats['cr_growth']) }}%
                                </span>
                                <span>vs previous period</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row">
        <!-- Sales Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-line"></i> Sales Trend
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-star"></i> Top Selling Products
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Sales</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProducts as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 class="rounded me-2" 
                                                 style="width: 30px; height: 30px; object-fit: cover;">
                                            @endif
                                            <div>
                                                <div>{{ Str::limit($product->name, 20) }}</div>
                                                <small class="text-muted">SKU: {{ $product->sku }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $product->total_quantity }}</span>
                                    </td>
                                    <td>${{ number_format($product->total_revenue, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">
                                        No sales data available
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Statistics -->
    <div class="row mt-4">
        <!-- Sales by Category -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-chart-pie"></i> Sales by Category
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Hourly Sales -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-clock"></i> Hourly Sales Pattern
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="hourlyChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Tables -->
    <div class="card shadow mt-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table"></i> Detailed Sales Data
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Orders</th>
                            <th>Items Sold</th>
                            <th>Revenue</th>
                            <th>Avg. Order Value</th>
                            <th>Conversion Rate</th>
                        </tr>
                    </thead>
                    <tbody id="dailyData">
                        @foreach($dailyStats as $day)
                        <tr>
                            <td>{{ $day->date }}</td>
                            <td>{{ $day->orders }}</td>
                            <td>{{ $day->items_sold }}</td>
                            <td>${{ number_format($day->revenue, 2) }}</td>
                            <td>${{ number_format($day->avg_order_value, 2) }}</td>
                            <td>{{ number_format($day->conversion_rate, 2) }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let salesChart, categoryChart, hourlyChart;

document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
});

function initializeCharts() {
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    salesChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: @json($salesTrend['dates']),
            datasets: [{
                label: 'Sales ($)',
                data: @json($salesTrend['sales']),
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                }
            }
        }
    });

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    categoryChart = new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: @json($categorySales->pluck('category')),
            datasets: [{
                data: @json($categorySales->pluck('sales')),
                backgroundColor: [
                    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', 
                    '#e74a3b', '#858796', '#6f42c1', '#20c9a6'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Hourly Chart
    const hourlyCtx = document.getElementById('hourlyChart').getContext('2d');
    hourlyChart = new Chart(hourlyCtx, {
        type: 'bar',
        data: {
            labels: @json($hourlySales->pluck('hour')),
            datasets: [{
                label: 'Sales ($)',
                data: @json($hourlySales->pluck('sales')),
                backgroundColor: 'rgba(78, 115, 223, 0.8)',
                borderColor: '#4e73df',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                }
            }
        }
    });
}

function updateDateRange() {
    const period = document.getElementById('period').value;
    const today = new Date();
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    
    endDate.value = today.toISOString().split('T')[0];
    
    switch(period) {
        case 'today':
            startDate.value = today.toISOString().split('T')[0];
            break;
        case 'yesterday':
            const yesterday = new Date(today);
            yesterday.setDate(yesterday.getDate() - 1);
            startDate.value = yesterday.toISOString().split('T')[0];
            endDate.value = yesterday.toISOString().split('T')[0];
            break;
        case 'last7':
            const last7 = new Date(today);
            last7.setDate(last7.getDate() - 6);
            startDate.value = last7.toISOString().split('T')[0];
            break;
        case 'last30':
            const last30 = new Date(today);
            last30.setDate(last30.getDate() - 29);
            startDate.value = last30.toISOString().split('T')[0];
            break;
        case 'this_month':
            startDate.value = new Date(today.getFullYear(), today.getMonth(), 1)
                .toISOString().split('T')[0];
            break;
        case 'last_month':
            const firstDayLastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
            const lastDayLastMonth = new Date(today.getFullYear(), today.getMonth(), 0);
            startDate.value = firstDayLastMonth.toISOString().split('T')[0];
            endDate.value = lastDayLastMonth.toISOString().split('T')[0];
            break;
        case 'this_year':
            startDate.value = new Date(today.getFullYear(), 0, 1)
                .toISOString().split('T')[0];
            break;
    }
    
    // Disable date inputs for non-custom periods
    const isCustom = period === 'custom';
    startDate.disabled = !isCustom;
    endDate.disabled = !isCustom;
}

function loadData() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    
    // Show loading state
    document.getElementById('totalSales').textContent = 'Loading...';
    document.getElementById('totalOrders').textContent = 'Loading...';
    
    fetch(`/seller/sales/data?start_date=${startDate}&end_date=${endDate}`)
        .then(response => response.json())
        .then(data => {
            // Update summary cards
            document.getElementById('totalSales').textContent = 
                data.stats.total_sales.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById('totalOrders').textContent = data.stats.total_orders;
            document.getElementById('avgOrderValue').textContent = 
                data.stats.avg_order_value.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById('conversionRate').textContent = 
                data.stats.conversion_rate.toFixed(2);
            
            // Update charts
            salesChart.data.labels = data.sales_trend.dates;
            salesChart.data.datasets[0].data = data.sales_trend.sales;
            salesChart.update();
            
            categoryChart.data.labels = data.category_sales.map(c => c.category);
            categoryChart.data.datasets[0].data = data.category_sales.map(c => c.sales);
            categoryChart.update();
            
            hourlyChart.data.labels = data.hourly_sales.map(h => h.hour);
            hourlyChart.data.datasets[0].data = data.hourly_sales.map(h => h.sales);
            hourlyChart.update();
            
            // Update daily data table
            let dailyHtml = '';
            data.daily_stats.forEach(day => {
                dailyHtml += `
                <tr>
                    <td>${day.date}</td>
                    <td>${day.orders}</td>
                    <td>${day.items_sold}</td>
                    <td>$${day.revenue.toFixed(2)}</td>
                    <td>$${day.avg_order_value.toFixed(2)}</td>
                    <td>${day.conversion_rate.toFixed(2)}%</td>
                </tr>`;
            });
            document.getElementById('dailyData').innerHTML = dailyHtml;
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading data');
        });
}

function printReport() {
    window.print();
}

function exportData() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    window.open(`/seller/sales/export?start_date=${startDate}&end_date=${endDate}`, '_blank');
}

// Initialize date range on load
updateDateRange();
</script>
@endsection