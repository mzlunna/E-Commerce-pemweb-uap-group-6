@extends('layouts.seller')
@section('title','Dashboard')

@section('content')

<div class="page-header page-header-actions">
    <div>
        <h1>Seller Dashboard</h1>
        <p>Selamat datang kembali, {{ $store->name }}!</p>
    </div>

    <a href="{{ route('seller.products.create') }}" class="btn btn-primary">
        ➕ Tambah Produk
    </a>
</div>

<div class="stats-grid">

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">Total Produk</span>
            <div class="stat-icon primary">📦</div>
        </div>
        <div class="stat-value">{{ $stats['total_products'] }}</div>
    </div>

    <div class="stat-card warning">
        <div class="stat-header">
            <span class="stat-label">Pesanan Pending</span>
            <div class="stat-icon warning">⏳</div>
        </div>
        <div class="stat-value">{{ $stats['pending_orders'] }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">Total Pesanan</span>
            <div class="stat-icon primary">🛒</div>
        </div>
        <div class="stat-value">{{ $stats['total_orders'] }}</div>
    </div>

    <div class="stat-card success">
        <div class="stat-header">
            <span class="stat-label">Total Pendapatan</span>
            <div class="stat-icon success">💰</div>
        </div>
        <div class="stat-value">
            {{ 'Rp ' . number_format($stats['total_revenue'], 0, ',', '.') }}
        </div>
    </div>

</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Pesanan Terbaru</h2>
        <a href="{{ route('seller.orders.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
    </div>

    <div class="card-body">

        @if($recentOrders->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Pembeli</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                <tr>
                    <td><strong>#{{ $order->id }}</strong></td>
                    <td>{{ $order->buyer->name }}</td>
                    <td>{{ 'Rp ' . number_format($order->grand_total, 0, ',', '.') }}</td>

                    <td>
                        <span class="status-badge 
                            {{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </td>

                    <td>{{ $order->created_at->format('d M Y') }}</td>

                    <td>
                        <a href="{{ route('seller.orders.show', $order->id) }}" 
                           class="btn btn-secondary btn-sm">
                            Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @else
        <div class="empty-state">
            <div class="empty-icon">📦</div>
            <h3 class="empty-title">Belum ada pesanan</h3>
        </div>
        @endif

    </div>
</div>

@endsection
