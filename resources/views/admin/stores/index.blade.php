@extends('layouts.admin')

@section('header', 'Store Management')

@section('content')
<div class="p-6 bg-[#d8e1e8] min-h-screen rounded-lg">

    <h2 class="text-3xl font-bold mb-6 text-[#304674]">🏬 Kelola Store</h2>

    {{-- FILTER & CREATE --}}
    <div class="mb-6 flex justify-between items-center">
        <form method="GET">
            <select name="status" onchange="this.form.submit()"
                class="px-4 py-2 border border-[#b2cbde] rounded-lg bg-[#d8e1e8] text-[#304674]">
                <option value="">Semua</option>
                <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                <option value="verified" {{ request('status')=='verified' ? 'selected' : '' }}>Terverifikasi</option>
                <option value="deleted" {{ request('status')=='deleted' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </form>

        <a href="{{ route('admin.stores.create') }}"
           class="px-4 py-2 bg-[#98bad5] hover:bg-[#304674] text-white rounded-lg transition">
            + Tambah Store
        </a>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto mb-10">
        <table class="min-w-full bg-[#c6d3e3]/50 rounded-lg shadow">
            <thead class="bg-[#304674]/90 text-white">
                <tr>
                    <th class="py-3 px-6">Logo</th>
                    <th class="py-3 px-6">Nama</th>
                    <th class="py-3 px-6">About</th>
                    <th class="py-3 px-6">Pemilik</th>
                    <th class="py-3 px-6">Produk</th>
                    <th class="py-3 px-6">Transaksi</th>
                    <th class="py-3 px-6">Status</th>
                    <th class="py-3 px-6">Dibuat</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="text-[#304674]/90">
                @forelse($stores as $store)
                <tr class="border-b border-[#b2cbde] hover:bg-[#b2cbde]/50 transition">

                    {{-- LOGO --}}
                    <td class="py-3 px-6">
                        @php
                            $logoUrl = 'https://i.ibb.co/N22VY8m/default-store-logo-blue.png';
                            if ($store->logo && file_exists(storage_path('app/public/' . $store->logo))) {
                                $logoUrl = asset('storage/' . $store->logo);
                            }
                        @endphp
                        <img src="{{ $logoUrl }}" class="w-12 h-12 rounded object-cover shadow" alt="{{ $store->name }}">
                    </td>

                    {{-- NAMA --}}
                    <td class="py-3 px-6 font-semibold">{{ $store->name }}</td>

                    {{-- ABOUT --}}
                    <td class="py-3 px-6">{{ Str::limit($store->about, 50) ?? '-' }}</td>

                    {{-- PEMILIK --}}
                    <td class="py-3 px-6">{{ $store->user->name ?? 'Tidak ditemukan' }}</td>

                    {{-- JUMLAH PRODUK --}}
                    <td class="py-3 px-6">{{ $store->products_count }}</td>

                    {{-- JUMLAH TRANSAKSI --}}
                    <td class="py-3 px-6">{{ $store->transactions_count }}</td>

                    {{-- STATUS --}}
                    <td class="py-3 px-6">
                        @if($store->deleted_at)
                            <span class="px-2 py-1 rounded font-semibold bg-[#f8d7da] text-[#842029]">Ditolak</span>
                        @elseif($store->is_verified)
                            <span class="px-2 py-1 rounded font-semibold bg-[#b2f2bb] text-[#1b5e20]">Terverifikasi</span>
                        @else
                            <span class="px-2 py-1 rounded font-semibold bg-[#b8daff] text-[#0c5460]">Pending</span>
                        @endif
                    </td>

                    {{-- CREATED DATE --}}
                    <td class="py-3 px-6">{{ $store->created_at->format('d M Y') }}</td>

                    {{-- ACTION BUTTONS --}}
                    <td class="py-3 px-6 flex flex-wrap justify-center gap-2">
                        <a href="{{ route('admin.stores.show', $store->id) }}"
                           class="px-3 py-1 bg-[#98bad5] hover:bg-[#b2cbde] text-[#304674] rounded">View</a>

                        @if(!$store->is_verified && !$store->deleted_at)
                        <a href="{{ route('admin.stores.edit', $store->id) }}"
                           class="px-3 py-1 bg-[#b2cbde] hover:bg-[#98bad5] text-[#304674] rounded">Edit</a>
                        @endif

                        @if(!$store->deleted_at)
                        <form action="{{ route('admin.stores.destroy', $store->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus store ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 bg-[#f5c2c7] hover:bg-[#f5a3a8] text-[#b02a37] rounded">Delete</button>
                        </form>
                        @endif

                        @if($store->deleted_at)
                        <form action="{{ route('admin.stores.restore', $store->id) }}" method="POST">
                            @csrf
                            <button class="px-3 py-1 bg-[#b8daff] hover:bg-[#90c2ff] text-[#0c5460] rounded">Restore</button>
                        </form>
                        @endif

                        @if(!$store->is_verified && !$store->deleted_at)
                        <form action="{{ route('admin.stores.verify', $store->id) }}" method="POST">
                            @csrf
                            <button class="px-3 py-1 bg-[#b2f2bb] hover:bg-[#8ce99a] text-[#1b5e20] rounded">Approve</button>
                        </form>

                        <form action="{{ route('admin.stores.reject', $store->id) }}" method="POST">
                            @csrf
                            <button class="px-3 py-1 bg-[#f5c2c7] hover:bg-[#f5a3a8] text-[#b02a37] rounded">Reject</button>
                        </form>
                        @endif
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="9" class="py-8 text-center text-[#304674]/70">Tidak ada toko</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex justify-end">
        {{ $stores->links() }}
    </div>
</div>
@endsection
