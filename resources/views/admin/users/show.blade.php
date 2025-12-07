@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Detail User</h1>

    <p><strong>Nama:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Role:</strong> {{ $user->role }}</p>

    @if($user->store)
        <hr class="my-4">
        <h2 class="text-xl font-semibold">Toko</h2>
        <p><strong>Nama Toko:</strong> {{ $user->store->name }}</p>
        <p><strong>Status Verifikasi:</strong>
            {{ $user->store->is_verified ? 'Terverifikasi' : 'Belum Diverifikasi' }}
        </p>
        <p><strong>Total Produk:</strong> {{ $user->store->products_count }}</p>
    @endif

    <a href="{{ route('admin.users.index') }}" class="mt-4 inline-block px-4 py-2 bg-gray-700 text-white rounded">
        Kembali
    </a>
</div>
@endsection
