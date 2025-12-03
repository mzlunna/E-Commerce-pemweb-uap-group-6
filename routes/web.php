<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\HomeController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\StoreVerificationController;
use App\Http\Controllers\Admin\WithdrawalController;  

// Home (Buyer)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Manage Users
    Route::get('/users', [AdminController::class, 'manageUsers'])->name('users');
    Route::put('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.update-role');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    // Store Verification
    Route::get('/stores', [StoreVerificationController::class, 'index'])->name('store-verification');
    Route::post('/stores/{store}/verify', [StoreVerificationController::class, 'verify'])->name('stores.verify');
    Route::get('/stores/{store}', [StoreVerificationController::class, 'show'])->name('stores.show');
    Route::delete('/stores/{store}', [StoreVerificationController::class, 'destroy'])->name('stores.delete');
    
    // Withdrawal Management
    Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals');
    Route::post('/withdrawals/{withdrawal}/status', [WithdrawalController::class, 'updateStatus'])->name('withdrawals.update-status');
});

// Seller routes
Route::middleware(['auth', 'seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
});

// Profile routes (authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
