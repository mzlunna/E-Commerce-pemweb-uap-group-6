@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="p-6 bg-[#d8e1e8] min-h-screen">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-[#304674]">Selamat Datang di Dashboard Admin</h1>
        <p class="text-[#304674]/80 mt-1">Overview sistem dan aktivitas terbaru</p>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="bg-[#98bad5]/30 border-l-4 border-[#304674] text-[#304674] px-4 py-3 rounded mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-[#f5c2c7]/30 border-l-4 border-[#b02a37] text-[#b02a37] px-4 py-3 rounded mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if(session('info'))
        <div class="bg-[#c6d3e3]/30 border-l-4 border-[#304674] text-[#304674] px-4 py-3 rounded mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('info') }}</span>
        </div>
    @endif

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

        {{-- Total Users --}}
        <div class="bg-gradient-to-br from-[#304674]/90 to-[#1167b1]/70 p-6 rounded-xl shadow-md text-white transform hover:scale-105 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[#d8e1e8] text-sm font-medium">Total Users</p>
                    <p class="text-4xl font-bold mt-2">{{ number_format($stats['total_users']) }}</p>
                    <p class="text-[#d8e1e8] text-xs mt-1">Member terdaftar</p>
                </div>
                <div class="bg-[#98bad5]/40 p-4 rounded-lg">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Stores --}}
        <div class="bg-gradient-to-br from-[#1167b1]/70 to-[#187bcd]/70 p-6 rounded-xl shadow-md text-white transform hover:scale-105 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[#d8e1e8] text-sm font-medium">Total Stores</p>
                    <p class="text-4xl font-bold mt-2">{{ number_format($stats['total_stores']) }}</p>
                    <p class="text-[#d8e1e8] text-xs mt-1">Toko terverifikasi</p>
                </div>
                <div class="bg-[#98bad5]/40 p-4 rounded-lg">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Pending Stores --}}
        <div class="bg-gradient-to-br from-[#187bcd]/70 to-[#2a9df4]/70 p-6 rounded-xl shadow-md text-white transform hover:scale-105 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[#d8e1e8] text-sm font-medium">Stores Pending</p>
                    <p class="text-4xl font-bold mt-2">{{ number_format($stats['pending_stores']) }}</p>
                    <p class="text-[#d8e1e8] text-xs mt-1">Menunggu verifikasi</p>
                </div>
                <div class="bg-[#98bad5]/40 p-4 rounded-lg">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Products --}}
        <div class="bg-gradient-to-br from-[#2a9df4]/70 to-[#98bad5]/70 p-6 rounded-xl shadow-md text-[#304674] transform hover:scale-105 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[#304674]/90 text-sm font-medium">Total Products</p>
                    <p class="text-4xl font-bold mt-2">{{ number_format($stats['total_products']) }}</p>
                    <p class="text-[#304674]/70 text-xs mt-1">Produk terdaftar</p>
                </div>
                <div class="bg-[#c6d3e3]/40 p-4 rounded-lg">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Transactions --}}
        <div class="bg-gradient-to-br from-[#1167b1]/70 to-[#187bcd]/70 p-6 rounded-xl shadow-md text-white transform hover:scale-105 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[#d8e1e8] text-sm font-medium">Total Transactions</p>
                    <p class="text-4xl font-bold mt-2">{{ number_format($stats['total_transactions']) }}</p>
                    <p class="text-[#d8e1e8] text-xs mt-1">Total transaksi</p>
                </div>
                <div class="bg-[#98bad5]/40 p-4 rounded-lg">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Revenue --}}
        <div class="bg-gradient-to-br from-[#2a9df4]/70 to-[#98bad5]/70 p-6 rounded-xl shadow-md text-[#304674] transform hover:scale-105 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[#304674]/90 text-sm font-medium">Total Revenue</p>
                    <p class="text-3xl font-bold mt-2">
                        Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                    </p>
                    <p class="text-[#304674]/70 text-xs mt-1">Pendapatan terbayar</p>
                </div>
                <div class="bg-[#c6d3e3]/40 p-4 rounded-lg">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>

    {{-- Users Terbaru --}}
    <div class="bg-[#d0efff] rounded-xl shadow-md mb-8 overflow-hidden">
        <div class="bg-[#b2cbde] px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-[#304674] flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                10 Users Terbaru
            </h2>

            <a href="{{ route('admin.users.index') }}"
               class="bg-[#98bad5] text-[#304674]/90 hover:bg-[#b2cbde] px-4 py-2 rounded-lg text-sm font-medium transition">
                Lihat Semua →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr class="bg-[#b2cbde]/90 border-b">
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#304674] uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#304674] uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#304674] uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#304674] uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#304674] uppercase">Registered</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#304674] uppercase">Actions</th>
                    </tr>
                </thead>

                <tbody class="bg-[#d0efff] divide-y">
                    @forelse($users as $user)
                        <tr class="hover:bg-[#c6d3e3]/30 transition">
                            <td class="px-6 py-4 text-sm text-[#304674]">#{{ $user->id }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex items-center justify-center rounded-full bg-[#1167b1] text-white font-bold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="ml-3 text-sm font-medium text-[#304674]">
                                        {{ $user->name }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#304674]">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $user->role == 'admin'
                                        ? 'bg-[#304674] text-white'
                                        : 'bg-[#1167b1] text-white' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#304674]">
                                {{ $user->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                       class="px-3 py-1 bg-[#1167b1]/90 hover:bg-[#187bcd]/80 text-white rounded-lg text-xs transition">
                                        Detail
                                    </a>
                                    @if($user->role != 'admin' && $user->id != auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin hapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-1 bg-[#6fa8dc] hover:bg-[#5d8cc6] text-white rounded-lg text-xs transition-colors duration-200">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-[#304674]/70">
                                Tidak ada user terbaru
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection