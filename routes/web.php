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
//GET ROUTER PUBLIC
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('landing');

Route::prefix('get')->name('get.')->group(function () {
    Route::get('/kabupaten', [App\Http\Controllers\HomeController::class, 'getKabupaten']);
    Route::get('/users/{id}', [App\Http\Controllers\HomeController::class, 'getUsersLevel']);
    Route::get('/wilayah_kerja/{id}', [App\Http\Controllers\HomeController::class, 'getWilayahKerja']);
    Route::get('/tanaman', [App\Http\Controllers\HomeController::class, 'getTanaman']);
    Route::get('/opt', [App\Http\Controllers\HomeController::class, 'getOPT']);
});

//FIND ROUTER PUBLIC

Route::prefix('find')->name('find.')->group(function () {
    Route::get('/kabupaten/{id}', [App\Http\Controllers\HomeController::class, 'findKabupaten']);
    Route::get('/kecamatan/{id}', [App\Http\Controllers\HomeController::class, 'findKecamatan']);
    Route::get('/petugas/{id}', [App\Http\Controllers\HomeController::class, 'findPetugas']);
});

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
    Route::get('/tanaman', [App\Http\Controllers\AdminTanamanController::class, 'index'])->name('tanaman');
    Route::get('/opt', [App\Http\Controllers\AdminOPTController::class, 'index'])->name('opt');
    Route::get('/laporan', [App\Http\Controllers\AdminLaporanController::class, 'index'])->name('laporan');


    Route::prefix('kabupaten')->name('kabupaten.')->group(function () {
        Route::get('/tambah', [App\Http\Controllers\AdminKabupatenController::class, 'new'])->name('new');
        Route::get('/edit/{id}', [App\Http\Controllers\AdminKabupatenController::class, 'edit'])->name('edit');
        Route::POST('/save', [App\Http\Controllers\AdminKabupatenController::class, 'store']);
        Route::POST('/update/{id}', [App\Http\Controllers\AdminKabupatenController::class, 'update']);
        Route::GET('/delete/{id}', [App\Http\Controllers\AdminKabupatenController::class, 'destroy']);
        Route::get('/json', [App\Http\Controllers\AdminKabupatenController::class, 'json']);
        Route::get('/find/{id}', [App\Http\Controllers\AdminKabupatenController::class, 'find']);
    });

    Route::prefix('tanaman')->name('tanaman.')->group(function () {
        Route::get('/tambah', [App\Http\Controllers\AdminTanamanController::class, 'new'])->name('new');
        Route::get('/edit/{id}', [App\Http\Controllers\AdminTanamanController::class, 'edit'])->name('edit');
        Route::POST('/save', [App\Http\Controllers\AdminTanamanController::class, 'store']);
        Route::POST('/update/{id}', [App\Http\Controllers\AdminTanamanController::class, 'update']);
        Route::GET('/delete/{id}', [App\Http\Controllers\AdminTanamanController::class, 'destroy']);
        Route::get('/json', [App\Http\Controllers\AdminTanamanController::class, 'json']);
        Route::get('/find/{id}', [App\Http\Controllers\AdminTanamanController::class, 'find']);
    });

    Route::prefix('opt')->name('opt.')->group(function () {
        Route::get('/tambah', [App\Http\Controllers\AdminOPTController::class, 'new'])->name('new');
        Route::get('/edit/{id}', [App\Http\Controllers\AdminOPTController::class, 'edit'])->name('edit');
        Route::POST('/save', [App\Http\Controllers\AdminOPTController::class, 'store']);
        Route::POST('/update/{id}', [App\Http\Controllers\AdminOPTController::class, 'update']);
        Route::GET('/delete/{id}', [App\Http\Controllers\AdminOPTController::class, 'destroy']);
        Route::get('/json', [App\Http\Controllers\AdminOPTController::class, 'json']);
        Route::get('/find/{id}', [App\Http\Controllers\AdminOPTController::class, 'find']);
    });

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::POST('/update/{id}', [App\Http\Controllers\AdminLaporanController::class, 'update']);
        Route::GET('/delete/{id}', [App\Http\Controllers\AdminLaporanController::class, 'destroy']);
        Route::get('/json', [App\Http\Controllers\AdminLaporanController::class, 'json']);
        Route::get('/find/{id}', [App\Http\Controllers\AdminLaporanController::class, 'find']);
    });
});

