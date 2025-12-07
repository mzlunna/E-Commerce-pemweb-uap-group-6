@extends('layouts.buyer')

@section('title', 'Dashboard - Buyer')

@section('styles')
    @vite(['resources/css/dashboard-buyer.css'])
@endsection

@section('content')
<div class="buyer-container">

    <!-- Header -->
    <div class="buyer-header">
        <h3>Halo, {{ auth()->user()->name }} 👋</h3>
        <p class="buyer-subtitle">Belanja snack favoritmu dengan mudah!</p>
    </div>

    <!-- Search & Filter -->
    <form method="GET" action="{{ route('buyer.dashboard') }}" class="buyer-filter">
        <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}">

        <select name="category">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <input type="number" name="price_min" placeholder="Harga Min" value="{{ request('price_min') }}">
        <input type="number" name="price_max" placeholder="Harga Max" value="{{ request('price_max') }}">

        <button type="submit">Cari</button>
    </form>

    <!-- Product List -->
    @if($products->count() > 0)
        <div class="buyer-product-title">Produk Untukmu</div>

        <div class="buyer-product-grid">
            @foreach($products as $product)
                <div class="buyer-product-card">

                    <!-- Image -->
                    <a href="{{ route('buyer.products.show', $product->id) }}">
                        @if($product->images->count() > 0)
                            <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" alt="{{ $product->name }}">
                        @else
                            <div class="no-image">No Image</div>
                        @endif
                    </a>

                    <!-- Info -->
                    <div class="buyer-product-info">
                        <a href="{{ route('buyer.products.show', $product->id) }}" class="buyer-product-name">
                            {{ \Illuminate\Support\Str::limit($product->name, 40) }}
                        </a>

                        <div class="buyer-store-name">
                            <i class="fas fa-store"></i> {{ $product->store->name ?? 'Unknown' }}
                        </div>

                        <div class="buyer-product-price">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>

                        <div class="buyer-product-stock">
                            Stok: {{ $product->stock }}
                        </div>

                        <form action="{{ route('buyer.cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="qty" value="1">
                            <button class="buyer-add-cart">
                                <i class="fas fa-cart-plus"></i> Keranjang
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="buyer-pagination">
            {{ $products->links() }}
        </div>

    @else
        <div class="buyer-empty">
            <i class="fas fa-box-open"></i>
            <h4>Produk tidak ditemukan</h4>
            <a href="{{ route('buyer.dashboard') }}" class="buyer-empty-btn">
                Kembali ke semua produk
            </a>
        </div>
    @endif

</div>
@endsection
