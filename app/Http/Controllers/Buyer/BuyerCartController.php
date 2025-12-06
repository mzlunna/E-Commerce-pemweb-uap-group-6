<?php
// ============================================
// BuyerCartController.php
// ============================================

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class BuyerCartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        return view('buyer.cart', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|numeric|min:1',
        ]);

        $product = Product::with('store')->findOrFail($request->product_id);
        
        // Check stock
        if ($product->stock < $request->qty) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        $cart = session()->get('cart', []);

        // Check if product already in cart
        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] += $request->qty;
        } else {
            $cart[$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'qty' => $request->qty,
                'image' => $product->images->first()->image_url ?? null,
                'store_id' => $product->store_id,
                'store_name' => $product->store->name,
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|numeric|min:1',
        ]);

        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['qty'] = $request->qty;
            session()->put('cart', $cart);
            return back()->with('success', 'Keranjang berhasil diperbarui!');
        }

        return back()->with('error', 'Produk tidak ditemukan di keranjang!');
    }

    public function destroy($id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return back()->with('success', 'Produk berhasil dihapus dari keranjang!');
        }

        return back()->with('error', 'Produk tidak ditemukan di keranjang!');
    }
}