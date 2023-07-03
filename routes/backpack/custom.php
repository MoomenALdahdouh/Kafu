<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('plan', 'PlanCrudController');
    Route::crud('user', 'UserCrudController');
    Route::crud('job', 'JobCrudController');
    Route::crud('incubator', 'IncubatorCrudController');
    Route::crud('company', 'CompanyCrudController');
    Route::crud('feature', 'FeatureCrudController');
    Route::crud('permission', 'PermissionCrudController');
    Route::crud('role', 'RoleCrudController');
}); // this should be the absolute last line of this file