<?php
/*
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CompanyAdminController;
use App\Http\Controllers\Admin\IncubatorAdminController;
use App\Http\Controllers\Admin\JobAdminController;
use App\Http\Controllers\Admin\PlanAdminController;
use App\Http\Controllers\PlanController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::middleware('guest:admin')
            ->controller(AdminAuthController::class)
            ->group(function () {
                Route::get('auth', 'auth')->name('auth');
                Route::post('login', 'login')->name('login');
            });

        Route::middleware('auth:admin')
            ->controller(AdminAuthController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('dashboard', 'index')->name('dashboard');
                Route::get('logout', 'logout')->name('logout');

                Route::resource('plan', PlanAdminController::class)->only(['index', 'store', 'update', 'destroy']);
                Route::resource('company', CompanyAdminController::class)->only(['index', 'store', 'update', 'destroy']);
                Route::resource('job', JobAdminController::class)->only(['index', 'store', 'update', 'destroy']);
                Route::resource('incubator', IncubatorAdminController::class)->only(['index', 'store', 'update', 'destroy']);
            });
    });

*/
