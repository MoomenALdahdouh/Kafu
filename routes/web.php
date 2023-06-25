<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncubatorController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PlanController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('about', function () {
    return Inertia::render('about');
})->name('about');

Route::get('/', function () {
    return Inertia::render('index');
})->name('/');

Route::get('home', [HomeController::class, 'index'])->name('home');
Route::resource('employee', EmployeeController::class)->only(['index', 'store', 'update', 'destroy']);
Route::resource('company', CompanyController::class)->only(['index', 'store', 'update', 'destroy']);
Route::get('register/company', [CompanyController::class, 'create_company'])->name('company.register');
Route::post('register/company', [CompanyController::class, 'store_company'])->name('company.register.store');
Route::resource('job', JobController::class)->only(['index', 'store', 'update', 'destroy']);
Route::resource('incubator', IncubatorController::class)->only(['index', 'store', 'update', 'destroy']);
Route::resource('plan', PlanController::class)->only(['index', 'store', 'update', 'destroy']);

require __DIR__ . '/auth.php';
