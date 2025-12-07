@extends('layouts.admin')

@section('header', 'Order Details')

@section('content')
<div class="p-6 bg-[#d8e1e8] min-h-screen rounded-lg">

    {{-- Judul --}}
    <h2 class="text-3xl font-bold mb-6 text-[#304674]">📄 Detail Order #{{ $order->id }}</h2>

    {{-- Info Order --}}
    <div class="mb-6 bg-[#c6d3e3] p-6 rounded-lg shadow">
        <div class="mb-3"><strong>Customer:</strong> {{ $order->user->name }}</div>
        <div class="mb-3"><strong>Email:</strong> {{ $order->user->email }}</div>
        <div class="mb-3"><strong>Total Price:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
        <div class="mb-3">
            <strong>Status:</strong> 
            <span class="px-2 py-1 rounded-full font-semibold
                {{ $order->status === 'completed' ? 'bg-[#b2f2bb] text-[#1b5e20]' : ($order->status === 'pending' ? 'bg-[#b8daff] text-[#0c5460]' : 'bg-[#f5c2c7] text-[#b02a37]') }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>
        <div class="mb-3"><strong>Created At:</strong> {{ $order->created_at->format('d M Y H:i') }}</div>
    </div>

    {{-- Daftar Produk --}}
    <h3 class="text-xl font-semibold mb-4 text-[#304674]">Products in Order</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-[#c6d3e3]/50 rounded-lg shadow">
            <thead class="bg-[#304674]/90 text-white">
                <tr>
                    <th class="py-3 px-6 text-left">Product</th>
                    <th class="py-3 px-6 text-left">Price</th>
                    <th class="py-3 px-6 text-left">Quantity</th>
                    <th class="py-3 px-6 text-left">Subtotal</th>
                </tr>
            </thead>
            <tbody class="text-[#304674]/90">
                @foreach($order->orderItems as $item)
                <tr class="border-b border-[#b2cbde] hover:bg-[#b2cbde]/50 transition">
                    <td class="py-3 px-6">{{ $item->product->name }}</td>
                    <td class="py-3 px-6">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="py-3 px-6">{{ $item->quantity }}</td>
                    <td class="py-3 px-6">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Kembali --}}
    <div class="mt-6">
        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-[#98bad5] hover:bg-[#b2cbde] text-[#304674] rounded transition">← Back to Orders</a>
    </div>

</div>
@endsection
