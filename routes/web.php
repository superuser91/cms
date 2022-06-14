<?php

use Illuminate\Support\Facades\Route;
use Vgplay\Acl\Controllers\PermissionController;
use Vgplay\Acl\Controllers\RoleController;

Route::middleware('web')->group(function () {
    Route::group([
        'prefix' => config('vgplay.roles.prefix'),
        'middleware' => config('vgplay.roles.middleware')
    ], function () {
        Route::resource('permissions', PermissionController::class);
        Route::resource('roles', RoleController::class);
    });
});
