<?php
namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class BuyerOrderController extends Controller
{
    public function index()
    {
        // Mengambil pesanan berdasarkan buyer_id, bukan user_id
        $orders = Transaction::where('buyer_id', auth()->id()) // Ganti user_id dengan buyer_id
            ->with('details.product.images')
            ->latest()
            ->paginate(10);

        return view('buyer.orders.index', compact('orders'));
    }

    public function show($id)
    {
        // Mengambil detail pesanan berdasarkan buyer_id
        $order = Transaction::where('buyer_id', auth()->id()) // Ganti user_id dengan buyer_id
            ->with('details.product.images')
            ->findOrFail($id);

        return view('buyer.orders.show', compact('order'));
    }
}
