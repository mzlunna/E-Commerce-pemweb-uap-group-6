@extends('layouts.buyer')

@section('title', $product->name . ' - ELSHOP')

@section('content')
<div class="buyer-container">
    <div style="max-width: 900px; margin: 0 auto;">
        
        <!-- Product Detail Section -->
        <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: var(--shadow); border: 1px solid var(--accent-light); margin-bottom: 32px;">
            
            <!-- Product Image -->
            <div style="margin-bottom: 32px;">
                <div style="background: var(--gray-50); border-radius: 12px; overflow: hidden; display: flex; align-items: center; justify-content: center; min-height: 400px;">
                    @if($product->images && $product->images->count() > 0)
                        <img src="{{ $product->images->first()->image_url }}" 
                             alt="{{ $product->name }}" 
                             style="max-width: 100%; max-height: 500px; object-fit: contain;"
                             onerror="this.src='https://via.placeholder.com/500x500/1e3a5f/ffffff?text=No+Image'">
                    @else
                        <img src="https://via.placeholder.com/500x500/1e3a5f/ffffff?text=No+Image" 
                             alt="No Image" style="max-width: 100%; max-height: 500px; object-fit: contain;">
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div>
                <!-- Category Badge -->
                @if($product->category)
                    <div style="margin-bottom: 16px;">
                        <span style="background: var(--accent-lightest); color: var(--primary); padding: 6px 16px; border-radius: 20px; font-size: 0.875rem; font-weight: 600; display: inline-block;">
                            {{ $product->category->name }}
                        </span>
                    </div>
                @endif

                <!-- Product Title -->
                <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); line-height: 1.3; margin-bottom: 16px;">
                    {{ $product->name }}
                </h1>

                <!-- Rating -->
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px solid var(--accent-light);">
                    <div style="display: flex; align-items: center; gap: 4px; color: var(--warning);">
                        <span style="font-size: 1.125rem;">⭐⭐⭐⭐⭐</span>
                    </div>
                    <span style="font-weight: 600; color: var(--gray-700);">{{ $product->average_rating ?? '4.5' }}</span>
                    <span style="color: var(--gray-400);">|</span>
                    <span style="color: var(--gray-600);">{{ $product->reviews_count ?? 0 }} ulasan</span>
                </div>

                <!-- Price -->
                <div style="margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px solid var(--accent-light);">
                    <div style="font-size: 2rem; font-weight: 700; color: var(--primary); margin-bottom: 8px;">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                    @if(isset($product->original_price) && $product->original_price > $product->price)
                        <div style="font-size: 1rem; color: var(--gray-500); text-decoration: line-through;">
                            Rp {{ number_format($product->original_price, 0, ',', '.') }}
                        </div>
                    @endif
                </div>

                <!-- Stock & Seller Info -->
                <div style="background: var(--gray-50); padding: 20px; border-radius: 12px; margin-bottom: 24px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                        <span style="color: var(--gray-600); font-weight: 600;">Stok Tersedia</span>
                        <span style="color: var(--gray-900); font-weight: 600;">{{ $product->stock }} produk</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--gray-600); font-weight: 600;">Penjual</span>
                        <a href="#" style="color: var(--accent); font-weight: 600; text-decoration: none;">
                            {{ $product->store->name ?? 'ELSHOP Official' }}
                        </a>
                    </div>
                </div>

                <!-- Description -->
                <div style="margin-bottom: 32px; padding-bottom: 32px; border-bottom: 1px solid var(--accent-light);">
                    <h4 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin-bottom: 12px;">
                        Deskripsi Produk
                    </h4>
                    <p style="color: var(--gray-700); line-height: 1.8; font-size: 0.938rem;">
                        {{ $product->description }}
                    </p>
                </div>

                <!-- Add to Cart Section -->
                <input type="hidden" id="productId" value="{{ $product->id }}">

                <!-- Quantity Selector -->
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 12px; color: var(--gray-700); font-size: 0.938rem;">
                        Jumlah
                    </label>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <button type="button" onclick="decreaseQty()" style="background: var(--gray-200); border: 1px solid var(--gray-300); color: var(--gray-800); width: 40px; height: 40px; border-radius: 8px; font-size: 1.25rem; font-weight: 700; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center;">
                            −
                        </button>
                        <input type="number" id="qtyInput" value="1" min="1" max="{{ $product->stock }}" 
                               style="width: 80px; padding: 10px 12px; border: 1px solid var(--accent-light); border-radius: 8px; font-size: 1rem; font-weight: 600; text-align: center; outline: none;">
                        <button type="button" onclick="increaseQty()" style="background: var(--gray-200); border: 1px solid var(--gray-300); color: var(--gray-800); width: 40px; height: 40px; border-radius: 8px; font-size: 1.25rem; font-weight: 700; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center;">
                            +
                        </button>
                        <span style="color: var(--gray-500); font-size: 0.875rem; margin-left: 8px;">
                            Maksimal: {{ $product->stock }} produk
                        </span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <button type="button" onclick="addToCart()" style="background: white; color: var(--accent); border: 2px solid var(--accent); padding: 14px 24px; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <i class="fas fa-shopping-cart"></i>
                        Tambah ke Keranjang
                    </button>
                    <button type="button" onclick="buyNow()" style="background: var(--accent); color: white; border: none; padding: 14px 24px; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: var(--shadow-md);">
                        <i class="fas fa-bolt"></i>
                        Beli Sekarang
                    </button>
                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <div style="margin-bottom: 48px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900);">
                        Produk Lainnya dari Toko Ini
                    </h2>
                    <a href="#" style="color: var(--accent); text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                        Lihat Semua →
                    </a>
                </div>

                <div class="product-grid">
                    @foreach($relatedProducts->take(4) as $related)
                        <a href="{{ route('buyer.products.show', $related->id) }}" class="product-card">
                            @if($related->images && $related->images->count() > 0)
                                <img src="{{ $related->images->first()->image_url }}" 
                                     alt="{{ $related->name }}" class="product-image"
                                     onerror="this.src='https://via.placeholder.com/400x400/1e3a5f/ffffff?text=No+Image'">
                            @else
                                <img src="https://via.placeholder.com/400x400/1e3a5f/ffffff?text=No+Image" 
                                     alt="{{ $related->name }}" class="product-image">
                            @endif

                            <div class="product-info">
                                <h3 class="product-name">{{ $related->name }}</h3>
                                <div class="product-price">
                                    Rp {{ number_format($related->price, 0, ',', '.') }}
                                </div>
                                <div class="product-meta">
                                    <div class="product-rating">
                                        <span>⭐</span>
                                        <span>{{ $related->average_rating ?? '4.5' }}</span>
                                    </div>
                                    <div class="product-sold">{{ $related->sold ?? rand(50, 500) }}+ terjual</div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<style>
