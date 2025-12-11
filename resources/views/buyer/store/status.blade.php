@extends('layouts.buyer')

@section('title', 'Status Toko - ELSHOP')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('buyer.dashboard') }}">Beranda</a>
    <span>/</span>
    <span>Status Toko</span>
</div>

<div class="section">
    <div class="section-header">
        <h2 class="section-title">🏪 Status Pendaftaran Toko</h2>
    </div>

    @if($store)
        <div style="max-width: 800px; margin: 0 auto;">
            {{-- Status Card --}}
            <div style="background: white; border-radius: 16px; padding: 40px; box-shadow: var(--shadow-lg); border: 1px solid var(--accent-light); text-align: center; margin-bottom: 32px;">
                @if($store->is_verified)
                    {{-- Verified --}}
                    <div style="font-size: 5rem; margin-bottom: 20px;">✅</div>
                    <h2 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 12px; color: var(--success);">
                        Toko Anda Telah Diverifikasi!
                    </h2>
                    <p style="color: var(--gray-600); margin-bottom: 32px; font-size: 1.063rem;">
                        Selamat! Toko <strong>{{ $store->name }}</strong> sudah disetujui dan siap untuk melayani pelanggan.
                    </p>
                    <a href="{{ route('seller.dashboard') }}" 
                       style="display: inline-block; background: var(--accent); color: white; padding: 14px 40px; border-radius: 8px; text-decoration: none; font-weight: 600; box-shadow: var(--shadow-md); transition: all 0.2s;">
                        <i class="fas fa-store"></i> Kelola Toko Sekarang
                    </a>
                @else
                    {{-- Pending --}}
                    <div style="font-size: 5rem; margin-bottom: 20px;">⏳</div>
                    <h2 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 12px; color: var(--warning);">
                        Menunggu Verifikasi
                    </h2>
                    <p style="color: var(--gray-600); margin-bottom: 20px; font-size: 1.063rem;">
                        Admin sedang meninjau aplikasi toko <strong>{{ $store->name }}</strong> Anda.
                    </p>
                    <p style="color: var(--gray-500); font-size: 0.938rem;">
                        Proses verifikasi biasanya memakan waktu 1-2 hari kerja. Anda akan menerima notifikasi ketika toko Anda diverifikasi.
                    </p>
                @endif
            </div>

            {{-- Store Details --}}
            <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 24px; color: var(--gray-800); display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-info-circle" style="color: var(--accent);"></i>
                    Informasi Toko
                </h3>
                
                <div style="display: grid; gap: 20px;">
                    {{-- Logo --}}
                    @if($store->logo)
                    <div style="display: flex; justify-content: space-between; padding-bottom: 20px; border-bottom: 1px solid var(--accent-light);">
                        <div style="font-weight: 600; color: var(--gray-700);">Logo Toko</div>
                        <div>
                            <img src="{{ asset('storage/' . $store->logo) }}" 
                                 alt="Logo" 
                                 style="width: 80px; height: 80px; border-radius: 8px; object-fit: cover; box-shadow: var(--shadow);">
                        </div>
                    </div>
                    @endif

                    {{-- Name --}}
                    <div style="display: flex; justify-content: space-between; padding-bottom: 20px; border-bottom: 1px solid var(--accent-light);">
                        <div style="font-weight: 600; color: var(--gray-700);">Nama Toko</div>
                        <div style="color: var(--gray-800); font-weight: 500;">{{ $store->name }}</div>
                    </div>

                    {{-- About --}}
                    <div style="display: flex; justify-content: space-between; padding-bottom: 20px; border-bottom: 1px solid var(--accent-light);">
                        <div style="font-weight: 600; color: var(--gray-700);">Deskripsi</div>
                        <div style="color: var(--gray-800); max-width: 400px; text-align: right;">{{ Str::limit($store->about, 100) }}</div>
                    </div>

                    {{-- Phone --}}
                    <div style="display: flex; justify-content: space-between; padding-bottom: 20px; border-bottom: 1px solid var(--accent-light);">
                        <div style="font-weight: 600; color: var(--gray-700);">Telepon</div>
                        <div style="color: var(--gray-800); font-weight: 500;">{{ $store->phone }}</div>
                    </div>

                    {{-- City --}}
                    <div style="display: flex; justify-content: space-between; padding-bottom: 20px; border-bottom: 1px solid var(--accent-light);">
                        <div style="font-weight: 600; color: var(--gray-700);">Kota</div>
                        <div style="color: var(--gray-800); font-weight: 500;">{{ $store->city }}</div>
                    </div>

                    {{-- Address --}}
                    <div style="display: flex; justify-content: space-between; padding-bottom: 20px; border-bottom: 1px solid var(--accent-light);">
                        <div style="font-weight: 600; color: var(--gray-700);">Alamat</div>
                        <div style="color: var(--gray-800); max-width: 400px; text-align: right;">{{ $store->address }}</div>
                    </div>

                    {{-- Registration Date --}}
                    <div style="display: flex; justify-content: space-between;">
                        <div style="font-weight: 600; color: var(--gray-700);">Tanggal Pendaftaran</div>
                        <div style="color: var(--gray-800); font-weight: 500;">{{ $store->created_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>
            </div>

            {{-- Action Button --}}
            <div style="margin-top: 24px; text-align: center;">
                <a href="{{ route('buyer.dashboard') }}" 
                   style="display: inline-block; color: var(--gray-700); text-decoration: none; font-weight: 600; padding: 12px 24px; border: 2px solid var(--accent-light); border-radius: 8px; transition: all 0.2s;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    @else
        {{-- No Store Found --}}
        <div style="max-width: 600px; margin: 0 auto;">
            <div class="empty-state">
                <div class="empty-icon">🏪</div>
                <h3 class="empty-title">Belum Mendaftar Toko</h3>
                <p class="empty-text">Anda belum mendaftar toko. Daftar sekarang dan mulai berjualan di ELSHOP!</p>
                <a href="{{ route('buyer.store.create') }}" 
                   style="display: inline-block; background: var(--accent); color: white; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; margin-top: 16px; box-shadow: var(--shadow-md); transition: all 0.2s;">
                    <i class="fas fa-plus-circle"></i> Daftar Toko Sekarang
                </a>
            </div>
        </div>
    @endif
</div>

<style>
a[href*="seller.dashboard"]:hover,
a[href*="store.create"]:hover {
    background: var(--primary) !important;
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

a[href*="buyer.dashboard"]:hover {
    background: var(--accent-lightest) !important;
    border-color: var(--accent);
}
</style>
@endsection