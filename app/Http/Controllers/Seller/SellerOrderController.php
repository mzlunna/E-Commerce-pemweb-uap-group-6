<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\StoreBalance;
use App\Models\StoreBalanceHistory;
use Illuminate\Http\Request;

class SellerOrderController extends Controller
{
    public function index()
    {
        $storeId = auth()->user()->store->id;

        $orders = Transaction::where('store_id', $storeId)
            ->with('buyer')
            ->latest()
            ->get();

        return view('seller.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $storeId = auth()->user()->store->id;

        $order = Transaction::where('store_id', $storeId)
            ->with(['buyer', 'details.product'])
            ->findOrFail($id);

        return view('seller.orders.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'shipping_type' => 'required|in:pending,shipped,delivered',
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $store = auth()->user()->store;
        $storeId = $store->id;

        $order = Transaction::where('store_id', $storeId)
            ->findOrFail($id);

        // Update status & resi
        $order->shipping_type = $request->shipping_type;
        $order->tracking_number = $request->tracking_number;

        // Jika pesanan selesai
        if ($request->shipping_type === 'delivered') {

            // Tandai sudah dibayar
            $order->payment_status = 'paid';

            // ===============================
            // MASUKKAN UANG KE STORE BALANCE
            // ===============================

            // 1. Ambil saldo toko
            $balance = $store->balance;

            // Jika balance record belum ada
            if (!$balance) {
                $balance = $store->balance()->create([
                    'balance' => 0
                ]);
            }

            // 2. Tambahkan uang
            $balance->balance += $order->grand_total;
            $balance->save();

            // 3. Catat history
            $balance->histories()->create([
                'type' => 'credit',
                'reference_id' => $order->id,
                'reference_type' => 'transaction',
                'amount' => $order->grand_total,
                'remarks' => 'Pemasukan dari pesanan #' . $order->id,
            ]);
        }

        $order->save();

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

}
