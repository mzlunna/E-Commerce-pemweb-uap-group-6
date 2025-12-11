@extends('layouts.seller')

@section('title', 'Tambah Produk')

@section('content')

<div class="page-header">
    <h1>Tambah Produk</h1>
</div>

<div class="card">
    <div class="card-body">

        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- NAMA PRODUK --}}
            <div class="form-group">
                <label>Kategori Produk</label>
                <select name="category" class="form-input" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="name" class="form-input" required>
            </div>

            {{-- KONDISI --}}
            <div class="form-group">
                <label>Kondisi Produk</label>
                <select name="condition" class="form-input" required>
                    <option value="new">Baru</option>
                    <option value="used">Bekas</option>
                </select>
            </div>

            {{-- HARGA --}}
            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="price" class="form-input" required>
            </div>

            {{-- BERAT --}}
            <div class="form-group">
                <label>Berat (gram)</label>
                <input type="number" name="weight" class="form-input" required>
            </div>

            {{-- STOK --}}
            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stock" class="form-input" required>
            </div>

            {{-- DESKRIPSI --}}
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="desc" class="form-input" rows="5" required></textarea>
            </div>

            {{-- GAMBAR --}}
            <div class="form-group">
                <label>Gambar Produk (boleh lebih dari 1)</label>
                <input type="file" name="images[]" multiple class="form-input">
            </div>

            <div class="form-actions">
                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('seller.products.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>

    </div>
</div>

@endsection
