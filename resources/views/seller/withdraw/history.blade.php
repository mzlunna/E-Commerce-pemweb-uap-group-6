@extends('layouts.seller')
@section('title','Withdraw History')

@section('content')

<div class="page-header page-header-actions">
    <h1>Riwayat Penarikan Saldo</h1>
</div>

<div class="card">
    <div class="card-body">

        @if($withdrawals->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Jumlah</th>
                    <th>Metode</th>
                    <th>Nomor Tujuan</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>

            <tbody>
                @foreach($withdrawals as $w)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>Rp {{ number_format($w->amount, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($w->method) }}</td>
                    <td>{{ $w->account_number }}</td>

                    <td>
                        <span class="status-badge
                            {{ $w->status == 'completed' ? 'success' : ($w->status == 'pending' ? 'warning' : 'danger') }}">
                            {{ ucfirst($w->status) }}
                        </span>
                    </td>

                    <td>{{ $w->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @else
        <div class="empty-state">
            <div class="empty-icon">💸</div>
            <h3 class="empty-title">Belum ada riwayat withdraw</h3>
        </div>
        @endif

    </div>
</div>

@endsection
