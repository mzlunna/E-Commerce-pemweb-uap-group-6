@extends('layouts.buyer')
@section('title','Checkout')

@section('content')
<h1>Checkout</h1>

<form action="{{ route('buyer.checkout.process') }}" method="POST">
    @csrf
    <textarea name="address" placeholder="Shipping Address"></textarea>
    <button type="submit">Pay Now</button>
</form>
@endsection
