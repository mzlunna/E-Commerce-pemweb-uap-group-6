@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-[#d8e1e8] p-6">
    <div class="w-full max-w-2xl bg-[#c6d3e3]/50 p-8 rounded-xl shadow-lg">
        {{-- Judul --}}
        <h1 class="text-3xl font-bold mb-6 text-[#304674] text-center">Detail User</h1>

        {{-- Informasi User --}}
        <div class="space-y-4">
            <p class="text-lg text-[#304674]/90"><strong>Nama:</strong> {{ $user->name }}</p>
            <p class="text-lg text-[#304674]/90"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="text-lg text-[#304674]/90"><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
        </div>

        {{-- Informasi Toko --}}
        @if ($user->store)
            <hr class="my-6 border-[#b2cbde]">
            <h2 class="text-2xl font-semibold mb-4 text-[#304674] text-center">Toko</h2>
            <div class="space-y-3 text-center">
                <p class="text-[#304674]/90"><strong>Nama Toko:</strong> {{ $user->store->name }}</p>
                <p class="text-[#304674]/90"><strong>Status Verifikasi:</strong>
                    {{ $user->store->is_verified ? 'Terverifikasi' : 'Belum Diverifikasi' }}
                </p>
                <p class="text-[#304674]/90"><strong>Total Produk:</strong> {{ $user->store->products_count ?? 0 }}</p>
            </div>
        @endif

        {{-- Tombol Kembali --}}
        <div class="mt-6 text-center">
            <a href="{{ route('admin.dashboard') }}"
               class="inline-block px-6 py-3 bg-[#98bad5] hover:bg-[#304674] text-white font-semibold rounded-lg transition">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
