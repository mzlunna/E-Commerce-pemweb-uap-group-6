<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Store;

class SellerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $store = Store::where('user_id', auth()->id())
            ->where('status', 'approved')
            ->first();

        if (!$store) {
            return redirect()->route('buyer.home')
                ->with('error', 'Anda belum memiliki toko yang disetujui.');
        }

        return $next($request);
    }
}