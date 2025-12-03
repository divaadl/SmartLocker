<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LockerController;

Route::get('/', function () {
    return view('welcome');
});

// routes/web.php
Route::get('/', [LockerController::class, 'index'])->name('locker.index');
Route::get('/sewa/{locker}', [LockerController::class, 'create'])->name('locker.create');
Route::post('/sewa/{locker}', [LockerController::class, 'store'])->name('locker.store');
