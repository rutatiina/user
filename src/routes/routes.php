<?php

use Illuminate\Support\Facades\Route;
use Rutatiina\User\Http\Controllers\GroupController;
use Rutatiina\User\Http\Controllers\GroupUserController;
use Rutatiina\User\Http\Controllers\PermissionController;
use Rutatiina\User\Http\Controllers\ProfileController;
use Rutatiina\User\Http\Controllers\RoleController;
use Rutatiina\User\Http\Controllers\UserController;

Route::group(['middleware' => ['web', 'auth']], function() {

    Route::resource('users', UserController::class);

});


Route::group(['middleware' => ['web', 'auth', 'tenant']], function() {

    //Route::get('permissions/setup', 'PermissionController@setup');
    Route::get('profile/activity', [ProfileController::class, 'activity'])->name('profile.activity');
    Route::get('profile/roles', [ProfileController::class, 'roles'])->name('profile.roles');
    Route::get('profile/permissions', [ProfileController::class, 'permissions'])->name('profile.permissions');
    Route::get('settings/permissions/assign', [PermissionController::class, 'assign']);
    Route::get('settings/permissions/count', [PermissionController::class, 'count']);
    Route::any('settings/roles/assign', [RoleController::class, 'assign'])->name('roles.assign');
    Route::get('settings/roles/count', [RoleController::class, 'count']);
    Route::post('groups/assign', [GroupController::class, 'assign'])->name('groups.assign');

    Route::resources([
        'profile' => ProfileController::class,
        'settings/roles' => RoleController::class,
        'settings/permissions' => PermissionController::class,
        'groups' => GroupController::class,
        'group-users' => GroupUserController::class,
    ]);

});
