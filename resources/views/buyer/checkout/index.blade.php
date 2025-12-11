@extends('layouts.buyer')

@section('title', 'Checkout - ELSHOP')

@section('content')
<div class="section">
    <div class="section-header">
        <h2 class="section-title">Checkout Pesanan</h2>
    </div>

    <form action="{{ route('buyer.checkout.process') }}" method="POST">
        @csrf
        
        <div style="max-width: 900px; margin: 0 auto;">
            
            <!-- Order Items -->
            <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 20px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
                <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 20px; color: var(--gray-800);">
                    Produk yang Dibeli
                </h3>

                @if(isset($items))
                    @foreach($items as $item)
                        <div style="display: flex; gap: 16px; padding: 16px; margin-bottom: 12px; background: var(--gray-50); border-radius: 8px; border: 1px solid var(--accent-light);">
                            @if($item->product->images && $item->product->images->count() > 0)
                                <img src="{{ $item->product->images->first()->image_url }}" 
                                     style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; flex-shrink: 0;">
                            @else
                                <div style="width: 80px; height: 80px; background: var(--gray-100); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: var(--gray-400); flex-shrink: 0;">
                                    ?
                                </div>
                            @endif
                            
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-weight: 600; font-size: 0.938rem; margin-bottom: 8px; color: var(--gray-800);">
                                    {{ $item->product->name }}
                                </div>
                                
                                <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span style="font-size: 0.875rem; color: var(--gray-600);">Jumlah:</span>
                                        <button type="button" class="qty-btn-small" onclick="updateItemQty({{ $item->id }}, -1, {{ $item->product->price }})">-</button>
                                        <input type="number" id="qty-{{ $item->id }}" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" readonly
                                               style="width: 50px; text-align: center; border: 1px solid var(--accent-light); border-radius: 4px; padding: 6px; font-weight: 600; font-size: 0.938rem;">
                                        <button type="button" class="qty-btn-small" onclick="updateItemQty({{ $item->id }}, 1, {{ $item->product->price }})">+</button>
                                    </div>
                                    
                                    <div style="font-size: 0.875rem; color: var(--gray-600);">
                                        Harga: Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                    </div>
                                    
                                    <div style="font-weight: 700; color: var(--primary); font-size: 1rem; margin-left: auto;">
                                        Subtotal: <span id="subtotal-{{ $item->id }}">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Shipping Address -->
            <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 20px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
                <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 20px; color: var(--gray-800);">
                    Alamat Pengiriman
                </h3>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700);">
                        Nama Penerima <span style="color: var(--danger);">*</span>
                    </label>
                    <input type="text" name="receiver_name" class="filter-select"
                           style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px;"
                           value="{{ auth()->user()->name }}" required>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700);">
                        Nomor Telepon <span style="color: var(--danger);">*</span>
                    </label>
                    <input type="text" name="receiver_phone" class="filter-select"
                           style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px;"
                           value="{{ auth()->user()->phone }}" required>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700);">
                        Alamat Lengkap <span style="color: var(--danger);">*</span>
                    </label>
                    <textarea name="shipping_address" rows="3" class="filter-select"
                              style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px; resize: vertical;"
                              required>{{ auth()->user()->address }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700);">
                            Kota <span style="color: var(--danger);">*</span>
                        </label>
                        <input type="text" name="city" class="filter-select"
                               style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px;"
                               value="Malang" required>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700);">
                            Kode Pos <span style="color: var(--danger);">*</span>
                        </label>
                        <input type="text" name="postal_code" class="filter-select"
                               style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px;"
                               required>
                    </div>
                </div>
            </div>

            <!-- Shipping Method -->
            <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 20px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
                <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 20px; color: var(--gray-800);">
                    Metode Pengiriman
                </h3>

                <div style="display: grid; gap: 12px;">
                    <label class="shipping-option">
                        <input type="radio" name="shipping_method" value="regular" data-cost="15000" checked>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; margin-bottom: 4px;">JNE Regular</div>
                            <div style="font-size: 0.875rem; color: var(--gray-600);">Estimasi 2-3 hari</div>
                        </div>
                        <div style="font-weight: 700; color: var(--primary);">Rp 15.000</div>
                    </label>

                    <label class="shipping-option">
                        <input type="radio" name="shipping_method" value="express" data-cost="25000">
                        <div style="flex: 1;">
                            <div style="font-weight: 600; margin-bottom: 4px;">JNE Express</div>
                            <div style="font-size: 0.875rem; color: var(--gray-600);">Estimasi 1 hari</div>
                        </div>
                        <div style="font-weight: 700; color: var(--primary);">Rp 25.000</div>
                    </label>

                    <label class="shipping-option">
                        <input type="radio" name="shipping_method" value="same-day" data-cost="35000">
                        <div style="flex: 1;">
                            <div style="font-weight: 600; margin-bottom: 4px;">Same Day</div>
                            <div style="font-size: 0.875rem; color: var(--gray-600);">Hari ini juga</div>
                        </div>
                        <div style="font-weight: 700; color: var(--primary);">Rp 35.000</div>
                    </label>
                </div>
            </div>

            <!-- Payment Method -->
            <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 20px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
                <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 20px; color: var(--gray-800);">
                    Metode Pembayaran
                </h3>

                <div style="display: grid; gap: 12px;">
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="transfer" checked>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; margin-bottom: 4px;">Transfer Bank</div>
                            <div style="font-size: 0.875rem; color: var(--gray-600);">BCA, Mandiri, BNI</div>
                        </div>
                    </label>

                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="ewallet">
                        <div style="flex: 1;">
                            <div style="font-weight: 600; margin-bottom: 4px;">E-Wallet</div>
                            <div style="font-size: 0.875rem; color: var(--gray-600);">OVO, GoPay, DANA</div>
                        </div>
                    </label>

                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="cod">
                        <div style="flex: 1;">
                            <div style="font-weight: 600; margin-bottom: 4px;">COD</div>
                            <div style="font-size: 0.875rem; color: var(--gray-600);">Bayar saat barang sampai</div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Order Summary -->
            <div style="background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%); border-radius: 12px; padding: 24px; margin-bottom: 20px; box-shadow: var(--shadow-lg); color: white;">
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 20px;">
                    Ringkasan Pembayaran
                </h3>

                @if(isset($items))
                    @php
                        $subtotal = $items->sum(function($item) {
                            return $item->product->price * $item->quantity;
                        });
                    @endphp

                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid rgba(255,255,255,0.2);">
                        <span>Subtotal Produk</span>
                        <span style="font-weight: 600;" id="subtotalAmount">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid rgba(255,255,255,0.2);">
                        <span>Ongkos Kirim</span>
                        <span style="font-weight: 600;" id="shippingCost">Rp 15.000</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 1.25rem; font-weight: 700;">Total Pembayaran</span>
                        <span style="font-size: 1.75rem; font-weight: 700;" id="totalAmount">
                            Rp {{ number_format($subtotal + 15000, 0, ',', '.') }}
                        </span>
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" style="width: 100%; background: var(--accent); color: white; border: none; padding: 16px; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: var(--shadow-md);">
                Buat Pesanan
            </button>

            <a href="{{ route('buyer.cart.index') }}" style="display: block; width: 100%; margin-top: 12px; text-align: center; padding: 14px; background: white; color: var(--gray-700); border: 2px solid var(--accent-light); border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.2s;">
                Kembali ke Keranjang
            </a>

        </div>
    </form>
