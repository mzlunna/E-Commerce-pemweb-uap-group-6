<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User - Admin</title>
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
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-gray-900">Dashboard</a>
                    <a href="{{ route('admin.users') }}" class="text-gray-900 font-bold">Kelola User</a>
                    <a href="{{ route('admin.store-verification') }}" class="text-gray-700 hover:text-gray-900">Verifikasi Toko</a>
                    <a href="{{ route('admin.withdrawals') }}" class="text-gray-900">Withdrawal</a>
                    
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
        
        <!-- Alert -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <h2 class="text-3xl font-bold mb-6">👥 Kelola User</h2>

        <!-- Users Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-yellow-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Toko</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Terdaftar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $user->id }}</td>
                        <td class="px-6 py-4 font-medium">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="flex gap-2">
                                @csrf
                                @method('PUT')
                                <select name="role" 
                                        class="text-sm border-gray-300 rounded px-2 py-1
                                               {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}"
                                        onchange="this.form.submit()"
                                        {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="member" {{ $user->role === 'member' ? 'selected' : '' }}>Member</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->store)
                                <span class="text-green-600">
                                    ✓ {{ $user->store->name }}
                                    @if($user->store->is_verified)
                                        <span class="text-xs">(Verified)</span>
                                    @else
                                        <span class="text-xs text-yellow-600">(Pending)</span>
                                    @endif
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.delete', $user) }}" 
                                      onsubmit="return confirm('Yakin hapus user ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400">You</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            Belum ada user
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $users->links() }}
        </div>

    </div>

</body>
</html>