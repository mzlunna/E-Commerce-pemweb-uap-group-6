<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ELSHOP - Marketplace Snack Premium')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/css/header_footer.css'])
    @yield('styles')
</head>
<body>
    <!-- Header Top -->
    <div class="header-top">
        <div class="container-fluid" style="max-width: 1200px;">
            <div class="header-top-content">
                <div class="location">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Dikirim ke Malang, East Java</span>
                </div>
                <div class="top-links">
                    @guest
                        <a href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Masuk
                        </a>
                        <a href="{{ route('register') }}">
                            <i class="fas fa-user-plus"></i> Daftar
                        </a>
                    @endguest
                    @auth
                        <a href="{{ route('buyer.orders.index') }}">
                            <i class="fas fa-box"></i> Pesanan Saya
                        </a>
                        <a href="{{ route('buyer.profile.edit') }}">
                            <i class="fas fa-user"></i> {{ auth()->user()->name }}
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Header Main -->
    <header class="header-main">
        <div class="container-fluid" style="max-width: 1200px;">
            <div class="header-content">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="logo">
                    <img src="{{ asset('images/elshop-logo.png') }}" alt="ELSHOP Logo">
                    <span>ELSHOP</span>
                </a>

                <!-- Search Bar -->
                @auth
                <div class="search-bar">
                    <form action="{{ route('buyer.dashboard') }}" method="GET">
                        <input type="text" name="search" placeholder="Cari di ELSHOP...">
                        <button type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                @endauth

                <!-- Header Icons -->
                <div class="header-icons">
                    @auth
                        @php
                            $user = auth()->user();
                            $hasStore = \App\Models\Store::where('user_id', $user->id)
                                ->where('is_verified', 1)
                                ->exists();
                        @endphp

                        @if($user->role === 'member' && !$hasStore)
                            <!-- Member (Buyer) Icons -->
                            <a href="{{ route('buyer.cart.index') }}" class="icon-link">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Keranjang</span>
                            </a>
                            <a href="{{ route('buyer.orders.index') }}" class="icon-link">
                                <i class="fas fa-box"></i>
                                <span>Pesanan</span>
                            </a>
                        @elseif($hasStore)
                            <!-- Seller Icons -->
                            <a href="{{ route('seller.dashboard') }}" class="icon-link">
                                <i class="fas fa-store"></i>
                                <span>Toko Saya</span>
                            </a>
                            <a href="{{ route('seller.orders.index') }}" class="icon-link">
                                <i class="fas fa-box"></i>
                                <span>Pesanan</span>
                            </a>
                        @elseif($user->role === 'admin')
                            <!-- Admin Icons -->
                            <a href="{{ route('admin.stores.index') }}" class="icon-link">
                                <i class="fas fa-store-alt"></i>
                                <span>Toko</span>
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="icon-link">
                                <i class="fas fa-users"></i>
                                <span>User</span>
                            </a>
                        @endif

                        <!-- Logout -->
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="icon-link" style="background:none;border:none;cursor:pointer;">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main style="min-height: calc(100vh - 200px); padding: 20px 0;">
        <div class="container-fluid" style="max-width: 1200px;">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container-fluid" style="max-width: 1200px;">
            <div class="footer-content">
                <!-- Column 1 -->
                <div class="footer-column">
                    <h4>ELSHOP</h4>
                    <p>Marketplace snack premium terpercaya di Indonesia.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Column 2 -->
                <div class="footer-column">
                    <h4>Belanja</h4>
                    <a href="{{ route('buyer.dashboard') }}">Semua Produk</a>
                    <a href="{{ route('buyer.cart.index') }}">Keranjang</a>
                    <a href="{{ route('buyer.orders.index') }}">Pesanan Saya</a>
                </div>

                <!-- Column 3 -->
                <div class="footer-column">
                    <h4>Jual</h4>
                    @auth
                        <a href="{{ route('buyer.store.apply') }}">Daftar Toko</a>
                    @else
                        <a href="{{ route('login') }}">Daftar Toko</a>
                    @endauth
                    <a href="#">Pusat Edukasi Seller</a>
                    <a href="#">Tips & Trik Jualan</a>
                </div>

                <!-- Column 4 -->
                <div class="footer-column">
                    <h4>Bantuan</h4>
                    <a href="#">Pusat Bantuan</a>
                    <a href="#">Cara Berbelanja</a>
                    <a href="#">Syarat & Ketentuan</a>
                    <a href="#">Kebijakan Privasi</a>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 ELSHOP. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    @yield('scripts')
</body>
</html>