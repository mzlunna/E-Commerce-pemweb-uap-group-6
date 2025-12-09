@extends('layouts.admin')

@section('content')
<div class="p-6 bg-[#d8e1e8] min-h-screen rounded-xl">
<div class="flex items-center justify-center min-h-screen bg-[#d8e1e8] p-6">
    <div class="w-full max-w-lg bg-[#c6d3e3]/50 p-8 rounded-xl shadow-lg">
        <h2 class="text-3xl font-bold mb-6 text-[#304674] text-center">🏬 Detail Toko</h2>

        {{-- Logo --}}
        @php
            $logoUrl = 'https://i.ibb.co/N22VY8m/default-store-logo-blue.png';
            if ($store->logo && file_exists(storage_path('app/public/' . $store->logo))) {
                $logoUrl = asset('storage/' . $store->logo);
            }
        @endphp
        <div class="flex justify-center mb-6">
            <img src="{{ $logoUrl }}" alt="{{ $store->name }}" class="w-24 h-24 rounded object-cover shadow">
        </div>

        <div class="space-y-4 text-[#304674]/90">
            <p><strong>Nama Toko:</strong> {{ $store->name }}</p>
            <p><strong>Pemilik:</strong> {{ $store->user->name ?? 'Tidak ditemukan' }}</p>
            <p><strong>Status Verifikasi:</strong>
                @if($store->deleted_at)
                    <span class="px-2 py-1 rounded bg-[#f8d7da] text-[#842029]">Ditolak</span>
                @elseif($store->is_verified)
                    <span class="px-2 py-1 rounded bg-[#b2f2bb] text-[#1b5e20]">Terverifikasi</span>
                @else
                    <span class="px-2 py-1 rounded bg-[#b8daff] text-[#0c5460]">Pending</span>
                @endif
            </p>
            <p><strong>Total Produk:</strong> {{ $store->products_count ?? 0 }}</p>
        </div>

        <div class="mt-6 flex flex-col gap-3">
            @if(!$store->is_verified && !$store->deleted_at)
                <form action="{{ route('admin.stores.verify', $store->id) }}" method="POST">@csrf
                    <button type="submit" class="w-full py-3 bg-[#b2f2bb] hover:bg-[#8ce99a] text-[#1b5e20] font-semibold rounded-lg transition">
                        Approve
                    </button>
                </form>
                <form action="{{ route('admin.stores.reject', $store->id) }}" method="POST">@csrf
                    <button type="submit" class="w-full py-3 bg-[#f5c2c7] hover:bg-[#f5a3a8] text-[#b02a37] font-semibold rounded-lg transition">
                        Reject
                    </button>
                </form>
            @endif

            @if($store->deleted_at)
                <form action="{{ route('admin.stores.restore', $store->id) }}" method="POST">@csrf
                    <button type="submit" class="w-full py-3 bg-[#98bad5] hover:bg-[#b2cbde] text-[#304674] font-semibold rounded-lg transition">
                        Restore
                    </button>
                </form>
            @endif
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('admin.stores.index') }}" class="inline-block px-6 py-3 bg-[#304674] hover:bg-[#1f2f4e] text-white font-semibold rounded-lg transition">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
