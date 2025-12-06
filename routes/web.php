<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LockerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SewaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [SewaController::class, 'beranda'])->name('beranda');
Route::post('/sewa', [SewaController::class, 'sewa'])->name('sewa.store');
// Halaman detail pembayaran
Route::get('/pembayaran/{id}', [SewaController::class, 'detailPembayaran'])->name('pembayaran.detail');
Route::post('/payment/create', [PaymentController::class, 'create'])->name('payment.create');