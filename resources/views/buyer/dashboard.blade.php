@extends('layouts.buyer')

<<<<<<< HEAD
@section('title', 'Dashboard - Buyer')

@section('styles')
    @vite(['resources/css/dashboard-buyer.css'])
@endsection,
=======
@section('title', 'ELSHOP - Dashboard Pembeli')
>>>>>>> origin/main

@section('content')
    {{-- Hero Banner --}}
    <section class="hero-banner">
        <div class="hero-content">
            <h1>Selamat Datang di ELSHOP!</h1>
            <p>Temukan berbagai snack premium dan camilan favorit Anda di ELSHOP</p>
            <a href="{{ route('buyer.products.index') }}" class="hero-btn">
                Mulai Belanja Sekarang
            </a>
        </div>
    </section>

    {{-- Categories Section --}}
    <section class="section">
        <div class="section-header">
            <h2 class="section-title">Kategori Populer</h2>
            <a href="{{ route('buyer.products.index') }}" class="view-all">
                Lihat Semua →
            </a>
        </div>

        <div class="category-grid">
            @php
                $iconMap = [
                    'Keripik' => '🟨',
                    'Biskuit' => '🍪',
                    'Cokelat' => '🍫',
                    'Permen' => '🍭',
                    'Minuman' => '🥤',
                    'Makanan Instan' => '🍜',
                    'Roti & Pastry' => '🥐',
                    'Kopi' => '☕',
                    'Teh' => '🍵',
                    'Minuman Soda' => '🥤',
                    'Air Mineral' => '💧',
                    'Susu' => '🥛',
                    'Camilan Pedas' => '🌶️',
                    'Camilan Manis' => '🍰',
                ];
            @endphp

            @if(isset($categories) && $categories->count() > 0)
                @foreach($categories->take(8) as $category)
                    <a href="{{ route('buyer.products.index', ['category' => $category->id]) }}" class="category-card">
                        <div class="category-icon">
                            {!! $iconMap[$category->name] ?? '📦' !!}
                        </div>
                        <div class="category-name">{{ $category->name }}</div>
                        <div style="font-size: 0.813rem; color: var(--gray-500); margin-top: 4px;">
                            {{ $category->products_count ?? 0 }} produk
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </section>

    {{-- Featured Products Section --}}
    <section class="section">
        <div class="section-header">
            <h2 class="section-title">Produk Pilihan Hari Ini</h2>
            <a href="{{ route('buyer.products.index') }}" class="view-all">
                Lihat Semua →
            </a>
        </div>

        @if(isset($products) && $products->count() > 0)
            <div class="product-grid">
                @foreach($products as $product)
                    <a href="{{ route('buyer.products.show', $product->id) }}" class="product-card">
                        {{-- Menggunakan accessor image_url --}}
                        @if($product->images && $product->images->count() > 0)
                            <img src="{{ $product->images->first()->image_url }}" 
                                 alt="{{ $product->name }}"
                                 class="product-image">
                        @else
                            <div class="product-image" style="background: var(--gray-100); display: flex; align-items: center; justify-content: center; color: var(--gray-400); font-size: 3rem;">
                                📦
                            </div>
                        @endif

                        <div class="product-info">
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <div class="product-price">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                            <div class="product-meta">
                                <div class="product-rating">
                                    ⭐ <span>{{ number_format($product->average_rating ?? 4.5, 1) }}</span>
                                </div>
                                <div class="product-sold">{{ $product->sold ?? 0 }}+ terjual</div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <h3 class="empty-title">Belum Ada Produk</h3>
                <p class="empty-text">Produk akan segera hadir. Silakan cek kembali nanti!</p>
            </div>
        @endif
    </section>
@endsection
