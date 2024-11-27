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
Route::get('/account/login', [App\Http\Controllers\HomeController::class, 'login'])->name('login');
Route::POST('/account/logout', [App\Http\Controllers\CustomAuth::class, 'customlogout'])->name('logout');
Route::POST('/account/set_password', [App\Http\Controllers\CustomAuth::class, 'set_password'])->name('set.password');
Route::POST('/account/login/cek_login', [App\Http\Controllers\CustomAuth::class, 'customLogin'])->name('custom.login');

//GET ADMIN
Route::get('/admin/appointment', [App\Http\Controllers\AdminController::class, 'appointment'])->name('admin.appointment');
Route::get('/admin/billing', [App\Http\Controllers\AdminController::class, 'billing'])->name('admin.billing');
Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/dokter', [App\Http\Controllers\AdminController::class, 'doctors'])->name('admin.dokter');
Route::get('/admin/pasien', [App\Http\Controllers\AdminController::class, 'patients'])->name('admin.pasien');

//STORE ADMIN
Route::POST('/admin/appointment/save', [App\Http\Controllers\AppointmentController::class, 'store']);
Route::POST('/admin/billing/save', [App\Http\Controllers\BillingController::class, 'store']);
Route::POST('/admin/dokter/save', [App\Http\Controllers\DoctorController::class, 'store']);
Route::POST('/admin/pasien/save', [App\Http\Controllers\PatientsController::class, 'store']);

//UPDATE ADMIN
Route::POST('/admin/appointment/update/{id}', [App\Http\Controllers\AppointmentController::class, 'update']);
Route::POST('/admin/billing/update/{id}', [App\Http\Controllers\BillingController::class, 'update']);
Route::POST('/admin/dokter/update/{id}', [App\Http\Controllers\DoctorController::class, 'update']);
Route::POST('/admin/pasien/update/{id}', [App\Http\Controllers\PatientsController::class, 'update']);

//DESTROY ADMIN
Route::GET('/admin/appointment/delete/{id}', [App\Http\Controllers\AppointmentController::class, 'destroy']);
Route::GET('/admin/billing/delete/{id}', [App\Http\Controllers\BillingController::class, 'destroy']);
Route::GET('/admin/dokter/delete/{id}', [App\Http\Controllers\DoctorController::class, 'destroy']);
Route::GET('/admin/pasien/delete/{id}', [App\Http\Controllers\PatientsController::class, 'destroy']);

//JSON
Route::get('/admin/appointment/json', [App\Http\Controllers\AppointmentController::class, 'json']);
Route::get('/admin/billing/json', [App\Http\Controllers\BillingController::class, 'json']);
Route::get('/admin/dokter/json', [App\Http\Controllers\DoctorController::class, 'json']);
Route::get('/admin/pasien/json', [App\Http\Controllers\PatientsController::class, 'json']);

//FIND
Route::get('/admin/appointment/find/{id}', [App\Http\Controllers\AppointmentController::class, 'find']);
Route::get('/admin/billing/find/{id}', [App\Http\Controllers\BillingController::class, 'find']);
Route::get('/admin/dokter/find/{id}', [App\Http\Controllers\DoctorController::class, 'find']);
Route::get('/admin/pasien/find/{id}', [App\Http\Controllers\PatientsController::class, 'find']);

//Doctor
Route::get('/dokter/appointment', [App\Http\Controllers\LoginDoctor::class, 'appointments'])->name('dokter.appointment');
Route::get('/dokter/dashboard', [App\Http\Controllers\LoginDoctor::class, 'index'])->name('dokter.dashboard');
Route::get('/dokter/medical', [App\Http\Controllers\LoginDoctor::class, 'medical_records'])->name('dokter.medical');
Route::get('/dokter/pasien', [App\Http\Controllers\LoginDoctor::class, 'patients'])->name('dokter.pasien');
Route::get('/dokter/pasien/record/{id}', [App\Http\Controllers\LoginDoctor::class, 'patients_diagnose']);
Route::get('/dokter/prescriptions', [App\Http\Controllers\LoginDoctor::class, 'prescriptions'])->name('dokter.prescriptions');

Route::get('/dokter/appointment/json', [App\Http\Controllers\DoctorAppointmentController::class, 'json']);
Route::get('/dokter/appointment/find/{id}', [App\Http\Controllers\DoctorAppointmentController::class, 'find']);
Route::GET('/dokter/appointment/confirm/{id}', [App\Http\Controllers\DoctorAppointmentController::class, 'confirm']);
Route::GET('/dokter/appointment/reject/{id}', [App\Http\Controllers\DoctorAppointmentController::class, 'reject']);

Route::POST('/dokter/medical/save', [App\Http\Controllers\DoctorMedicalController::class, 'store']);
Route::POST('/dokter/medical/update/{id}', [App\Http\Controllers\DoctorMedicalController::class, 'update']);
Route::GET('/dokter/medical/delete/{id}', [App\Http\Controllers\DoctorMedicalController::class, 'destroy']);
Route::get('/dokter/medical/json', [App\Http\Controllers\DoctorMedicalController::class, 'json']);
Route::get('/dokter/medical/find/{id}', [App\Http\Controllers\DoctorMedicalController::class, 'find']);

Route::get('/dokter/pasien/json', [App\Http\Controllers\DoctorPatientsController::class, 'json']);
Route::get('/dokter/pasien/find/{id}', [App\Http\Controllers\DoctorPatientsController::class, 'find']);
Route::get('/dokter/pasien/get/medical/{id}', [App\Http\Controllers\DoctorPatientsController::class, 'medical_json']);
Route::get('/dokter/pasien/record/{id}/json', [App\Http\Controllers\DoctorPatientsController::class, 'diagnose_json']);

Route::POST('/dokter/prescriptions/save', [App\Http\Controllers\DoctorPrescriptionsController::class, 'store']);
Route::POST('/dokter/prescriptions/update/{id}', [App\Http\Controllers\DoctorPrescriptionsController::class, 'update']);
Route::GET('/dokter/prescriptions/delete/{od}', [App\Http\Controllers\DoctorPrescriptionsController::class, 'destroy']);
Route::get('/dokter/prescriptions/json', [App\Http\Controllers\DoctorPrescriptionsController::class, 'json']);
Route::get('/dokter/prescriptions/find/{id}', [App\Http\Controllers\DoctorPrescriptionsController::class, 'find']);


//Pasien

//Robot
Route::get('/robot/notif/json/{id}', [App\Http\Controllers\NotifLoader::class, 'read']);
Route::get('/robot/notif/get', [App\Http\Controllers\NotifLoader::class, 'get_notif']);
Route::get('/robot/notif/test', [App\Http\Controllers\NotifLoader::class, 'test']);

//Data Binding
Route::get('/get/data/dokter', [App\Http\Controllers\HomeController::class, 'get_doctors']);
Route::get('/get/data/pasien', [App\Http\Controllers\HomeController::class, 'get_patients']);
Route::get('/get/data/appointment/{id}', [App\Http\Controllers\HomeController::class, 'get_patients_appointments']);
Route::get('/get/data/appointment', [App\Http\Controllers\HomeController::class, 'get_appointments']);
Route::get('/get/data/doctor/appointment', [App\Http\Controllers\HomeController::class, 'get_doctor_appointments']);
