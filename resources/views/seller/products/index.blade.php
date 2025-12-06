@extends('layouts.seller')
@section('title','Products')

@section('content')
<h1>Your Products</h1>

<a href="{{ route('seller.products.create') }}">Add Product</a>

@foreach($products as $p)
    <div>
        {{ $p->name }}
        <a href="{{ route('seller.products.edit', $p->id) }}">Edit</a>
    </div>
@endforeach
@endsection
