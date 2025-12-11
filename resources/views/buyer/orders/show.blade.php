@extends('layouts.buyer')

@section('title', 'Detail Pesanan - ELSHOP')

@section('content')
<div class="section">

    <!-- Breadcrumb -->
    <div style="
        margin-bottom: 24px;
        font-size: .95rem;
        max-width: 900px;
        margin-inline: auto;
        color: var(--gray-700);
    ">
        <a href="{{ route('buyer.dashboard') }}" style="color: var(--accent); text-decoration: none;">Beranda</a>
        <span> / </span>
        <a href="{{ route('buyer.orders.index') }}" style="color: var(--accent); text-decoration: none;">Pesanan Saya</a>
        <span> / </span>
        <span style="color: var(--gray-500); font-weight: 600;">Detail Pesanan</span>
    </div>

    <div style="max-width: 900px; margin-inline: auto;">

        <!-- Order Header -->
        <div class="card-elegant">
            <div class="flex-between">
                <div>
                    <h1 class="title-main">
                        Order {{ $order->code }}
                    </h1>
                    <p class="text-muted-sm">
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </p>
                </div>

                @php
                    $statusConfig = [
                        'unpaid' => ['color' => 'var(--warning)', 'text' => 'Menunggu Pembayaran'],
                        'paid' => ['color' => 'var(--accent)', 'text' => 'Diproses'],
                        'shipped' => ['color' => 'var(--info)', 'text' => 'Dikirim'],
                        'completed' => ['color' => 'var(--success)', 'text' => 'Selesai'],
                        'cancelled' => ['color' => 'var(--danger)', 'text' => 'Dibatalkan']
                    ];

                    $status = $statusConfig[$order->payment_status] ?? $statusConfig['unpaid'];
                @endphp

                <span class="status-badge"
                    style="color: {{ $status['color'] }}; background: {{ $status['color'] }}22;">
                    {{ $status['text'] }}
                </span>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card-elegant">
            <h3 class="title-section">Detail Produk</h3>

            @forelse($order->transactionDetails as $item)
                <div class="product-row">

                    <!-- IMAGE -->
                    @if($item->product && $item->product->images->count() > 0)
                        <img src="{{ asset('storage/' . $item->product->images->first()->image_url) }}"
                            class="product-img" alt="{{ $item->product->name }}">
                    @else
                        <div class="product-img placeholder">?</div>
                    @endif

                    <!-- PRODUCT INFO -->
                    <div style="flex: 1;">
                        <h4 class="product-title">
                            {{ $item->product->name ?? 'Produk telah dihapus' }}
                        </h4>

                        <p class="sku">SKU: {{ $item->product->sku ?? '-' }}</p>

                        <div class="flex-between">
                            <span class="qty-price">
                                {{ $item->qty }}x Rp {{ number_format($item->price, 0, ',', '.') }}
                            </span>

                            <span class="subtotal">
                                Subtotal: Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <p class="empty-text">Tidak ada item dalam pesanan ini</p>
            @endforelse
        </div>

        <!-- Shipping Info -->
        <div class="card-elegant">
            <h3 class="title-section">Informasi Pengiriman</h3>

            <div class="grid-info">
                <div>
                    <label class="label">Alamat Pengiriman</label>
                    <p class="text-dark">{{ $order->address }}</p>
                </div>

                <div class="grid-2">
                    <div>
                        <label class="label">Kota</label>
                        <p class="text-dark">{{ $order->city }}</p>
                    </div>
                    <div>
                        <label class="label">Kode Pos</label>
                        <p class="text-dark">{{ $order->postal_code }}</p>
                    </div>
                </div>

                <div>
                    <label class="label">Metode Pengiriman</label>
                    <p class="text-dark">
                        {{ $order->shipping_type }} -
                        Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                    </p>
                </div>

                @if($order->tracking_number)
                <div>
                    <label class="label">Nomor Resi</label>
                    <p class="resi">{{ $order->tracking_number }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Summary -->
        <div class="summary-card">
            <h3 class="summary-title">Ringkasan Pembayaran</h3>

            <div class="summary-list">
                <div class="flex-between summary-item">
                    <span>Subtotal</span>
                    <span class="bold">
                        Rp {{ number_format($order->grand_total - $order->shipping_cost - $order->tax, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex-between summary-item">
                    <span>Ongkos Kirim</span>
                    <span class="bold">
                        Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex-between summary-item">
                    <span>Pajak</span>
                    <span class="bold">
                        Rp {{ number_format($order->tax, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex-between" style="margin-top: 12px;">
                    <span class="total-label">Total Pembayaran</span>
                    <span class="total-value">
                        Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="actions">
            @if($order->payment_status == 'unpaid')
                <form action="{{ route('buyer.orders.payment', $order->id) }}" method="POST">
                    @csrf
                    <button class="btn-accent" style="width: 100%;">Bayar Sekarang</button>
                </form>

                <form action="{{ route('buyer.orders.cancel', $order->id) }}" method="POST"
                      onsubmit="return confirm('Batalkan pesanan ini?')">
                    @csrf
                    <button class="btn-danger-outline" style="width: 100%; margin-top: 10px;">
                        Batalkan Pesanan
                    </button>
                </form>

            @elseif($order->payment_status == 'paid')
                <div class="status-notice success">Pembayaran Diterima - Sedang Diproses</div>

            @elseif($order->payment_status == 'shipped')
                <form action="{{ route('buyer.orders.confirm', $order->id) }}" method="POST">
                    @csrf
                    <button class="btn-success" style="width: 100%;">Terima Pesanan</button>
                </form>

            @elseif($order->payment_status == 'completed')
                <a href="{{ route('buyer.review.create', $order->id) }}" class="review-button">
                    ★ Beri Rating & Review
                </a>

            @elseif($order->payment_status == 'cancelled')
                <div class="status-notice danger">Pesanan Dibatalkan</div>
            @endif

            <a href="{{ route('buyer.orders.index') }}" class="back-button">
                Kembali ke Daftar Pesanan
            </a>
        </div>

    </div>
</div>

<!-- INLINE CSS FULL -->
<style>
.card-elegant {
    background: #fff;
    padding: 16px;
    border-radius: 12px;
    margin-bottom: 20px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}
.title-main { font-size: 1.5rem; font-weight: 600; margin-bottom: 4px; }
.title-section { font-size: 1.2rem; font-weight: 500; margin-bottom: 12px; }
.product-row { display: flex; align-items: center; margin-bottom: 12px; }
.product-img { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; margin-right: 12px; }
.placeholder { background: #eee; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #888; }
.flex-between { display: flex; justify-content: space-between; align-items: center; }
.status-badge { padding: 4px 12px; border-radius: 12px; font-size: 0.85rem; font-weight: 500; }
.summary-card { background: #f9f9f9; padding: 16px; border-radius: 12px; margin-top: 20px; }
.summary-list .summary-item { margin-bottom: 8px; }
.total-label { font-weight: 600; }
.total-value { font-weight: 600; color: #111; }
.actions { margin-top: 20px; }
.btn-accent { background: #304674; color: #fff; padding: 10px; border-radius: 8px; border: none; }
.btn-danger-outline { background: #fff; border: 1px solid #dc3545; color: #dc3545; padding: 10px; border-radius: 8px; }
.btn-success { background: #28a745; color: #fff; padding: 10px; border-radius: 8px; border: none; }
.review-button { display: inline-block; padding: 10px; background: #ffc107; border-radius: 8px; text-decoration: none; color: #111; margin-top: 10px; text-align: center; }
.back-button { display: block; margin-top: 10px; text-decoration: none; color: #304674; font-weight: 500; }
.text-muted-sm { color: #6c757d; font-size: 0.875rem; }
.sku { font-size: 0.8rem; color: #666; }
.text-dark { color: #111; }
.resi { font-weight: 500; }
.empty-text { font-style: italic; color: #888; }
.status-notice.success { color: #28a745; font-weight: 500; }
.status-notice.danger { color: #dc3545; font-weight: 500; }
.grid-info { display: grid; gap: 12px; }
.grid-2 { display: flex; gap: 12px; }
.label { font-weight: 500; font-size: 0.85rem; margin-bottom: 4px; display: block; }
</style>

@endsection
