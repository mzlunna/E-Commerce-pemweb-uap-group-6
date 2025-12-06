@extends('layouts.admin')

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
