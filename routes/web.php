<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LockerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SewaController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [SewaController::class, 'beranda'])->name('beranda');
Route::post('/sewa', [SewaController::class, 'sewa'])->name('sewa.store');
// TOMBOL DETAIL → INPUT KODE AKSES
// Route::post('/sewa/detail', [SewaController::class, 'validateKode'])
//     ->name('sewa.detailSewa');

// HALAMAN LANJUT PEMBAYARAN
// Route::get('/pembayaran/{id}', [SewaController::class, 'detailPembayaran'])
//     ->name('pembayaran.detail');

// Halaman detail pembayaran
Route::get('/pembayaran/{id}', [SewaController::class, 'detailPembayaran'])->name('pembayaran.detail');
Route::post('/payment/create', [PaymentController::class, 'create'])->name('payment.create');

Route::post('/loker/validate-kode', [SewaController::class, 'validateKode'])->name('loker.validateKode');
Route::post('/send-wa', [SewaController::class, 'sendWa'])->name('send.wa');

// INPUT KODE AKSES (POST)
Route::post('/sewa/detail', [SewaController::class, 'validateKode'])
    ->name('sewa.detailSewa');

// JIKA KODE BENAR, MASUK HALAMAN DETAIL SEWA
Route::get('/loker/detail/{id}', [SewaController::class, 'detailSewaPage'])
    ->name('loker.detailPage');
Route::post('/sewa/{id}/selesai', [SewaController::class, 'selesaikanSewa'])
    ->name('sewa.selesai');


Route::post('/midtrans/callback', [PaymentController::class, 'callback']);
Route::post('/payment/success', [PaymentController::class, 'success'])
    ->name('payment.success');


