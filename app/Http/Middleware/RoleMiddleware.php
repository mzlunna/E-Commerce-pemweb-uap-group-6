<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        /**
         * 1. ADMIN → boleh akses admin route
         */
        if (in_array('admin', $roles)) {
            if ($user->role === 'admin') {
                return $next($request);
            }

            abort(403, 'Unauthorized action (admin only).');
        }

        /**
         * 2. MEMBER (BUYER) → default member akses
         */
        if (in_array('member', $roles)) {
            if ($user->role === 'member') {
                return $next($request);
            }

            abort(403, 'Unauthorized action (member only).');
        }

        /**
         * 3. SELLER → role member + punya toko verified
         */
        if (in_array('seller', $roles)) {

            if ($user->role !== 'member') {
                abort(403, 'Unauthorized action (seller must be a member).');
            }

            $store = \App\Models\Store::where('user_id', $user->id)
                ->where('is_verified', 1)
                ->first();

            if ($store) {
                return $next($request);
            }

            return redirect()->route('buyer.dashboard')
                ->with('error', 'Toko Anda belum terverifikasi.');
        }

        abort(403, 'Unauthorized action.');
    }
}
