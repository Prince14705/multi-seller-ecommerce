@extends('admin.dashboard')
@section('title', 'Blog Management')

@section('content')
<div class="container-fluid pt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3"><i class="fas fa-blog"></i> Blog Management</h1>
            <p class="text-muted mb-0">Manage blog posts and articles</p>
        </div>
        <button class="btn btn-primary"><i class="fas fa-plus"></i> New Post</button>
    </div>
    
    <div class="card shadow">
        <div class="card-body">
            <p>Blog management page content goes here.</p>
        </div>
    </div>
</div>
@endsection