<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SellerOrderController extends Controller
{
    public function index()
    {
        $storeId = auth()->user()->store->id;

        $orders = Transaction::where('store_id', $storeId)
            ->with(['buyer', 'details.product'])
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

        $storeId = auth()->user()->store->id;

        // ambil order
        $order = Transaction::where('store_id', $storeId)
            ->with(['details.product', 'store.balance'])
            ->findOrFail($id);

        // set shipping (seller)
        $order->shipping_type = $request->shipping_type;
        $order->tracking_number = $request->tracking_number;

        // ---------------------------
        //  UPDATE STATUS BUYER
        // ---------------------------
        if ($request->shipping_type === 'pending') {
            $order->payment_status = 'paid'; // pembeli lihat "Diproses"
        }

        if ($request->shipping_type === 'shipped') {
            $order->payment_status = 'shipped'; // pembeli lihat "Dikirim"
        }

        if ($request->shipping_type === 'delivered') {
            $order->payment_status = 'completed'; // pembeli lihat "Selesai"

            // Hitung uang yang masuk ke seller
            $sellerTotal = $order->details->sum(fn($d) => $d->subtotal);

            // Ambil atau buat saldo toko
            $balance = $order->store->balance()->firstOrCreate(
                ['store_id' => $order->store_id],
                ['balance' => 0]
            );

            // Tambah saldo
            $balance->increment('balance', $sellerTotal);

            // Simpan riwayat saldo
            $balance->histories()->create([
                'type' => 'income',
                'reference_id' => $order->id,
                'reference_type' => 'transaction',
                'amount' => $sellerTotal,
                'remarks' => 'Pemasukan dari pesanan #' . $order->id,
            ]);
        }

        $order->save();

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
