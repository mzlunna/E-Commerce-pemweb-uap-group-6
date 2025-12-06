<!DOCTYPE html>
<html>
<head>
    <title>Seller - @yield('title')</title>
</head>
<body>
    <header>
        <nav>
            <a href="{{ route('seller.dashboard') }}">Dashboard</a>
            <a href="{{ route('seller.products.index') }}">Products</a>
            <a href="{{ route('seller.categories.index') }}">Categories</a>
            <a href="{{ route('seller.images.index') }}">Images</a>
            <a href="{{ route('seller.orders.index') }}">Orders</a>
            <a href="{{ route('seller.balance.index') }}">Balance</a>
            <a href="{{ route('seller.withdraw.index') }}">Withdraw</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>
