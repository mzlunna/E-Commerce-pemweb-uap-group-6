@extends('layouts.buyer')
@section('title','Cart')

@section('content')
<h1>Your Cart</h1>

@foreach($cart as $item)
    <div>
        {{ $item->product->name }} - {{ $item->quantity }}
    </div>
@endforeach

<a href="{{ route('buyer.checkout') }}">Proceed to Checkout</a>
@endsection
