@extends('layouts.seller')
@section('title','Edit Product')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Edit Product</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('seller.products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- NAME --}}
            <div class="form-group">
                <label class="form-label required">Product Name</label>
                <input type="text" name="name" class="form-input" value="{{ $product->name }}" required>
            </div>

            {{-- CATEGORY --}}
            <div class="form-group">
                <label class="form-label required">Category</label>
                <select name="category" class="form-input" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->product_category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- DESCRIPTION --}}
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="desc" class="form-textarea" rows="4">{{ $product->description }}</textarea>
            </div>

            {{-- CONDITION --}}
            <div class="form-group">
                <label class="form-label required">Condition</label>
                <input type="text" name="condition" class="form-input" value="{{ $product->condition }}" required>
            </div>

            {{-- PRICE --}}
            <div class="form-group">
                <label class="form-label required">Price</label>
                <input type="number" name="price" class="form-input" value="{{ $product->price }}" required>
            </div>

            {{-- WEIGHT --}}
            <div class="form-group">
                <label class="form-label required">Weight (grams)</label>
                <input type="number" name="weight" class="form-input" value="{{ $product->weight }}" required>
            </div>

            {{-- STOCK --}}
            <div class="form-group">
                <label class="form-label required">Stock</label>
                <input type="number" name="stock" class="form-input" value="{{ $product->stock }}" required>
            </div>

            {{-- ACTION --}}
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Product</button>
            </div>
        </form>
    </div>
</div>
@endsection
