<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JenisBarangController;

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login')->name('login');
    Route::post('/login', 'authenticate')->name('authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user/store', [UserController::class, 'store']);
    Route::post('/user/update/{id}', [UserController::class, 'update']);
    Route::get('/user/destroy/{id}', [UserController::class, 'destroy']);

    Route::get('/jenisbarang', [JenisBarangController::class, 'index']);
    Route::post('/jenisbarang/store', [JenisBarangController::class, 'store']);
    Route::post('/jenisbarang/update/{id}', [JenisBarangController::class, 'update']);
    Route::get('/jenisbarang/destroy/{id}', [JenisBarangController::class, 'destroy']);
    
    Route::get('/home', [HomeController::class, 'index'])->name('home');

});

