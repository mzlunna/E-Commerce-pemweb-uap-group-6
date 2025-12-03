<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Withdrawal</title>
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
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700">Dashboard</a>
                    <a href="{{ route('admin.users') }}" class="text-gray-700">Kelola User</a>
                    <a href="{{ route('admin.store-verification') }}" class="text-gray-700">Verifikasi Toko</a>
                    <a href="{{ route('admin.withdrawals') }}" class="text-gray-900 font-bold">Withdrawal</a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600">Logout</button>
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
                ✅ {{ session('success') }}
            </div>
        @endif

        <h2 class="text-3xl font-bold mb-6">💰 Kelola Withdrawal</h2>

        <!-- Withdrawals Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-yellow-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Toko</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Pemilik</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Bank</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($withdrawals as $withdrawal)
                    <tr>
                        <td class="px-6 py-4">
                            {{ $withdrawal->storeBalance->store->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $withdrawal->storeBalance->store->user->name }}
                        </td>
                        <td class="px-6 py-4 font-bold text-green-600">
                            Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <p class="font-bold">{{ $withdrawal->bank_name }}</p>
                                <p class="text-gray-600">{{ $withdrawal->bank_account_name }}</p>
                                <p class="text-gray-600">{{ $withdrawal->bank_account_number }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($withdrawal->status === 'pending')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-bold">
                                    ⏳ Pending
                                </span>
                            @elseif($withdrawal->status === 'approved')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-bold">
                                    ✓ Approved
                                </span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-bold">
                                    ✕ Rejected
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            {{ $withdrawal->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($withdrawal->status === 'pending')
                                <div class="flex gap-2">
                                    <!-- Tombol APPROVE -->
                                    <form method="POST" action="{{ route('admin.withdrawals.update-status', $withdrawal) }}">
                                        @csrf
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                                            ✓ Approve
                                        </button>
                                    </form>
                                    
                                    <!-- Tombol REJECT -->
                                    <form method="POST" action="{{ route('admin.withdrawals.update-status', $withdrawal) }}" 
                                          onsubmit="return confirm('Yakin tolak withdrawal ini?')">
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                            ✕ Reject
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            Belum ada withdrawal request
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $withdrawals->links() }}
        </div>

    </div>

</body>
</html>