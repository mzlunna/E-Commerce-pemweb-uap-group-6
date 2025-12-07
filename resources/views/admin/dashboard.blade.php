@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-gray-500 text-sm font-medium">Total Users</h2>
            <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($stats['total_users']) }}</p>
            <p class="text-xs text-gray-500 mt-1">Member terdaftar</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-gray-500 text-sm font-medium">Total Stores</h2>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ number_format($stats['total_stores']) }}</p>
            <p class="text-xs text-gray-500 mt-1">Toko terverifikasi</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-gray-500 text-sm font-medium">Stores Pending</h2>
            <p class="text-3xl font-bold text-yellow-600 mt-2">{{ number_format($stats['pending_stores']) }}</p>
            <p class="text-xs text-gray-500 mt-1">Menunggu verifikasi</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-gray-500 text-sm font-medium">Total Products</h2>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ number_format($stats['total_products']) }}</p>
            <p class="text-xs text-gray-500 mt-1">Produk terdaftar</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-gray-500 text-sm font-medium">Total Transactions</h2>
            <p class="text-3xl font-bold text-purple-600 mt-2">{{ number_format($stats['total_transactions']) }}</p>
            <p class="text-xs text-gray-500 mt-1">Transaksi</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-gray-500 text-sm font-medium">Total Revenue</h2>
            <p class="text-3xl font-bold text-green-600 mt-2">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500 mt-1">Pendapatan terbayar</p>
        </div>
    </div>

    {{-- Users Terbaru --}}
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">10 Users Terbaru</h2>
                <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                    Lihat Semua →
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registered</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $user->id }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $user->role == 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $user->created_at->diffForHumans() }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.users.show', $user->id) }}" 
                                   class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded text-xs">
                                    Detail
                                </a>
                                @if($user->role != 'admin')
                                <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin ingin hapus user ini?')"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded text-xs">
                                        Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada user terbaru
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Recent Stores Pending Approval --}}
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">Toko Menunggu Verifikasi</h2>
                <a href="{{ route('admin.stores.index', ['status' => 'pending']) }}" 
                   class="text-blue-600 hover:text-blue-800 text-sm">
                    Lihat Semua →
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Store Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Owner</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recentStores as $store)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $store->id }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $store->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $store->user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $store->created_at->diffForHumans() }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.stores.show', $store->id) }}" 
                                   class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded text-xs">
                                    Review
                                </a>
                                <form action="{{ route('admin.stores.verify', $store->id) }}" 
                                      method="POST" 
                                      class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white rounded text-xs"
                                            onclick="return confirm('Setujui toko ini?')">
                                        Verifikasi
                                    </button>
                                </form>
                                <form action="{{ route('admin.stores.reject', $store->id) }}" 
                                      method="POST" 
                                      class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded text-xs"
                                            onclick="return confirm('Tolak toko ini?')">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada toko yang menunggu verifikasi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Recent Transactions --}}
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">Transaksi Terbaru</h2>
                @if(Route::has('admin.orders.index'))
                <a href="{{ route('admin.orders.index') }}" 
                   class="text-blue-600 hover:text-blue-800 text-sm">
                    Lihat Semua →
                </a>
                @endif
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recentTransactions as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-blue-600">
                            @if(Route::has('admin.orders.show'))
                            <a href="{{ route('admin.orders.show', $transaction->id) }}" class="hover:underline">
                                {{ $transaction->code ?? '#' . $transaction->id }}
                            </a>
                            @else
                            {{ $transaction->code ?? '#' . $transaction->id }}
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $transaction->user->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                            Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @php
                                $paymentColors = [
                                    'paid' => 'bg-green-100 text-green-800',
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'failed' => 'bg-red-100 text-red-800',
                                    'cancelled' => 'bg-gray-100 text-gray-800',
                                ];
                                $color = $paymentColors[$transaction->payment_status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $color }}">
                                {{ ucfirst($transaction->payment_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'processing' => 'bg-blue-100 text-blue-800',
                                    'shipped' => 'bg-purple-100 text-purple-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                                $color = $statusColors[$transaction->order_status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $color }}">
                                {{ ucfirst($transaction->order_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $transaction->created_at->format('d M Y, H:i') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada transaksi terbaru
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div> <!-- penutup container p-6 -->

@endsection