button:hover {
    opacity: 0.9;
    transform: translateY(-2px);
}

button[onclick*="buyNow"]:hover {
    background: var(--primary) !important;
    box-shadow: var(--shadow-lg);
}

button[onclick*="addToCart"]:hover {
    background: var(--accent-lightest) !important;
}

button[onclick*="Qty"]:hover {
    background: var(--accent) !important;
    color: white !important;
    border-color: var(--accent) !important;
}

@media (max-width: 768px) {
    div[style*="grid-template-columns: 1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
}
</style>

@push('scripts')
<script>
function increaseQty() {
    const input = document.getElementById('qtyInput');
    const max = parseInt(input.max);
    if (parseInt(input.value) < max) {
        input.value = parseInt(input.value) + 1;
    }
}

function decreaseQty() {
    const input = document.getElementById('qtyInput');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

function addToCart() {
    const qty = document.getElementById('qtyInput').value;
    const productId = document.getElementById('productId').value;
    
    if (!qty || parseInt(qty) < 1) {
        alert('Masukkan jumlah yang valid');
        return;
    }

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route('buyer.cart.add') }}';
    
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    form.appendChild(csrfInput);

    const productInput = document.createElement('input');
    productInput.type = 'hidden';
    productInput.name = 'product_id';
    productInput.value = productId;
    form.appendChild(productInput);

    const qtyInput = document.createElement('input');
    qtyInput.type = 'hidden';
    qtyInput.name = 'quantity';
    qtyInput.value = qty;
    form.appendChild(qtyInput);

    document.body.appendChild(form);

    fetch('{{ route('buyer.cart.add') }}', {
        method: 'POST',
        body: new FormData(form)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Berhasil ditambahkan ke keranjang!');
            document.getElementById('qtyInput').value = 1;
        } else {
            alert(data.message || 'Gagal menambahkan ke keranjang');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    })
    .finally(() => {
        form.remove();
    });
}

function buyNow() {
    const qty = document.getElementById('qtyInput').value;
    const productId = document.getElementById('productId').value;

    if (!qty || parseInt(qty) < 1) {
        alert('Masukkan jumlah yang valid');
        return;
    }

    window.location.href = `{{ route('buyer.checkout.index') }}?product_id=${productId}&qty=${qty}`;
}
</script>
@endpush
@endsection