@extends('layouts.seller')
@section('title','Balance')

@section('content')

<div class="page-header">
    <h1>Saldo Penjual</h1>
    <p>Berikut adalah saldo saat ini dan riwayat transaksi Anda.</p>
</div>

<div class="stats-grid">

    <div class="stat-card success">
        <div class="stat-header">
            <span class="stat-label">Saldo Tersedia</span>
            <div class="stat-icon success">💰</div>
        </div>

        <div class="stat-value">
            {{ 'Rp ' . number_format($balance->available ?? 0, 0, ',', '.') }}
        </div>
    </div>

    <div class="stat-card warning">
        <div class="stat-header">
            <span class="stat-label">Saldo Pending</span>
            <div class="stat-icon warning">⏳</div>
        </div>

        <div class="stat-value">
            {{ 'Rp ' . number_format($balance->pending ?? 0, 0, ',', '.') }}
        </div>
    </div>

</div>

<div class="card mt-4">
    <div class="card-header">
        <h2 class="card-title">Riwayat Transaksi</h2>
    </div>

    <div class="card-body">

        @if(isset($transactions) && $transactions->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Deskripsi</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>

            <tbody>
                @foreach($transactions as $t)
                <tr>
                    <td>#{{ $t->id }}</td>
                    <td>{{ $t->description }}</td>
                    <td>{{ 'Rp ' . number_format($t->amount, 0, ',', '.') }}</td>

                    <td>
                        <span class="status-badge 
                            {{ $t->status == 'completed' ? 'success' : 'warning' }}">
                            {{ ucfirst($t->status) }}
                        </span>
                    </td>

                    <td>{{ $t->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @else
        <div class="empty-state">
            <div class="empty-icon">💼</div>
            <h3 class="empty-title">Belum ada transaksi</h3>
        </div>
        @endif

    </div>
</div>

@endsection
