@extends('admin.dashboard')
@section('title', 'Home Page Settings')

@section('content')
<div class="container-fluid pt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3"><i class="fas fa-home"></i> Home/Menu Page Settings</h1>
            <p class="text-muted mb-0">Customize homepage and menu settings</p>
        </div>
        <button class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
    </div>
    
    <div class="card shadow">
        <div class="card-body">
            <p>Home page settings content goes here.</p>
        </div>
    </div>
</div>
@endsection