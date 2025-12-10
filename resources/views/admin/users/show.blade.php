@extends('layouts.admin')

@section('content')
<div class="p-6 bg-[#d8e1e8] min-h-screen rounded-xl flex justify-center">

    <div class="w-full max-w-lg bg-[#c6d3e3]/50 p-8 rounded-xl shadow-lg">

        {{-- TITLE – DETAIL USER --}}
        <h2 class="text-3xl font-bold mb-6 text-[#304674] text-center">👤 Detail User</h2>

        {{-- USER INFO --}}
        <div class="flex flex-col items-center mb-6">
            <div class="w-20 h-20 bg-[#304674] text-white rounded-full flex items-center justify-center text-3xl font-bold shadow-md">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <p class="mt-4 text-xl font-semibold text-[#304674]">{{ $user->name }}</p>
            <p class="text-[#304674]/80">{{ $user->email }}</p>
            <p class="mt-1">
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    {{ $user->role == 'admin' ? 'bg-[#304674] text-white' : 'bg-[#1167b1] text-white' }}">
                    {{ ucfirst($user->role) }}
                </span>
            </p>
        </div>

        {{-- USER DETAILS --}}
        <div class="space-y-3 text-[#304674]/90 mb-6">
            <p><strong>User ID:</strong> #{{ $user->id }}</p>
            <p><strong>Dibuat:</strong> {{ $user->created_at->format('d M Y - H:i') }}</p>
            <p><strong>Terakhir Update:</strong> {{ $user->updated_at->format('d M Y - H:i') }}</p>
        </div>


        {{-- SECTION TOKO MILIK USER --}}
        <h3 class="text-2xl font-bold mt-10 mb-4 text-[#304674]">🏬 Informasi Toko</h3>

        @if($store)
            {{-- LOGO TOKO --}}
            <div class="flex justify-center mb-6">
                <img src="{{ $store->logo 
                    ? asset('storage/' . $store->logo) 
                    : 'https://i.ibb.co/N22VY8m/default-store-logo-blue.png' }}"
                    class="w-28 h-28 rounded-lg object-cover shadow-md border border-[#98bad5]/50">
            </div>

            <div class="space-y-4 text-[#304674]/90">

                <p><strong>Nama Toko:</strong> {{ $store->name }}</p>

                <p>
                    <strong>Status Verifikasi:</strong>
                    @if($store->deleted_at)
                        <span class="px-2 py-1 rounded bg-[#f8d7da] text-[#842029]">Ditolak</span>
                    @elseif($store->is_verified)
                        <span class="px-2 py-1 rounded bg-[#b2f2bb] text-[#1b5e20]">Terverifikasi</span>
                    @else
                        <span class="px-2 py-1 rounded bg-[#b8daff] text-[#0c5460]">Pending</span>
                    @endif
                </p>

                <p><strong>Total Produk:</strong> {{ $store->products_count ?? 0 }}</p>
                <p><strong>Alamat:</strong> {{ $store->address ?? '-' }}</p>
                <p><strong>About:</strong> {{ $store->about ?? '-' }}</p>
            </div>

            {{-- TOMBOL AKSI TOKO --}}
            <div class="mt-6 flex flex-col gap-3">

                @if(!$store->is_verified && !$store->deleted_at)
                    <form action="{{ route('admin.stores.verify', $store->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full py-3 bg-[#b2f2bb] hover:bg-[#8ce99a] text-[#1b5e20] font-semibold rounded-lg transition">
                            Approve Store
                        </button>
                    </form>

                    <form action="{{ route('admin.stores.reject', $store->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full py-3 bg-[#f5c2c7] hover:bg-[#f5a3a8] text-[#b02a37] font-semibold rounded-lg transition">
                            Reject Store
                        </button>
                    </form>
                @endif

                @if($store->deleted_at)
                    <form action="{{ route('admin.stores.restore', $store->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full py-3 bg-[#98bad5] hover:bg-[#b2cbde] text-[#304674] font-semibold rounded-lg transition">
                            Restore Store
                        </button>
                    </form>
                @endif

            </div>

        @else
            {{-- JIKA USER TIDAK PUNYA TOKO --}}
            <p class="text-center text-[#304674]/70 py-6">
                User ini belum membuat toko.
            </p>
        @endif

        {{-- BACK BUTTON --}}
        <div class="mt-6 text-center">
            <a href="{{ route('admin.users.index') }}"
               class="inline-block px-6 py-3 bg-[#304674] hover:bg-[#1f2f4e] text-white font-semibold rounded-lg transition">
                Kembali
            </a>
        </div>

    </div>
</div>
@endsection