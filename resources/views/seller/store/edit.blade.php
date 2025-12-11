@extends('layouts.seller')
@section('title','Edit Store')

@section('content')

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Edit Store Profile</h2>
    </div>

    <div class="card-body">
        <form action="{{ route('seller.store.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label required">Store Name</label>
                <input type="text" name="name" class="form-input" value="{{ $store->name }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-textarea">{{ $store->description }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label required">Address</label>
                <input type="text" name="address" class="form-input" value="{{ $store->address }}" required>
            </div>

            <div class="form-group">
                <label class="form-label required">Phone</label>
                <input type="text" name="phone" class="form-input" value="{{ $store->phone }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Logo</label>
                <input type="file" name="logo" class="form-input">

                @if($store->logo)
                    <p class="mt-2">Current Logo:</p>
                    <img src="{{ asset('storage/'.$store->logo) }}" width="120">
                @endif
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Store</button>
            </div>

        </form>
    </div>
</div>

@endsection
