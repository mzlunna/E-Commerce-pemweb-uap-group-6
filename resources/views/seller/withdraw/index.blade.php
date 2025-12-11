@extends('layouts.seller')
@section('title','Withdraw')

@section('content')

<div class="page-header">
    <h1>Tarik Saldo</h1>
    <p class="text-muted">
        Saldo tersedia: 
        <strong>Rp {{ number_format($availableBalance, 0, ',', '.') }}</strong>
    </p>
</div>

<div class="card">
    <div class="card-body">

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('seller.withdraw.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Jumlah Penarikan</label>
                <input type="number" name="amount" class="form-input"
                       min="50000" max="{{ $availableBalance }}" required>
            </div>

            <div class="form-group">
                <label>Nama Bank</label>
                <input type="text" name="bank_name" class="form-input" required>
            </div>

            <div class="form-group">
                <label>Nama Rekening</label>
                <input type="text" name="account_name" class="form-input" required>
            </div>

            <div class="form-group">
                <label>Nomor Rekening</label>
                <input type="text" name="account_number" class="form-input" required>
            </div>

            <div class="form-actions">
                <button class="btn btn-primary">Ajukan Penarikan</button>
                <a href="{{ route('seller.withdraw.history') }}" class="btn btn-secondary">
                    Riwayat
                </a>
            </div>

        </form>

    </div>
</div>

@endsection
