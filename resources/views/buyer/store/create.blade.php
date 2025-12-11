@extends('layouts.buyer')
@section('title', 'Daftar Toko - ELSHOP')
@section('content')
<div class="section">
    <div class="section-header">
        <h2 class="section-title"><i class="fas fa-store"></i> Daftar Toko Anda</h2>
    </div>

    <div style="max-width: 900px; margin: 0 auto;">
        {{-- Info Box --}}
        <div style="background: linear-gradient(135deg, var(--accent-lightest) 0%, white 100%); border-radius: 12px; padding: 24px; margin-bottom: 32px; border: 1px solid var(--accent-light); box-shadow: var(--shadow);">
            <div style="display: flex; gap: 16px; align-items: start;">
                <div style="font-size: 2.5rem;"><i class="fas fa-lightbulb" style="color: var(--warning);"></i></div>
                <div>
                    <h3 style="font-weight: 700; margin-bottom: 8px; color: var(--primary);">Mulai Berjualan di ELSHOP</h3>
                    <p style="color: var(--gray-600); line-height: 1.6;">Daftarkan toko Anda sekarang dan jangkau ribuan pembeli. Proses verifikasi biasanya memakan waktu 1-2 hari kerja.</p>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
            <form action="{{ route('buyer.store.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Logo Upload --}}
                <div style="margin-bottom: 32px; text-align: center;">
                    <label style="display: block; font-weight: 600; margin-bottom: 16px; color: var(--gray-700); text-align: left;">
                        Logo Toko (Opsional)
                    </label>
                    <div style="display: inline-block; position: relative;">
                        <div id="logoPreview" style="width: 120px; height: 120px; border-radius: 12px; background: var(--gray-100); display: flex; align-items: center; justify-content: center; font-size: 3rem; margin: 0 auto; overflow: hidden; border: 2px dashed var(--accent-light);">
                            🏪
                        </div>
                        <label for="logo" style="position: absolute; bottom: -10px; right: -10px; background: var(--accent); color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: var(--shadow-md);">
                            <i class="fas fa-camera"></i>
                        </label>
                        <input type="file" id="logo" name="logo" accept="image/*" style="display: none;" onchange="previewLogo(event)">
                    </div>
                    <p style="margin-top: 12px; color: var(--gray-500); font-size: 0.875rem;">Max 2MB (JPG, PNG)</p>
                    @error('logo')
                        <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Store Name --}}
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700);">
                        Nama Toko <span style="color: var(--danger);">*</span>
                    </label>
                    <input type="text" name="name" class="filter-select"
                           style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px; font-size: 0.938rem;"
                           value="{{ old('name') }}" placeholder="Contoh: Snack Paradise" required>
                    @error('name')
                        <span style="color: var(--danger); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- About Store --}}
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700);">
                        Deskripsi Toko <span style="color: var(--danger);">*</span>
                    </label>
                    <textarea name="about" rows="4" class="filter-select"
                              style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px; font-size: 0.938rem; resize: vertical;"
                              placeholder="Ceritakan tentang toko Anda, produk yang dijual, dan keunggulannya... (Min. 50 karakter)" required>{{ old('about') }}</textarea>
                    <p style="color: var(--gray-500); font-size: 0.813rem; margin-top: 4px;">Minimal 50 karakter</p>
                    @error('about')
                        <span style="color: var(--danger); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Phone --}}
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700);">
                        Nomor Telepon Toko <span style="color: var(--danger);">*</span>
                    </label>
                    <input type="text" name="phone" class="filter-select"
                           style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px; font-size: 0.938rem;"
                           value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required>
                    @error('phone')
                        <span style="color: var(--danger); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Address --}}
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700);">
                        Alamat Lengkap Toko <span style="color: var(--danger);">*</span>
                    </label>
                    <textarea name="address" rows="3" class="filter-select"
                              style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px; font-size: 0.938rem; resize: vertical;"
                              placeholder="Jalan, No, RT/RW, Kelurahan, Kecamatan..." required>{{ old('address') }}</textarea>
                    @error('address')
                        <span style="color: var(--danger); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- City & Postal Code --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700);">
                            Kota <span style="color: var(--danger);">*</span>
                        </label>
                        <input type="text" name="city" class="filter-select"
                               style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px; font-size: 0.938rem;"
                               value="{{ old('city') }}" placeholder="Contoh: Malang" required>
                        @error('city')
                            <span style="color: var(--danger); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700);">
                            Kode Pos <span style="color: var(--danger);">*</span>
                        </label>
                        <input type="text" name="postal_code" class="filter-select"
                               style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px; font-size: 0.938rem;"
                               value="{{ old('postal_code') }}" placeholder="65xxx" maxlength="5" required>
                        @error('postal_code')
                            <span style="color: var(--danger); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Terms Agreement --}}
                <div style="margin-bottom: 32px; padding: 16px; background: var(--accent-lightest); border-radius: 8px; border: 1px solid var(--accent-light);">
                    <label style="display: flex; align-items: start; gap: 12px; cursor: pointer;">
                        <input type="checkbox" name="terms" required style="margin-top: 4px;">
                        <span style="font-size: 0.938rem; color: var(--gray-700);">
                            Saya setuju dengan <a href="#" style="color: var(--primary); text-decoration: underline;">Syarat & Ketentuan</a> dan <a href="#" style="color: var(--primary); text-decoration: underline;">Kebijakan Privasi</a> ELSHOP
                        </span>
                    </label>
                </div>

                {{-- Action Buttons --}}
                <div style="display: flex; gap: 16px;">
                    <button type="submit" style="flex: 1; background: var(--accent); color: white; border: none; padding: 14px 32px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: var(--shadow);">
                        <i class="fas fa-paper-plane"></i> Ajukan Toko
                    </button>
                    <a href="{{ route('buyer.dashboard') }}" style="flex: 1; background: white; color: var(--gray-700); border: 2px solid var(--accent-light); padding: 14px 32px; border-radius: 8px; font-weight: 600; text-decoration: none; text-align: center; transition: all 0.2s; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewLogo(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('logoPreview');
        preview.innerHTML = `<img src="${reader.result}" style="width: 100%; height: 100%; object-fit: cover;">`;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

<style>
button[type="submit"]:hover {
    background: var(--primary) !important;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

a[href*="dashboard"]:hover {
    background: var(--accent-lightest) !important;
    border-color: var(--accent);
}
</style>
@endsection