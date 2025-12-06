@extends('layouts.seller')
@section('title','Create Product')

@section('content')
<h1>Add New Product</h1>

<form method="POST">
    @csrf
    <input name="name" placeholder="Product Name">
    <button>Create</button>
</form>
@endsection
