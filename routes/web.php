<?php

use Illuminate\Support\Facades\Route;

// BUYER
use App\Http\Controllers\Buyer\BuyerDashboardController;
use App\Http\Controllers\Buyer\BuyerProductController;
use App\Http\Controllers\Buyer\BuyerCartController;
use App\Http\Controllers\Buyer\BuyerCheckoutController;
use App\Http\Controllers\Buyer\BuyerOrderController;
use App\Http\Controllers\Buyer\BuyerProfileController;
use App\Http\Controllers\Buyer\BuyerStoreController;
use App\Http\Controllers\Buyer\BuyerReviewController;

// SELLER
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerCategoryController;
use App\Http\Controllers\Seller\SellerProductImageController;
use App\Http\Controllers\Seller\SellerOrderController;
use App\Http\Controllers\Seller\SellerBalanceController;
use App\Http\Controllers\Seller\SellerWithdrawController;
use App\Http\Controllers\Seller\SellerStoreController;

// ADMIN
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminStoreController;
use App\Http\Controllers\Admin\AdminUserController;


// -------------------------------------------------
// ROOT REDIRECT
// -------------------------------------------------
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});


// -------------------------------------------------
// AUTH + VERIFIED GROUP
// -------------------------------------------------
Route::middleware(['auth', 'verified'])->group(function () {

    // ROLE REDIRECT
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $store = \App\Models\Store::where('user_id', $user->id)
            ->where('is_verified', 1)
            ->first();

        if ($store) {
            return redirect()->route('seller.dashboard');
        }

        return redirect()->route('buyer.dashboard');
    })->name('dashboard');


    // ============================================
    // BUYER ROUTES
    // ============================================
    Route::prefix('buyer')->name('buyer.')->group(function () {

        Route::get('/dashboard', [BuyerDashboardController::class, 'index'])->name('dashboard');

        Route::get('/products', [BuyerProductController::class, 'index'])->name('products.index');
        Route::get('/products/{id}', [BuyerProductController::class, 'show'])->name('products.show');

        Route::get('/cart', [BuyerCartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [BuyerCartController::class, 'add'])->name('cart.add');
        Route::patch('/cart/{id}/update', [BuyerCartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{id}', [BuyerCartController::class, 'delete'])->name('cart.destroy');

        Route::get('/checkout', [BuyerCheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout/process', [BuyerCheckoutController::class, 'placeOrder'])->name('checkout.process');

        Route::get('/orders', [BuyerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [BuyerOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{id}/cancel', [BuyerOrderController::class, 'cancel'])->name('orders.cancel');
        Route::post('/orders/{id}/confirm', [BuyerOrderController::class, 'confirmReceived'])->name('orders.confirm');
        Route::match(['get', 'post'], '/orders/{id}/payment', [BuyerOrderController::class, 'payment'])->name('orders.payment');

        Route::get('/profile/edit', [BuyerProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile/update', [BuyerProfileController::class, 'update'])->name('profile.update');

        // STORE APPLICATION
        Route::get('/store/create', [BuyerStoreController::class, 'create'])->name('store.create');
        Route::post('/store', [BuyerStoreController::class, 'store'])->name('store.store');
        Route::get('/store/status', [BuyerStoreController::class, 'status'])->name('store.status');

        // REVIEW ROUTES
        Route::prefix('review')->name('review.')->group(function () {
            Route::get('/create/{transactionId}', [BuyerReviewController::class, 'create'])->name('create');
            Route::post('/{transactionId}', [BuyerReviewController::class, 'store'])->name('store');
            Route::delete('/{reviewId}', [BuyerReviewController::class, 'destroy'])->name('destroy');
            Route::get('/product/{productId}', [BuyerReviewController::class, 'productReviews'])->name('product-reviews');
        });
    });


    // ============================================
    // SELLER ROUTES
    // ============================================
    Route::prefix('seller')
        ->name('seller.')
        ->middleware(['role:seller'])
        ->group(function () {

            Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');

            // STORE PROFILE
            Route::get('/store/edit', [SellerStoreController::class, 'edit'])->name('store.edit');
            Route::put('/store/update', [SellerStoreController::class, 'update'])->name('store.update');

            // PRODUCTS
            Route::resource('products', SellerProductController::class);

            // CATEGORIES
            Route::resource('categories', SellerCategoryController::class);

            // PRODUCT IMAGES
            Route::prefix('products/{product}/images')->name('products.images.')->group(function () {
                Route::get('/', [SellerProductImageController::class, 'index'])->name('index');
                Route::get('/create', [SellerProductImageController::class, 'create'])->name('create');
                Route::post('/', [SellerProductImageController::class, 'store'])->name('store');
                Route::delete('/{image}', [SellerProductImageController::class, 'destroy'])->name('destroy');
            });

            // ORDERS
            Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/{id}', [SellerOrderController::class, 'show'])->name('orders.show');
            Route::put('/orders/{id}', [SellerOrderController::class, 'update'])->name('orders.update');
            Route::patch('/orders/{id}/status', [SellerOrderController::class, 'updateStatus'])->name('orders.update-status');

            // BALANCE
            Route::get('/balance', [SellerBalanceController::class, 'index'])->name('balance.index');

            // WITHDRAW
            Route::get('/withdraw', [SellerWithdrawController::class, 'index'])->name('withdraw.index');
            Route::post('/withdraw', [SellerWithdrawController::class, 'store'])->name('withdraw.store');
            Route::get('/withdraw/history', [SellerWithdrawController::class, 'history'])->name('withdraw.history');
        });



    // ============================================
    // ADMIN ROUTES (UPDATED + FIXED)
    // ============================================
    Route::prefix('admin')->name('admin.')->middleware(['role:admin'])->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // STORES
        Route::prefix('stores')->name('stores.')->group(function () {
            Route::get('/', [AdminStoreController::class, 'index'])->name('index');
            Route::get('/create', [AdminStoreController::class, 'create'])->name('create');
            Route::post('/', [AdminStoreController::class, 'store'])->name('store');
            Route::get('/{id}', [AdminStoreController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [AdminStoreController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminStoreController::class, 'update'])->name('update');
            Route::post('/{id}/verify', [AdminStoreController::class, 'verify'])->name('verify');
            Route::post('/{id}/reject', [AdminStoreController::class, 'reject'])->name('reject');
            Route::delete('/{id}', [AdminStoreController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/restore', [AdminStoreController::class, 'restore'])->name('restore');
        });

        // USERS (self-delete MUST be first)
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');

        Route::get('/users/{id}/confirm-delete', [AdminUserController::class, 'confirmDelete'])->name('users.confirmDelete');
        Route::delete('/users/{id}/destroy-self', [AdminUserController::class, 'destroySelf'])->name('users.destroySelf');

        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('users.show');
        Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    });

});


// -------------------------------------------------
// AUTH ROUTES
// -------------------------------------------------
require __DIR__ . '/auth.php';
