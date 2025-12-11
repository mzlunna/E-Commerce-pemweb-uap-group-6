@extends('layouts.seller')
@section('title','Edit Category')

@section('content')

<div class="page-header">
    <h1>Edit Kategori</h1>
</div>

<div class="card">
    <div class="card-body">

        <form action="{{ route('seller.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="name" value="{{ $category->name }}" class="form-input" required>
            </div>

            <div class="form-actions">
                <button class="btn btn-primary">Update</button>
                <a href="{{ route('seller.categories.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>

    </div>
</div>

@endsection
