<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\StoreBalance;
use App\Models\StoreBalanceHistory;
use Illuminate\Http\Request;

class SellerBalanceController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        // Ambil saldo toko dari tabel store_balances
        $balance = $store->balance;

        $currentBalance = $balance->balance ?? 0;

        // Saldo pending = semua penarikan yang statusnya "pending"
        $pendingBalance = $store->withdrawals()
            ->where('status', 'pending')
            ->sum('amount');

        // Riwayat history saldo
        $transactions = $balance
            ? $balance->histories()->latest()->get()
            : collect([]);

        return view('seller.balance.index', compact(
            'currentBalance',
            'pendingBalance',
            'transactions'
        ));
    }
}
