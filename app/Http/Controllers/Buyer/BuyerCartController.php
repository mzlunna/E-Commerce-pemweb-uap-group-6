<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class BuyerCartController extends Controller
{
    public function index()
    {
        $buyer = auth()->user()->buyer;

        if (!$buyer) {
            return redirect()->route('buyer.dashboard')
                ->with('error', 'Buyer profile not found');
        }

        // FIX: Hapus storeCategory → ganti dengan relasi yang valid
        $cartItems = CartItem::with([
            'product.images',
            'product.category',
            'product.store'
        ])
        ->where('buyer_id', $buyer->id)
        ->get();

        return view('buyer.cart.index', compact('cartItems'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $buyer = auth()->user()->buyer;

        if (!$buyer) {
            return response()->json([
                'success' => false,
                'message' => 'Buyer profile not found'
            ], 404);
        }

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi'
            ], 400);
        }

        $cartItem = CartItem::where('buyer_id', $buyer->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;

            if ($newQuantity > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Total quantity melebihi stok tersedia'
                ], 400);
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            CartItem::create([
                'buyer_id' => $buyer->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk ditambahkan ke keranjang'
        ]);
    }

    public function update(Request $request, $id)
    {
        $cartItem = CartItem::findOrFail($id);
        $product = $cartItem->product;

        if ($request->action === 'increase') {
            if ($cartItem->quantity >= $product->stock) {
                return back()->with('error', 'Stok tidak mencukupi');
            }
            $cartItem->increment('quantity');

        } elseif ($request->action === 'decrease') {
            if ($cartItem->quantity > 1) {
                $cartItem->decrement('quantity');
            } else {
                return back()->with('error', 'Minimal quantity adalah 1');
            }
        }

        return back()->with('success', 'Keranjang diperbarui');
    }

    public function delete($id)
    {
        CartItem::findOrFail($id)->delete();
        return back()->with('success', 'Produk dihapus dari keranjang');
    }
}
