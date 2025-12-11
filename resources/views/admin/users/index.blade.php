@extends('layouts.admin')

@section('content')
<div class="p-6 bg-[#d8e1e8] min-h-screen rounded-xl">

    {{-- Judul --}}
    <div class="bg-[#c6d3e3] px-6 py-4 rounded-lg shadow mb-6">
        <h2 class="text-3xl font-bold mb-6 text-[#304674]">👥 Kelola User</h2>
    </div>

    {{-- Tombol Tambah User --}}
    <a href="{{ route('admin.users.create')}}"
       class="px-5 py-2 mb-6 inline-block bg-[#98bad5] hover:bg-[#b2cbde] text-[#304674] font-semibold rounded shadow transition">
        + Tambah User
    </a>

    {{-- Tabel User --}}
    <div class="overflow-x-auto mb-10">
        <table class="min-w-full bg-[#c6d3e3]/50 rounded-lg shadow">
            <thead class="bg-[#304674]/90 text-white">
                <tr>
                    <th class="py-3 px-6 text-left">Nama</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Role</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-[#304674]/90">
                @foreach ($users as $user)
                <tr class="border-b border-[#b2cbde] hover:bg-[#b2cbde]/50 transition">
                    <td class="py-3 px-6">{{ $user->name }}</td>
                    <td class="py-3 px-6">{{ $user->email }}</td>
                    <td class="py-3 px-6">{{ ucfirst($user->role) }}</td>
                    <td class="py-3 px-6 flex justify-center gap-2">
                        <a href="{{ route('admin.users.show', $user->id) }}" 
                           class="px-3 py-1 bg-[#98bad5] hover:bg-[#b2cbde] text-[#304674] rounded transition">Detail</a>
                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                           class="px-3 py-1 bg-[#98bad5] hover:bg-[#b2cbde] text-[#304674] rounded transition">Edit</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="px-3 py-1 bg-[#f5c2c7] hover:bg-[#f5a3a8] text-[#b02a37] rounded transition">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection