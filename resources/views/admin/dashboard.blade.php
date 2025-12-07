@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

    {{-- Statistik --}}
    <div class="grid grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-gray-500">Total Users</h2>
            <p class="text-2xl font-bold">{{ $stats['total_users'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-gray-500">Total Stores</h2>
            <p class="text-2xl font-bold">{{ $stats['total_stores'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-gray-500">Stores Pending</h2>
            <p class="text-2xl font-bold">{{ $stats['pending_stores'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-gray-500">Total Products</h2>
            <p class="text-2xl font-bold">{{ $stats['total_products'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-gray-500">Total Transactions</h2>
            <p class="text-2xl font-bold">{{ $stats['total_transactions'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-gray-500">Total Revenue</h2>
            <p class="text-2xl font-bold">${{ number_format($stats['total_revenue'], 2) }}</p>
        </div>
    </div>

    {{-- Users Terbaru --}}
    <h2 class="text-xl font-semibold mb-2">10 Users Terbaru</h2>
    <table class="table-auto w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="border-b hover:bg-gray-100">
                <td class="px-4 py-2">{{ $user->id }}</td>
                <td class="px-4 py-2">{{ $user->name }}</td>
                <td class="px-4 py-2">{{ $user->email }}</td>
                <td class="px-4 py-2">
                    <span class="px-2 py-1 rounded text-white {{ $user->is_active ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="px-4 py-2 flex gap-2">
                    <a href="{{ route('admin.users.show', $user->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded">Detail</a>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="px-3 py-1 bg-green-500 text-white rounded">Edit</a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus?')">
                        @csrf
                        @method('DELETE')
                        <button class="px-3 py-1 bg-red-500 text-white rounded">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Recent Stores --}}
    <h2 class="text-xl font-semibold mt-8 mb-2">Recent Stores Pending Approval</h2>
    <table class="table-auto w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Store Name</th>
                <th class="px-4 py-2">Owner</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentStores as $store)
            <tr class="border-b hover:bg-gray-100">
                <td class="px-4 py-2">{{ $store->id }}</td>
                <td class="px-4 py-2">{{ $store->name }}</td>
                <td class="px-4 py-2">{{ $store->user->name ?? 'N/A' }}</td>
                <td class="px-4 py-2">
                    <a href="{{ route('admin.stores.show', $store->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Recent Transactions --}}
    <h2 class="text-xl font-semibold mt-8 mb-2">Recent Transactions</h2>
    <table class="table-auto w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">User</th>
                <th class="px-4 py-2">Total</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentTransactions as $transaction)
             <tr class="border-b hover:bg-gray-100">
        <td class="px-4 py-2">{{ $transaction->id }}</td>
        <td class="px-4 py-2">{{ $transaction->user->name ?? 'N/A' }}</td>
        <td class="px-4 py-2">${{ number_format($transaction->grand_total, 2) }}</td>
        <td class="px-4 py-2">
            <span class="px-2 py-1 rounded text-white {{ $transaction->payment_status == 'paid' ? 'bg-green-500' : 'bg-red-500' }}">
                {{ ucfirst($transaction->payment_status) }}
            </span>
        </td>
    </tr>
    @endforeach
</tbody>
</table>

</div> <!-- penutup container p-6 -->

@endsection