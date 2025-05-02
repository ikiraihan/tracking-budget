<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\PerjalananController;
use App\Http\Controllers\SupirController;
use App\Http\Controllers\TrukController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register/store', [AuthController::class, 'register'])->name('register.store');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/dashboard', function () {
    return 'Selamat datang, ' . auth()->user()->username;
})->middleware('auth');


// Route::get('/dashboard', function () {
//     return view('perjalanan.form');
// })->middleware('auth');

Route::get('perjalanan', [PerjalananController::class, 'index'])->name('perjalanan.index')->middleware('auth');
Route::get('perjalanan/form', [PerjalananController::class, 'formIndex'])->name('perjalanan.form_index')->middleware('auth');
Route::post('perjalanan/store', [PerjalananController::class, 'store'])->name('perjalanan.store')->middleware('auth');
Route::get('perjalanan/detail/{id}', [PerjalananController::class, 'detail'])->name('perjalanan.detail')->middleware('auth');
Route::get('perjalanan/edit/{id}', [PerjalananController::class, 'edit'])->name('perjalanan.edit')->middleware('auth');
Route::put('perjalanan/update/{id}', [PerjalananController::class, 'update'])->name('perjalanan.update')->middleware('auth');
Route::delete('perjalanan/delete/{id}', [PerjalananController::class, 'delete'])->name('perjalanan.delete')->middleware('auth');

Route::get('truk', [TrukController::class, 'index'])->name('truk.index')->middleware('auth');
Route::get('truk/detail/{id}', [TrukController::class, 'detail'])->name('truk.detail')->middleware('auth');
Route::get('truk/create', [TrukController::class, 'create'])->name('truk.create')->middleware('auth');
Route::post('truk/store', [TrukController::class, 'store'])->name('truk.store')->middleware('auth');
Route::get('truk/edit/{id}', [TrukController::class, 'edit'])->name('truk.edit')->middleware('auth');
Route::put('truk/update/{id}', [TrukController::class, 'update'])->name('truk.update')->middleware('auth');
Route::delete('truk/delete/{id}', [TrukController::class, 'delete'])->name('truk.delete')->middleware('auth');

Route::get('supir', [SupirController::class, 'index'])->name('supir.index')->middleware('auth');
Route::get('supir/detail/{id}', [SupirController::class, 'detail'])->name('supir.detail')->middleware('auth');
Route::get('supir/create', [SupirController::class, 'create'])->name('supir.create')->middleware('auth');
Route::post('supir/store', [SupirController::class, 'store'])->name('supir.store')->middleware('auth');
Route::get('supir/edit/{id}', [SupirController::class, 'edit'])->name('supir.edit')->middleware('auth');
Route::put('supir/update/{id}', [SupirController::class, 'update'])->name('supir.update')->middleware('auth');
Route::get('supir/change-password/{user_id}', [SupirController::class, 'changePassForm'])->name('supir.change_password_form')->middleware('auth');
Route::put('supir/password/{user_id}', [SupirController::class, 'changePass'])->name('supir.change_password')->middleware('auth');
Route::delete('supir/delete/{id}', [SupirController::class, 'delete'])->name('supir.delete')->middleware('auth');
Route::get('supir/verifikasi-form/{id}', [SupirController::class, 'verifikasiForm'])->name('supir.verifikasi_form')->middleware('auth');
Route::put('supir/verifikasi/{id}', [SupirController::class, 'verifikasi'])->name('supir.verifikasi')->middleware('auth');

// Route::get('/kota', [KotaController::class, 'getKotaByProvinsi']);
Route::get('/get-kota-by-provinsi/{provinsiId}', [KotaController::class, 'getKotaByProvinsi']);
