<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->prefix('shop')->group(function () {
    Route::get('/', [App\Http\Controllers\ProductController::class, 'list'])->name('product.list');
});

Route::middleware('auth')->prefix('cart')->group(function () {
    Route::get('/', [App\Http\Controllers\CartController::class, 'list'])->name('cart.list');
    Route::get('/add/{id}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::post('/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
     Route::get('/check', [App\Http\Controllers\CartController::class, 'check'])->name('cart.check');
});

Route::post('/paypal/create-order', [App\Http\Controllers\PayPalController::class, 'createOrder']);
Route::post('/paypal/capture-order/{orderId}', [App\Http\Controllers\PayPalController::class, 'captureOrder']);