<<<<<<< HEAD
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
    :root {
        --lunpia-orange: #F4A261;
        --lunpia-red: #E76F51;
        --lunpia-peach: #FFDAC1;
        --lunpia-brown: #8D6E63;
        --lunpia-cream: #FFF9F4;
        --lunpia-yellow: #f5d99a;
    }
</style>

</head>
<body class="bg-[var(--lunpia-cream)]">

    
    <!-- Navbar -->
    <nav class="bg-[var(--lunpia-yellow)] shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-red-600">👨‍💼 Admin Panel</h1>
                
                <div class="flex gap-4 items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-gray-900 font-bold">Dashboard</a>
                    <a href="{{ route('admin.users') }}" class="text-gray-700 hover:text-gray-900">Kelola User</a>
                    <a href="{{ route('admin.store-verification') }}" class="text-gray-700 hover:text-gray-900">Verifikasi Toko</a>
                    <a href="{{ route('admin.withdrawals') }}" class="text-gray-700 hover:text-gray-900">Withdrawal</a>
                    
                    
                    <span class="text-gray-700">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        
        <!-- Alert Success -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-3xl font-bold mb-6">Dashboard Admin</h2>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            
            <!-- Total Users -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-gray-500 text-sm">Total Users</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $totalUsers }}</p>
                    </div>
                    <div class="text-4xl">👥</div>
                </div>
                <div class="mt-4 text-sm text-gray-600">
                    Admin: {{ $adminCount }} | Member: {{ $memberCount }}
                </div>
            </div>

            <!-- Total Stores -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-gray-500 text-sm">Total Toko</p>
                        <p class="text-3xl font-bold text-green-600">{{ $totalStores }}</p>
                    </div>
                    <div class="text-4xl">🏪</div>
                </div>
                <div class="mt-4 text-sm text-gray-600">
                    Verified: {{ $verifiedStores }} | Pending: {{ $pendingStores }}
                </div>
            </div>

            <!-- Total Products -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-gray-500 text-sm">Total Produk</p>
                        <p class="text-3xl font-bold text-purple-600">{{ $totalProducts }}</p>
                    </div>
                    <div class="text-4xl">📦</div>
                </div>
            </div>

            <!-- Total Transactions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-gray-500 text-sm">Total Transaksi</p>
                        <p class="text-3xl font-bold text-orange-600">{{ $totalTransactions }}</p>
                    </div>
                    <div class="text-4xl">💰</div>
                </div>
            </div>

        </div>

        <!-- Pending Stores -->
        @if($pendingStores > 0)
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">⏳ Toko Pending Verifikasi</h3>
                <a href="{{ route('admin.store-verification') }}" class="text-blue-600 hover:text-blue-800">
                    Lihat Semua →
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Toko</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Pemilik</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kota</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Dibuat</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($pendingStoresList as $store)
                        <tr>
                            <td class="px-4 py-3">{{ $store->name }}</td>
                            <td class="px-4 py-3">{{ $store->user->name }}</td>
                            <td class="px-4 py-3">{{ $store->city }}</td>
                            <td class="px-4 py-3">{{ $store->created_at->diffForHumans() }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.store-verification') }}" 
                                   class="text-blue-600 hover:text-blue-800">
                                    Verifikasi →
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <a href="{{ route('admin.users') }}" 
               class="bg-blue-600 text-white p-6 rounded-lg hover:bg-blue-700 transition text-center">
                <div class="text-4xl mb-2">👥</div>
                <h3 class="text-xl font-bold">Kelola User</h3>
                <p class="text-sm mt-2">Lihat dan kelola semua user</p>
            </a>

            <a href="{{ route('admin.store-verification') }}" 
               class="bg-green-600 text-white p-6 rounded-lg hover:bg-green-700 transition text-center">
                <div class="text-4xl mb-2">🏪</div>
                <h3 class="text-xl font-bold">Verifikasi Toko</h3>
                <p class="text-sm mt-2">Approve atau reject toko</p>
            </a>

            <a href="{{ route('home') }}" 
               class="bg-purple-600 text-white p-6 rounded-lg hover:bg-purple-700 transition text-center">
                <div class="text-4xl mb-2">🏠</div>
                <h3 class="text-xl font-bold">Lihat Website</h3>
                <p class="text-sm mt-2">Kembali ke homepage</p>
            </a>

            <a href="{{ route('admin.withdrawals') }}" 
                    class="bg-orange-600 text-white p-6 rounded-lg hover:bg-orange-700 transition text-center">
                        <div class="text-4xl mb-2">💰</div>
                        <h3 class="text-xl font-bold">Kelola Withdrawal</h3>
                        <p class="text-sm mt-2">Approve/reject withdrawal</p>
                    </a>

        </div>
=======
@extends('layouts.admin')
>>>>>>> viaa

@section('content')
<div class="grid grid-cols-3 gap-6 mb-6">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-gray-500">Total Users</h2>
        <p class="text-2xl font-bold">{{ $totalUsers }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-gray-500">Total Stores</h2>
        <p class="text-2xl font-bold">{{ $totalStores }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-gray-500">Stores Pending</h2>
        <p class="text-2xl font-bold">{{ $pendingStores }}</p>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-lg font-semibold mb-4">Recent Users</h2>
    <table class="min-w-full bg-white rounded-lg overflow-hidden">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="py-3 px-6 text-left">ID</th>
                <th class="py-3 px-6 text-left">Name</th>
                <th class="py-3 px-6 text-left">Email</th>
                <th class="py-3 px-6">Status</th>
                <th class="py-3 px-6">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="border-b hover:bg-gray-100">
                <td class="py-3 px-6">{{ $user->id }}</td>
                <td class="py-3 px-6">{{ $user->name }}</td>
                <td class="py-3 px-6">{{ $user->email }}</td>
                <td class="py-3 px-6">
                    <span class="px-2 py-1 rounded-full text-white text-xs 
                        {{ $user->is_active ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="py-3 px-6 flex gap-2 justify-center">
                    <a href="{{ route('admin.users.show', $user->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Detail</a>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
