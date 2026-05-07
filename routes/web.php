<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentCallbackController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/initiate', [CheckoutController::class, 'initiate'])->name('checkout.initiate');

Route::post('/payment/success', [PaymentCallbackController::class, 'success'])->name('payment.success');
Route::post('/payment/fail',    [PaymentCallbackController::class, 'fail'])->name('payment.fail');
Route::post('/payment/cancel',  [PaymentCallbackController::class, 'cancel'])->name('payment.cancel');
Route::post('/payment/ipn',     [PaymentCallbackController::class, 'ipn'])->name('payment.ipn');
