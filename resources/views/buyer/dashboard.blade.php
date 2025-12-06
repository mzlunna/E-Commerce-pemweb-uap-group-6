@extends('layouts.buyer')

@section('content')
<div class="container py-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h2>Selamat Datang, {{ auth()->user()->name }}!</h2>
            <p class="text-muted">Temukan berbagai snack favorit Anda</p>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('buyer.dashboard') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari produk..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="category" class="form-select">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="price_min" class="form-control" 
                                       placeholder="Harga Min" value="{{ request('price_min') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="price_max" class="form-control" 
                                       placeholder="Harga Max" value="{{ request('price_max') }}">
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100">
                        <a href="{{ route('buyer.products.show', $product->id) }}">
                            @if($product->images && $product->images->count() > 0)
                                <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" 
                                     class="card-img-top" alt="{{ $product->name }}"
                                     style="height: 200px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/300x200?text=No+Image" 
                                     class="card-img-top" alt="No Image">
                            @endif
                        </a>
                        <div class="card-body">
                            <h6 class="card-title">
                                <a href="{{ route('buyer.products.show', $product->id') }}" 
                                   class="text-decoration-none text-dark">
                                    {{ Str::limit($product->name, 40) }}
                                </a>
                            </h6>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-store"></i> {{ $product->store->name ?? 'Unknown' }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-primary fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <small class="text-muted">Stok: {{ $product->stock }}</small>
                            </div>
                            <form action="{{ route('buyer.cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="qty" value="1">
                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>
    @else
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle fa-3x mb-3"></i>
            <h5>Produk tidak ditemukan</h5>
            <p>Coba gunakan filter yang berbeda.</p>
        </div>
    @endif
</div>
@endsection