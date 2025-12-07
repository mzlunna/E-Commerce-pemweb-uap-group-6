<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class BuyerCartController extends Controller
{
    public function index()
    {
        // Logika untuk menampilkan produk di keranjang (contoh: menggunakan session)
        $cart = session()->get('cart', []);
        
        return view('buyer.cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        // Menambahkan produk ke keranjang
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);
        
        // Jika produk sudah ada di keranjang
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }
        
        // Simpan ke session
        session()->put('cart', $cart);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    public function update(Request $request, $id)
    {
        // Update jumlah produk dalam keranjang
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->qty;
            session()->put('cart', $cart);
            return back()->with('success', 'Keranjang berhasil diupdate');
        }

        return back()->with('error', 'Produk tidak ditemukan di keranjang');
    }

    public function destroy($id)
    {
        // Hapus produk dari keranjang
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return back()->with('success', 'Produk berhasil dihapus dari keranjang');
        }

        return back()->with('error', 'Produk tidak ditemukan di keranjang');
    }
}
