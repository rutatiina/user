<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Rutatiina\User\Http\Controllers\GroupController;
use Rutatiina\User\Http\Controllers\GroupUserController;
use Rutatiina\User\Http\Controllers\PermissionController;
use Rutatiina\User\Http\Controllers\ProfileController;
use Rutatiina\User\Http\Controllers\RoleController;
use Rutatiina\User\Http\Controllers\UserController;

use Rutatiina\User\Http\Controllers\Auth\LoginController;
use Rutatiina\User\Http\Controllers\Auth\RegisterController;
use Rutatiina\User\Http\Controllers\Auth\ForgotPasswordController;
use Rutatiina\User\Http\Controllers\Auth\ResetPasswordController;
use Rutatiina\User\Http\Controllers\Auth\VerificationController;

//this commented code bellow is to be removed
//Route::group(['middleware' => ['web']], function() {
//    Auth::routes();
//});

Route::group(['middleware' => ['web', 'auth']], function() {
    Route::get('users/current', [UserController::class, 'self']);
    Route::resource('users', UserController::class);
});

Route::group(['middleware' => ['web', 'auth', 'tenant']], function() {
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

//*
// Authentication Routes...
Route::group(['middleware' => ['web']], function() {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Registration Routes...
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    // Password Reset Routes...
    Route::get('password/reset', ['Auth\ForgotPasswordController@showLinkRequestForm'])->name('password.request');
    Route::post('password/email', ['Auth\ForgotPasswordController@sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', ['Auth\ResetPasswordController@showResetForm'])->name('password.reset');
    Route::post('password/reset', ['Auth\ResetPasswordController@reset']);

    Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});
//*/
/*
+--------+----------+------------------------+------------------+------------------------------------------------------------------------+------------+
| Domain | Method   | URI                    | Name             | Action                                                                 | Middleware |
+--------+----------+------------------------+------------------+------------------------------------------------------------------------+------------+
|        | GET|HEAD | login                  | login            | App\Http\Controllers\Auth\LoginController@showLoginForm                | web        |
|        |          |                        |                  |                                                                        | guest      |
|        | POST     | login                  |                  | App\Http\Controllers\Auth\LoginController@login                        | web        |
|        |          |                        |                  |                                                                        | guest      |
|        | POST     | logout                 | logout           | App\Http\Controllers\Auth\LoginController@logout                       | web        |
|        | GET|HEAD | password/confirm       | password.confirm | App\Http\Controllers\Auth\ConfirmPasswordController@showConfirmForm    | web        |
|        |          |                        |                  |                                                                        | auth       |
|        | POST     | password/confirm       |                  | App\Http\Controllers\Auth\ConfirmPasswordController@confirm            | web        |
|        |          |                        |                  |                                                                        | auth       |
|        | POST     | password/email         | password.email   | App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail  | web        |
|        | GET|HEAD | password/reset         | password.request | App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm | web        |
|        | POST     | password/reset         | password.update  | App\Http\Controllers\Auth\ResetPasswordController@reset                | web        |
|        | GET|HEAD | password/reset/{token} | password.reset   | App\Http\Controllers\Auth\ResetPasswordController@showResetForm        | web        |
|        | GET|HEAD | register               | register         | App\Http\Controllers\Auth\RegisterController@showRegistrationForm      | web        |
|        |          |                        |                  |                                                                        | guest      |
|        | POST     | register               |                  | App\Http\Controllers\Auth\RegisterController@register                  | web        |
|        |          |                        |                  |                                                                        | guest      |
+--------+----------+------------------------+------------------+------------------------------------------------------------------------+------------+
*/

