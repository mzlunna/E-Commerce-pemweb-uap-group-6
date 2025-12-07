@extends('layouts.admin')

@section('header', 'Store Management')

@section('content')
<div class="p-6 bg-[#d8e1e8] min-h-screen rounded-lg">

    {{-- Judul --}}
    <h2 class="text-3xl font-bold mb-6 text-[#304674]">🏬 Kelola Store</h2>

    {{-- Filter Status --}}
    <div class="mb-6 flex justify-between items-center">
        <select class="px-4 py-2 border border-[#b2cbde] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#98bad5] bg-[#d8e1e8] text-[#304674]">
            <option value="">All Status</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
        </select>
    </div>

    {{-- Tabel Store --}}
    <div class="overflow-x-auto mb-10">
        <table class="min-w-full bg-[#c6d3e3]/50 rounded-lg shadow">
            <thead class="bg-[#304674]/90 text-white">
                <tr>
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Store Name</th>
                    <th class="py-3 px-6 text-left">Owner</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-left">Products</th>
                    <th class="py-3 px-6 text-left">Created</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-[#304674]/90">
                @forelse($stores as $store)
                <tr class="border-b border-[#b2cbde] hover:bg-[#b2cbde]/50 transition">
                    <td class="py-3 px-6">{{ $store->id }}</td>
                    <td class="py-3 px-6">{{ $store->name }}</td>
                    <td class="py-3 px-6">{{ $store->user->name }}</td>
                    <td class="py-3 px-6">
                        <span class="px-2 py-1 rounded-full font-semibold
                            {{ $store->status === 'approved' ? 'bg-[#b2f2bb] text-[#1b5e20]' : ($store->status === 'pending' ? 'bg-[#b8daff] text-[#0c5460]' : 'bg-[#f5c2c7] text-[#b02a37]') }}">
                            {{ ucfirst($store->status) }}
                        </span>
                    </td>
                    <td class="py-3 px-6">{{ $store->products->count() }}</td>
                    <td class="py-3 px-6">{{ $store->created_at->format('d M Y') }}</td>
                    <td class="py-3 px-6 flex justify-center gap-2">
                        <a href="{{ route('admin.stores.show', $store->id) }}" 
                           class="px-3 py-1 bg-[#98bad5] hover:bg-[#b2cbde] text-[#304674] rounded transition">View</a>

                        @if($store->status === 'pending')
                        <form action="{{ route('admin.stores.approve', $store->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-3 py-1 bg-[#98bad5] hover:bg-[#b2cbde] text-[#304674] rounded transition">Approve</button>
                        </form>

                        <button onclick="openRejectModal({{ $store->id }}, '{{ $store->name }}')" 
                                class="px-3 py-1 bg-[#f5c2c7] hover:bg-[#f5a3a8] text-[#b02a37] rounded transition">Reject</button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-8 text-center text-[#304674]/70">No stores found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex justify-end">
        {{ $stores->links() }}
    </div>

</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-[#304674]/50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-[#c6d3e3]">
        <h3 class="text-lg font-medium text-[#304674] mb-4">Reject Store Application</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-[#304674] mb-2">Rejection Reason</label>
                <textarea name="rejection_reason" rows="4" required class="w-full px-3 py-2 border border-[#98bad5] rounded-md focus:outline-none focus:ring-2 focus:ring-[#98bad5]" placeholder="Please provide a reason..."></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-[#98bad5] text-[#304674] rounded-md hover:bg-[#b2cbde]">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-[#f5c2c7] text-[#b02a37] rounded-md hover:bg-[#f5a3a8]">Reject</button>
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
