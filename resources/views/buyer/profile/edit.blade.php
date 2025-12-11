@extends('layouts.buyer')

@section('title', 'Edit Profil - ELSHOP')

@section('content')
<div class="section">
    <div class="section-header">
        <h2 class="section-title">Edit Profil Saya</h2>
    </div>

    <div style="max-width: 800px; margin: 0 auto;">
        <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
            
            <form action="{{ route('buyer.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Profile Photo Upload -->
                <div style="margin-bottom: 32px; text-align: center; padding-bottom: 32px; border-bottom: 1px solid var(--accent-light);">
                    <label style="display: block; font-weight: 600; margin-bottom: 16px; color: var(--gray-700); text-align: left;">
                        Foto Profil
                    </label>
                    <div style="display: inline-block; position: relative;">
                        <div id="photoPreview" style="width: 120px; height: 120px; border-radius: 50%; background: var(--gray-100); display: flex; align-items: center; justify-content: center; font-size: 3rem; margin: 0 auto; overflow: hidden; border: 3px solid var(--accent-light);">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <span style="font-size: 3rem; font-weight: 700; color: var(--gray-400);">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            @endif
                        </div>
                        <label for="avatar" style="position: absolute; bottom: 0; right: 0; background: var(--accent); color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: var(--shadow-md); border: 3px solid white;">
                            <i class="fas fa-camera"></i>
                        </label>
                        <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;" onchange="previewPhoto(event)">
                    </div>
                    <p style="margin-top: 12px; color: var(--gray-500); font-size: 0.875rem;">JPG atau PNG, maksimal 2MB</p>
                    @error('avatar')
                        <span style="color: var(--danger); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Full Name -->
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700);">
                        Nama Lengkap <span style="color: var(--danger);">*</span>
                    </label>
                    <input type="text" name="name" class="filter-select"
                           style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px; font-size: 0.938rem;"
                           value="{{ old('name', auth()->user()->name) }}" required>
                    @error('name')
                        <span style="color: var(--danger); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700);">
                        Email <span style="color: var(--danger);">*</span>
                    </label>
                    <input type="email" name="email" class="filter-select"
                           style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px; font-size: 0.938rem;"
                           value="{{ old('email', auth()->user()->email) }}" required>
                    @error('email')
                        <span style="color: var(--danger); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Phone -->
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700);">
                        Nomor Telepon
                    </label>
                    <input type="text" name="phone" class="filter-select"
                           style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px; font-size: 0.938rem;"
                           value="{{ old('phone', auth()->user()->phone) }}" placeholder="08xxxxxxxxxx">
                    @error('phone')
                        <span style="color: var(--danger); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Address -->
                <div style="margin-bottom: 32px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700);">
                        Alamat Lengkap
                    </label>
                    <textarea name="address" rows="3" class="filter-select"
                              style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px; font-size: 0.938rem; resize: vertical;"
                              placeholder="Masukkan alamat lengkap Anda">{{ old('address', auth()->user()->address) }}</textarea>
                    @error('address')
                        <span style="color: var(--danger); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Change Section (Optional) -->
                <div style="padding: 24px; background: var(--gray-50); border-radius: 12px; margin-bottom: 32px;">
                    <h3 style="font-weight: 600; margin-bottom: 16px; color: var(--gray-800);">Ubah Password (Opsional)</h3>
                    
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700);">
                            Password Baru
                        </label>
                        <input type="password" name="password" class="filter-select"
                               style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px; font-size: 0.938rem;"
                               placeholder="Kosongkan jika tidak ingin mengubah">
                        @error('password')
                            <span style="color: var(--danger); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700);">
                            Konfirmasi Password Baru
                        </label>
                        <input type="password" name="password_confirmation" class="filter-select"
                               style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px; font-size: 0.938rem;"
                               placeholder="Ulangi password baru">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 16px;">
                    <button type="submit" style="flex: 1; background: var(--accent); color: white; border: none; padding: 14px 32px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: var(--shadow);">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('buyer.dashboard') }}" style="flex: 1; background: white; color: var(--gray-700); border: 2px solid var(--accent-light); padding: 14px 32px; border-radius: 8px; font-weight: 600; text-decoration: none; text-align: center; transition: all 0.2s; display: flex; align-items: center; justify-content: center;">
                        Batal
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
function previewPhoto(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('photoPreview');
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