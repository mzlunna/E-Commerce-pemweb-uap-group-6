<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $store = getSellerStore();

        $stats = [
            'total_products' => Product::where('store_id', $store->id)->count(),
            'total_orders' => Transaction::whereHas('details', function($q) use ($store) {
                $q->whereHas('product', function($q2) use ($store) {
                    $q2->where('store_id', $store->id);
                });
            })->count(),
            'pending_orders' => Transaction::where('status', 'pending')
                ->whereHas('details', function($q) use ($store) {
                    $q->whereHas('product', function($q2) use ($store) {
                        $q2->where('store_id', $store->id);
                    });
                })->count(),
            'total_revenue' => Transaction::where('status', 'completed')
                ->whereHas('details', function($q) use ($store) {
                    $q->whereHas('product', function($q2) use ($store) {
                        $q2->where('store_id', $store->id);
                    });
                })->sum('total_amount'),
        ];

        $recentOrders = Transaction::whereHas('details', function($q) use ($store) {
            $q->whereHas('product', function($q2) use ($store) {
                $q2->where('store_id', $store->id);
            });
        })->latest()->take(5)->get();

        return view('seller.dashboard', compact('stats', 'recentOrders', 'store'));
    }
}