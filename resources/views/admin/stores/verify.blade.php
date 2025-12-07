@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-[#d8e1e8] p-6">
    <div class="w-full max-w-lg bg-[#c6d3e3]/50 p-8 rounded-xl shadow-lg">
        <h2 class="text-3xl font-bold mb-6 text-[#304674] text-center">🏬 Verifikasi Toko</h2>

        <div class="space-y-4 text-[#304674]/90">
            <p><strong>Nama Toko:</strong> {{ $store->name }}</p>
            <p><strong>Pemilik:</strong> {{ $store->owner->name }}</p>
            <p><strong>Status Verifikasi:</strong>
                <span class="px-2 py-1 rounded 
                    {{ $store->is_verified ? 'bg-[#98bad5] text-[#304674]' : 'bg-[#f5c2c7] text-[#b02a37]' }}">
                    {{ $store->is_verified ? 'Terverifikasi' : 'Belum Diverifikasi' }}
                </span>
            </p>
            <p><strong>Total Produk:</strong> {{ $store->products_count ?? 0 }}</p>
        </div>

        <div class="mt-6 flex flex-col gap-3">
            @if(!$store->is_verified)
                <form action="{{ route('stores.approve', $store->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full py-3 bg-[#98bad5] hover:bg-[#b2cbde] text-[#304674] font-semibold rounded-lg transition">
                        Approve
                    </button>
                </form>
                <form action="{{ route('stores.reject', $store->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full py-3 bg-[#f5c2c7] hover:bg-[#f5a3a8] text-[#b02a37] font-semibold rounded-lg transition">
                        Reject
                    </button>
                </form>
            @else
                <form action="{{ route('stores.restore', $store->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full py-3 bg-[#98bad5] hover:bg-[#b2cbde] text-[#304674] font-semibold rounded-lg transition">
                        Restore
                    </button>
                </form>
            @endif
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('stores.index') }}"
               class="inline-block px-6 py-3 bg-[#98bad5] hover:bg-[#304674] text-white font-semibold rounded-lg transition">
                Kembali ke Daftar Toko
            </a>
        </div>
    </div>
</div>
@endsection
