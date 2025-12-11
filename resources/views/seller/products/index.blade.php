@extends('layouts.seller')

@section('content')
<div class="page-header page-header-actions">
    <div>
        <h1>Daftar Produk</h1>
        <p>Kelola semua produk tokomu di sini.</p>
    </div>

    <a href="{{ route('seller.products.create') }}" class="btn btn-primary">
        ➕ Tambah Produk
    </a>
</div>

<div class="card">
    <div class="card-body">

        @if($products->count() > 0)

        <table class="table align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($products as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>
                        @if($p->images->count() > 0)
                            <img src="{{ asset('storage/' . $p->images->first()->image_url) }}"
                                 alt="{{ $p->name }}" class="product-thumb">
                        @else
                            <span class="text-muted">Tidak ada gambar</span>
                        @endif
                    </td>

                    <td>{{ $p->name }}</td>

                    <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                    <td>{{ $p->stock }}</td>

                    <td class="text-center">

                        <a href="{{ route('seller.products.edit', $p->id) }}"
                           class="btn btn-warning btn-sm">
                            ✏️ Edit
                        </a>

                        <form action="{{ route('seller.products.destroy', $p->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Yakin mau menghapus produk ini?')">
                            @csrf
                            @method('DELETE')

                            <!-- TOMBOL HAPUS TIDAK MERAH → SECONDARY -->
                            <button class="btn btn-secondary btn-sm">
                                🗑️ Hapus
                            </button>

                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @else
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <h3 class="empty-title">Belum ada produk</h3>
                <p class="empty-text">Tambahkan produk pertama kamu sekarang.</p>

                <a href="{{ route('seller.products.create') }}"
                   class="btn btn-primary mt-3">
                    ➕ Tambah Produk
                </a>
            </div>
        @endif

    </div>
</div>

@endsection
