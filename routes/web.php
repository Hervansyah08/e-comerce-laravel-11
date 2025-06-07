<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OngkirController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Landing\CartController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\UserOrderController;
use App\Http\Controllers\Landing\LandingController;
use App\Http\Controllers\StoreController;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/coba', function () {
    return view('coba');
});
Route::get('/clear', function () {
    session()->forget('cart');
    session()->forget('ongkir');
    session()->forget('ekspedisi');
});
Route::get('/session-all', function () {
    return session()->all();
});

Route::get('/produk', [LandingController::class, 'product'])->name('produk');


Route::middleware(['auth'])->group(function () {
    // riwayat pesanan
    Route::get('/orders/history', [UserOrderController::class, 'index'])->name('user.orders.history');

    // Checkout Routes
    Route::post('/checkout/process', [CheckoutController::class, 'process'])
        ->name('checkout.process');
    Route::post('/checkout/update-status', [CheckoutController::class, 'updateStatus'])
        ->name('checkout.updateStatus');
    // Route::post('/checkout/cancel-order', [CheckoutController::class, 'cancelOrder'])
    //     ->name('checkout.cancelOrders');
});

// cart'
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/store/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
});

// ongkir
Route::middleware(['auth'])->prefix('cek-ongkir')->group(function () {
    Route::get('/', [OngkirController::class, 'index'])
        ->name('ongkir.index');
    Route::post('/', [OngkirController::class, 'cekOngkir'])
        ->name('cek-ongkir');
    Route::post('/pilih-ongkir', [OngkirController::class, 'pilihOngkir'])->name('pilih-ongkir');
    Route::delete('/', [OngkirController::class, 'delete'])->name('ongkir.delete');
});

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
});
Route::post('/auth/logout', [AuthController::class, 'logout'])
    ->name('auth.logout')
    ->middleware('auth');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // Categories Management
    // jadi nanti semua route di dalam group ini memiliki awal categories
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])
            ->name('admin.categories.index');
        Route::post('/', [CategoryController::class, 'store'])
            ->name('admin.categories.store');
        Route::put('/{category}', [CategoryController::class, 'update'])
            ->name('admin.categories.update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])
            ->name('admin.categories.destroy');
    });

    // Products Management
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])
            ->name('admin.products.index');
        Route::post('/', [ProductController::class, 'store'])
            ->name('admin.products.store');
        Route::put('/{product}', [ProductController::class, 'update'])
            ->name('admin.products.update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])
            ->name('admin.products.destroy');
    });

    // Orders Management
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrdersController::class, 'index'])
            ->name('admin.orders.index');
        Route::put('/{order}/status', [OrdersController::class, 'updateStatus'])
            ->name('admin.orders.update-status');
        Route::get('/{order}/print-pdf', [OrdersController::class, 'printPdf'])->name('orders.print.pdf');
    });

    // Order History
    Route::get('/history-order', [OrderHistoryController::class, 'index'])
        ->name('admin.history.index');
    Route::patch('/history-order/{order}/received', [OrderHistoryController::class, 'orderReceived'])->name('orders.received');


    // user Management
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])
            ->name('admin.user.index');
        Route::post('/', [UserController::class, 'store'])
            ->name('admin.user.store');
        // Route::put('/{product}', [ProductController::class, 'update'])
        //     ->name('admin.products.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])
            ->name('admin.user.destroy');
    });

    Route::prefix('store')->group(function () {
        Route::get('/', [StoreController::class, 'index'])
            ->name('admin.store.index');
        Route::post('/', [StoreController::class, 'store'])
            ->name('admin.store.store');
        Route::put('/{store}', [StoreController::class, 'update'])
            ->name('admin.store.update');
        Route::delete('/{store}', [StoreController::class, 'destroy'])
            ->name('admin.store.destroy');
    });
});
