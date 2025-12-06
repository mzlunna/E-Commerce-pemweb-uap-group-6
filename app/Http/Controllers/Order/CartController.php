<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index() {
        $cart = Cart::where('user_id', auth()->id())->get();
        return view('cart.index', compact('cart'));
    }

    public function update(Request $r, $id) {
        $item = Cart::findOrFail($id);
        $item->qty = $r->qty;
        $item->save();
        return back();
    }

    public function destroy($id) {
        Cart::findOrFail($id)->delete();
        return back();
    }
}