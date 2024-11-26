<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

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



Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

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
    Route::get('/search', [CategoryController::class, 'search'])
        ->name('admin.categories.search');
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
    Route::get('/search', [CategoryController::class, 'search'])
        ->name('admin.products.search');
});
