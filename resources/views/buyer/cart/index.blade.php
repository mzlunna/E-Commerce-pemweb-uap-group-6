@extends('layouts.buyer')

@section('title', 'Keranjang Belanja - ELSHOP')

@section('content')
<div class="section">
    <div class="section-header">
        <h2 class="section-title">Keranjang Belanja</h2>
    </div>

    @if(isset($cartItems) && $cartItems->count() > 0)
        <div style="max-width: 900px; margin: 0 auto;">
            
            <!-- Cart Items -->
            @foreach($cartItems as $item)
                <div style="background: white; border-radius: 12px; padding: 20px; margin-bottom: 16px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
                    <div style="display: flex; gap: 20px; align-items: start;">
                        
                        <!-- Product Image -->
                        <div style="flex-shrink: 0;">
                            @if($item->product->images && $item->product->images->count() > 0)
                                <img src="{{ $item->product->images->first()->image_url }}" 
                                     alt="{{ $item->product->name }}"
                                     style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                            @else
                                <div style="width: 100px; height: 100px; background: var(--gray-100); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: var(--gray-400);">
                                    ?
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div style="flex: 1; min-width: 0;">
                            <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 8px; color: var(--gray-800);">
                                <a href="{{ route('buyer.products.show', $item->product->id) }}" style="color: var(--gray-800); text-decoration: none;">
                                    {{ $item->product->name }}
                                </a>
                            </h3>
                            
                            <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: 12px;">
                                Toko: {{ $item->product->store->name }}
                            </p>

                            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                                <!-- Price -->
                                <div>
                                    <div style="font-size: 1.375rem; font-weight: 700; color: var(--primary); margin-bottom: 4px;">
                                        Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                    </div>
                                    <div style="font-size: 0.813rem; color: var(--gray-500);">
                                        per item
                                    </div>
                                </div>

                                <!-- Quantity Controls -->
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <form action="{{ route('buyer.cart.update', $item->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="action" value="decrease" class="qty-btn-cart">
                                            -
                                        </button>
                                    </form>
                                    
                                    <span style="font-weight: 600; font-size: 1rem; min-width: 40px; text-align: center;">
                                        {{ $item->quantity }}
                                    </span>
                                    
                                    <form action="{{ route('buyer.cart.update', $item->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="action" value="increase" class="qty-btn-cart">
                                            +
                                        </button>
                                    </form>

                                    <!-- Remove Button -->
                                    <form action="{{ route('buyer.cart.destroy', $item->id) }}" method="POST" style="display: inline; margin-left: 8px;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus produk dari keranjang?')"
                                                style="background: none; border: none; color: var(--danger); cursor: pointer; padding: 8px; transition: all 0.2s; font-size: 1.125rem;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Subtotal -->
                            <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--accent-light); text-align: right;">
                                <span style="color: var(--gray-600); font-size: 0.875rem;">Subtotal: </span>
                                <span style="font-weight: 700; color: var(--primary); font-size: 1.25rem;">
                                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Order Summary -->
            <div style="background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%); border-radius: 12px; padding: 24px; margin-bottom: 20px; box-shadow: var(--shadow-lg); color: white;">
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 20px;">
                    Ringkasan Belanja
                </h3>

                @php
                    $subtotal = $cartItems->sum(function($item) {
                        return $item->product->price * $item->quantity;
                    });
                @endphp

                <div style="display: flex; justify-content: space-between; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid rgba(255,255,255,0.2);">
                    <span>Total Item</span>
                    <span style="font-weight: 600;">{{ $cartItems->sum('quantity') }} item</span>
                </div>

                <div style="display: flex; justify-content: space-between; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid rgba(255,255,255,0.2);">
                    <span>Subtotal</span>
                    <span style="font-weight: 600;">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>

                <div style="display: flex; justify-content: space-between; margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid rgba(255,255,255,0.2);">
                    <span>Ongkos Kirim</span>
                    <span style="font-weight: 600; color: var(--success);">Hitung di checkout</span>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 1.25rem; font-weight: 700;">Total</span>
                    <span style="font-size: 1.75rem; font-weight: 700;">
                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <!-- Action Buttons -->
            <a href="{{ route('buyer.checkout.index') }}" 
               style="display: block; width: 100%; background: var(--accent); color: white; padding: 16px; border-radius: 8px; text-align: center; font-weight: 600; text-decoration: none; transition: all 0.2s; box-shadow: var(--shadow-md); margin-bottom: 12px;">
                Checkout Sekarang
            </a>

            <a href="{{ route('buyer.products.index') }}" 
               style="display: block; width: 100%; background: white; color: var(--gray-700); border: 2px solid var(--accent-light); padding: 14px; border-radius: 8px; text-align: center; font-weight: 600; text-decoration: none; transition: all 0.2s;">
                Lanjut Belanja
            </a>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon" style="font-size: 5rem; margin-bottom: 20px;">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h3 class="empty-title">Keranjang Belanja Kosong</h3>
            <p class="empty-text">Anda belum menambahkan produk ke keranjang</p>
            <a href="{{ route('buyer.products.index') }}" 
               style="display: inline-block; background: var(--accent); color: white; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; margin-top: 16px; box-shadow: var(--shadow-md); transition: all 0.2s;">
                Mulai Belanja
            </a>
        </div>
    @endif
</div>

<style>
.qty-btn-cart {
    background: var(--gray-200);
    border: 1px solid var(--gray-300);
    color: var(--gray-800);
    width: 32px;
    height: 32px;
    border-radius: 6px;
    font-size: 1.125rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0;
}

.qty-btn-cart:hover {
    background: var(--accent);
    color: white;
    border-color: var(--accent);
}

a[href*="checkout"]:hover {
    background: var(--primary) !important;
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

a[href*="products"]:hover {
    background: var(--accent-lightest) !important;
    border-color: var(--accent);
}

button[type="submit"]:not(.qty-btn-cart):hover {
    opacity: 0.8;
}

@media (max-width: 768px) {
    div[style*="display: flex"] {
        flex-direction: column;
        align-items: stretch !important;
    }
}
</style>
@endsection
