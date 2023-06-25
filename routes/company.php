<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\PlanController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->name('admin.')->group(function () {
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
            Route::get('logout', 'logout')->name('logout');
            Route::prefix('users')
                ->controller(AdminAuthController::class)
                ->name('users.')
                ->group(function () {
                    Route::get('/', 'list')->name('list');
                    Route::post('/', 'store')->name('store');
                    Route::get('create', 'create')->name('create');
                    Route::get('{id}/edit', 'edit')->name('edit');
                    Route::get('{id}/show', 'show')->name('show');
                    Route::put('{id}/update', 'update')->name('update');
                    Route::get('{id}/delete', 'delete')->name('delete');
                });

            Route::prefix('plans')
                ->name('plans.')
                ->controller(PlanController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('create', 'create')->name('create');
                    Route::get('delete', 'delete')->name('delete');
                    Route::post('update/{id}', 'update')->name('update');
                    Route::post('fields/{id}', 'fields')->name('fields');
                });
        });

});
