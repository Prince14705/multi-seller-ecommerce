<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">E-Commerce</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Products</h1>
        
        <div class="row">
            @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">${{ $product->price }}</p>
                        <p class="card-text">Stock: {{ $product->stock }}</p>
                        <button class="btn btn-primary">Add to Cart</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            <a href="/home" class="btn btn-secondary">Back to Home</a>
        </div>
    </div>
</body>
</html>