<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdrawal;

class SellerWithdrawController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        // Ambil saldo dari tabel store_balances
        $balance = $store->balance; 
        $availableBalance = $balance ? $balance->balance : 0;

        return view('seller.withdraw.index', compact('store', 'availableBalance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount'          => 'required|numeric|min:1000',
            'bank_name'       => 'required|string',
            'account_name'    => 'required|string',
            'account_number'  => 'required|string',
        ]);

        $store = auth()->user()->store;
        $balance = $store->balance;

        if (!$balance) {
            return back()->with('error', 'Saldo belum tersedia.');
        }

        // Pastikan saldo cukup
        if ($request->amount > $balance->balance) {
            return back()->with('error', 'Saldo tidak mencukupi.');
        }

        // Simpan withdraw
        Withdrawal::create([
            'store_balance_id'   => $balance->id,
            'amount'             => $request->amount,
            'bank_name'          => $request->bank_name,
            'bank_account_name'  => $request->account_name,
            'bank_account_number'=> $request->account_number,
            'status'             => 'pending',
        ]);

        return redirect()->route('seller.withdraw.history')
            ->with('success', 'Permintaan penarikan berhasil diajukan.');
    }

    public function history()
    {
        $store = auth()->user()->store;

        $withdrawals = $store->balance
            ->withdrawals()
            ->latest()
            ->get();

        return view('seller.withdraw.history', compact('withdrawals'));
    }
}
