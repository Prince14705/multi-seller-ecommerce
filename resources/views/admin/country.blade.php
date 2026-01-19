@extends('admin.dashboard')
@section('title', 'Manage Countries')

@section('content')
<div class="container-fluid pt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3"><i class="fas fa-globe"></i> Manage Countries/Regions</h1>
            <p class="text-muted mb-0">Manage available countries and regions</p>
        </div>
        <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Country</button>
    </div>
    
    <div class="card shadow">
        <div class="card-body">
            <p>Countries management page content goes here.</p>
        </div>
    </div>
</div>
@endsection