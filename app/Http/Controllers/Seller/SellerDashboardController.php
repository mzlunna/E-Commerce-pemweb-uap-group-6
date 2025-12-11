<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use App\Models\Transaction;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $store = Store::where('user_id', auth()->id())
            ->where('is_verified', 1)
            ->first();

        if (!$store) {
            return redirect()->route('buyer.store.create')
                ->with('error', 'Toko belum tersedia atau belum diverifikasi.');
        }

        // Statistik dashboard
        $stats = [
            'total_products' => Product::where('store_id', $store->id)->count(),

            'pending_orders' => Transaction::where('payment_status', 'unpaid')
                ->whereHas('transactionDetails', function($q) use ($store) {
                    $q->whereHas('product', function($q2) use ($store) {
                        $q2->where('store_id', $store->id);
                    });
                })
                ->count(),

            'total_orders' => Transaction::whereHas('transactionDetails', function($q) use ($store) {
                $q->whereHas('product', function($q2) use ($store) {
                    $q2->where('store_id', $store->id);
                });
            })
            ->count(),

            'total_revenue' => Transaction::where('payment_status', 'paid')
                ->whereHas('transactionDetails', function($q) use ($store) {
                    $q->whereHas('product', function($q2) use ($store) {
                        $q2->where('store_id', $store->id);
                    });
                })
                ->sum('grand_total'),
        ];

        // Order terbaru
        $recentOrders = Transaction::whereHas('transactionDetails', function($q) use ($store) {
            $q->whereHas('product', function($q2) use ($store) {
                $q2->where('store_id', $store->id);
            });
        })
        ->with('user')
        ->latest()
        ->take(5)
        ->get();

        return view('seller.dashboard', compact('store', 'stats', 'recentOrders'));
    }
}
