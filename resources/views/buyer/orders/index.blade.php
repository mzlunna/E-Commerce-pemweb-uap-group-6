@extends('layouts.buyer')
@section('title','Orders')

@section('content')
<h1>Your Orders</h1>

@foreach($orders as $order)
    <a href="{{ route('buyer.order.show', $order->id) }}">
        Order #{{ $order->id }}
    </a><br>
@endforeach
@endsection
