<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index() {
        $cart = Cart::where('user_id', auth()->id())->get();
        return view('checkout.index', compact('cart'));
    }

    public function store(Request $r) {
        Order::create([
            'user_id' => auth()->id(),
            'total' => $r->total,
            'status' => 'waiting',
        ]);

        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('buyer.myOrders');
    }
}