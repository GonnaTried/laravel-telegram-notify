<?php

use App\Http\Controllers\cartController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\productController;
use Illuminate\Support\Facades\Route;

Route::controller(productController::class)->group(function () {

    Route::get('', 'index');
    Route::get('home', 'index');
});

Route::controller(cartController::class)->group(function () {

    Route::post('/cart/add/{productId}', 'addToCart')->name('cart.add');
});
Route::get('/checkout', [cartController::class, 'checkout'])->name('checkout');
Route::post('/checkout/process', [cartController::class, 'processCheckout'])->name('checkout.process');
Route::post('/cart/update/{productId}', [cartController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove/{productId}', [cartController::class, 'removeFromCart'])->name('cart.remove');
