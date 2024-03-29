<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\TransaksiController;

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login')->name('login');
    Route::post('/login', 'authenticate')->name('authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::middleware('role:admin,kasir')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    //setting profile
    Route::get('/profile', [UserController::class, 'profile']);
    Route::post('/profile/update/{id}', [UserController::class, 'updateprofile']);
});
 
Route::middleware('role:admin')->group(function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user/store', [UserController::class, 'store']);
    Route::post('/user/update/{id}', [UserController::class, 'update']);
    Route::get('/user/destroy/{id}', [UserController::class, 'destroy']);

    Route::get('/jenisbarang', [JenisBarangController::class, 'index']);
    Route::post('/jenisbarang/store', [JenisBarangController::class, 'store']);
    Route::post('/jenisbarang/update/{id}', [JenisBarangController::class, 'update']);
    Route::get('/jenisbarang/destroy/{id}', [JenisBarangController::class, 'destroy']);

    Route::get('/barang', [BarangController::class, 'index']);
    Route::post('/barang/store', [BarangController::class, 'store']);
    Route::post('/barang/update/{id}', [BarangController::class, 'update']);
    Route::get('/barang/destroy/{id}', [BarangController::class, 'destroy']);
    
    //setting diskon
    Route::get('/setdiskon', [DiskonController::class, 'index']);
    Route::post('/setdiskon/update/{id}', [DiskonController::class, 'update']);

    //Data Laporan
    Route::get('/laporan', [TransaksiController::class, 'laporan']);
    Route::post('/laporan/cetak', [TransaksiController::class, 'laporancetak']);
});

Route::middleware('role:kasir')->group(function () {
     //Data Transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::get('/transaksi/create', [TransaksiController::class, 'create']);
    Route::get('/transaksi/detail/{no_transaksi}', [TransaksiController::class, 'detail']);
    Route::get('/transaksi/cetakfaktur/{no_transaksi}', [TransaksiController::class, 'cetakfaktur']);
    Route::get('/transaksi/cetakinvoice/{no_transaksi}', [TransaksiController::class, 'cetakinvoice']);
    Route::get('/transaksi/detailbarang/{id_barang}', [TransaksiController::class, 'detailbarang']);
    Route::post('/transaksi/cart', [TransaksiController::class, 'cart']);
    Route::post('/transaksi/store', [TransaksiController::class, 'store']);
    Route::get('/transaksi/remove/{id_barang}', [TransaksiController::class, 'remove']);
});
