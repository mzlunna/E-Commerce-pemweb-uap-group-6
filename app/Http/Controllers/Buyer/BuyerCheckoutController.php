<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BuyerCheckoutController extends Controller
{
    public function index()
    {
        $buyer = auth()->user()->buyer;

        if (!$buyer) {
            return redirect()->route('buyer.dashboard')->with('error', 'Buyer profile not found');
        }

        $items = CartItem::with(['product.images', 'product.store'])
            ->where('buyer_id', $buyer->id)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('buyer.cart.index')->with('error', 'Keranjang kosong');
        }

        return view('buyer.checkout.index', compact('items'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'receiver_name' => 'required|string|max:255',
            'receiver_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'shipping_method' => 'required|in:regular,express,same-day',
            'payment_method' => 'required|in:transfer,ewallet,cod',
        ]);

        $buyer = auth()->user()->buyer;
        $cartItems = CartItem::with('product')->where('buyer_id', $buyer->id)->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang kosong');
        }

        // Ongkir
        $shippingCosts = [
            'regular' => 15000,
            'express' => 25000,
            'same-day' => 35000,
        ];

        $shippingCost = $shippingCosts[$request->shipping_method];

        // Group by store
        $itemsByStore = $cartItems->groupBy('product.store_id');

        DB::beginTransaction();
        try {
            foreach ($itemsByStore as $storeId => $items) {

                $subtotal = $items->sum(fn($item) => $item->product->price * $item->quantity);
                $tax = $subtotal * 0.11;
                $grandTotal = $subtotal + $tax + $shippingCost;

                // INSERT TRANSACTION (FIXED)
                $transaction = Transaction::create([
                    'code'          => 'TRX-' . strtoupper(Str::random(10)),
                    'buyer_id'      => $buyer->id,
                    'store_id'      => $storeId,
                    'receiver_name' => $request->receiver_name,
                    'receiver_phone'=> $request->receiver_phone,
                    'address'       => $request->shipping_address,

                    // 🔥 FIX WAJIB — tabel butuh address_id
                    'address_id'    => Str::uuid(),

                    'city'          => $request->city,
                    'postal_code'   => $request->postal_code,

                    // 🔥 FIX WAJIB — tabel butuh shipping
                    'shipping'      => $request->shipping_method,

                    'shipping_type' => $request->shipping_method,
                    'shipping_cost' => $shippingCost,
                    'payment_method'=> $request->payment_method,
                    'tax'           => $tax,
                    'grand_total'   => $grandTotal,
                    'payment_status'=> 'unpaid',
                ]);

                // INSERT DETAIL
                foreach ($items as $item) {
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id'     => $item->product_id,
                        'qty'            => $item->quantity,
                        'subtotal'       => $item->product->price * $item->quantity,
                    ]);

                    // Kurangi stok
                    $item->product->decrement('stock', $item->quantity);

                    // Hapus item dari cart
                    $item->delete();
                }
            }

            DB::commit();
            return redirect()->route('buyer.orders.index')
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
