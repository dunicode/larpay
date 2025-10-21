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
    Route::get('/add/{id}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    /* Route::delete('/{id}', [TransferController::class, 'destroy'])->name('transfer.destroy');
    Route::patch('/{id}', [TransferController::class, 'update'])->name('transfer.update');
    Route::post('/print', [TransferController::class, 'print'])->name('transfer.print');
    Route::post('/store', [TransferController::class, 'store'])->name('transfer.store');
    Route::get('/delete/{id}', [TransferController::class, 'destroy'])->name('transfer.destroy'); */
});