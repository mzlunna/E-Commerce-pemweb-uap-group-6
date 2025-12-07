<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Transaction;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Statistik dashboard
        $stats = [
            'total_users' => User::where('role', 'member')->count(),
            'total_stores' => Store::where('is_verified', true)->count(),
            'pending_stores' => Store::where('is_verified', false)->count(),
            'total_products' => Product::count(),
            'total_transactions' => Transaction::count(),
            'total_revenue' => Transaction::where('payment_status', 'paid')->sum('grand_total'),
        ];

        // 10 user terbaru
        $users = User::latest()->take(10)->get();

        // 5 store terbaru yang belum diverifikasi
        $recentStores = Store::where('is_verified', false)
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        // 10 transaksi terbaru
        $recentTransactions = Transaction::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'users', 'recentStores', 'recentTransactions'));
    }
}