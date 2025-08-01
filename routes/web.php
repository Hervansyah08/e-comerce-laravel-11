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
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
    Route::get('/orders/history', [UserOrderController::class, 'index'])->name('user.orders.history')->middleware('verified');



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

// VERIFIKASI EMAIL
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // untuk mengisi kolom email verived at di tabel user

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// FORGOT PASSWORD
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

// Order History
Route::get('/history-order', [OrderHistoryController::class, 'index'])
    ->name('admin.history.index')->middleware('auth');
Route::patch('/history-order/{order}/received', [OrderHistoryController::class, 'orderReceived'])->name('orders.received')->middleware('auth');
Route::patch('/history-order/{order}/cancel', [OrderHistoryController::class, 'cancelOrder'])->name('orders.cancelOrder')->middleware('auth');
Route::get('/ulasan/{order}', [OrderHistoryController::class, 'edit'])->name('ulasan.edit');
Route::put('/ulasan/{order}', [OrderHistoryController::class, 'updateUlasan'])->name('ulasan.update');
Route::get('/detail-ulasan/{order}', [OrderHistoryController::class, 'detailUlasan'])->name('detail.ulasan');




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

    // management profil toko
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
