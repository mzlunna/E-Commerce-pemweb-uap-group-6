<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_stores' => Store::where('status', 'approved')->count(),
            'pending_stores' => Store::where('status', 'pending')->count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Transaction::where('status', 'completed')->sum('total_amount'),
        ];

        $recent_orders = Order::with(['user', 'store'])
            ->latest()
            ->take(5)
            ->get();

        $pending_stores = Store::where('status', 'pending')
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'pending_stores'));
    }
}