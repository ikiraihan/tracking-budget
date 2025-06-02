<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\KotaTujuanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PerjalananController;
use App\Http\Controllers\SupirController;
use App\Http\Controllers\TrukController;
use App\Http\Controllers\UserController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register/store', [AuthController::class, 'register'])->name('register.store');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Route::get('/dashboard', function () {
//     return 'Selamat datang, ' . auth()->user()->username;
// })->middleware('auth');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware('auth')->name('dashboard');

Route::middleware(['auth', 'role:1'])->group(function () {//admin
    Route::get('supir/change-password/{user_id}', [SupirController::class, 'changePassForm'])->name('supir.change_password_form');
    Route::get('supir/create', [SupirController::class, 'create'])->name('supir.create');
    Route::post('supir/store', [SupirController::class, 'store'])->name('supir.store');
    Route::get('supir/edit/{id}', [SupirController::class, 'edit'])->name('supir.edit');
    Route::put('supir/update/{id}', [SupirController::class, 'update'])->name('supir.update');
    Route::delete('supir/delete/{id}', [SupirController::class, 'delete'])->name('supir.delete');
    Route::put('supir/password/{user_id}', [SupirController::class, 'changePass'])->name('supir.change_password');
    Route::get('supir/verifikasi-form/{id}', [SupirController::class, 'verifikasiForm'])->name('supir.verifikasi_form');
    Route::put('supir/verifikasi/{id}', [SupirController::class, 'verifikasi'])->name('supir.verifikasi');

    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    Route::get('user/change-password/{id}', [UserController::class, 'changePassForm'])->name('user.change_password_form');
    Route::put('user/password/{id}', [UserController::class, 'changePass'])->name('user.change_password');
});

Route::middleware(['auth', 'role:1,2'])->group(function () { //admin dan owner
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('truk', [TrukController::class, 'index'])->name('truk.index');
    Route::get('truk/detail/{id}', [TrukController::class, 'detail'])->name('truk.detail');
    Route::get('truk/create', [TrukController::class, 'create'])->name('truk.create');
    Route::post('truk/store', [TrukController::class, 'store'])->name('truk.store');
    Route::get('truk/edit/{id}', [TrukController::class, 'edit'])->name('truk.edit');
    Route::put('truk/update/{id}', [TrukController::class, 'update'])->name('truk.update');
    Route::delete('truk/delete/{id}', [TrukController::class, 'delete'])->name('truk.delete');

    Route::get('supir', [SupirController::class, 'index'])->name('supir.index');
    Route::get('supir/detail/{id}', [SupirController::class, 'detail'])->name('supir.detail');

    Route::get('pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
    Route::get('/pengeluaran/show/{truk_id}', [PengeluaranController::class, 'show']);

    Route::get('kota-tujuan', [KotaTujuanController::class, 'index'])->name('kota_tujuan.index');
    Route::get('kota-tujuan/create', [KotaTujuanController::class, 'create'])->name('kota_tujuan.create');
    Route::post('kota-tujuan/store', [KotaTujuanController::class, 'store'])->name('kota_tujuan.store');
    Route::get('kota-tujuan/edit/{id}', [KotaTujuanController::class, 'edit'])->name('kota_tujuan.edit');
    Route::put('kota-tujuan/update/{id}', [KotaTujuanController::class, 'update'])->name('kota_tujuan.update');
});

Route::middleware(['auth', 'role:1,2,3'])->group(function () { //admin , owner, dan supir
    Route::get('perjalanan', [PerjalananController::class, 'index'])->name('perjalanan.index');
    Route::get('perjalanan/form', [PerjalananController::class, 'formIndex'])->name('perjalanan.form_index');
    Route::post('perjalanan/store', [PerjalananController::class, 'store'])->name('perjalanan.store');
    Route::get('perjalanan/detail/{id}', [PerjalananController::class, 'detail'])->name('perjalanan.detail');
    Route::get('perjalanan/edit/{id}', [PerjalananController::class, 'edit'])->name('perjalanan.edit');
    Route::put('perjalanan/update/{id}', [PerjalananController::class, 'update'])->name('perjalanan.update');
    Route::put('perjalanan/verifikasi-data/{id}', [PerjalananController::class, 'verifikasiData'])->name('perjalanan.verifikasi_data');
    Route::put('perjalanan/tolak-data/{id}', [PerjalananController::class, 'tolakData'])->name('perjalanan.tolak_data');
    Route::put('perjalanan/pembayaran/{id}', [PerjalananController::class, 'pembayaran'])->name('perjalanan.pembayaran');
    Route::delete('perjalanan/delete/{id}', [PerjalananController::class, 'delete'])->name('perjalanan.delete');

});

Route::middleware(['auth', 'role:3'])->group(function () { //supir
    Route::get('perjalanan/form', [PerjalananController::class, 'formIndex'])->name('perjalanan.form_index');

});

// Route::get('/kota', [KotaController::class, 'getKotaByProvinsi']);
Route::get('/get-kota-by-provinsi/{provinsiId}', [KotaController::class, 'getKotaByProvinsi']);
