<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('landing');

//Login

Route::prefix('account')->group(function () {
    Route::get('/login', [App\Http\Controllers\HomeController::class, 'login'])->name('login');
    Route::POST('/logout', [App\Http\Controllers\CustomAuth::class, 'customlogout'])->name('logout');
    Route::POST('/set_password', [App\Http\Controllers\CustomAuth::class, 'set_password'])->name('set.password');
    Route::POST('/login/cek_login', [App\Http\Controllers\CustomAuth::class, 'customLogin'])->name('custom.login');
});
//ADMIN ROUTES
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/kabupaten', [App\Http\Controllers\AdminKabupatenController::class, 'index'])->name('kabupaten');
    Route::get('/laporan', [App\Http\Controllers\AdminKabupatenController::class, 'index'])->name('laporan');


    Route::prefix('kabupaten')->name('kabupaten.')->group(function () {
        Route::get('/tambah', [App\Http\Controllers\AdminKabupatenController::class, 'new'])->name('new');
        Route::POST('/save', [App\Http\Controllers\AdminKabupatenController::class, 'store']);
        Route::POST('/update/{id}', [App\Http\Controllers\AdminKabupatenController::class, 'update']);
        Route::GET('/delete/{id}', [App\Http\Controllers\AdminKabupatenController::class, 'destroy']);
        Route::get('/json', [App\Http\Controllers\AdminKabupatenController::class, 'json']);
        Route::get('/find/{id}', [App\Http\Controllers\AdminKabupatenController::class, 'find']);
    });
});
