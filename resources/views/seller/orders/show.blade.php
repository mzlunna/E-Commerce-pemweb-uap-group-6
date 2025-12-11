@extends('layouts.seller')
@section('title','Detail Pesanan')

@section('content')

<div class="page-header">
    <h1>Detail Pesanan #{{ $order->id }}</h1>
</div>

<div class="card">
    <div class="card-body">

        <p><strong>Pembeli:</strong> {{ $order->buyer->name }}</p>
        <p><strong>Total:</strong> Rp {{ number_format($order->grand_total,0,',','.') }}</p>

        <hr>

        <form action="{{ route('seller.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Status Pengiriman</label>
                <select name="shipping_type" class="form-input">
                    <option value="pending" {{ $order->shipping_type=='pending'?'selected':'' }}>Pending</option>
                    <option value="shipped" {{ $order->shipping_type=='shipped'?'selected':'' }}>Dikirim</option>
                    <option value="delivered" {{ $order->shipping_type=='delivered'?'selected':'' }}>Selesai</option>
                </select>
            </div>

            <div class="form-group">
                <label>Nomor Resi</label>
                <input type="text" name="tracking_number" class="form-input" 
                       value="{{ $order->tracking_number }}">
            </div>

            <div class="form-actions">
                <button class="btn btn-primary">Update Pesanan</button>
            </div>

        </form>

    </div>
</div>

@endsection
