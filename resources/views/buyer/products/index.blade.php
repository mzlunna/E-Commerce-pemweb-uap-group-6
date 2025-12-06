<!-- buyer/products/index.blade.php -->
@extends('layouts.app')
@section('title', 'Belanja Produk - ELSHOP')
@section('content')
<div class="container mt-5">
    <div class="dashboard-header">
        <h1>🛍️ Belanja Produk</h1>
        <p>Jelajahi ribuan produk pilihan</p>
    </div>

    <div class="shop-container">
        <!-- Sidebar Filter -->
        <div class="shop-sidebar">
            <div class="filter-card">
                <h3>Filter Kategori</h3>
                <div class="category-list">
                    <a href="{{ route('buyer.products.index') }}" class="category-link {{ !request('category') ? 'active' : '' }}">
                        Semua Kategori
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('buyer.products.index', ['category' => $category->id]) }}" 
                           class="category-link {{ request('category') == $category->id ? 'active' : '' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="filter-card">
                <h3>Urutkan Harga</h3>
                <div class="price-range">
                    <input type="range" min="0" max="500000" step="10000" class="price-slider">
                    <p>Rp0 - Rp500.000</p>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="shop-content">
            <div class="products-toolbar">
                <p class="product-count">Menampilkan {{ $products->count() }} produk</p>
                <form action="{{ route('buyer.products.index') }}" method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
                    <button type="submit">Cari</button>
                </form>
            </div>

            @if($products->count() > 0)
                <div class="products-grid">
                    @foreach($products as $product)
                        <a href="{{ route('buyer.products.show', $product->id) }}" class="product-card">
                            <div class="product-image">
                                @if($product->images->first())
                                    <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" alt="{{ $product->name }}">
                                @else
                                    <div class="placeholder">🛍️</div>
                                @endif
                            </div>
                            <div class="product-info">
                                <h3>{{ Str::limit($product->name, 50) }}</h3>
                                <p class="category">{{ $product->category->name }}</p>
                                <div class="product-footer">
                                    <div class="price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                                    <div class="rating">⭐ 4.8 | Terjual 234</div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    {{ $products->links() }}
                </div>
            @else
                <div class="empty-state">
                    <p>Produk tidak ditemukan</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection