@extends('admin.dashboard')
@section('title', 'Staff Management')

@section('content')
<div class="container-fluid pt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3"><i class="fas fa-users-cog"></i> Staff Management</h1>
            <p class="text-muted mb-0">Manage staff members and permissions</p>
        </div>
        <button class="btn btn-primary"><i class="fas fa-user-plus"></i> Add Staff</button>
    </div>
    
    <div class="card shadow">
        <div class="card-body">
            <p>Staff management page content goes here.</p>
        </div>
    </div>
</div>
@endsection