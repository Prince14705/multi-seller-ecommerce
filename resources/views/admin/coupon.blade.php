@extends('admin.dashboard')
@section('title', 'Coupons Management')

@section('content')
<div class="container-fluid pt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3"><i class="fas fa-tags"></i> Coupons Management</h1>
            <p class="text-muted mb-0">Manage discount coupons and promotions</p>
        </div>
        <button class="btn btn-primary"><i class="fas fa-plus"></i> Create Coupon</button>
    </div>
    
    <div class="card shadow">
        <div class="card-body">
            <p>Coupons management page content goes here.</p>
        </div>
    </div>
</div>
@endsection