<!-- buyer/store/status.blade.php -->
@extends('layouts.buyer')
@section('title', 'Status Toko - ELSHOP')
@section('content')
<div class="container mt-5">
    <div class="dashboard-header">
        <h1>🏪 Status Toko Anda</h1>
    </div>

    @if($store)
        <div class="content-card">
            <div class="status-card">
                <div class="status-icon">
                    @if($store->is_verified)
                        ✅
                    @else
                        ⏳
                    @endif
                </div>
                <div class="status-info">
                    <h2>{{ $store->name }}</h2>
                    @if($store->is_verified)
                        <p class="status-badge success">Toko Anda Telah Diverifikasi</p>
                        <p>Selamat! Toko Anda sudah disetujui dan siap untuk melayani pelanggan.</p>
                        <a href="{{ route('seller.dashboard') }}" class="btn-primary">Kelola Toko</a>
                    @else
                        <p class="status-badge warning">Menunggu Verifikasi</p>
                        <p>Admin sedang meninjau aplikasi toko Anda. Proses verifikasi biasanya memakan waktu 1-2 hari kerja.</p>
                        <p style="margin-top: 20px; color: #999;">Anda akan menerima notifikasi ketika toko Anda diverifikasi.</p>
                    @endif
                </div>
            </div>

            <div class="store-details">
                <h3>Informasi Toko</h3>
                <div class="detail-row">
                    <label>Nama Toko</label>
                    <p>{{ $store->name }}</p>
                </div>
                <div class="detail-row">
                    <label>Kota</label>
                    <p>{{ $store->city }}</p>
                </div>
                <div class="detail-row">
                    <label>Telepon</label>
                    <p>{{ $store->phone }}</p>
                </div>
                <div class="detail-row">
                    <label>Tanggal Pendaftaran</label>
                    <p>{{ $store->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    @else
        <div class="empty-state">
            <p style="font-size: 64px; margin-bottom: 20px;">🏪</p>
            <h2>Belum Daftar Toko</h2>
            <p style="color: #999; margin: 20px 0;">Daftar toko Anda sekarang dan mulai berjualan</p>
            <a href="{{ route('buyer.store.apply') }}" class="btn-primary">Daftar Toko</a>
        </div>
    @endif
</div>
@endsection