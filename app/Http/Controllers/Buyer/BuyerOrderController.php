<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class BuyerOrderController extends Controller
{
    public function index()
    {
        $buyer = auth()->user()->buyer;
        
        if (!$buyer) {
            return redirect()->route('buyer.dashboard')
                ->with('error', 'Buyer profile not found');
        }

        // Fetch orders with related transaction details, product images, and store
        $orders = Transaction::with(['transactionDetails.product.images', 'store'])
            ->where('buyer_id', $buyer->id)
            ->latest()
            ->paginate(10); // Paginate results

        return view('buyer.orders.index', compact('orders')); // Pass orders to the view
    }

    public function show($id)
    {
        $buyer = auth()->user()->buyer;
        
        $order = Transaction::with(['transactionDetails.product.images', 'store'])
            ->where('buyer_id', $buyer->id)
            ->findOrFail($id);

        return view('buyer.orders.show', compact('order'));
    }

    public function payment(Request $request, $id)
    {
        $buyer = auth()->user()->buyer;
        
        $order = Transaction::where('buyer_id', $buyer->id)
            ->where('payment_status', 'unpaid')
            ->findOrFail($id);

        // Simulate payment by updating the status
        $order->update([
            'payment_status' => 'paid',
        ]);

        return redirect()->route('buyer.orders.show', $order->id)
            ->with('success', 'Pembayaran berhasil! Pesanan sedang diproses.');
    }

    public function cancel($id)
    {
        $buyer = auth()->user()->buyer;
        
        $order = Transaction::where('buyer_id', $buyer->id)
            ->where('payment_status', 'unpaid')
            ->findOrFail($id);

        // Return stock to the product
        foreach ($order->transactionDetails as $detail) {
            $detail->product->increment('stock', $detail->qty);
        }

        $order->update([
            'payment_status' => 'cancelled',
        ]);

        return redirect()->route('buyer.orders.index')
            ->with('success', 'Pesanan berhasil dibatalkan');
    }

    public function confirmReceived($id)
    {
        $buyer = auth()->user()->buyer;
        
        $order = Transaction::where('buyer_id', $buyer->id)
            ->where('payment_status', 'shipped')
            ->findOrFail($id);

        $order->update([
            'payment_status' => 'completed',
        ]);

        return redirect()->route('buyer.orders.show', $order->id)
            ->with('success', 'Pesanan dikonfirmasi diterima. Silakan beri review!');
    }
}
