<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Toko - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    
    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-red-600">👨‍💼 Admin Panel</h1>
                
                <div class="flex gap-4 items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-gray-900">Dashboard</a>
                    <a href="{{ route('admin.users') }}" class="text-gray-700 hover:text-gray-900">Kelola User</a>
                    <a href="{{ route('admin.store-verification') }}" class="text-gray-900 font-bold">Verifikasi Toko</a>
                    <a href="{{ route('admin.withdrawals') }}" class="text-gray-900 f">Withdrawal</a>
                    
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
        
        <!-- Alert -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-3xl font-bold mb-6">🏪 Verifikasi Toko</h2>

        <!-- Stores Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-yellow-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Toko</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pemilik</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kota</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Terdaftar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($stores as $store)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-medium">{{ $store->name }}</p>
                                <p class="text-xs text-gray-500">{{ $store->phone }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-medium">{{ $store->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $store->user->email }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p>{{ $store->city }}</p>
                                <p class="text-xs text-gray-500">{{ $store->postal_code }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                {{ $store->products_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($store->is_verified)
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                    ✓ Verified
                                </span>
                            @else
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                    ⏳ Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $store->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <!-- Approve Button -->
                                @if(!$store->is_verified)
                                    <form method="POST" action="{{ route('admin.stores.verify', $store) }}">
                                        @csrf
                                        <input type="hidden" name="action" value="approve">
                                        <button type="submit" 
                                                class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                                            ✓ Approve
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.stores.verify', $store) }}">
                                        @csrf
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" 
                                                class="px-3 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-700 text-sm">
                                            ✕ Unverify
                                        </button>
                                    </form>
                                @endif

                                <!-- Delete Button -->
                                <form method="POST" action="{{ route('admin.stores.delete', $store) }}" 
                                      onsubmit="return confirm('Yakin hapus toko ini? Semua produk akan ikut terhapus!')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            Belum ada toko terdaftar
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $stores->links() }}
        </div>

        <!-- Info Box -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="font-bold text-blue-900 mb-2">ℹ️ Informasi Verifikasi</h3>
            <ul class="text-sm text-blue-800 space-y-1">
                <li>• <strong>Approve</strong> - Toko bisa mulai berjualan, produknya muncul di homepage</li>
                <li>• <strong>Reject/Unverify</strong> - Toko tidak bisa berjualan, produk tidak tampil</li>
                <li>• <strong>Hapus</strong> - Menghapus toko beserta semua produknya secara permanen</li>
            </ul>
        </div>

    </div>

</body>
</html>