@extends('layouts.admin')

@section('header', 'Withdrawal Requests')

@section('content')
<div class="p-6 bg-[#d8e1e8] min-h-screen">

    {{-- Judul --}}
    <h2 class="text-3xl font-bold mb-6 text-[#304674]">💰 Kelola Penarikan Saldo</h2>

    {{-- Tabel Withdrawal --}}
    <div class="overflow-x-auto mb-10">
        <table class="min-w-full bg-[#c6d3e3]/50 rounded-lg shadow">
            <thead class="bg-[#304674]/90 text-white">
                <tr>
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Store</th>
                    <th class="py-3 px-6 text-left">Amount</th>
                    <th class="py-3 px-6 text-left">Bank</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-[#304674]/90">
                @forelse($withdrawals as $withdrawal)
                <tr class="border-b border-[#b2cbde] hover:bg-[#b2cbde]/50 transition">
                    <td class="py-3 px-6">{{ $withdrawal->id }}</td>
                    <td class="py-3 px-6">{{ $withdrawal->storeBalance->store->name }}</td>
                    <td class="py-3 px-6">Rp {{ number_format($withdrawal->amount,0,',','.') }}</td>
                    <td class="py-3 px-6">{{ $withdrawal->bank_name }} ({{ $withdrawal->bank_account_number }})</td>
                    <td class="py-3 px-6">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            {{ $withdrawal->status === 'approved' ? 'bg-[#b2f2bb] text-[#1b5e20]' : ($withdrawal->status === 'pending' ? 'bg-[#fff3bf] text-[#856404]' : 'bg-[#f8d7da] text-[#842029]') }}">
                            {{ ucfirst($withdrawal->status) }}
                        </span>
                    </td>
                    <td class="py-3 px-6 flex justify-center gap-2">
                        <a href="{{ route('admin.withdrawals.show', $withdrawal->id) }}" 
                           class="px-3 py-1 bg-[#98bad5] hover:bg-[#b2cbde] text-[#304674] rounded transition">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-[#304674]/70">No withdrawals found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $withdrawals->links() }}
</div>
@endsection
