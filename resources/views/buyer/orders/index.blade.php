@extends('layouts.buyer')

@section('title', 'Detail Pesanan - ELSHOP')

@section('content')
<div class="section">
    <!-- Breadcrumb -->
    <nav class="breadcrumb" aria-label="breadcrumb">
        <a href="{{ route('buyer.dashboard') }}">Beranda</a>
        <span>/</span>
        <a href="{{ route('buyer.orders.index') }}">Pesanan Saya</a>
        <span>/</span>
        <span>Detail Pesanan</span>
    </nav>

    <div class="order-container">
        @if(!isset($orders) || $orders->isEmpty())
            <div class="empty-state">
                <p>Pesanan tidak ditemukan</p>
                <a href="{{ route('buyer.orders.index') }}" class="btn btn-primary">Kembali ke Daftar Pesanan</a>
            </div>
        @else
            @php
                $order = $orders->first();
            @endphp
            
            <!-- Order Header -->
            <div class="card order-header">
                <div class="order-header-content">
                    <div>
                        <h1>Order {{ $order->code }}</h1>
                        <p class="order-date">
                            <time datetime="{{ $order->created_at->toIso8601String() }}">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </time>
                        </p>
                    </div>

                    @php
                        $statusConfig = [
                            'unpaid' => ['color' => 'warning', 'text' => 'Menunggu Pembayaran', 'icon' => '⏳'],
                            'paid' => ['color' => 'info', 'text' => 'Diproses', 'icon' => '⚙️'],
                            'shipped' => ['color' => 'primary', 'text' => 'Dikirim', 'icon' => '🚚'],
                            'completed' => ['color' => 'success', 'text' => 'Selesai', 'icon' => '✓'],
                            'cancelled' => ['color' => 'danger', 'text' => 'Dibatalkan', 'icon' => '✕']
                        ];
                        $status = $statusConfig[$order->payment_status] ?? $statusConfig['unpaid'];
                    @endphp
                    <span class="status-badge status-{{ $status['color'] }}">
                        <span class="status-icon">{{ $status['icon'] }}</span>
                        {{ $status['text'] }}
                    </span>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card">
                <h3 class="card-title">Detail Produk</h3>

                <div class="order-items">
                    @forelse($order->transactionDetails as $item)
                    <div class="order-item">
                        @if($item->product && $item->product->images && $item->product->images->count() > 0)
                            <img src="{{ asset('storage/' . $item->product->images->first()->image_url) }}" 
                                 alt="{{ $item->product->name }}"
                                 class="product-image"
                                 loading="lazy">
                        @else
                            <div class="product-image-placeholder">
                                <span>?</span>
                            </div>
                        @endif

                        <div class="product-details">
                            <h4 class="product-name">
                                @if($item->product)
                                    <a href="{{ route('buyer.products.show', $item->product->id) }}">
                                        {{ $item->product->name }}
                                    </a>
                                @else
                                    Produk Tidak Tersedia
                                @endif
                            </h4>
                            <p class="product-sku">SKU: {{ $item->product->sku ?? '-' }}</p>
                            <div class="product-pricing">
                                <span class="quantity-price">
                                    {{ $item->qty }}x Rp {{ number_format($item->product->price ?? 0, 0, ',', '.') }}
                                </span>
                                <span class="subtotal">
                                    Subtotal: Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted">Tidak ada produk dalam pesanan ini.</p>
                    @endforelse
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="card">
                <h3 class="card-title">Informasi Pengiriman</h3>

                <div class="shipping-info">
                    <div class="info-item">
                        <label>Alamat Pengiriman</label>
                        <p>{{ $order->address }}</p>
                    </div>

                    <div class="info-row">
                        <div class="info-item">
                            <label>Kota</label>
                            <p>{{ $order->city }}</p>
                        </div>
                        <div class="info-item">
                            <label>Kode Pos</label>
                            <p>{{ $order->postal_code }}</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <label>Metode Pengiriman</label>
                        <p class="shipping-method">
                            {{ ucwords($order->shipping_type) }} - Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                        </p>
                    </div>

                    @if($order->tracking_number)
                    <div class="info-item">
                        <label>Nomor Resi</label>
                        <p class="tracking-number">{{ $order->tracking_number }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Summary -->
            <div class="card payment-summary">
                <h3 class="card-title">Ringkasan Pembayaran</h3>

                <div class="summary-details">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($order->grand_total - $order->shipping_cost - $order->tax, 0, ',', '.') }}</span>
                    </div>

                    <div class="summary-row">
                        <span>Ongkos Kirim</span>
                        <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>

                    <div class="summary-row">
                        <span>Pajak</span>
                        <span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                    </div>

                    <div class="summary-total">
                        <span>Total Pembayaran</span>
                        <span>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="order-actions">
                @if($order->payment_status == 'unpaid')
                    <form action="{{ route('buyer.orders.payment', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            💳 Bayar Sekarang
                        </button>
                    </form>
                    
                    <form action="{{ route('buyer.orders.cancel', $order->id) }}" method="POST" 
                          onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">
                        @csrf
                        <button type="submit" class="btn btn-danger-outline">
                            Batalkan Pesanan
                        </button>
                    </form>
                @elseif($order->payment_status == 'paid')
                    <div class="alert alert-success">
                        ✓ Pembayaran Diterima - Sedang Diproses
                    </div>
                @elseif($order->payment_status == 'shipped')
                    <form action="{{ route('buyer.orders.confirm', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            ✓ Terima Pesanan
                        </button>
                    </form>
                @elseif($order->payment_status == 'completed')
                    <a href="{{ route('buyer.review.create', $order->id) }}" class="btn btn-warning">
                        ★ Beri Rating & Review
                    </a>
                @elseif($order->payment_status == 'cancelled')
                    <div class="alert alert-danger">
                        ✕ Pesanan Dibatalkan
                    </div>
                @endif

                <a href="{{ route('buyer.orders.index') }}" class="btn btn-secondary">
                    ← Kembali ke Daftar Pesanan
                </a>
            </div>
        @endif
    </div>
