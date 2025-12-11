@extends('layouts.seller')
@section('title','Create Category')

@section('content')

<div class="page-header">
    <h1>Buat Kategori Baru</h1>
</div>

<div class="card">
    <div class="card-body">

        <form action="{{ route('seller.categories.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="name" class="form-input" required>
            </div>

            <div class="form-actions">
                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('seller.categories.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>

    </div>
</div>

@endsection