</div>

<style>
.shipping-option, .payment-option {
    display: flex;
    align-items: center;
    padding: 16px;
    border: 2px solid var(--accent-light);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    gap: 12px;
}

.shipping-option:hover, .payment-option:hover {
    border-color: var(--accent);
    background: var(--accent-lightest);
}

.shipping-option:has(input:checked), .payment-option:has(input:checked) {
    border-color: var(--accent);
    background: var(--accent-lightest);
}

.qty-btn-small {
    background: var(--gray-200);
    border: 1px solid var(--gray-300);
    color: var(--gray-800);
    width: 28px;
    height: 28px;
    border-radius: 4px;
    font-size: 0.938rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
}

.qty-btn-small:hover {
    background: var(--accent);
    color: white;
    border-color: var(--accent);
}

button[type="submit"]:hover {
    background: var(--primary) !important;
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

a[href*="cart"]:hover {
    background: var(--accent-lightest) !important;
    border-color: var(--accent);
}

@media (max-width: 768px) {
    .section {
        padding: 16px;
    }
    
    div[style*="display: flex"] {
        flex-direction: column;
        align-items: stretch !important;
    }
}
</style>

<script>
// Initialize subtotal
let currentSubtotal = {{ $subtotal ?? 0 }};
const itemQuantities = {};
const itemPrices = {};

// Store initial quantities and prices
@foreach($items as $item)
    itemQuantities[{{ $item->id }}] = {{ $item->quantity }};
    itemPrices[{{ $item->id }}] = {{ $item->product->price }};
@endforeach

// Update item quantity
function updateItemQty(itemId, change, price) {
    const input = document.getElementById('qty-' + itemId);
    const currentQty = parseInt(input.value);
    const max = parseInt(input.max);
    const newQty = currentQty + change;
    
    if (newQty >= 1 && newQty <= max) {
        input.value = newQty;
        itemQuantities[itemId] = newQty;
        
        // Update item subtotal display
        const itemSubtotal = price * newQty;
        const itemElement = document.getElementById('subtotal-' + itemId);
        if (itemElement) {
            itemElement.textContent = 'Rp ' + itemSubtotal.toLocaleString('id-ID');
        }
        
        // Recalculate total
        recalculateTotal();
    }
}

// Recalculate total based on current quantities
function recalculateTotal() {
    currentSubtotal = 0;
    
    for (let itemId in itemQuantities) {
        currentSubtotal += itemPrices[itemId] * itemQuantities[itemId];
    }
    
    const shippingCost = parseInt(document.querySelector('input[name="shipping_method"]:checked').dataset.cost);
    const total = currentSubtotal + shippingCost;
    
    document.getElementById('subtotalAmount').textContent = 'Rp ' + currentSubtotal.toLocaleString('id-ID');
    document.getElementById('totalAmount').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

// Update shipping cost
document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const shippingCost = parseInt(this.dataset.cost);
        const total = currentSubtotal + shippingCost;
        
        document.getElementById('shippingCost').textContent = 'Rp ' + shippingCost.toLocaleString('id-ID');
        document.getElementById('totalAmount').textContent = 'Rp ' + total.toLocaleString('id-ID');
    });
});
</script>
@endsection