//KORDINATOR ROUTES
Route::prefix('kordinator')->name('kordinator.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\KordinatorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/petugas', [App\Http\Controllers\KordinatorPetugasController::class, 'index'])->name('petugas');
    Route::get('/kecamatan', [App\Http\Controllers\KordinatorKecamatanController::class, 'index'])->name('kecamatan');
    Route::get('/wilayah_kerja', [App\Http\Controllers\KordinatorWilayahKerjaController::class, 'index'])->name('wilayah_kerja');
    Route::get('/laporan', [App\Http\Controllers\KordinatorLaporanController::class, 'index'])->name('laporan');

    Route::prefix('petugas')->name('petugas.')->group(function () {
        Route::get('/tambah', [App\Http\Controllers\KordinatorPetugasController::class, 'new'])->name('new');
        Route::get('/edit/{id}', [App\Http\Controllers\KordinatorPetugasController::class, 'edit'])->name('edit');
        Route::POST('/save', [App\Http\Controllers\KordinatorPetugasController::class, 'store']);
        Route::POST('/update/{id}', [App\Http\Controllers\KordinatorPetugasController::class, 'update']);
        Route::GET('/delete/{id}', [App\Http\Controllers\KordinatorPetugasController::class, 'destroy']);
        Route::get('/json', [App\Http\Controllers\KordinatorPetugasController::class, 'json']);
        Route::get('/find/{id}', [App\Http\Controllers\KordinatorPetugasController::class, 'find']);
    });

    Route::prefix('kecamatan')->name('kecamatan.')->group(function () {
        Route::get('/tambah', [App\Http\Controllers\KordinatorKecamatanController::class, 'new'])->name('new');
        Route::get('/edit/{id}', [App\Http\Controllers\KordinatorKecamatanController::class, 'edit'])->name('edit');
        Route::POST('/save', [App\Http\Controllers\KordinatorKecamatanController::class, 'store']);
        Route::POST('/update/{id}', [App\Http\Controllers\KordinatorKecamatanController::class, 'update']);
        Route::GET('/delete/{id}', [App\Http\Controllers\KordinatorKecamatanController::class, 'destroy']);
        Route::get('/json', [App\Http\Controllers\KordinatorKecamatanController::class, 'json']);
        Route::get('/find/{id}', [App\Http\Controllers\KordinatorKecamatanController::class, 'find']);
    });

    Route::prefix('wilayah_kerja')->name('wilayah_kerja.')->group(function () {
        Route::get('/tambah', [App\Http\Controllers\KordinatorWilayahKerjaController::class, 'new'])->name('new');
        Route::get('/edit/{id}', [App\Http\Controllers\KordinatorWilayahKerjaController::class, 'edit'])->name('edit');
        Route::POST('/save', [App\Http\Controllers\KordinatorWilayahKerjaController::class, 'store']);
        Route::POST('/update/{id}', [App\Http\Controllers\KordinatorWilayahKerjaController::class, 'update']);
        Route::GET('/delete/{id}', [App\Http\Controllers\KordinatorWilayahKerjaController::class, 'destroy']);
        Route::get('/json', [App\Http\Controllers\KordinatorWilayahKerjaController::class, 'json']);
        Route::get('/find/{id}', [App\Http\Controllers\KordinatorWilayahKerjaController::class, 'find']);
    });
    
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::POST('/update/{id}', [App\Http\Controllers\KordinatorLaporanController::class, 'update']);
        Route::GET('/delete/{id}', [App\Http\Controllers\KordinatorLaporanController::class, 'destroy']);
        Route::get('/json', [App\Http\Controllers\KordinatorLaporanController::class, 'json']);
        Route::get('/find/{id}', [App\Http\Controllers\KordinatorLaporanController::class, 'find']);
    });
});


//PETUGAS ROUTES
Route::prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\PetugasDashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [App\Http\Controllers\PetugasLaporanController::class, 'index'])->name('laporan');

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/tambah', [App\Http\Controllers\PetugasLaporanController::class, 'new'])->name('new');
        Route::get('/edit/{id}', [App\Http\Controllers\PetugasLaporanController::class, 'edit'])->name('edit');
        Route::POST('/save', [App\Http\Controllers\PetugasLaporanController::class, 'store']);
        Route::POST('/update/{id}', [App\Http\Controllers\PetugasLaporanController::class, 'update']);
        Route::GET('/delete/{id}', [App\Http\Controllers\PetugasLaporanController::class, 'destroy']);
        Route::get('/json', [App\Http\Controllers\PetugasLaporanController::class, 'json']);
        Route::get('/find/{id}', [App\Http\Controllers\PetugasLaporanController::class, 'find']);
    });
});
