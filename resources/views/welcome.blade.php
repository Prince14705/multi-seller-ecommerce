<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>E-Commerce App</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

        <style>
            body {
                font-family: 'Instrument Sans', sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .welcome-card {
                background: white;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                overflow: hidden;
            }
            .welcome-header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 2rem;
                text-align: center;
            }
            .welcome-body {
                padding: 2rem;
            }
            .btn-welcome {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border: none;
                color: white;
                padding: 10px 30px;
                border-radius: 25px;
                transition: transform 0.2s;
            }
            .btn-welcome:hover {
                transform: translateY(-2px);
                color: white;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="welcome-card">
                        <div class="welcome-header">
                            <h1><i class="fas fa-shopping-cart"></i> E-Commerce App</h1>
                            <p class="mb-0">Welcome to our multi-vendor e-commerce platform</p>
                        </div>
                        <div class="welcome-body text-center">
                            <p class="lead mb-4">
                                A complete e-commerce solution with admin, seller, and customer panels.
                            </p>
                            <div class="row mb-4">
                                <div class="col-md-4 mb-3">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <i class="fas fa-user-shield fa-2x text-primary mb-3"></i>
                                            <h5>Admin Panel</h5>
                                            <p class="text-muted small">Manage sellers, products, and orders</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <i class="fas fa-store fa-2x text-success mb-3"></i>
                                            <h5>Seller Panel</h5>
                                            <p class="text-muted small">Sell products and manage inventory</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <i class="fas fa-user fa-2x text-info mb-3"></i>
                                            <h5>Customer Panel</h5>
                                            <p class="text-muted small">Shop from multiple sellers</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Debug info (remove in production) -->
                            <div class="alert alert-info text-start small mb-4">
                                <strong>Debug Info:</strong><br>
                                Auth Check: {{ auth()->check() ? 'Yes' : 'No' }}<br>
                                User: {{ auth()->check() ? auth()->user()->name : 'Not logged in' }}<br>
                                Role: {{ auth()->check() ? auth()->user()->role : 'N/A' }}
                            </div>
                            
                            @auth
                                <!-- Show when user is logged in -->
                                <div class="alert alert-success">
                                    <h4>Welcome back, {{ Auth::user()->name }}!</h4>
                                    <p>You are logged in as <strong>{{ ucfirst(Auth::user()->role) }}</strong></p>
                                    
                                    @if(Auth::user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="btn btn-welcome me-2">
                                            <i class="fas fa-tachometer-alt"></i> Go to Admin Dashboard
                                        </a>
                                    @elseif(Auth::user()->isSeller())
                                        <a href="{{ route('seller.dashboard') }}" class="btn btn-welcome me-2">
                                            <i class="fas fa-store"></i> Go to Seller Dashboard
                                        </a>
                                    @else
                                        <a href="{{ route('home') }}" class="btn btn-welcome me-2">
                                            <i class="fas fa-user"></i> Go to Customer Dashboard
                                        </a>
                                    @endif
                                    
                                    <a href="{{ route('products.index') }}" class="btn btn-outline-primary me-2">
                                        <i class="fas fa-shopping-bag"></i> Go Shopping
                                    </a>
                                    
                                    <a href="{{ route('logout') }}" 
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                       class="btn btn-outline-danger">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            @else
                                <!-- Show when user is not logged in -->
                                <div class="d-flex gap-3 justify-content-center flex-wrap">
                                    <a href="{{ route('login') }}" class="btn btn-welcome">
                                        <i class="fas fa-sign-in-alt"></i> Login
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn btn-outline-primary">
                                            <i class="fas fa-user-plus"></i> Register
                                        </a>
                                    @endif
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>