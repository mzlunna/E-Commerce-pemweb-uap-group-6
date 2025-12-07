<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Buyer\BuyerDashboardController;
use App\Http\Controllers\Buyer\BuyerProductController;
use App\Http\Controllers\Buyer\BuyerCartController;
use App\Http\Controllers\Buyer\BuyerCheckoutController;
use App\Http\Controllers\Buyer\BuyerOrderController;
use App\Http\Controllers\Buyer\BuyerProfileController;
use App\Http\Controllers\Buyer\BuyerStoreController;
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerOrderController;
use App\Http\Controllers\Seller\SellerBalanceController;
use App\Http\Controllers\Seller\SellerWithdrawController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminStoreApprovalController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminProductController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        // Admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        // Seller (member dengan toko verified)
        $store = \App\Models\Store::where('user_id', $user->id)
            ->where('is_verified', 1)
            ->first();
        
        if ($store) {
            return redirect()->route('seller.dashboard');
        }
        
        // Default: Buyer
        return redirect()->route('buyer.dashboard');
    })->name('dashboard');

    // ============================================
    // BUYER ROUTES
    // ============================================
    Route::prefix('buyer')->name('buyer.')->middleware(['role:member'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [BuyerDashboardController::class, 'index'])->name('dashboard');
        
        // Products
        Route::get('/products', [BuyerProductController::class, 'index'])->name('products.index');
        Route::get('/products/{id}', [BuyerProductController::class, 'show'])->name('products.show');
        
        // Cart
        Route::get('/cart', [BuyerCartController::class, 'index'])->name('cart.index'); // Correct route
        Route::post('/cart/add', [BuyerCartController::class, 'add'])->name('cart.add');
        Route::patch('/cart/{id}', [BuyerCartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{id}', [BuyerCartController::class, 'destroy'])->name('cart.destroy');
        
        // Checkout
        Route::get('/checkout', [BuyerCheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [BuyerCheckoutController::class, 'process'])->name('checkout.process');
        
        // Orders
        Route::get('/orders', [BuyerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [BuyerOrderController::class, 'show'])->name('orders.show');
        
        // Profile
        Route::get('/profile', [BuyerProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [BuyerProfileController::class, 'update'])->name('profile.update');
        
        // Store Application
        Route::get('/apply-store', [BuyerStoreController::class, 'create'])->name('store.apply');
        Route::post('/apply-store', [BuyerStoreController::class, 'store'])->name('store.submit');
        Route::get('/store-status', [BuyerStoreController::class, 'status'])->name('store.status');
    });

    // ============================================
    // SELLER ROUTES
    // ============================================
    Route::prefix('seller')->name('seller.')->middleware(['role:seller'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');
        
        // Products
        Route::resource('products', SellerProductController::class);
        
        // Orders
        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [SellerOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{id}/update-status', [SellerOrderController::class, 'updateStatus'])->name('orders.update-status');
        
        // Balance & Withdraw
        Route::get('/balance', [SellerBalanceController::class, 'index'])->name('balance.index');
        Route::get('/withdraw', [SellerWithdrawController::class, 'index'])->name('withdraw.index');
        Route::post('/withdraw', [SellerWithdrawController::class, 'store'])->name('withdraw.store');
    });

    // ============================================
    // ADMIN ROUTES
    // ============================================
    Route::prefix('admin')->name('admin.')->middleware(['role:admin'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Store Approvals
        Route::get('/stores', [AdminStoreApprovalController::class, 'index'])->name('stores.index');
        Route::get('/stores/{id}', [AdminStoreApprovalController::class, 'show'])->name('stores.show');
        Route::post('/stores/{id}/approve', [AdminStoreApprovalController::class, 'approve'])->name('stores.approve');
        Route::post('/stores/{id}/reject', [AdminStoreApprovalController::class, 'reject'])->name('stores.reject');
        
        // Users
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('users.show');
        Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
        
        // Products
        Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
        Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    });
});

// Auth routes
require __DIR__.'/auth.php';
