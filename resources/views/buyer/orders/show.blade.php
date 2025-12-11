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

                <span class="status-badge" style="
                    color: {{ $status['color'] }};
                    background: {{ $status['color'] }}22;
                ">
                    {{ $status['text'] }}
                </span>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card-elegant">
            <h3 class="title-section">Detail Produk</h3>

            @if($order->transactionDetails->count() > 0)
                @foreach($order->transactionDetails as $item)
                    <div class="product-row">

                        <!-- Product Image -->
                        @if($item->product && $item->product->images->count() > 0)
                            <img src="{{ asset('storage/' . $item->product->images->first()->image_url) }}"
                                 class="product-img"
                                 alt="{{ $item->product->name }}">
                        @else
                            <div class="product-img placeholder">?</div>
                        @endif

                        <!-- Product Info -->
                        <div style="flex: 1;">
                            <h4 class="product-title">
                                <a href="{{ route('buyer.products.show', $item->product->id) }}">
                                    {{ $item->product->name ?? 'Produk' }}
                                </a>
                            </h4>

                            <p class="sku">SKU: {{ $item->product->sku ?? '-' }}</p>

                            <div class="flex-between">
                                <span class="qty-price">
                                    {{ $item->qty }}x Rp {{ number_format($item->product->price ?? 0, 0, ',', '.') }}
                                </span>

                                <span class="subtotal">
                                    Subtotal: Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                    </div>
                @endforeach
            @else
                <p class="empty-text">Tidak ada item dalam pesanan ini</p>
            @endif
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
                        {{ $order->shipping_type }} - Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
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

        <!-- Order Summary -->
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

                <!-- BAYAR SEKARANG -->
                <form action="{{ route('buyer.orders.payment', $order->id) }}" method="POST">
                    @csrf
                    <button class="btn-accent" style="width: 100%;">
                        Bayar Sekarang
                    </button>
                </form>

                <!-- BATALKAN PESANAN -->
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

                <!-- TERIMA PESANAN -->
                <form action="{{ route('buyer.orders.confirm', $order->id) }}" method="POST">
                    @csrf
                    <button class="btn-success" style="width: 100%;">
                        Terima Pesanan
                    </button>
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

@include('buyer.orders.styles')
@endsection
