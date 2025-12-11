@extends('layouts.buyer')

@section('title', 'Belanja Produk - ELSHOP')

@section('content')
<div class="section">
    <div class="section-header">
        <h2 class="section-title"><i class="fas fa-shopping-bag"></i> Belanja Produk</h2>
        <div style="color: var(--gray-600); font-size: 0.938rem;">
            Menampilkan {{ $products->total() ?? 0 }} produk
        </div>
    </div>

    {{-- Filter & Sort Bar --}}
    <div class="filter-bar">
        <div class="filter-group">
            <label>Kategori:</label>
            <select name="category" class="filter-select" onchange="window.location.href='?category='+this.value+'&search={{ request('search') }}&sort={{ request('sort') }}'">
                <option value="">Semua Kategori</option>
                @if(isset($categories))
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="filter-group">
            <label>Urutkan:</label>
            <select name="sort" class="filter-select" onchange="window.location.href='?category={{ request('category') }}&search={{ request('search') }}&sort='+this.value">
                <option value="">Terbaru</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
            </select>
        </div>

        <button type="button" class="filter-btn" onclick="applyFilters()">
            <i class="fas fa-filter"></i> Terapkan
        </button>
    </div>

    {{-- Products Grid --}}
    @if($products->count() > 0)
        <div class="product-grid">
            @foreach($products as $product)
                <a href="{{ route('buyer.products.show', $product->id) }}" class="product-card">
                    {{-- FIXED: Using image_url accessor --}}
                    @if($product->images && $product->images->count() > 0)
                        <img src="{{ $product->images->first()->image_url }}" 
                             alt="{{ $product->name }}" 
                             class="product-image">
                    @else
                        <div class="product-image" style="background: var(--gray-100); display: flex; align-items: center; justify-content: center; color: var(--gray-400); font-size: 3rem;">
                            📦
                        </div>
                    @endif
                    
                    @if($product->stock < 10)
                        <div style="position: absolute; top: 12px; left: 12px; background: var(--danger); color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; box-shadow: var(--shadow);">
                            <i class="fas fa-fire"></i> Stok {{ $product->stock }}
                        </div>
                    @endif

                    <div class="product-info">
                        <h3 class="product-name">{{ $product->name }}</h3>
                        
                        <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 8px; font-size: 0.813rem; color: var(--gray-600);">
                            <i class="fas fa-store"></i>
                            <span>{{ $product->store->name ?? 'Store' }}</span>
                        </div>

                        <div class="product-price">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                        
                        <div class="product-meta">
                            <div class="product-rating">
                                <span class="star-icon">⭐</span>
                                <span>{{ number_format($product->average_rating ?? 4.5, 1) }}</span>
                                <span style="color: var(--gray-400);">|</span>
                                <span>{{ $product->sold ?? 0 }} terjual</span>
                            </div>
                        </div>

                        @if($product->category)
                            <div style="margin-top: 8px;">
                                <span style="background: var(--accent-lightest); color: var(--primary); padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">
                                    {{ $product->category->name }}
                                </span>
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        <div style="margin-top: 40px; display: flex; justify-content: center;">
            {{ $products->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-search"></i></div>
            <h3 class="empty-title">Produk Tidak Ditemukan</h3>
            <p class="empty-text">
                @if(request('search'))
                    Tidak ada hasil untuk "{{ request('search') }}"
                @else
                    Belum ada produk yang tersedia saat ini
                @endif
            </p>
        </div>
    @endif
</div>

<script>
function applyFilters() {
    const category = document.querySelector('select[name="category"]').value;
    const sort = document.querySelector('select[name="sort"]').value;
    const search = '{{ request("search") }}';
    
    let url = '{{ route("buyer.products.index") }}?';
    const params = [];
    
    if (category) params.push('category=' + category);
    if (sort) params.push('sort=' + sort);
    if (search) params.push('search=' + search);
    
    window.location.href = url + params.join('&');
}
</script>

<style>
.product-card {
    position: relative;
}

.product-card:hover {
    transform: translateY(-6px);
}
</style>
@endsection