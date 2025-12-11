@extends('layouts.seller')

@section('title', 'Edit Produk')

@section('content')

<div class="page-header">
    <h1>Edit Produk</h1>
</div>

<div class="card">
    <div class="card-body">

        <form action="{{ route('seller.products.update', $product->id) }}"
              method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="name" value="{{ $product->name }}" class="form-input" required>
            </div>

            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="price" value="{{ $product->price }}" class="form-input" required>
            </div>

            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stock" value="{{ $product->stock }}" class="form-input" required>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="desc" class="form-input" rows="5" required>{{ $product->description }}</textarea>
            </div>

            <div class="form-group">
                <label>Tambah Gambar Baru (opsional)</label>
                <input type="file" name="images[]" multiple class="form-input">
            </div>

            <div class="form-group">
                <label>Gambar Lama</label>

                <div class="product-gallery">
                    @foreach ($product->images as $img)
                        <img src="{{ asset('storage/' . $img->image_url) }}"
                             class="product-image-thumb">
                    @endforeach
                </div>
            </div>

            <div class="form-actions">
                <button class="btn btn-primary">Update</button>
                <a href="{{ route('seller.products.index') }}" class="btn btn-secondary">Kembali</a>
            </div>

        </form>

    </div>
</div>

@endsection
