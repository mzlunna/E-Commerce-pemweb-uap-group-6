<?php
// ============================================
// FILE 4: app/Http/Controllers/Admin/AdminDashboardController.php
// BUAT BARU - Dashboard Admin
// ============================================

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'member')->count(),
            'total_stores' => Store::where('status', 'approved')->count(),
            'pending_stores' => Store::where('status', 'pending')->count(),
            'total_products' => Product::count(),
            'total_transactions' => Transaction::count(),
            'total_revenue' => Transaction::where('status', 'completed')->sum('total_amount'),
        ];

        $recentStores = Store::where('status', 'pending')
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        $recentTransactions = Transaction::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentStores', 'recentTransactions'));
    }
}