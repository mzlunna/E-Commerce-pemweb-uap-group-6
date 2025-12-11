@extends('layouts.admin')

@section('header', 'Edit Store')

@section('content')
<div class="p-6 bg-[#d8e1e8] min-h-screen rounded-lg">

    <h2 class="text-3xl font-bold mb-6 text-[#304674]">✏️ Edit Store</h2>

    <form action="{{ route('admin.stores.update', $store->id) }}" method="POST" class="bg-[#c6d3e3]/50 p-6 rounded-xl shadow-lg max-w-2xl" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Owner --}}
        <div class="mb-4">
            <label class="block text-[#304674] mb-2 font-semibold">Pemilik Store</label>
            <select name="user_id" required class="w-full p-2 border border-[#98bad5] rounded-lg">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $store->user_id ? 'selected' : '' }}>
                        {{ $user->name }} (ID: {{ $user->id }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Name --}}
        <div class="mb-4">
            <label class="block text-[#304674] mb-2 font-semibold">Nama Toko</label>
            <input type="text" name="name" value="{{ $store->name }}" required class="w-full p-2 border border-[#98bad5] rounded-lg">
        </div>

        {{-- Phone --}}
        <div class="mb-4">
            <label class="block text-[#304674] mb-2 font-semibold">Nomor Telepon</label>
            <input type="text" name="phone" value="{{ $store->phone }}" class="w-full p-2 border border-[#98bad5] rounded-lg">
        </div>

        {{-- City --}}
        <div class="mb-4">
            <label class="block text-[#304674] mb-2 font-semibold">Kota</label>
            <input type="text" name="city" value="{{ $store->city }}" class="w-full p-2 border border-[#98bad5] rounded-lg">
        </div>

        {{-- Address ID --}}
        <div class="mb-4">
            <label class="block text-[#304674] mb-2 font-semibold">Address ID</label>
            <input type="text" name="address_id" value="{{ $store->address_id }}" class="w-full p-2 border border-[#98bad5] rounded-lg">
        </div>

        {{-- Address --}}
        <div class="mb-4">
            <label class="block text-[#304674] mb-2 font-semibold">Alamat</label>
            <textarea name="address" rows="3" class="w-full p-2 border border-[#98bad5] rounded-lg">{{ $store->address }}</textarea>
        </div>

        {{-- About --}}
        <div class="mb-6">
            <label class="block text-[#304674] mb-2 font-semibold">Deskripsi Toko</label>
            <textarea name="about" rows="3" class="w-full p-2 border border-[#98bad5] rounded-lg">{{ $store->about }}</textarea>
        </div>

        {{-- Logo --}}
        <div class="mb-6">
            <label class="block text-[#304674] mb-2 font-semibold">Logo Toko (Opsional)</label>
            <input type="file" name="logo" class="w-full p-2 border border-[#98bad5] rounded-lg bg-white">
        </div>

        {{-- Status --}}
        <div class="mb-6">
            <label class="block text-[#304674] mb-2 font-semibold">Status Toko</label>
            <select name="is_verified" class="w-full p-2 border border-[#98bad5] rounded-lg">
                <option value="0" {{ !$store->is_verified && !$store->deleted_at ? 'selected' : '' }}>Pending</option>
                <option value="1" {{ $store->is_verified ? 'selected' : '' }}>Terverifikasi</option>
                <option value="deleted" {{ $store->deleted_at ? 'selected' : '' }}>Ditolak (Soft Delete)</option>
            </select>
        </div>

        <button class="px-4 py-2 bg-[#98bad5] hover:bg-[#b2cbde] text-[#304674] font-semibold rounded-lg">
            Update
        </button>
    </form>

</div>
<<<<<<< HEAD
@endsection
=======
@endsection
>>>>>>> origin/main
