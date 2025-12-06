<?php
namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class BuyerOrderController extends Controller
{
    public function index()
    {
        $orders = Transaction::where('user_id', auth()->id())
            ->with('details.product.images')
            ->latest()
            ->paginate(10);

        return view('buyer.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Transaction::where('user_id', auth()->id())
            ->with('details.product.images')
            ->findOrFail($id);

        return view('buyer.orders.show', compact('order'));
    }
}