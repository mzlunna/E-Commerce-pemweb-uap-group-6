<!-- buyer/profile/edit.blade.php -->
@extends('layouts.app')
@section('title', 'Edit Profil - ELSHOP')
@section('content')
<div class="container mt-5">
    <div class="dashboard-header">
        <h1>👤 Edit Profil Anda</h1>
    </div>

    <div class="content-card">
        <form action="{{ route('buyer.profile.update') }}" method="POST">
            @csrf @method('PATCH')

            <div class="form-group">
                <label>Nama Lengkap *</label>
                <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
                @error('name') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
                @error('email') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Nomor Telepon</label>
                <input type="text" name="phone" class="form-control" value="{{ auth()->user()->phone }}">
                @error('phone') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea name="address" class="form-control" rows="3">{{ auth()->user()->address }}</textarea>
                @error('address') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
                <a href="{{ route('buyer.dashboard') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

---

<!-- buyer/store/create.blade.php -->
@extends('layouts.app')
@section('title', 'Daftar Toko - ELSHOP')
@section('content')
<div class="container mt-5">
    <div class="dashboard-header">
        <h1>🏪 Daftar Toko Anda</h1>
        <p>Mulai berjualan di ELSHOP</p>
    </div>

    <div class="content-card">
        <form action="{{ route('buyer.store.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Toko *</label>
                <input type="text" name="name" class="form-control" placeholder="Nama toko Anda" required>
                @error('name') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Nomor Telepon *</label>
                <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx" required>
                @error('phone') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Alamat Toko *</label>
                <textarea name="address" class="form-control" rows="3" placeholder="Jalan, No, RT/RW..." required></textarea>
                @error('address') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Kota *</label>
                    <input type="text" name="city" class="form-control" required>
                    @error('city') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Kode Pos *</label>
                    <input type="text" name="postal_code" class="form-control" required>
                    @error('postal_code') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Deskripsi Toko</label>
                <textarea name="about" class="form-control" rows="4" placeholder="Ceritakan tentang toko Anda..."></textarea>
                @error('about') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Daftar Toko</button>
                <a href="{{ route('buyer.dashboard') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

---

<!-- buyer/store/status.blade.php -->
@extends('layouts.app')
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