@extends('layouts.admin')

@section('content')
<div class="p-6 bg-[#d8e1e8] min-h-screen">
    <h2 class="text-3xl font-bold mb-6 text-[#304674]">✏️ Edit User</h2>

    <div class="max-w-md mx-auto bg-[#c6d3e3] p-6 rounded-lg shadow-lg">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-2 font-semibold text-[#304674]">Nama:</label>
                <input type="text" name="name" value="{{ $user->name }}" 
                       class="w-full px-4 py-2 rounded-lg border border-[#b2cbde] bg-[#d8e1e8] text-[#304674] focus:outline-none focus:ring-2 focus:ring-[#98bad5]">
            </div>

            <div>
                <label class="block mb-2 font-semibold text-[#304674]">Email:</label>
                <input type="email" name="email" value="{{ $user->email }}" 
                       class="w-full px-4 py-2 rounded-lg border border-[#b2cbde] bg-[#d8e1e8] text-[#304674] focus:outline-none focus:ring-2 focus:ring-[#98bad5]">
            </div>

            <div>
                <label class="block mb-2 font-semibold text-[#304674]">Role:</label>
                <select name="role" 
                        class="w-full px-4 py-2 rounded-lg border border-[#b2cbde] bg-[#d8e1e8] text-[#304674] focus:outline-none focus:ring-2 focus:ring-[#98bad5]">
                    <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
                    <option value="member" {{ $user->role=='member'?'selected':'' }}>Member</option>
                </select>
            </div>

            <button type="submit" 
                    class="w-full py-3 bg-[#98bad5] hover:bg-[#304674] text-white font-semibold rounded-lg transition-colors">
                Update
            </button>
        </form>
    </div>
</div>
@endsection
