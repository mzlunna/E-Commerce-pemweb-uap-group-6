<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SellerBalanceController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        // Ambil saldo toko dari relasi balance()
        $balanceModel = $store->balance()->first();

        // Jika belum punya record saldo, buat
        if (!$balanceModel) {
            $store->balance()->create(['balance' => 0]);
            $balanceModel = $store->balance;
        }

        // Format saldo untuk Blade
        $balance = (object) [
            'available' => $balanceModel->balance,
            'pending'   => $store->withdrawals()
                                ->where('status', 'pending')
                                ->sum('amount'),
        ];

        // Riwayat transaksi saldo
        $transactions = $balanceModel->histories()->latest()->get();

        return view('seller.balance.index', compact('balance', 'transactions'));
    }
}
