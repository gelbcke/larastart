<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::post('/login/locked', [App\Http\Controllers\Auth\LoginController::class, 'unlock'])->name('login.unlock');

Route::group(['middleware' => ['auth', 'check_user_status', 'check_user_single_session', 'auth.lock', '2fa', 'language']], function () {
    Route::get('/home', [App\Http\Controllers\Backend\HomeController::class, 'index'])->name('home');

    Route::get('/login/locked', [App\Http\Controllers\Auth\LoginController::class, 'locked'])->withoutMiddleware('auth.lock')->name('login.locked');

    Route::get('/lang/{language}', [App\Http\Controllers\Backend\UserController::class, 'change_language'])->name('lang.update');

    Route::get('/users', [App\Http\Controllers\Backend\UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [App\Http\Controllers\Backend\UserController::class, 'create'])->name('users.create');
    Route::get('/users/edit/{user}', [App\Http\Controllers\Backend\UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/store', [App\Http\Controllers\Backend\UserController::class, 'store'])->name('users.store');
    Route::patch('/users/update/{user}', [App\Http\Controllers\Backend\UserController::class, 'update'])->name('users.update');
    Route::get('/users/getUsers', [App\Http\Controllers\Backend\UserController::class, 'getUsers'])->name('users.get');
    Route::get('/users/lockscreen', [App\Http\Controllers\Backend\UserController::class, 'lockscreen'])->name('users.lockscreen');

    Route::get('/users_a/{id}', [App\Http\Controllers\Backend\UserController::class, 'active'])->name('users.active');
    Route::get('/users_d/{id}', [App\Http\Controllers\Backend\UserController::class, 'deactive'])->name('users.deactive');

    Route::get('/user/profile/{user}', [App\Http\Controllers\Backend\UserController::class, 'user_profile'])->name('user.profile');
    Route::get('/profile/{user}', [App\Http\Controllers\Backend\UserController::class, 'profile'])->name('profile');
    Route::post('/profile/{user}', [App\Http\Controllers\Backend\UserController::class, 'update_profile'])->name('profile.update');

    Route::get('/system/settings', [App\Http\Controllers\Backend\SystemSettingController::class, 'index'])->name('system_settings');
    Route::get('/system/settings/edit', [App\Http\Controllers\Backend\SystemSettingController::class, 'settings'])->name('system_settings.edit');
    Route::post('/system/settings/edit', [App\Http\Controllers\Backend\SystemSettingController::class, 'update'])->name('system_settings.update');

    Route::get('/log', [App\Http\Controllers\Backend\LogController::class, 'index'])->name('logs.index');
    Route::get('/log/getLogs', [App\Http\Controllers\Backend\LogController::class, 'getLogs'])->name('logs.get');
    Route::get('/log/clearLogs', [App\Http\Controllers\Backend\LogController::class, 'clearLogs'])->name('logs.clear');

    Route::any('/2fa', [App\Http\Controllers\Backend\LoginSecurityController::class, 'show2faForm'])->name('2fa');
    Route::post('/2fa/secret', [App\Http\Controllers\Backend\LoginSecurityController::class, 'generate2faSecret'])->name('generate2faSecret');
    Route::post('/2fa/enable', [App\Http\Controllers\Backend\LoginSecurityController::class, 'enable2fa'])->name('enable2fa');
    Route::post('/2fa/disable', [App\Http\Controllers\Backend\LoginSecurityController::class, 'disable2fa'])->name('disable2fa');



    Route::resource('/roles', App\Http\Controllers\RoleController::class);
    Route::resource('/permissions', App\Http\Controllers\PermissionController::class);



    // 2fa middleware
    Route::post('/2faVerify', function () {
        return redirect(URL()->previous());
    })->name('2faVerify');
});
