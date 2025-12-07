@extends('layouts.admin')

@section('header', 'Order Management')

@section('content')
<div class="p-6 bg-[#d8e1e8] min-h-screen rounded-lg">

    {{-- Judul --}}
    <h2 class="text-3xl font-bold mb-6 text-[#304674]">🛒 Kelola Order</h2>

    {{-- Filter Status --}}
    <div class="mb-6 flex justify-between items-center">
        <select class="px-4 py-2 border border-[#b2cbde] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#98bad5] bg-[#d8e1e8] text-[#304674]">
            <option value="">All Status</option>
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>

    {{-- Tabel Order --}}
    <div class="overflow-x-auto mb-10">
        <table class="min-w-full bg-[#c6d3e3]/50 rounded-lg shadow">
            <thead class="bg-[#304674]/90 text-white">
                <tr>
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Customer</th>
                    <th class="py-3 px-6 text-left">Total Price</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-left">Created</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-[#304674]/90">
                @forelse($orders as $order)
                <tr class="border-b border-[#b2cbde] hover:bg-[#b2cbde]/50 transition">
                    <td class="py-3 px-6">{{ $order->id }}</td>
                    <td class="py-3 px-6">{{ $order->user->name }}</td>
                    <td class="py-3 px-6">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td class="py-3 px-6">
                        <span class="px-2 py-1 rounded-full font-semibold
                            {{ $order->status === 'completed' ? 'bg-[#b2f2bb] text-[#1b5e20]' : ($order->status === 'pending' ? 'bg-[#b8daff] text-[#0c5460]' : 'bg-[#f5c2c7] text-[#b02a37]') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="py-3 px-6">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="py-3 px-6 flex justify-center gap-2">
                        <a href="{{ route('admin.orders.show', $order->id) }}" 
                           class="px-3 py-1 bg-[#98bad5] hover:bg-[#b2cbde] text-[#304674] rounded transition">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-[#304674]/70">No orders found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex justify-end">
        {{ $orders->links() }}
    </div>

</div>
@endsection
