<?php
namespace App\Http\Controllers\Buyer;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class BuyerCheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('buyer.cart.index')->with('error', 'Keranjang Anda kosong!');
        }
        return view('buyer.checkout.index', ['cart' => $cart]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'phone' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('buyer.cart.index')->with('error', 'Keranjang Anda kosong!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'phone' => $request->phone,
            'total_price' => $total,
            'status' => 'pending',
        ]);

        session()->forget('cart');
        return redirect()->route('buyer.orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat!');
    }
}