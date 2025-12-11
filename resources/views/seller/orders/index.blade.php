@extends('layouts.seller')
@section('title','Pesanan Masuk')

@section('content')

<div class="page-header">
    <h1>Pesanan Masuk</h1>
</div>

<div class="card">
    <div class="card-body">

        @if($orders->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pembeli</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->buyer->name }}</td>
                    <td>Rp {{ number_format($order->grand_total,0,',','.') }}</td>

                    <td>
                        <span class="status-badge {{ $order->shipping_type }}">
                            {{ ucfirst($order->shipping_type) }}
                        </span>
                    </td>

                    <td>{{ $order->created_at->format('d M Y') }}</td>

                    <td>
                        <a href="{{ route('seller.orders.show', $order->id) }}" class="btn btn-secondary btn-sm">
                            Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
        @else
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <h3 class="empty-title">Belum ada pesanan</h3>
            </div>
        @endif

    </div>
</div>

@endsection