</div>

<style>
/* Breadcrumb */
.breadcrumb {
    margin-bottom: 24px;
    font-size: 0.938rem;
    max-width: 900px;
    margin-left: auto;
    margin-right: auto;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.breadcrumb a {
    color: var(--accent);
    text-decoration: none;
    transition: opacity 0.2s;
}

.breadcrumb a:hover {
    opacity: 0.8;
    text-decoration: underline;
}

.breadcrumb span:not([class]) {
    color: var(--gray-400);
}

.breadcrumb span:last-child {
    color: var(--gray-600);
}

/* Container */
.order-container {
    max-width: 900px;
    margin: 0 auto;
}

/* Card */
.card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 20px;
}

/* Order Header */
.order-header {
    border: 1px solid var(--accent-light);
}

.order-header-content {
    display: flex;
    justify-content: space-between;
    align-items: start;
    flex-wrap: wrap;
    gap: 16px;
}

.order-header h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 8px;
}

.order-date {
    color: var(--gray-600);
    font-size: 0.938rem;
    margin: 0;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.938rem;
}

.status-icon {
    font-size: 1rem;
}

.status-warning {
    background: #fef3c7;
    color: #d97706;
}

.status-info {
    background: #dbeafe;
    color: #2563eb;
}

.status-primary {
    background: var(--accent-lightest, #e0f2fe);
    color: var(--accent);
}

.status-success {
    background: #dcfce7;
    color: #16a34a;
}

.status-danger {
    background: #fee2e2;
    color: #dc2626;
}

/* Order Items */
.order-items {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.order-item {
    display: flex;
    gap: 16px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e5e7eb;
}

.order-item:last-child {
    padding-bottom: 0;
    border-bottom: none;
}

.product-image {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
    flex-shrink: 0;
}

.product-image-placeholder {
    width: 100px;
    height: 100px;
    background: var(--gray-100);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: var(--gray-400);
    flex-shrink: 0;
}

.product-details {
    flex: 1;
    min-width: 0;
}

.product-name {
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 1rem;
}

.product-name a {
    color: var(--gray-800);
    text-decoration: none;
    transition: color 0.2s;
}

.product-name a:hover {
    color: var(--accent);
}

.product-sku {
    color: var(--gray-600);
    font-size: 0.875rem;
    margin-bottom: 12px;
}

.product-pricing {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}

.quantity-price {
    color: var(--gray-600);
}

.subtotal {
    font-weight: 700;
    color: var(--primary);
}

/* Shipping Info */
.shipping-info {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.info-item label {
    color: var(--gray-600);
    font-size: 0.875rem;
    font-weight: 600;
    display: block;
    margin-bottom: 4px;
}

.info-item p {
    color: var(--gray-800);
    margin: 0;
}

.info-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
}

.shipping-method {
    text-transform: capitalize;
}

.tracking-number {
    font-family: 'Courier New', monospace;
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* Payment Summary */
.payment-summary {
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    color: white;
}

.payment-summary .card-title {
    color: white;
}

.summary-details {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding-bottom: 12px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.summary-row span:last-child {
    font-weight: 600;
}

.summary-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 8px;
}

.summary-total span:first-child {
    font-size: 1.25rem;
    font-weight: 700;
}

.summary-total span:last-child {
    font-size: 1.75rem;
    font-weight: 700;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px 24px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    width: 100%;
}

.btn:hover {
    transform: translateY(-2px);
}

.btn-primary {
    background: var(--accent);
    color: white;
}

.btn-primary:hover {
    opacity: 0.9;
}

.btn-success {
    background: #16a34a;
    color: white;
}

.btn-success:hover {
    background: #15803d;
}

.btn-warning {
    background: #f59e0b;
    color: white;
}

.btn-warning:hover {
    background: #d97706;
}

.btn-danger-outline {
    background: white;
    color: #dc2626;
    border: 2px solid #dc2626;
}

.btn-danger-outline:hover {
    background: #fee2e2;
}

.btn-secondary {
    background: white;
    color: var(--gray-700);
    border: 2px solid var(--accent-light);
}

.btn-secondary:hover {
    background: var(--accent-lightest, #f0f9ff);
    border-color: var(--accent);
}

/* Alerts */
.alert {
    padding: 14px;
    border-radius: 8px;
    text-align: center;
    font-weight: 600;
    width: 100%;
}

.alert-success {
    background: #dcfce7;
    color: #16a34a;
}

.alert-danger {
    background: #fee2e2;
    color: #dc2626;
}

/* Actions */
.order-actions {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.order-actions form {
    width: 100%;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: var(--gray-600);
}

.empty-state p {
    font-size: 1.125rem;
    margin-bottom: 20px;
}

/* Utilities */
.text-muted {
    color: var(--gray-600);
}

/* Responsive */
@media (max-width: 768px) {
    .order-header-content {
        flex-direction: column;
        align-items: stretch;
    }

    .status-badge {
        align-self: flex-start;
    }

    .order-item {
        flex-direction: column;
    }

    .product-image,
    .product-image-placeholder {
        width: 100%;
        height: 200px;
    }

    .summary-total span:first-child {
        font-size: 1.125rem;
    }

    .summary-total span:last-child {
        font-size: 1.5rem;
    }
}

@media (max-width: 480px) {
    .card {
        padding: 16px;
    }

    .card-title {
        font-size: 1.125rem;
    }

    .order-header h1 {
        font-size: 1.5rem;
    }
}
</style>
@endsection