@extends('layouts.admin')

@section('header', 'Store Management')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">All Stores</h2>
        <div class="flex items-center space-x-3">
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Store Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Products</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($stores as $store)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $store->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded bg-gray-200 flex items-center justify-center mr-3">
                                @if($store->logo)
                                    <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}" class="w-full h-full object-cover rounded">
                                @else
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $store->name }}</div>
                                <div class="text-xs text-gray-500">{{ Str::limit($store->description, 30) }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $store->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $store->status === 'approved' ? 'bg-green-100 text-green-800' : ($store->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($store->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $store->products->count() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $store->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.stores.show', $store->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
                            
                            @if($store->status === 'pending')
                            <form action="{{ route('admin.stores.approve', $store->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-900">Approve</button>
                            </form>
                            
                            <button onclick="openRejectModal({{ $store->id }}, '{{ $store->name }}')" class="text-red-600 hover:text-red-900">Reject</button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">No stores found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $stores->links() }}
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Reject Store Application</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Rejection Reason</label>
                <textarea name="rejection_reason" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Please provide a reason..."></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Reject</button>
            </div>
        </form>
    </div>
</div>

<script>
function openRejectModal(storeId, storeName) {
    document.getElementById('rejectModal').classList.remove('hidden');
    document.getElementById('rejectForm').action = `/admin/stores/${storeId}/reject`;
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
@endsection