<?php

// ============================================
// FILE 1: app/Http/Controllers/Auth/AuthenticatedSessionController.php
// EDIT METHOD store() - Tambahkan redirect by role
// ============================================

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

<<<<<<< HEAD
        $user = Auth::user();

        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->role === 'seller') {
            return redirect()->intended(route('seller.dashboard'));
        } else { // buyer
            return redirect()->intended(route('home'));
        }
    } 
=======
        // ✅ REDIRECT BY ROLE
        $user = auth()->user();
        
        // Admin
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }
        
        // Seller (member dengan toko approved)
        $store = \App\Models\Store::where('user_id', $user->id)
            ->where('status', 'approved')
            ->first();
        
        if ($store) {
            return redirect()->intended(route('seller.dashboard'));
        }
        
        // Default: Buyer
        return redirect()->intended(route('buyer.home'));
    }
>>>>>>> viaa

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
<<<<<<< HEAD

        return redirect('/login');
=======
        return redirect('/');
>>>>>>> viaa
    }
}