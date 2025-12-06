@extends('layouts.buyer')
@section('title','Apply Store')

@section('content')
<h1>Apply for Store</h1>

<form action="{{ route('buyer.store.submit') }}" method="POST">
    @csrf
    <input name="store_name" placeholder="Store Name">
    <button>Submit</button>
</form>
@endsection
