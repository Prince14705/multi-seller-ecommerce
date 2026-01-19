@extends('admin.dashboard')
@section('title', 'SEO Tools')

@section('content')
<div class="container-fluid pt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3"><i class="fas fa-search"></i> SEO Tools</h1>
            <p class="text-muted mb-0">Search Engine Optimization tools</p>
        </div>
        <button class="btn btn-primary"><i class="fas fa-sync"></i> Scan Site</button>
    </div>
    
    <div class="card shadow">
        <div class="card-body">
            <p>SEO tools page content goes here.</p>
        </div>
    </div>
</div>
@endsection