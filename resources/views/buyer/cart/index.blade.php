@extends('layouts.buyer')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-4">
    <h2>Keranjang Belanja Anda</h2>
    @if(session()->has('cart') && count(session('cart')) > 0)
        <div class="cart-items">
            @foreach(session('cart') as $id => $item)
                <div class="cart-item">
                    <h5>{{ $item['name'] }}</h5>
                    <p>Harga: Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                    <p>Jumlah: {{ $item['quantity'] }}</p>
                    <form action="{{ route('buyer.cart.update', $id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="number" name="qty" value="{{ $item['quantity'] }}" min="1">
                        <button type="submit" class="btn btn-update">Update</button>
                    </form>
                    <form action="{{ route('buyer.cart.destroy', $id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete">Hapus</button>
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <p>Keranjang Anda kosong.</p>
    @endif
</div>
@endsection
