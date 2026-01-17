<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">E-Commerce</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Welcome, {{ Auth::user()->name }}
                </span>
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Welcome to Your Dashboard</h1>
        
        @if(Auth::user()->role === 'admin')
        <div class="alert alert-info">
            <h4>Admin Account</h4>
            <p>You have administrative privileges.</p>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Go to Admin Dashboard</a>
        </div>
        @elseif(Auth::user()->role === 'seller')
        <div class="alert alert-warning">
            <h4>Seller Account</h4>
            <p>You can manage your products and view orders.</p>
            <a href="{{ route('seller.dashboard') }}" class="btn btn-primary">Go to Seller Dashboard</a>
        </div>
        @else
        <div class="alert alert-success">
            <h4>Customer Account</h4>
            <p>Welcome to our e-commerce store!</p>
            <a href="{{ route('products.index') }}" class="btn btn-success">Start Shopping</a>
        </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">Visit Store</a>
            <a href="/" class="btn btn-outline-secondary">Home Page</a>
        </div>
    </div>
</body>
</html>