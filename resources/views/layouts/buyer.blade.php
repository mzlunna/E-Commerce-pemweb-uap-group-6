<!DOCTYPE html>
<html>
<head>
    <title>Buyer - @yield('title')</title>
</head>
<body>
    <header>
        <nav>
            <a href="{{ route('buyer.dashboard') }}">Dashboard</a>
            <a href="{{ route('buyer.products.index') }}">Products</a>
            <a href="{{ route('buyer.cart') }}">Cart</a>
            <a href="{{ route('buyer.orders') }}">Orders</a>
            <a href="{{ route('buyer.profile.edit') }}">Profile</a>
            <a href="{{ route('buyer.store.apply') }}">Apply Store</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>
