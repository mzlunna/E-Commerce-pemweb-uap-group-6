<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = auth()->user();
        
        // Admin
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }
        
        // Seller (member dengan toko verified)
        $store = \App\Models\Store::where('user_id', $user->id)
            ->where('is_verified', 1)
            ->first();
        
        if ($store) {
            return redirect()->intended(route('seller.dashboard'));
        }
        
        // Default: Buyer
        return redirect()->intended(route('buyer.dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}