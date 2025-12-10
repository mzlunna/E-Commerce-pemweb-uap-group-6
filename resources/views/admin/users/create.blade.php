@extends('layouts.admin')

@section('content')
<div class="p-6 bg-[#d8e1e8] min-h-screen rounded-xl">

    {{-- Judul --}}
    <h2 class="text-3xl font-bold mb-6 text-[#304674]">➕ Tambah User</h2>

    {{-- Form Tambah User --}}
    <div class="max-w-md mx-auto bg-[#b2cbde] p-6 rounded-lg shadow-lg">
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block mb-2 font-semibold text-[#304674]">Nama:</label>
                <input type="text" name="name" 
                       class="w-full px-4 py-2 rounded-lg border border-[#304674] bg-[#d8e1e8] text-[#304674] focus:outline-none focus:ring-2 focus:ring-[#98bad5]">
            </div>

            <div>
                <label class="block mb-2 font-semibold text-[#304674]">Email:</label>
                <input type="email" name="email" 
                       class="w-full px-4 py-2 rounded-lg border border-[#304674] bg-[#d8e1e8] text-[#304674] focus:outline-none focus:ring-2 focus:ring-[#98bad5]">
            </div>

            <div>
                <label class="block mb-2 font-semibold text-[#304674]">Password:</label>
                <input type="password" name="password" 
                       class="w-full px-4 py-2 rounded-lg border border-[#304674] bg-[#d8e1e8] text-[#304674] focus:outline-none focus:ring-2 focus:ring-[#98bad5]">
            </div>

            <div>
                <label class="block mb-2 font-semibold text-[#304674]">Role:</label>
                <select name="role" 
                        class="w-full px-4 py-2 rounded-lg border border-[#304674] bg-[#d8e1e8] text-[#304674] focus:outline-none focus:ring-2 focus:ring-[#98bad5]">
                    <option value="admin">Admin</option>
                    <option value="member">Member</option>
                </select>
            </div>

            <button type="submit" 
                    class="w-full py-3 bg-[#98bad5] hover:bg-[#304674] text-white font-semibold rounded-lg transition-colors">
                Simpan
            </button>
        </form>
    </div>
</div>
@endsection