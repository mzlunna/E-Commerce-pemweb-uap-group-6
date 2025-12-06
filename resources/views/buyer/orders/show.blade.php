@extends('layouts.buyer')
@section('title','Order Detail')

@section('content')
<h1>Order Detail</h1>
<p>Order ID: {{ $order->id }}</p>
@endsection
