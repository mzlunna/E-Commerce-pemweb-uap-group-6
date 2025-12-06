<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika belum login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $userRole = $user->role;

        // Jika role cocok → lanjut
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        /**
         * FIX PENTING:
         * Jangan pakai redirect()->route() karena menyebabkan middleware dipanggil ulang → infinite loop.
         * Pakai URL langsung saja.
         */

        switch ($userRole) {
            case 'admin':
                return redirect('/admin/dashboard');
            case 'seller':
                return redirect('/seller/dashboard');
            default:
                return redirect('/buyer/dashboard');
        }
    }
}
