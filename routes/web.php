<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncubatorController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PlanController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('index');
})->name('/');

Route::get('home', [HomeController::class, 'index'])->middleware('auth:web')->name('home');

Route::resource('company', CompanyController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware(['auth:web','permission:companies']);

Route::get('register/company', [CompanyController::class, 'create'])->name('company.register');

Route::post('register/company', [CompanyController::class, 'store'])->name('company.register.store');

Route::resource('job', JobController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware(['auth:web','permission:jobs']);

Route::resource('incubator', IncubatorController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware(['auth:web','permission:incubators']);


require __DIR__ . '/auth.php';
