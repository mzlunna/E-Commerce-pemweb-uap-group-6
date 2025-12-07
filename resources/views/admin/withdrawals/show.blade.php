@extends('layouts.admin')

@section('header', 'Withdrawal Details')

@section('content')
<div class="p-6 bg-[#d8e1e8] min-h-screen">

    {{-- Judul --}}
    <h2 class="text-3xl font-bold mb-6 text-[#304674]">💰 Detail Penarikan Saldo</h2>

    <div class="bg-[#c6d3e3]/50 p-6 rounded-lg shadow mb-6">
        <h3 class="text-xl font-semibold mb-4 text-[#304674]">Informasi Penarikan</h3>
        <div class="space-y-2 text-[#304674]">
            <p><strong>ID:</strong> {{ $withdrawal->id }}</p>
            <p><strong>Store:</strong> {{ $withdrawal->storeBalance->store->name }}</p>
            <p><strong>Owner:</strong> {{ $withdrawal->storeBalance->store->user->name }}</p>
            <p><strong>Amount:</strong> Rp {{ number_format($withdrawal->amount,0,',','.') }}</p>
            <p><strong>Bank:</strong> {{ $withdrawal->bank_name }}</p>
            <p><strong>Account Name:</strong> {{ $withdrawal->bank_account_name }}</p>
            <p><strong>Account Number:</strong> {{ $withdrawal->bank_account_number }}</p>
            <p><strong>Status:</strong> 
                <span class="px-2 py-1 rounded-full text-xs font-semibold
                    {{ $withdrawal->status === 'approved' ? 'bg-[#b2f2bb] text-[#1b5e20]' : ($withdrawal->status === 'pending' ? 'bg-[#fff3bf] text-[#856404]' : 'bg-[#f8d7da] text-[#842029]') }}">
                    {{ ucfirst($withdrawal->status) }}
                </span>
            </p>
        </div>

        @if($withdrawal->status === 'pending')
        <div class="mt-6 flex gap-3">
            <form action="{{ route('admin.withdrawals.approve', $withdrawal->id) }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-[#98bad5] hover:bg-[#b2cbde] text-[#304674] rounded transition">Approve</button>
            </form>
            <form action="{{ route('admin.withdrawals.reject', $withdrawal->id) }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-[#f08080] hover:bg-[#f5a3a8] text-white rounded transition">Reject</button>
            </form>
        </div>
        @endif

    </div>

    <a href="{{ route('admin.withdrawals.index') }}" class="px-4 py-2 bg-[#c6d3e3] hover:bg-[#b2cbde] text-[#304674] rounded transition">← Back to Withdrawals</a>

</div>
@endsection
