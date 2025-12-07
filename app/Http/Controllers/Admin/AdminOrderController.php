<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of all orders with filters.
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['store', 'user'])->latest();

        // Filter by order status
        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Search by order code or store name
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('code', 'like', '%' . $request->search . '%')
                  ->orWhereHas('store', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $orders = $query->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order with all details.
     */
    public function show($id)
    {
        $order = Transaction::findOrFail($id);
        
        $order->load([
            'store', 
            'user', 
            'transactionDetails.product.productImages'
        ]);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Verify payment manually.
     */
    public function verifyPayment($id)
    {
        $order = Transaction::findOrFail($id);

        if ($order->payment_status === 'paid') {
            return back()->with('error', 'Pembayaran pesanan ini sudah diverifikasi.');
        }

        DB::transaction(function () use ($order) {
            $order->update([
                'payment_status' => 'paid',
                'order_status' => 'processing',
            ]);
        });

        return back()->with('success', 'Pembayaran berhasil diverifikasi. Pesanan kini diproses.');
    }
}